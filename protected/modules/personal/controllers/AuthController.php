<?php

/**
 * Created by Alex Bond.
 * Date: 14.11.13
 * Time: 19:59
 */
class AuthController extends MainController
{
    public function actionIndex()
    {
        if (!Yii::app()->user->isGuest)
            $this->redirect($this->createUrl("/personal/cabinet/index"));
        $user = new Users();

        if (Yii::app()->request->isPostRequest && isset($_POST['Auth'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] !== Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $user->setAttributes($_POST['Auth']);
            $user->authenticate();
            if (!$user->hasErrors()) {
                $this->redirect($this->createUrl("/personal/cabinet/index"));
            }
        }

        $this->Title = "Авторизация";
        $this->render("index", array("model" => $user));
    }

    public function actionPasswordReset()
    {
        if (!Yii::app()->user->isGuest)
            $this->redirect($this->createUrl("/personal/cabinet/index"));

        if (Yii::app()->request->isPostRequest && !empty($_POST['passReset'])) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $user = Users::model()->findByEmail($_POST['passReset']);
            if ($user) {
                $reset = new PasswordResetCodes();
                $reset->user_id = $user->id;
                $reset->key = $reset->generateKey();
                $reset->validTill = time() + 600;
                $reset->save();
                Yii::import('ext.yii-mail.*');
                $message = new YiiMailMessage;
                $message->view = 'passwordReset';
                $message->setSubject('Напоминание имени и пароля');
                $message->setBody(array('user' => $user, 'reset' => $reset), 'text/html');
                $message->setTo($user->email);
                $message->from = array(Yii::app()->params['adminEmail'] => 'Crystal Reality Games');
                Yii::app()->mail->send($message);
                Yii::app()->user->setFlash("success", "Инструкции по сбросу пароля отправлены на почту.");
                $this->redirect($this->createUrl("index"));

            } else {
                $this->errors[] = "Игрок с таким почтовым адресом не найден.";
            }
        }
        $this->Title = "Восстановление пароля";
        $this->render("passwordReset");
    }

    public function actionResendActivation()
    {
        if (!Yii::app()->user->isGuest)
            $this->redirect($this->createUrl("/personal/cabinet/index"));

        if (Yii::app()->request->isPostRequest && !empty($_POST['resend'])) {
            $user = Users::model()->findByEmail($_POST['resend']);
            if ($user) {
                if ($user->active == UserActiveStates::EMAIL_ACTIVATION) {
                    Yii::import('ext.yii-mail.*');
                    $message = new YiiMailMessage;
                    $message->view = 'userActivationLink';
                    $message->setSubject('Активация профиля');
                    $message->setBody(array('user' => $user), 'text/html');
                    $message->setTo($user->email);
                    $message->from = array(Yii::app()->params['adminEmail'] => 'Crystal Reality Games');
                    Yii::app()->mail->send($message);
                    Yii::app()->user->setFlash("success", "Инструкции для активации профиля были повторно высланы на " . $user->email . ".");
                    $this->redirect($this->createUrl("index"));
                } else {
                    $this->errors[] = "Профиль с данным почтовым адресом уже активирован.";
                }
            } else {
                $this->errors[] = "Игрок с таким почтовым адресом не найден.";
            }
        }
        $this->Title = "Запрос письма для активации профиля";
        $this->render("resendActivation");
    }

    public function actionCheckUserNameAJAX()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['username']) && !empty($_GET['username'])) {
                if (Users::model()->usernameExists($_GET['username'])) {
                    echo json_encode(array("exists" => true));
                } else {
                    echo json_encode(array("exists" => false));
                }
            }
        } else {
            die("Ломать не хорошо.");
        }
    }

    public function actionRegistration()
    {
        if (!Yii::app()->user->isGuest)
            $this->redirect($this->createUrl("/personal/cabinet/index"));
        $user = new Users();

        if (Yii::app()->request->isPostRequest) {
            if (!isset($_POST['YII_CSRF_TOKEN']) || $_POST['YII_CSRF_TOKEN'] != Yii::app()->getRequest()->getCsrfToken())
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            if (!empty($_POST['Reg']['password']) && !empty($_POST['Reg']['password2'])) {
                if ($_POST['Reg']['password'] == $_POST['Reg']['password2']) {
                    $user->setAttributes($_POST['Reg']);
                    if ($user->save()) {
                        Yii::app()->redis->getClient()->set("allUsers_" . $user->username, "needAct");
                        Yii::import('ext.yii-mail.*');
                        $message = new YiiMailMessage;
                        $message->view = 'userActivationLink';
                        $message->setSubject('Активация профиля');
                        $message->setBody(array('user' => $user), 'text/html');
                        $message->setTo($user->email);
                        $message->from = array(Yii::app()->params['adminEmail'] => 'Crystal Reality Games');
                        Yii::app()->mail->send($message);
                        $this->redirect($this->createUrl("/personal/auth/needApprove"));
                    }
                } else {
                    $user->addError("password", "Пароли не совпадают");
                }
            } else {
                $user->addError("password", "Заполни все поля");
            }
        }

        $this->Title = "Регистрация";
        $this->render("registration", array("model" => $user));
    }

    public function actionNeedApprove()
    {
        $this->render("needApprove");
    }

    public function actionActivate()
    {
        if (isset($_GET['id']) && isset($_GET['key']) && $_GET['id'] > 0) {
            $user = Users::model()->findByPk($_GET['id']);
            if ($user) {
                if ($user->active == UserActiveStates::EMAIL_ACTIVATION) {
                    if ($_GET['key'] == $user->getActivationKey()) {
                        $user->active = UserActiveStates::ACTIVATED;
                        Yii::app()->redis->getClient()->set("allUsers_" . mb_strtolower($user->username), $user->id);
                        $user->save();
                        Yii::app()->user->setFlash("success", "Профиль успешно активирован.");
                        $user->encoded = true;
                        $user->authenticate();
                        if (!$user->hasErrors()) {
                            $this->redirect($this->createUrl("/Start/index"));
                        }
                    } else {
                        Yii::app()->user->setFlash("danger", "Неверый ключ активации.");
                        $this->redirect($this->createUrl("index"));
                    }
                } else {
                    Yii::app()->user->setFlash("danger", "Профиль уже активирован.");
                    $this->redirect($this->createUrl("index"));
                }
            } else {
                Yii::app()->user->setFlash("danger", "Профиль не найден.");
                $this->redirect($this->createUrl("index"));
            }
        } else {
            $this->redirect($this->createUrl("index"));
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect("/");
    }
}