<?php

/**
 * This is the model class for table "servers".
 *
 * The followings are the available columns in table 'servers':
 * @property integer $id
 * @property string $name
 * @property integer $gameType
 * @property string $serverIp
 * @property integer $serverPort
 * @property string $connectUrl
 * @property integer $active
 */
class Servers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'servers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, gameType, serverIp, serverPort, connectUrl', 'required'),
            array('gameType, serverPort, active', 'numerical', 'integerOnly' => true),
            array('name, connectUrl', 'length', 'max' => 64),
            array('serverIp', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, gameType, serverIp, serverPort, connectUrl, active', 'safe', 'on' => 'search'),
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
            'name' => 'Название',
            'gameType' => 'Тип игры',
            'serverIp' => 'IP',
            'serverPort' => 'Порт',
            'connectUrl' => 'Для Bungee',
            'active' => 'Активность',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('gameType', $this->gameType);
        $criteria->compare('serverIp', $this->serverIp, true);
        $criteria->compare('serverPort', $this->serverPort);
        $criteria->compare('connectUrl', $this->connectUrl, true);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Servers the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function defaultScope()
    {
        return [
            "order" => $this->getTableAlias(false, false) . ".gameType ASC, " . $this->getTableAlias(false, false) . ".id ASC"
        ];
    }
}