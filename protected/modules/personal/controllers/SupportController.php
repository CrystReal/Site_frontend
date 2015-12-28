<?php

/**
 * Created by Alex Bond.
 * Date: 26.01.14
 * Time: 2:33
 */
class SupportController extends MainController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionList()
    {
        $this->Title = "Служба поддержки";
        $list = SupportTickets::model()->findAllByAttributes(["userId" => Yii::app()->user->id]);
        $this->render("list", ["model" => $list]);
    }

    public function actionAdd()
    {
        $this->Title = "Служба поддержки";
        $model = new SupportTickets();
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['subject']) && isset($_POST['text'])) {
                $model->dateCreated = time();
                $model->userId = Yii::app()->user->id;
                $model->subject = $_POST['subject'];
                if ($model->save()) {
                    $m2 = new SupportTicketsComments();
                    $m2->ticketId = $model->id;
                    $m2->userId = Yii::app()->user->id;
                    $m2->datePosted = time();
                    $m2->isAnswer = 0;
                    $m2->content = $_POST['text'];
                    $m2->save();
                    Yii::app()->user->setFlash("success", "Ваш запрос успешно отправлен. Скоро с вами свяжется администрация.");
                    $this->redirect($this->createUrl("view", ["id" => $model->id]));
                }
            }
        }
        $this->render("add", ["model" => $model]);
    }

    public function actionView()
    {
        $this->Title = "Служба поддержки";
        if (!isset($_GET['id']))
            throw new CHttpException(500, "Ломаешь?");
        $model = SupportTickets::model()->findByAttributes(["userId" => Yii::app()->user->id, "id" => $_GET['id']]);
        if (!$model) {
            throw new CHttpException(404, "Не найдено");
        }
        $this->render("view", ["model" => $model]);
    }

    public function actionComment()
    {
        if (!isset($_GET['id']))
            throw new CHttpException(500, "Ломаешь?");
        /**
         * @var $model SupportTickets
         */
        $model = SupportTickets::model()->findByAttributes(["userId" => Yii::app()->user->id, "id" => $_GET['id']]);
        if (!$model) {
            throw new CHttpException(404, "Не найдено");
        }
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['content']) && isset($_POST['toClose'])) {
                if ($_POST['toClose'] == 1)
                    $model->status = 2;
                else
                    $model->status = 0;
                $model->save();
                $m2 = new SupportTicketsComments();
                $m2->ticketId = $model->id;
                $m2->userId = Yii::app()->user->id;
                $m2->datePosted = time();
                $m2->isAnswer = 0;
                $m2->content = $_POST['content'];
                $m2->save();
                $this->redirect($this->createUrl("list"));
            } else {
                $this->redirect($this->createUrl("view", ["id" => $model->id]));
            }
        }
    }
} 