<?php

/**
 * This is the model class for table "banLog".
 *
 * The followings are the available columns in table 'banLog':
 * @property integer $id
 * @property string $when
 * @property integer $admin_id
 * @property string $admin_server
 * @property string $victim_id
 * @property string $victim_server
 * @property integer $type
 * @property integer $term
 * @property string $reason
 * @property string $notes
 */
class BanLog extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'banLog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('when, admin_id, admin_server, victim_id, type, reason', 'required'),
            array('admin_id, type, term', 'numerical', 'integerOnly' => true),
            array('admin_server, victim_server', 'length', 'max' => 64),
            array('victim_id', 'length', 'max' => 16),
            array('reason', 'length', 'max' => 512),
            array('notes', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, when, admin_id, admin_server, victim_id, victim_server, type, term, reason, notes', 'safe', 'on' => 'search'),
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
            'when' => 'When',
            'admin_id' => 'Admin',
            'admin_server' => 'Admin Server',
            'victim_id' => 'Victim',
            'victim_server' => 'Victim Server',
            'type' => 'Type',
            'term' => 'Term',
            'reason' => 'Reason',
            'notes' => 'Notes',
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
        $criteria->compare('when', $this->when, true);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('admin_server', $this->admin_server, true);
        $criteria->compare('victim_id', $this->victim_id, true);
        $criteria->compare('victim_server', $this->victim_server, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('term', $this->term);
        $criteria->compare('reason', $this->reason, true);
        $criteria->compare('notes', $this->notes, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BanLog the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getLogOfUser($id)
    {
        return $this->findAllByAttributes(["victim_id" => $id]);
    }

    private $types = [
        1 => "Пожизненный бан",
        2 => "Пожизненный бан по IP",
        3 => "Временный бан",
        4 => "Временный IP бан",
        5 => "Пожизненный кляп",
        6 => "Временный кляп",
        7 => "Предупреждение",
        8 => "Выброс"
    ];

    private $typesWithColor = [
        1 => "<span style='color: darkred'>Пожизненный бан</span>",
        2 => "<span style='color: darkred'>Пожизненный бан по IP</span>",
        3 => "<span style='color: red'>Временный бан</span>",
        4 => "<span style='color: red'>Временный IP бан</span>",
        5 => "<span style='color: darkblue'>Пожизненный кляп</span>",
        6 => "<span style='color: blue'>Временный кляп</span>",
        7 => "<span style='color: darkgreen'>Предупреждение</span>",
        8 => "<span style='color: yellowgreen'>Выброс</span>"
    ];

    public function getTypeString()
    {
        if (isset($this->types[$this->type]))
            return $this->types[$this->type];
        return "WTF?";
    }

    public function getTypeWithColorString()
    {
        if (isset($this->typesWithColor[$this->type]))
            return $this->typesWithColor[$this->type];
        return "WTF?";
    }

    public function getTermString()
    {
        if (empty($this->term))
            return "";
        return date('d.m.Y H:m:i', $this->term);
    }

    public function getDateString()
    {
        return date('d.m.Y H:m:i', strtotime($this->when));
    }

    public function getDateWithTooltip()
    {
        return '<span rel="tooltip" title="' . $this->getDateString() . '">' . AlexBond::time_since(time() - strtotime($this->when)) . '</span>';
    }
}