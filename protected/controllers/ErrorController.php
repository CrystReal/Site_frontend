<?php

class ErrorController extends MainController
{
    public function actionError()
    {
        $this->Title = "Ошибка";
        if ($error = Yii::app()->errorHandler->error)
            $this->render('error', array('error' => $error));
    }
}