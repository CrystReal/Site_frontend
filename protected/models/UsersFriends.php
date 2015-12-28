<?php

/**
 * This is the model class for table "usersFriends".
 *
 * The followings are the available columns in table 'usersFriends':
 * @property integer $id
 * @property integer $first_user
 * @property integer $second_user
 * @property integer $approved
 * @property integer $since
 * @property integer $request
 */
class UsersFriends extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'usersFriends';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_user, second_user, since, request', 'required'),
            array('first_user, second_user, approved, since, request', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, first_user, second_user, approved, since, request', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            "u1" => [self::BELONGS_TO, "Users", "first_user"],
            "u2" => [self::BELONGS_TO, "Users", "second_user"]
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_user' => 'First User',
            'second_user' => 'Second User',
            'approved' => 'Approved',
            'since' => 'Since',
            'request' => 'Request',
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
        $criteria->compare('first_user', $this->first_user);
        $criteria->compare('second_user', $this->second_user);
        $criteria->compare('approved', $this->approved);
        $criteria->compare('since', $this->since);
        $criteria->compare('request', $this->request);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UsersFriends the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getUserFriends($id)
    {
        return $this->findAll("first_user=:id OR second_user=:id", [":id" => $id]);
    }

    public function getFriendship($id, $id2)
    {
        return $this->find("(first_user=:id AND second_user=:id2) OR (first_user=:id2 AND second_user=:id)", [":id" => $id, ":id2" => $id2]);
    }

    const WAITING = 0;
    const APPROVED = 1;
    const DECLINED = 2;

    public function scopes()
    {
        return [
            "approved" => [
                "condition" => "approved=" . self::APPROVED
            ],
            "pending" => [
                "condition" => "approved=" . self::WAITING
            ],
            "declined" => [
                "condition" => "approved=" . self::DECLINED
            ],
        ];
    }
}