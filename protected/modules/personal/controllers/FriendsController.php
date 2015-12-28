<?php

/**
 * Created by Alex Bond.
 * Date: 02.02.14
 * Time: 3:13
 */
class FriendsController extends MainController
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

    public function actionFriends()
    {
        $this->Title = "Друзья";
        $this->render("list");
    }

    public function actionDeclined()
    {
        $this->Title = "Друзья";
        $this->render("declined");
    }

    public function actionPending()
    {
        $this->Title = "Друзья";
        $this->render("pending");
    }

    public function actionAddFriend()
    {
        if (!isset($_GET['id']))
            throw new CHttpException(500, "err");
        $friend = Users::model()->findByPk($_GET['id']);
        if (!$friend)
            throw new CHttpException(404, "Друг не найден");
        /**
         * @var $friendsip UsersFriends
         */
        $friendsip = UsersFriends::model()->getFriendship(Yii::app()->user->id, $friend->id);
        if ($friendsip) {
            if ($friendsip->approved == UsersFriends::APPROVED) {
                Yii::app()->user->setFlash("danger", "Вы уже друзья");
                $this->redirect($friend->getProfileLink());
            } else
                if ($friendsip->first_user == Yii::app()->user->id) {
                    if ($friendsip->approved == UsersFriends::WAITING) {
                        Yii::app()->user->setFlash("danger", "Запрос на дружбу уже выслан");
                        $this->redirect($friend->getProfileLink());
                    } elseif ($friendsip->approved == UsersFriends::DECLINED) {
                        Yii::app()->user->setFlash("danger", "Запрос на дружбу отклонен второй стороной");
                        $this->redirect($friend->getProfileLink());
                    }
                } else {
                    $friendsip->approved = UsersFriends::APPROVED;
                    $friendsip->since = time();
                    $friendsip->save();
                    Yii::app()->user->setFlash("success", "Запрос на дружбу принят");
                    $this->redirect($friend->getProfileLink());
                }
        } else {
            $friendsip = new UsersFriends();
            $friendsip->request = time();
            $friendsip->since = time();
            $friendsip->approved = UsersFriends::WAITING;
            $friendsip->first_user = Yii::app()->user->id;
            $friendsip->second_user = $friend->id;
            $friendsip->save();
            Yii::app()->user->setFlash("success", "Запрос на дружбу отправлен");
            $this->redirect($friend->getProfileLink());
        }
    }

    public function actionDeleteFriend()
    {
        if (!isset($_GET['id']))
            throw new CHttpException(500, "err");
        $friend = Users::model()->findByPk($_GET['id']);
        if (!$friend)
            throw new CHttpException(404, "Друг не найден");
        $friendsip = UsersFriends::model()->getFriendship(Yii::app()->user->id, $friend->id);
        if (!$friendsip)
            throw new CHttpException(404, "Дружба не найдена");
        $friendsip->delete();
        Yii::app()->user->setFlash("success", "Запрос на дружбу отправлен");
        $this->redirect($friend->getProfileLink());
    }

    public function actionDecline()
    {
        if (!isset($_GET['id']))
            throw new CHttpException(500, "err");
        $friend = Users::model()->findByPk($_GET['id']);
        if (!$friend)
            throw new CHttpException(404, "Друг не найден");
        $friendsip = UsersFriends::model()->getFriendship(Yii::app()->user->id, $friend->id);
        if (!$friendsip)
            throw new CHttpException(404, "Дружба не найдена");
        if ($friendsip->second_user != Yii::app()->user->id)
            throw new CHttpException(403, "Не ломай!");
        $friendsip->approved = UsersFriends::DECLINED;
        $friendsip->since = time();
        $friendsip->save();
        Yii::app()->user->setFlash("success", "Вы больше не друзья");
        $this->redirect($friend->getProfileLink());
    }
} 