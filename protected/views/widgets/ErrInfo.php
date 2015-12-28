<?php

class ErrInfo extends CHtml
{

    public static function alerts($model = null, $header = '<div class="alert alert-danger">',
                                  $footer = '</div>')
    {
        $content = '';
        if (!is_null($model)) {
            if (!is_array($model)) {
                $model = array($model);
            }
            foreach ($model as $m) {
                foreach ($m->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        if ($error != '') {
                            $content .= $header . "\n$error\n" . $footer;
                        }
                    }
                }
            }
        }
        $controller = Yii::app()->getController();
        if (isset($controller->errors) && count($controller->errors) > 0) {
            foreach ($controller->errors as $error) {
                $content .= $header . "\n$error\n" . $footer;
            }
        }

        if (isset($controller->messages) && count($controller->messages) > 0) {
            foreach ($controller->messages as $error) {
                $content .= '<div class="alert alert-success">' . "\n$error\n" . '</div>';
            }
        }

        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            $content .= '<div class="alert alert-' . $key . '">' . "\n$message\n" . '</div>';
        }
        echo $content;
    }

}