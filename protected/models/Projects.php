<?php

/**
 * This is the model class for table "projects".
 *
 * The followings are the available columns in table 'projects':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $holder
 * @property string $domain
 * @property string $serverUrl
 * @property string $displayName
 */
class Projects extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'projects';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, code, holder, domain, serverUrl, displayName', 'required'),
            array('holder', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 256),
            array('code', 'length', 'max' => 16),
            array('domain, serverUrl, displayName', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, holder, domain, serverUrl, displayName', 'safe', 'on' => 'search'),
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
            'name' => 'Name',
            'code' => 'Code',
            'holder' => 'Holder',
            'domain' => 'Domain',
            'serverUrl' => 'Server Url',
            'displayName' => 'Display Name',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('holder', $this->holder);
        $criteria->compare('domain', $this->domain, true);
        $criteria->compare('serverUrl', $this->serverUrl, true);
        $criteria->compare('displayName', $this->displayName, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Projects the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getProjectByDomain($domain)
    {
        $model = $this->cache(3600)->find("domain LIKE '%" . $domain . "%'");
        if ($model)
            return $model;
        else
            return $this->cache(3600)->findByPk(0);
    }
}