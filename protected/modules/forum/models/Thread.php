<?php

/**
 * This is the model class for table "thread".
 *
 * The followings are the available columns in table 'thread':
 * @property integer $id
 * @property integer $forum_id
 * @property string $subject Thread subject
 * @property boolean $is_sticky Sticky thread
 * @property boolean $is_locked Locked thread
 * @property boolean $is_hidden Hidden thread
 * @property string icon Thread icon
 * @property string $notes Thread notes
 * @property integer $view_count (stat cache) Number of time thread was read
 *
 * The followings are the available model relations:
 * @property Forum $forum Forum this thread lives in
 */
class Thread extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Thread the static model class
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
        return 'forumThread';
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
            array('subject', 'required'),
            array('subject', 'length', 'max' => 120),
            /**
             * Normally, this would allow anyopne to set these, even non-admins,
             * however, since normal users do not create threads directly, hut
             * as part of a post (PostForm model), this one is only used by
             * admins, who acgtually need to be able to set these.
             */
            array('is_sticky, is_locked, is_hidden', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('subject', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Default scope to always apply to this model
     */
    public function defaultScope()
    {
        return array(
            'order' => $this->getTableAlias(false, false) . '.is_sticky DESC, ' . $this->getTableAlias(false, false) . '.created DESC, ' . $this->getTableAlias(false, false) . '.subject',
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
            'forum' => array(self::BELONGS_TO, 'Forum', 'forum_id'),

            'posts' => array(self::HAS_MANY, 'Post', 'thread_id', 'order' => 'posts.created'),
            'postCountInternal' => array(self::STAT, 'Post', 'thread_id'),

            'lastPost' => array(self::HAS_ONE, 'Post', 'thread_id', 'order' => 'lastPost.created DESC'),
            'firstPost' => array(self::HAS_ONE, 'Post', 'thread_id', 'order' => 'firstPost.created ASC')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'id' => 'ID',
            'forum_id' => 'Форум',
            'subject' => 'Тема',
            'is_sticky' => 'Прикреплена?',
            'is_locked' => 'Закрыта?',
            'view_count' => 'Кол. просмотров',
            'created' => 'Дата создания',
        ));
    }

    /**
     * Manage the created fields
     */
    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();
        $p = new CHtmlPurifier();
        $this->subject = $p->purify($this->subject);

        return parent::beforeSave();
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

        $criteria->compare('subject', $this->subject, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Return the url to this thread
     */
    public function getUrl()
    {
        return Yii::app()->createUrl('/forum/thread/view', array('id' => $this->id));
    }

    /**
     * Returns breadcrumbs array to this forum
     */
    public function getBreadcrumbs($currentlink = false)
    {
        return array_merge(
            $this->forum->getBreadcrumbs(true),
            ($currentlink ? array(CHtml::encode($this->subject) => array('/forum/thread/view', 'id' => $this->id)) : array(CHtml::encode($this->subject)))
        // array(isset($this->subject)?$this->subject:'New thread')
        );
    }

    /**
     * Return the first post in this thread (or null)
     */
    /*public function getFirstPost()
    {
        $result = Post::model()->findByAttributes(
            array('thread_id' => $this->id),
            array('order' => 'created', 'limit' => 1)
        );
        return $result;
    }*/

    /**
     * Return the last post in this thread (or null)
     */
    public function getLastPost()
    {
        $result = Post::model()->findByAttributes(
            array('thread_id' => $this->id),
            array('order' => 'created DESC', 'limit' => 1)
        );
        return $result;
    }

    public function renderSubjectCell()
    {
        /*$firstpost = $this->firstPost;
        if (null == $firstpost) return '<div style="text-align:center;">-</div>';*/

        $subjlink = CHtml::link(CHtml::encode($this->subject), $this->url);
        $authorlink = Users::model()->getUsernameWithLink($this->author_id, true);

        return '<div class="name">' . $subjlink . '</div>' .
        '<div class="level2"><small>' . $authorlink . ' ' . AlexBond::time_since(time() - $this->created) . '</small></div>';
    }

    public function renderLastpostCell()
    {
        //$lastpost = $this->lastPost;
        //if (null == $lastpost) return '<div style="text-align:center;">-</div>';

        return '<div style="position:relative; text-align: left;">
<a class="pull-left" style="position:relative; margin: 4px 5px 0 0;">
' . Users::model()->getAvatar(Users::model()->getUserNameFromID($this->lastPost_user_id), 32) . '
</a>
' . Users::model()->getUsernameWithLink($this->lastPost_user_id, true) . '
<div>
<small>' . AlexBond::time_since(time() - $this->lastPost_time) . '</small>
</div>
</div>';
    }

    public function getIcon()
    {
        if ($this->is_hidden)
            return "<i class='fa fa-adjust '>";
        if ($this->is_locked)
            return "<i class='fa fa-times-circle '>";
        if ($this->is_sticky)
            return "<i class='fa fa-star '>";

        return "<i class='fa fa-caret-square-o-right '>";
    }

    public function recalculatePosts()
    {
        $this->post_count = $this->postCountInternal;
        $this->save(false);
    }

    public function updateLastPost()
    {
        $this->lastPost_user_id = $this->lastPost->user_id;
        $this->lastPost_time = $this->lastPost->created;
        $this->save(false);
    }

}
