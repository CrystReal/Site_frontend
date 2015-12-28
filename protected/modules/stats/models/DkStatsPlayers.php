<?php

/**
 * This is the model class for table "dk_stats_players".
 *
 * The followings are the available columns in table 'dk_stats_players':
 * @property integer $id
 * @property integer $gameId
 * @property integer $playerId
 * @property integer $team
 * @property integer $nexusDamage
 * @property integer $killedGolems
 * @property integer $death
 * @property integer $timeInGame
 * @property integer $tillFinish
 */
class DkStatsPlayers extends CActiveRecord
{
    private $_ores;
    private $_victims;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dk_stats_players';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gameId, playerId, team, nexusDamage, killedGolems, death, timeInGame, tillFinish', 'required'),
            array('gameId, playerId, team, nexusDamage, killedGolems, death, timeInGame, tillFinish', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, gameId, playerId, team, nexusDamage, killedGolems, death, timeInGame, tillFinish', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array( // "victims" => [self::HAS_MANY, "DkStatsPlayersVictims", "playerId", 'on' => "victims.playerId=t.playerId AND victims.gameId=t.gateId"]
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'gameId' => 'Game',
            'playerId' => 'Player',
            'team' => 'Team',
            'nexusDamage' => 'Nexus Damage',
            'killedGolems' => 'Killed Golems',
            'death' => 'Death',
            'timeInGame' => 'Time In Game',
            'tillFinish' => 'Till Finish',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('gameId', $this->gameId);
        $criteria->compare('playerId', $this->playerId);
        $criteria->compare('team', $this->team);
        $criteria->compare('nexusDamage', $this->nexusDamage);
        $criteria->compare('killedGolems', $this->killedGolems);
        $criteria->compare('death', $this->death);
        $criteria->compare('timeInGame', $this->timeInGame);
        $criteria->compare('tillFinish', $this->tillFinish);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DkStatsPlayers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getVictims()
    {
        if (!$this->_victims)
            $this->_victims = DkStatsPlayersVictims::model()->findAllByAttributes(["playerId" => $this->playerId, "gameId" => $this->gameId]);
        return $this->_victims;
    }

    public function getOres()
    {
        if (!$this->_ores)
            $this->_ores = DkStatsMinedOres::model()->findByAttributes(["playerId" => $this->playerId, "gameId" => $this->gameId]);
        return $this->_ores;
    }
}