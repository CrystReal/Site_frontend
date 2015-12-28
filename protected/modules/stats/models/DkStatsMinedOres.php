<?php

/**
 * This is the model class for table "dk_stats_mined_ores".
 *
 * The followings are the available columns in table 'dk_stats_mined_ores':
 * @property integer $id
 * @property integer $gameId
 * @property integer $playerId
 * @property integer $wood
 * @property integer $coal
 * @property integer $iron
 * @property integer $gold
 * @property integer $diamonds
 */
class DkStatsMinedOres extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dk_stats_mined_ores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('gameId, playerId, wood, coal, iron, gold, diamonds', 'required'),
            array('gameId, playerId, wood, coal, iron, gold, diamonds', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, gameId, playerId, wood, coal, iron, gold, diamonds', 'safe', 'on' => 'search'),
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
            'wood' => 'Wood',
            'coal' => 'Coal',
            'iron' => 'Iron',
            'gold' => 'Gold',
            'diamonds' => 'Diamonds',
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
        $criteria->compare('wood', $this->wood);
        $criteria->compare('coal', $this->coal);
        $criteria->compare('iron', $this->iron);
        $criteria->compare('gold', $this->gold);
        $criteria->compare('diamonds', $this->diamonds);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DkStatsMinedOres the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}