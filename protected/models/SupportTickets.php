<?php

/**
 * This is the model class for table "supportTickets".
 *
 * The followings are the available columns in table 'supportTickets':
 * @property integer $id
 * @property integer $userId
 * @property string $subject
 * @property integer $dateCreated
 * @property integer $status
 */
class SupportTickets extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'supportTickets';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userId, subject, dateCreated', 'required'),
            array('userId, dateCreated, status', 'numerical', 'integerOnly' => true),
            array('subject', 'length', 'max' => 1024),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, userId, subject, dateCreated, status', 'safe', 'on' => 'search'),
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
            "user" => [self::BELONGS_TO, "Users", "userId"],
            "comments" => [self::HAS_MANY, "SupportTicketsComments", "ticketId"]
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'userId' => 'User',
            'subject' => 'Subject',
            'dateCreated' => 'Date Created',
            'status' => 'Status',
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
        $criteria->compare('userId', $this->userId);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('dateCreated', $this->dateCreated);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SupportTickets the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getStatusLabel()
    {
        switch ($this->status) {
            case 0:
                return '<span class="label label-danger">Ожидает ответа</span>';
            case 1:
                return '<span class="label label-success">Ответ получен</span>';
            case 2:
                return '<span class="label label-default">Закрыт</span>';
        }
    }
}