<?php

namespace inventory\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%item_location}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $location_id
 * @property string $lot_id
 * @property string $update_time
 * @property string $item_description
 * @property string $on_hand
 * @property integer $low_amount
 * @property integer $par
 * @property integer $alert_user_id
 * @property boolean $alert_email
 */
class ItemLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item_location}}';
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




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'location_id'], 'required'],
            [['item_id', 'location_id'], 'integer'],
            [['update_time'], 'safe'],
            [['item_description'], 'string'],
            [['on_hand'], 'number'],
            [['lot_id', 'update_time', 'item_description', 'on_hand'], 'default', 'value'=>NULL],
            [['item_id', 'location_id'], 'default', 'value'=>0],
            [['lot_id'], 'string', 'max' => 45],
            [['low_amount', 'par', 'alert_user_id'], 'integer'],
            [['alert_email'], 'boolean'],
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
            'location_id' => Yii::t('app', 'Location ID'),
            'lot_id' => Yii::t('app', 'Lot ID'),
            'update_time' => Yii::t('app', 'Update Time'),
            'item_description' => Yii::t('app', 'Item Description'),
            'on_hand' => Yii::t('app', 'On Hand'),
        ];
    }

    /**
     * @inheritdoc
     * @return \inventory\models\query\ItemLocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \inventory\models\query\ItemLocationQuery(get_called_class());
    }



}