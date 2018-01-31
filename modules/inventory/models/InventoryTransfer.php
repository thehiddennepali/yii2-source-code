<?php

namespace inventory\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%inventory_transfer}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $create_time
 * @property string $user_id
 * @property integer $from_id
 * @property integer $to_id
 * @property integer $po_lot_id
 * @property integer $created_at
 * @property integer $quantity
 * @property string $type
 */
class InventoryTransfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_transfer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id', 'to_id', 'quantity'], 'required'],
            [['item_id', 'from_id', 'to_id', 'po_lot_id', 'created_at', 'quantity'], 'integer'],
            [['create_time'], 'safe'],
            [['type'], 'string'],
            [['create_time', 'from_id', 'po_lot_id', 'created_at', 'type'], 'default', 'value'=>NULL],
            [['user_id'], 'default', 'value'=>''],
            [['item_id', 'to_id', 'quantity'], 'default', 'value'=>0],
            [['user_id'], 'string', 'max' => 64]
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
            'create_time' => Yii::t('app', 'Create Time'),
            'user_id' => Yii::t('app', 'User ID'),
            'from_id' => Yii::t('app', 'From ID'),
            'to_id' => Yii::t('app', 'To ID'),
            'po_lot_id' => Yii::t('app', 'Po Lot ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'quantity' => Yii::t('app', 'Quantity'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return \inventory\models\query\InventoryTransferQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \inventory\models\query\InventoryTransferQuery(get_called_class());
    }



}