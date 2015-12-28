<?php

class UserIdentity extends CUserIdentity
{
    private $_id;
    private $enc;

    const ERROR_NOT_ACTIVATED = 101;
    const ERROR_BLOCKED = 102;

    public function __construct($username, $password, $enc = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->enc = $enc;
    }

    public function authenticate()
    {
        $record = Users::model()->findByAttributes(array('username' => $this->username));
        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            if ((!$this->enc && $record->password !== $record->generateHash($this->password)) || ($this->enc && $record->password !== $this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                if ($record->active == UserActiveStates::EMAIL_ACTIVATION) {
                    $this->errorCode = self::ERROR_NOT_ACTIVATED;
                } elseif ($record->active == UserActiveStates::BLOCKED) {
                    $this->errorCode = self::ERROR_BLOCKED;
                } else {
                    $this->_id = $record->id;
                    $this->errorCode = self::ERROR_NONE;
                    $log = new UsersSiteLogins();
                    $log->user_id = $record->id;
                    $log->when = new CDbExpression("NOW()");
                    $log->userIP = $_SERVER['REMOTE_ADDR'];
                    $log->save();
                }
            }
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}

