<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property integer $id
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_keywords
 * @property string $meta_robots
 * @property string $meta_author
 * @property string $meta_menu
 * @property string $alias
 * @property integer $parent
 * @property string $header
 * @property string $data
 * @property integer $feedback
 * @property integer $candelete
 * @property integer $sort
 * @property integer $type
 * @property integer $menu_show
 * @property integer $iscat
 * @property integer $isInContent
 */
class StaticPages extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return StaticPages the static model class
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
        return 'static_pages';
    }

    /**
     * @return array validation rules for model attributes.
     */

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('meta_title, meta_menu, alias, header, data', 'required'),
            array('alias', 'unique', 'message' => 'Такой алиас уже существует'),
            array('parent, feedback, candelete, sort, type, menu_show, iscat, isInCat', 'numerical', 'integerOnly' => true),
            array('meta_title, meta_desc, meta_keywords', 'length', 'max' => 2048),
            array('meta_robots, meta_author', 'length', 'max' => 512),
            array('meta_menu, header', 'length', 'max' => 1024),
            array('alias', 'length', 'max' => 256),
            array('sort', 'default',
                'value' => 0,
                'setOnEmpty' => true),
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
            'meta_title' => 'Meta Title',
            'meta_desc' => 'Meta Desc',
            'meta_keywords' => 'Meta Keywords',
            'meta_robots' => 'Meta Robots',
            'meta_author' => 'Meta Autor',
            'alias' => 'Alias',
            'header' => 'Name',
            'data' => 'Data',
        );
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

        $criteria->compare('id', $this->id);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_desc', $this->meta_desc, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_robots', $this->meta_robots, true);
        $criteria->compare('meta_autor', $this->meta_autor, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('header', $this->header, true);
        $criteria->compare('data', $this->data, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope()
    {
        return array(
            'order' => "sort ASC",
        );
    }

    public function scopes()
    {
        return array(
            'notCategory' => array(
                'condition' => 'iscat=0',
            )
        );
    }


    public function beforeValidate()
    {
        if (empty($this->meta_title)) {
            $this->meta_title = $this->header;
        }
        if (empty($this->meta_menu)) {
            $this->meta_menu = $this->header;
        }
        if (empty($this->alias)) {
            Yii::import("application.helpers.toTranslit");
            $this->alias = toTranslit::make($this->alias, $this->meta_title);
        }
        if (empty($this->data) && $this->iscat == 1) {
            $this->data = "Not required";
        }
        return parent::beforeValidate();
    }

    public function findByAlias($alias, $parent = 0)
    {
        $ret = $this->find(array(
            'condition' => 'alias=:alias AND parent=:p',
            'params' => array(':alias' => $alias, ':p' => $parent),
        ));
        return $ret;
    }

    public function beforeDelete()
    {
        $this->updateAll('parent=' . $this->parent, 'parent=:id', array(':id' => $this->id));
    }

    public function getArrayDropDown($now = NULL)
    {
        $arr = array('0' => 'Root');
        $o = CMap::mergeArray($arr, $this->getArrayToDropDown($now));
        return $o;
    }

    private function getArrayToDropDown($now, $id = 0, $level = 0)
    {
        $o = array();
        $base = $this->getSubPages($id);
        $s_text = '';
        //$i = $level==0?-1:0;
        for ($i = -1; $i < $level; $i++) {
            $s_text .= "|—";
        }
        if (count($base) > 0 and ($id != $now OR $now == NULL)) {
            foreach ($base as $item) {
                if ($now != $item['id'])
                    //$o = array_merge($o, array((int) $item['id'] => $s_text . $item['header']));
                    if ($item['candelete'] == 0)
                        $o[$item['id']] = $s_text . $item['header'];
                $o = CMap::mergeArray($o, $this->getArrayToDropDown($now, $item['id'], $level + 1));
            }
        }
        return $o;
    }

    private function getSubPages($id)
    {
        return $this->findAll(array(
            'condition' => 'parent=:parent',
            'params' => array(':parent' => $id),
        ));
    }

    public function afterDelete()
    {
        $this->rrmdir("./static/upload/static/" . $this->id);
        parent::afterDelete();
    }

    private function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") $this->rrmdir($dir . "/" . $object); else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function getParents($id = null, $root = true)
    {
        $out = array();
        if ($id == null)
            $obj = $this;
        else
            $obj = $this->findByPk($id);
        if (!$obj)
            throw new CException("Object on recursion of static fount not found");
        if ($obj->parent != 0) {
            $model = $this->findByPk($obj->parent);
            $out[] = $model;
            if ($model->parent != 0)
                $out = array_merge($out, $this->getParents($model->id, false));
        }
        if ($root)
            return array_reverse($out);
        else
            return $out;
    }
}