<?php

namespace measurement\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%measurement_item}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $master_unit
 * @property string $name
 * @property double $factor
 */
class MeasurementItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%measurement_item}}';
    }

    public static $_measurement;
    public static function getMeasurements()
    {
        if(self::$_measurement)
            return self::$_measurement;
        return self::$_measurement = MeasurementItem::find()->indexBy(function(MeasurementItem $data){
            return 'alt:'.$data->id;
        })->all();
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

    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'master_unit', 'name', 'factor'], 'required'],
            [['item_id', ], 'integer'],
            [['factor'], 'number'],
            [['name'], 'default', 'value'=>''],
            [['item_id', 'master_unit', 'factor'], 'default', 'value'=>0],
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
            'item_id' => Yii::t('app', 'Item ID'),
            'master_unit' => Yii::t('app', 'Master Unit'),
            'name' => Yii::t('app', 'Name'),
            'factor' => Yii::t('app', 'Factor'),
        ];
    }

    /**
     * @inheritdoc
     * @return MeasurementItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MeasurementItemQuery(get_called_class());
    }



}