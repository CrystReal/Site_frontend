<?php

class Plural
{
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
}