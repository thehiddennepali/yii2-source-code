<?php

namespace recipe\models;

use item\models\Item;
use measurement\models\MeasurementItem;
use Yii;
use yii\behaviors\AttributeBehavior;
use measurement\models\Measurement;


/**
 * This is the model class for table "{{%ingredient}}".
 *
 * @property integer $item_id
 * @property integer $parent_id
 * @property double $amount
 * @property string $update_time
 * @property integer $include_labor
 * @property integer $include_packing
 * @property string $unit
 * @property string $unitText
 * @property Item $item
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ingredient}}';
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
            [['item_id', 'parent_id'], 'required'],
            [['amount', 'unit'], 'required'],
            [['item_id', 'parent_id', 'include_labor', 'include_packing'], 'integer'],
            [['amount'], 'number'],
            [['update_time'], 'safe'],
            [['amount', 'update_time', 'include_labor', 'include_packing', 'unit'], 'default', 'value'=>NULL],
            [['item_id', 'parent_id'], 'default', 'value'=>0],
            [['unit'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app', 'Item ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'amount' => Yii::t('app', 'Amount'),
            'update_time' => Yii::t('app', 'Update Time'),
            'include_labor' => Yii::t('app', 'Include Labor'),
            'include_packing' => Yii::t('app', 'Include Packing'),
            'unit' => Yii::t('app', 'Unit'),
        ];
    }

    /**
     * @inheritdoc
     * @return IngredientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IngredientQuery(get_called_class());
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }


    public function getUnitText()
    {
        $measures = Measurement::getMeasurements();
        if(isset($measures[$this->unit]))
            return $measures[$this->unit]->short_name;

        $measures = MeasurementItem::getMeasurements();
        if(isset($measures[$this->unit]))
            return $measures[$this->unit]->name;

        return $this->unit;
    }



}