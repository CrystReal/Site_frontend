<?php

/**
 * Created by Alex Bond.
 * Date: 18.01.14
 * Time: 22:51
 */
class AlexBond
{
    public static function secToTime($sec)
    {
        if ($sec < 60)
            return $sec . " сек.";
        else
            return number_format($sec / 60) . " мин.";
    }

    public static function record_sort($records, $field, $reverse = false)
    {
        $hash = array();

        foreach ($records as $record) {
            $hash[$record[$field]] = $record;
        }

        ($reverse) ? krsort($hash) : ksort($hash);

        $records = array();

        foreach ($hash as $record) {
            $records [] = $record;
        }

        return $records;
    }

    public static function doPlural($n, $form1, $form2, $form5)
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) return $form5;
        else if ($n1 > 1 && $n1 < 5) return $form2;
        else if ($n1 == 1) return $form1;
        if ($n == 0) return $form5;

        return $form5;
    }

    public static function time_since($since)
    {
        /*
         *  array(60 * 60 * 24 * 365, 'год', 'года', 'лет'),
            array(60 * 60 * 24 * 30, 'месяц', 'месяца', 'месяцев'),
            array(60 * 60 * 24 * 7, 'неделю', 'недели', 'недель'),
            array(60 * 60 * 24, 'день', 'дня', 'дней'),
            array(60 * 60, 'час', 'часа', 'часов'),
            array(60, 'минуту', 'минуты', 'минут'),
            array(1, 'секунду', 'секунды', 'секунд')
         */
        if($since <1)
            return "только что";
        $chunks = array(
            array(60 * 60 * 24 * 365, 'года', 'лет', 'лет'),
            array(60 * 60 * 24 * 30, 'месяца', 'месяцев', 'месяцев'),
            array(60 * 60 * 24 * 7, 'недели', 'недель', 'недель'),
            array(60 * 60 * 24, 'дня', 'дней', 'дней'),
            array(60 * 60, 'часа', 'часов', 'часов'),
            array(60, 'минуты', 'минут', 'минут'),
            array(1, 'секунды', 'секунд', 'секунд')
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            if (($count = floor($since / $seconds)) != 0) {
                $name = self::doPlural($count, $chunks[$i][1], $chunks[$i][2], $chunks[$i][3]);
                break;
            }
        }

        $print = ($count == 1) ? '1 ' . $name : "$count {$name}";
        return "около " . $print . " назад";
    }

} 