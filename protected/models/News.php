<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $meta_title
 * @property string $meta_desc
 * @property string $meta_keywords
 * @property string $meta_robots
 * @property string $meta_autor
 * @property string $alias
 * @property string $header
 * @property string $data
 * @property string $short_data
 * @property string $cdate
 * @property string $udate
 * @property integer $author
 */
class News extends CActiveRecord
{

    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('meta_title, alias, header, data, short_data, udate, author', 'required'),
            array('author', 'numerical', 'integerOnly' => true),
            array('meta_title, meta_desc, meta_keywords', 'length', 'max' => 2048),
            array('meta_robots, meta_autor', 'length', 'max' => 512),
            array('alias', 'length', 'max' => 256),
            array('alias', 'unique'),
            array('header', 'length', 'max' => 1024),
            array('cdate', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, meta_title, meta_desc, meta_keywords, meta_robots, meta_autor, alias, header, data, short_data, cdate, udate, author', 'safe', 'on' => 'search'),
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
            "user" => [self::BELONGS_TO, "Users", "author"]
        );
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
            'meta_autor' => 'Meta Autor',
            'header' => 'Название',
            'data' => 'Полный текст',
            'short_data' => 'Краткое описание',
            'cdate' => 'Дата',
            'udate' => 'Udate',
            'author' => 'Автор',
            'active' => 'Активность',
            'image' => 'Изображение',
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
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_desc', $this->meta_desc, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_robots', $this->meta_robots, true);
        $criteria->compare('meta_autor', $this->meta_autor, true);
        $criteria->compare('header', $this->header, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('short_data', $this->short_data, true);
        $criteria->compare('cdate', $this->cdate, true);
        $criteria->compare('udate', $this->udate, true);
        $criteria->compare('author', $this->author);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function defaultScope()
    {
        return [
            "condition" => "active=1",
            "order" => "cdate DESC"
        ];
    }

    public function beforeValidate()
    {
        if (strlen($this->cdate) != 10) {
            $this->cdate = new CDbExpression('NOW()');
        } else {
            $this->cdate = date_format(date_create($this->cdate), 'Y-m-d');
        }
        if ($this->meta_title == '' OR $this->meta_title == NULL) {
            $this->meta_title = $this->header;
        }
        return parent::beforeValidate();
    }

    public function afterFind()
    {
        $this->cdate = date_format(date_create($this->cdate), 'd-m-Y');
    }

    public function afterSave()
    {
        if ($this->image != null) {
            if ($this->image['error'] == 0 && strlen($this->image['name']) > 0) {
                if (is_file(Yii::app()->params['storeImages']['path'] . "news/" . $this->id . ".png")) unlink(Yii::app()->params['storeImages']['path'] . "news/" . $this->id . ".png");
                $img = Yii::app()->imagemod->load($this->image);
                $img->file_new_name_body = $this->id;
                $x = $img->image_src_x;
                $y = $img->image_src_y;
                $img->file_new_name_ext = 'png';
                $img->process(Yii::app()->params['storeImages']['path'] . 'news/');
            }
        }
        parent::afterSave();
    }

    public function afterDelete()
    {
        if (is_file(Yii::app()->params['storeImages']['path'] . 'news/' . $this->id . '.png')) unlink(Yii::app()->params['storeImages']['path'] . 'news/' . $this->id . '.png');
        parent::afterDelete();
    }

    /**
     * Get url to product image. Enter $size to resize image.
     * @param mixed $size New size of the image. e.g. '150x150'
     * @param mixed $resizeMethod Resize method name to override config. resize/adaptiveResize
     * @param mixed $random Add random number to the end of the string
     * @return string
     */
    public function getImage($size = false, $resizeMethod = false, $random = false)
    {
        if ($size !== false) {
            if ($resizeMethod === false)
                $resizeMethod = Yii::app()->params['storeImages']['sizes']['resizeThumbMethod'];
            $thumbPath = Yii::app()->params['storeImages']['thumbPath'] . '/news/' . $size . $resizeMethod;
            if (!file_exists($thumbPath))
                mkdir($thumbPath);

            // Path to source image
            $fullPath = Yii::app()->params['storeImages']['path'] . 'news/' . $this->id . ".png";
            // Path to thumb
            $thumbPath = $thumbPath . '/' . $this->id . ".png";

            if (!file_exists($thumbPath)) {
                // Resize if needed
                Yii::import('ext.phpthumb.PhpThumbFactory');
                $sizes = explode('x', $size);
                $thumb = PhpThumbFactory::create($fullPath);

                if ($resizeMethod == "inlineResize")
                    $thumb->$resizeMethod($sizes[0], $sizes[1], array(255, 255, 255))->save($thumbPath);
                else
                    $thumb->$resizeMethod($sizes[0], $sizes[1])->save($thumbPath);
            }

            return Yii::app()->params['storeImages']['thumbUrl'] . '/news/' . $size . $resizeMethod . '/' . $this->id . ".png";
        }

        if ($random === true)
            return Yii::app()->params['storeImages']['url'] . '/news/' . $this->id . ".png" . ' ? ' . rand(1, 10000);
        return Yii::app()->params['storeImages']['url'] . '/news/' . $this->id . ".png";
    }

    public function scopes()
    {
        return [
            "last2" => ["limit" => 2]
        ];
    }

    public function getUrl()
    {
        return $this->link;
    }
}