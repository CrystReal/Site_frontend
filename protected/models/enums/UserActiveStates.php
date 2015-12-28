<?php
/**
 * Created by Alex Bond.
 * Date: 15.11.13
 * Time: 2:15
 */

class UserActiveStates
{
    const EMAIL_ACTIVATION = 0;
    const ACTIVATED = 1;
    const BLOCKED = 2;

    public static function getByID($id)
    {
        switch ($id) {
            case 0:
                return self::EMAIL_ACTIVATION;
            case 1:
                return self::ACTIVATED;
            case 2:
                return self::BLOCKED;
        }
        return self::EMAIL_ACTIVATION;
    }
} 