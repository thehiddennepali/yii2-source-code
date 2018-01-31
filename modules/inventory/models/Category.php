<?php

namespace inventory\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $category_name
 * @property integer $priority
 * @property string $cat_type
 * @property integer $published
 * @property string $url
 * @property string $description
 * @property integer $organization_id
 *
 * @property ItemCategory[] $itemCategories
 * @property Item[] $items
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /*
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => function ($event) {
                    // @var $model self
                    $model = $event->sender;
                    return Yii::$app->user->id;
                },
            ],
        ];
    }
    */

    public function init()
    {
        parent::init();
        //$this->on(static::EVENT_BEFORE_INSERT, [$this, 'someFunction']);
        //$this->on(static::EVENT_BEFORE_UPDATE, [$this, 'someFunction']);
        /*
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            // @var $model self
            $model = $event->sender;
        });
        */

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'priority', 'published', 'organization_id'], 'integer'],
            [['category_name'], 'required'],
            [['cat_type'], 'string'],
            [['parent_id', 'priority', 'cat_type', 'published', 'url', 'description', 'organization_id'], 'default', 'value'=>NULL],
            [['category_name'], 'default', 'value'=>''],
            [['category_name'], 'string', 'max' => 45],
            [['url'], 'string', 'max' => 55],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'category_name' => Yii::t('app', 'Category Name'),
            'priority' => Yii::t('app', 'Priority'),
            'cat_type' => Yii::t('app', 'Cat Type'),
            'published' => Yii::t('app', 'Published'),
            'url' => Yii::t('app', 'Url'),
            'description' => Yii::t('app', 'Description'),
            'organization_id' => Yii::t('app', 'Organization ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCategories()
    {
        return $this->hasMany(ItemCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('{{%item_category}}', ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \inventory\models\query\CategoryQuery(get_called_class());
    }



}