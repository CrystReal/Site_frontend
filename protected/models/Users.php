<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property integer $phone
 * @property string $firstName
 * @property string $lastName
 * @property string $registerDate
 * @property string $registerIP
 * @property integer $active
 * @property integer $totalOnline
 * @property integer $rang
 * @property double $realMoney
 * @property integer $vip
 * @property string $vk_link
 * @property string $fb_link
 * @property string $yt_link
 * @property string $twitter_link
 * @property integer $sex
 * @property string $birthday
 * @property string $location
 * @property string $interests
 * @property string $about
 */
class Users extends CActiveRecord
{
    public $changePass = false;
    public $uncodedPass = null;
    public $encoded = false;
    public $saveAuth = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, salt, email, registerDate, registerIP', 'required'),
            array(
                'username',
                'match', 'not' => true, 'pattern' => '/[^0-9a-zA-Z_-]/',
                'message' => 'Имя может состоять только из латинского алфавита и знаков - и _',
            ),
            array('phone, active, totalOnline, rang, vip, sex', 'numerical', 'integerOnly' => true),
            array('realMoney', 'numerical'),
            array('username', 'length', 'max' => 16),
            array('password, salt', 'length', 'max' => 32),
            array('email, fb_link, location', 'length', 'max' => 256),
            array('firstName, lastName, vk_link, yt_link, twitter_link', 'length', 'max' => 128),
            array('registerIP', 'length', 'max' => 15),
            array('interests', 'length', 'max' => 512),
            array('email', 'email', "message" => "Что то не то ты вписал в почтовый адрес."),
            array('username', 'unique', "message" => "Данное имя уже зарегистрировано."),
            array('email', 'unique', "message" => "Игрок с такой почтой уже зарегистрирован."),
            array('phone', 'unique', "message" => "Игрок с таким номером телефона уже зарегистрирован."),
            array('birthday, about', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, salt, email, phone, firstName, lastName, registerDate, registerIP, active, totalOnline, rang, realMoney, vip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Ник',
            'password' => 'Пароль',
            'salt' => 'Salt',
            'email' => 'Email',
            'phone' => 'Телефон',
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'registerDate' => 'Дата регистрации',
            'registerIP' => 'IP регистрации',
            'active' => 'Активный?',
            'totalOnline' => 'Суммарный онлайн',
            'rang' => 'Ранг',
            'realMoney' => 'Баланс',
            'vip' => 'VIP',
            'vk_link' => 'Профиль Вконтакте',
            'fb_link' => 'Профиль Facebook',
            'yt_link' => 'Профиль YouTube',
            'twitter_link' => 'Профиль Twitter',
            'sex' => 'Пол',
            'birthday' => 'Дата рождения',
            'location' => 'Месторасположение',
            'interests' => 'Интересы',
            'about' => 'О себе',
            'signature' => 'Подпись на форуме'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('firstName', $this->firstName, true);
        $criteria->compare('lastName', $this->lastName, true);
        $criteria->compare('registerDate', $this->registerDate, true);
        $criteria->compare('registerIP', $this->registerIP, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('totalOnline', $this->totalOnline);
        $criteria->compare('rang', $this->rang);
        $criteria->compare('realMoney', $this->realMoney);
        $criteria->compare('vip', $this->vip);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        $p = new CHtmlPurifier();
        $this->signature = $p->purify($this->signature);
        $this->about = $p->purify($this->about);
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            Yii::app()->redis->getClient()->set("exp_" . mb_strtolower($this->username), 0);
            Yii::app()->redis->getClient()->set("money_" . mb_strtolower($this->username), 0);
        }
        Yii::app()->redis->getClient()->set("password_" . mb_strtolower($this->username), $this->password . ":" . $this->salt);
        Yii::app()->redis->getClient()->set("rang_" . mb_strtolower($this->username), $this->rang);
        Yii::app()->redis->getClient()->set("allUsers_" . mb_strtolower($this->username), $this->id);
        parent::afterSave();
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord || $this->changePass) {
            $this->uncodedPass = $this->password;
            $this->password = $this->generateHash($this->password);
        }
        if ($this->isNewRecord) {
            $this->registerDate = new CDbExpression("NOW()");
            $this->registerIP = $_SERVER['REMOTE_ADDR'];
        }
        if (strlen($this->birthday) != 10) {
            $this->birthday = null;
        } else {
            $out = explode(".", $this->birthday);
            if (count($out) != 3)
                $this->birthday = null;
            else
                $this->birthday = $out[2] . "-" . $out[1] . "-" . $out[0];
        }
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->birthday = date("d.m.Y", strtotime($this->birthday));
    }

    public function authenticate()
    {
        if (!$this->hasErrors()) {
            if ($this->encoded)
                $identity = new UserIdentity($this->username, $this->password, true);
            else
                if (!empty($this->uncodedPass))
                    $identity = new UserIdentity($this->username, $this->uncodedPass);
                else
                    $identity = new UserIdentity($this->username, $this->password);
            $identity->authenticate();

            switch ($identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                {
                    if ($this->saveAuth)
                        Yii::app()->user->login($identity, 3600 * 24 * 7);
                    else
                        Yii::app()->user->login($identity, 0);
                    break;
                }
                case UserIdentity::ERROR_USERNAME_INVALID:
                {
                    $this->addError('email', 'Игрок не найден!');
                    break;
                }
                case UserIdentity::ERROR_PASSWORD_INVALID:
                {
                    $this->addError('pass', 'Введенный пароль не верный!');
                    break;
                }
                case UserIdentity::ERROR_NOT_ACTIVATED:
                {
                    $this->addError('email', 'Данный профиль не активирован.<br>Если ты не получил письмо с подтверждением,  <a href="' . Yii::app()->controller->createUrl("/personal/auth/resendActivation") . '" class="alert-link">нажми сюда</a> для повторной отправки письма с подтверждением.');
                    break;
                }
                case UserIdentity::ERROR_BLOCKED:
                {
                    $this->addError('email', 'Данный профиль заблокирован администрацией.<br>Если ты считаешь что это ошибка напиши в <a href="/support" class="alert-link">службу технической</a> поддержки.');
                    break;
                }
            }
        }
    }

    public function generateHash($pass)
    {
        if (empty($this->salt))
            $this->salt = md5(rand() . time());
        return md5(md5($pass) . $this->salt);
    }

    public function getActivationKey()
    {
        return md5($this->id . $this->salt);
    }

    public function findByEmail($email)
    {
        return $this->find("email=:param1", array(":param1" => $email));
    }

    public function usernameExists($name)
    {
        return $this->count("username=:param1", array(":param1" => $name)) > 0;
    }

    public function getSexOptions()
    {
        return [
            0 => "Не скажу",
            1 => "Мужской",
            2 => "Женский",
        ];
    }

    public function getExp()
    {
        $exp = Yii::app()->redis->getClient()->get("exp_" . mb_strtolower($this->username));
        if (!$exp) {
            $exp = 0;
            Yii::app()->redis->getClient()->set("exp_" . mb_strtolower($this->username), $exp);
        }
        return $exp;
    }

    public function getMoney()
    {
        $money = Yii::app()->redis->getClient()->get("money_" . mb_strtolower($this->username));
        if (!$money) {
            $money = 0;
            Yii::app()->redis->getClient()->set("money_" . mb_strtolower($this->username), $money);
        }
        return $money;
    }

    public function addMoney($amount, $reason)
    {
        DataServer::addExpAndMoney($this->username, 0, $amount, $reason);
    }

    public function withdrawMoney($amount, $reason)
    {
        DataServer::withdrawExpAndMoney($this->username, 0, $amount, $reason);
    }

    public function addExp($amount, $reason)
    {
        DataServer::addExpAndMoney($this->username, $amount, 0, $reason);
    }

    public function withdrawExp($amount, $reason)
    {
        DataServer::withdrawExpAndMoney($this->username, $amount, 0, $reason);
    }

    public function getBadges()
    {
        $out = [];
        switch ($this->rang) {
            case 0:
                $out[] = '<span class="label label-default">Игрок</span>';
                break;
            case 1:
                $out[] = '<span class="label label-danger">Администратор</span>';
                break;
            case 2:
                $out[] = '<span class="label label-success">Модератор</span>';
                break;
            case 3:
                $out[] = '<span class="label label-info">Друг проекта</span>';
                break;
        }
        switch ($this->vip) {
            case 0:
                break;
            case 1:
                $out[] = '<span class="label label-warning">VIP</span>';
                break;
            case 2:
                $out[] = '<span class="label label-warning">VIP+</span>';
                break;
            case 3:
                $out[] = '<span class="label label-warning">Master</span>';
                break;
        }
        return implode(" ", $out);
    }

    public function getProfileLink()
    {
        return Yii::app()->params['siteUrl'] . "/u/" . $this->id . "." . $this->username;
    }

    public function getBirthday()
    {
        return date('d.m.Y', strtotime($this->birthday));
    }

    public function getUserNameFromID($id)
    {
        $cache = Yii::app()->redisCache->get("userName:" . $id);
        if ($cache)
            return $cache;
        else {
            $user = $this->findByPk($id);
            if (!$user)
                return "Неизвестный";
            Yii::app()->redisCache->set("userName:" . $user->id, $user->username);
            return $user->username;
        }
    }

    public function getUsernameWithLink($id, $color = false)
    {
        $cache = Yii::app()->redisCache->get("userLinkWithName:" . $id . ":" . $color);
        if ($cache)
            return $cache;
        else {
            $user = $this->findByPk($id);
            if (!$user)
                return CHtml::link("Неизвестный", "#");
            $htmlOptions = [];
            if ($color)
                $htmlOptions = ["style" => "color: " . $user->getColor()];
            $link = CHtml::link($user->username, "/u/" . $user->id . "." . $user->username, $htmlOptions);
            Yii::app()->redisCache->set("userLinkWithName:" . $id . ":" . $color, $link);
            return $link;
        }
    }

    public function getUsernameAvatarWithLink($id, $size)
    {
        $cache = Yii::app()->redisCache->get("userLinkWithAvatar:" . $id . ":" . $size);
        if ($cache)
            return $cache;
        else {
            $user = $this->findByPk($id);
            if (!$user)
                return CHtml::link($this->getAvatar("Player", $size), "#", ['title' => "Неизвестный", 'rel' => 'tooltip']);
            $link = CHtml::link($this->getAvatar($user->username, $size), "/u/" . $user->id . "." . $user->username, ['title' => $user->username, 'rel' => 'tooltip']);
            Yii::app()->redisCache->set("userLinkWithAvatar:" . $id . ":" . $size, $link);
            return $link;
        }
    }

    public function getUsernameWithAvatarAndLink($id, $size)
    {
        $cache = Yii::app()->redisCache->get("userLinkWithAvatarAndName:" . $id . ":" . $size);
        if ($cache)
            return $cache;
        else {
            $user = $this->findByPk($id);
            if (!$user)
                return CHtml::link($this->getAvatar("Player", $size) . " Неизвестный", "#");
            $link = CHtml::link($this->getAvatar($user->username, $size) . " " . $user->username, "/u/" . $user->id . "." . $user->username);
            Yii::app()->redisCache->set("userLinkWithAvatarAndName:" . $id . ":" . $size, $link);
            return $link;
        }
    }

    public function getAvatar($username, $size)
    {
        return CHtml::image($this->getAvatarLink($username, $size), $username);
    }

    public function getAvatarLink($username, $size)
    {
        return "/avatar/" . $username . "/" . $size;
    }

    public function getFriends()
    {
        $friends = UsersFriends::model()->approved()->getUserFriends($this->id);
        $out = [];
        foreach ($friends as $item) {
            if ($item->first_user == $this->id)
                $out[] = [
                    "id" => $item->second_user
                ];
            else
                $out[] = [
                    "id" => $item->first_user
                ];
        }
        return $out;
    }

    public function getTotalFriends()
    {
        return count($this->getFriends());
    }

    public function getTotalKills()
    {
        $kills = Yii::app()->redis->getClient()->get("totalKills_" . $this->id);
        if (!$kills) {
            $kills = 0;
            Yii::app()->redis->getClient()->set("totalKills_" . $this->id, $kills);
        }
        return $kills;
    }

    public function getLastKills()
    {
        $kills = Yii::app()->redis->getClient()->get("lastKills_" . $this->id);
        if (!$kills)
            return [];

        $killsArr = mb_split(":", $kills);
        $out = [];
        foreach ($killsArr as $item) {
            $t = mb_split("\|", $item);
            $out[] = [
                "id" => $t[0],
                "time" => $t[1],
                "gameId" => $t[2],
                "type" => $t[3]
            ];
        }
        return array_reverse($out);
    }

    public function getTotalDeaths()
    {
        $deaths = Yii::app()->redis->getClient()->get("totalDeaths_" . $this->id);
        if (!$deaths) {
            $deaths = 0;
            Yii::app()->redis->getClient()->set("totalDeaths_" . $this->id, $deaths);
        }
        return $deaths;
    }

    public function getLastDeaths()
    {
        $kills = Yii::app()->redis->getClient()->get("lastDeaths_" . $this->id);
        if (!$kills)
            return [];

        $killsArr = mb_split(":", $kills);
        $out = [];
        foreach ($killsArr as $item) {
            $t = mb_split("\|", $item);
            $out[] = [
                "id" => $t[0],
                "time" => $t[1],
                "gameId" => $t[2],
                "type" => $t[3]
            ];
        }
        return array_reverse($out);
    }

    public function getLastKillsAndDeaths()
    {
        $deaths = $this->getLastDeaths();
        $kills = $this->getLastKills();
        $out = [];
        foreach ($deaths as $item) {
            $out[] = [
                "by" => $item['id'],
                "to" => $this->id,
                "in" => $item['type'],
                "inId" => $item['gameId'],
                "when" => $item['time']
            ];
        }
        foreach ($kills as $item) {
            $out[] = [
                "by" => $this->id,
                "to" => $item['id'],
                "in" => $item['type'],
                "inId" => $item['gameId'],
                "when" => $item['time']
            ];
        }
        usort($out, function ($a, $b) {
            return $b['when'] - $a['when'];
        });
        return $out;
    }

    public function getLastJoin()
    {
        $var = Yii::app()->redis->getClient()->get("lastJoin_" . $this->id);
        if (!$var) {
            $var = 0;
            Yii::app()->redis->getClient()->set("lastJoin_" . $this->id, $var);
        }
        return $var;
    }

    public function getTotalJoins()
    {
        $var = Yii::app()->redis->getClient()->get("totalJoins_" . $this->id);
        if (!$var) {
            $var = 0;
            Yii::app()->redis->getClient()->set("totalJoins_" . $this->id, $var);
        }
        return $var;
    }

    public function getTotalGames()
    {
        $var = Yii::app()->redis->getClient()->get("totalGames_" . $this->id);
        if (!$var) {
            $var = 0;
            Yii::app()->redis->getClient()->set("totalGames_" . $this->id, $var);
        }
        return $var;
    }

    public function getWinsCount()
    {
        $var = Yii::app()->redis->getClient()->get("winsCount_" . $this->id);
        if (!$var) {
            $var = 0;
            Yii::app()->redis->getClient()->set("winsCount_" . $this->id, $var);
        }
        return $var;
    }


    public function getOnline()
    {
        $online = Yii::app()->redis->getClient()->get("online_" . mb_strtolower($this->username));
        if (!$online) {
            $offline = Yii::app()->redis->getClient()->get("offline_" . mb_strtolower($this->username));
            if (!$offline) {
                return '<div class="status offline"><i class="fa fa-circle" rel="tooltip" data-placement="right" title="Не заходил на сервер"></i></div>';
            } else {
                $t = mb_split("\|", $offline);
                return '<div class="status offline"><i class="fa fa-circle" rel="tooltip" data-placement="right" title="Последний раз был в ' . date("j.n.Y G:i:s", $t[0]) . ' на сервере ' . $t[1] . '"></i></div>';
            }
        } else {
            return '<div class="status online"><i class="fa fa-circle" rel="tooltip" data-placement="right" title="Сейчас на сервере ' . $online . '"></i></div>';
        }
    }

    public function getKDRatio()
    {
        if ($this->getTotalDeaths() > 0 && $this->getTotalKills() > 0)
            return number_format($this->getTotalKills() / $this->getTotalDeaths(), 3);
        else return 0;
    }

    public function getWinPerc()
    {
        if ($this->getTotalGames() > 0 && $this->getWinsCount()) {
            return number_format($this->getWinsCount() / $this->getTotalGames() * 100);
        } else return 0;
    }

    public function getColor()
    {
        switch ($this->rang) {
            case 0:
                return "black";
            case 1:
                return "red";
            case 2:
                return "green";
            case 3:
                return "blue";
        }
    }

    public function getUserId($username)
    {
        return Yii::app()->redis->get("allUsers_" . mb_strtolower($username));
    }
}