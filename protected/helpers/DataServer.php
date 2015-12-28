<?php
/**
 * Created by Alex Bond.
 * Date: 16.11.13
 * Time: 3:26
 */

class DataServer
{
    public static $connection = null;

    public static function sendCommand($command)
    {
        if (self::$connection == null) {
            self::$connection = stream_socket_client("tcp://127.0.0.1:8989", $errno, $errorMessage);
            if (self::$connection === false) {
                throw new UnexpectedValueException("Failed to connect: $errorMessage");
            }
        }
        fwrite(self::$connection, $command);
    }

    public static function addExpAndMoney($player, $exp, $money, $reason)
    {
        self::sendCommand("addPlayerExpAndMoney\t" . $player . ":" . $exp . ":" . $money . ":" . base64_encode($reason));
    }

    public static function withdrawExpAndMoney($player, $exp, $money, $reason)
    {
        self::sendCommand("withdrawPlayerExpAndMoney\t" . $player . ":" . $exp . ":" . $money . ":" . base64_encode($reason));
    }
} 