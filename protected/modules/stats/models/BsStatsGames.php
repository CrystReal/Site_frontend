<?php

/**
 * This is the model class for table "bs_stats_games".
 *
 * The followings are the available columns in table 'bs_stats_games':
 * @property integer $id
 * @property integer $serverId
 * @property integer $mapId
 * @property integer $winnerId
 * @property integer $start
 * @property integer $end
 */
class BsStatsGames extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bs_stats_games';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('serverId, mapId, winnerId, start, end', 'required'),
            array('serverId, mapId, winnerId, start, end', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, serverId, winnerId, start, end', 'safe', 'on' => 'search'),
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
            "players" => [self::HAS_MANY, "BsStatsPlayers", "gameId"],
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
            'winnerId' => 'Winner',
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
        // @todo Please modify the following code to remove attributes that should not be searched.
        $dependency = new CDbCacheDependency('SELECT MAX(id) FROM ' . $this->tableName());


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('serverId', $this->serverId);
        $criteria->compare('mapId', $this->mapId);
        $criteria->compare('winnerId', $this->winnerId);
        $criteria->compare('start', $this->start);
        $criteria->compare('end', $this->end);

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
     * @return BsStatsGames the static model class
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
        switch ($this->mapId) {
            case 1:
                return "Карта бета теста";
        }
        return $this->mapId;
    }
}