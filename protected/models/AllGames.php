<?php

/**
 * Created by Alex Bond.
 * Date: 25.01.14
 * Time: 21:28
 */
class AllGames
{
    public static function getLastGames($count = 5)
    {
        $var = Yii::app()->redis->getClient()->get("lastGames");
        if (!$var)
            return [];

        $varArr = mb_split(":", $var);
        $out = [];
        foreach ($varArr as $item) {
            $t = mb_split("\|", $item);
            $tmp = [
                "time" => $t[0],
                "gameId" => $t[1],
                "gameLink" => Yii::app()->createUrl("/stats/" . Yii::app()->params['gameTypes'][$t[2]]["url"] . "/view", ["id" => $t[1]]),
                "type" => $t[2],
                "typeLink" => Yii::app()->createUrl("/stats/" . Yii::app()->params['gameTypes'][$t[2]]["url"] . "/list"),
                "typeName" => Yii::app()->params['gameTypes'][$t[2]]["name"],
            ];
            if (Yii::app()->params['gameTypes'][$t[2]]["isTeams"]) {
                $tmp['winner'] = Yii::app()->params['gameTypes'][$t[2]]["teams"][$t[3]] . " команда выиграла ";
            } else {
                $tmp['winner'] = Users::model()->getUsernameWithAvatarAndLink($t[3], 15) . " выиграл";
            }
            $out[] = $tmp;
        }
        $out = array_reverse($out);
        $out1 = [];
        $i = 1;
        foreach ($out as $item) {
            if ($i <= $count) {
                $out1[] = $item;
            } else break;
            $i++;
        }
        return $out1;
    }
}