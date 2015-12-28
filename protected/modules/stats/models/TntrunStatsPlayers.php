<?php

/**
 * This is the model class for table "tntrun_stats_players".
 *
 * The followings are the available columns in table 'tntrun_stats_players':
 * @property integer $id
 * @property integer $gameId
 * @property integer $playerId
 * @property integer $position
 * @property integer $isWinner
 * @property integer $timeInGame
 */
class TntrunStatsPlayers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tntrun_stats_players';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gameId, playerId, position, isWinner, timeInGame', 'required'),
            array('gameId, playerId, position, isWinner, timeInGame', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, gameId, playerId, position, isWinner, timeInGame', 'safe', 'on' => 'search'),
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
            'gameId' => 'Game',
            'playerId' => 'Player',
            'position' => 'Position',
            'isWinner' => 'Is Winner',
            'timeInGame' => 'Time In Game',
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
        $criteria->compare('position', $this->position);
        $criteria->compare('isWinner', $this->isWinner);
        $criteria->compare('timeInGame', $this->timeInGame);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TntrunStatsPlayers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}