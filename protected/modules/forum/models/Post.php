<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property integer $author_id
 * @property integer $thread_id
 * @property integer $editor_id
 * @property string $content
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Thread $thread Thread this post lives in
 * @property Users $user User who posted this
 */
class Post extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'forumPost';
    }

    public function getTableAlias($quote = false, $checkScopes = true)
    {
        return 'forumPost';
    }

    /**
     * @return array primary key of the table
     * */
    public function primaryKey()
    {
        return array('id');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
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
            //'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
            'thread' => array(self::BELONGS_TO, 'Thread', 'thread_id'),
            //'editor' => array(self::BELONGS_TO, 'Users', 'editor_id'),
        );
    }

    public function getAuthor()
    {
        return Users::model()->cache(3600)->findByPk($this->author_id);
    }

    public function getEditor()
    {
        return Users::model()->cache(3600)->findByPk($this->editor_id);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'ID',
            'author_id' => 'Author',
            'thread_id' => 'Thread',
            'editor_id' => 'Editor',
            'content' => 'Текст',
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
        ));
    }

    /**
     * Manage the created/updated fields
     */
    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();
        $this->updated = time();
        $p = new CHtmlPurifier();
        $this->content = $p->purify($this->content);
        return parent::beforeSave();
    }

    public function afterSave()
    {
        $this->thread->recalculatePosts();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('content', $this->content, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterDelete()
    {
        if (!$this->thread->firstPost) {
            $this->thread->delete();
        }
        $this->thread->recalculatePosts();
        $this->thread->updateLastPost();
    }

}
