<?php

namespace inventory\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use inventory\models\Location;
use inventory\models\Category;
use user\models\User;
use inventory\models\InventoryLocationManualCount;

/**
 * This is the model class for table "{{%inventory_sheet}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $status
 * @property integer $location_id
 * @property integer $sub_location_id
 * @property integer $category_id
 * @property Category $category
 * @property Location $location
 * @property User $user
 * @property InventoryLocationManualCount[] $inventoryLocationManualCounts
 */
class InventorySheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_sheet}}';
    }


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

		$this->statusValues = [
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'location_id', 'name'], 'required'],
            [['user_id', 'status', 'location_id', 'sub_location_id', 'category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['status', 'default', 'value'=>0],
            [['name', 'location_id', 'sub_location_id', 'category_id'], 'default', 'value'=>NULL],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'location_id' => Yii::t('app', 'Location ID'),
            'sub_location_id' => Yii::t('app', 'Sub Location ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \inventory\models\query\InventorySheetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \inventory\models\query\InventorySheetQuery(get_called_class());
    }


	public $statusValues;
    public function getStatusText()
    {
        return isset($this->statusValues[$this->status]) ? $this->statusValues[$this->status]:null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventoryLocationManualCounts()
    {
        return $this->hasMany(InventoryLocationManualCount::className(), ['inventory_sheet_id' => 'id']);
    }

}