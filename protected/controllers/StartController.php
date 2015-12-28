<?php

/**
 * Created by Alex Bond.
 * Date: 01.02.14
 * Time: 22:19
 */
class StartController extends MainController
{
    public function actionIndex()
    {
        $this->Title = "Начни играть";
        $allPlayersR = Yii::app()->redis->keys("online_*");
        $allPlayers = [];
        foreach ($allPlayersR as $item) {
            $tmp = str_replace("online_", "", $item);
            $allPlayers[Users::model()->getUserId($tmp)] = $tmp;
        }
        $staff = Users::model()->findAll("rang in (1,2)");
        $admins = [];
        foreach ($staff as $item) {
            if (isset($allPlayers[$item->id])) {
                $admins[$item->id] = $allPlayers[$item->id];
            }
        }
        $this->render("index", ["users" => $allPlayers, "admins" => $admins]);
    }
}