<?php

/**
 * Created by Alex Bond.
 * Date: 16.11.13
 * Time: 0:41
 */
class CabinetController extends MainController
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

    public function actionIndex()
    {
        $this->breadcrumbs[] = [
            'title' => "Личный кабинет", 'url' => $this->createUrl("index")
        ];
        $this->Title = "Личный кабинет";
        $this->render("index");
    }

    public function actionEdit()
    {
        /**
         * @var $model Users
         */
        $this->breadcrumbs[] = [
            'title' => "Личный кабинет", 'url' => $this->createUrl("index")
        ];
        $this->breadcrumbs[] = [
            'title' => "Редактирование профиля", 'url' => $this->createUrl("edit")
        ];
        $this->Title = "Редактирование профиля";
        $model = Yii::app()->user->model;
        if (Yii::app()->request->isPostRequest && isset($_POST['Users'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $model->setAttributes($_POST['Users']);
            //if ($model->save(true, $model->getSafeAttributes())) {
            if ($model->save()) {
                Yii::app()->user->setFlash("success", "Профиль обновлен");
                $this->redirect($this->createUrl("index"));
            }
        }
        $this->render("edit", ["model" => $model]);
    }
} 