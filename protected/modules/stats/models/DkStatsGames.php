<?php

/**
 * This is the model class for table "dk_stats_games".
 *
 * The followings are the available columns in table 'dk_stats_games':
 * @property integer $id
 * @property integer $serverId
 * @property integer $map
 * @property integer $winner
 * @property integer $winType
 * @property integer $start
 * @property integer $end
 *
 * @property DkStatsPlayers[] $players
 */
class DkStatsGames extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dk_stats_games';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('serverId, map, winner, winType, start, end', 'required'),
            array('serverId, map, winner, winType, start, end', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            //array('id, serverId, map, winType', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "players" => [self::HAS_MANY, "DkStatsPlayers", "gameId"],
            "server" => [self::BELONGS_TO, "Servers", "serverId"],
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'serverId' => 'Server',
            'map' => 'Map',
            'winner' => 'Winner',
            'winType' => 'Win Type',
            'start' => 'Start',
            'end' => 'End',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $dependency = new CDbCacheDependency('SELECT MAX(id) FROM ' . $this->tableName());

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('serverId', $this->serverId);
        $criteria->compare('map', $this->map);
        $criteria->compare('winType', $this->winType);

        $criteria->order = $this->getTableAlias(false, false) . ".id DESC";
        $criteria->with = "server";

        if (!YII_DEBUG)
            return new CActiveDataProvider(self::model()->cache(604800, $dependency, 2), array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 50,
                )
            ));
        else
            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 50,
                )
            ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DkStatsGames the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getServerName()
    {
        if ($this->server)
            return $this->server->name;
        else
            return $this->serverId;
    }

    public function getMapName()
    {
        //TODO: MAP NAME
        switch ($this->map) {
            case 1:
                return "Карта бета теста";
        }
        return $this->map;
    }

    public function getWinnerTeam()
    {
        switch ($this->winner) {
            case 1:
                return "<span class='label red'>Красная команда</span>";
            case 2:
                return "<span class='label blue'>Синяя команда</span>";
            case 3:
                return "<span class='label green'>Зеленая команда</span>";
            case 4:
                return "<span class='label yellow'>Желтая команда</span>";
        }
        return "Наебнулося";
    }

    public function getWinType()
    {
        switch ($this->winType) {
            case 0:
                return "Нексусы противников уничтожены";
            case 1:
                return '<span rel="tooltip" title="Все игроки противников покинули игру.">Тех. победа</span>';
        }
        return "Наебнулося";
    }
}