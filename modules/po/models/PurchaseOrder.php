<?php

namespace po\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $user_id
 * @property integer $supplier_id
 * @property integer $location_id
 * @property integer $shipping_address_id
 * @property string $requested_delivery_date
 * @property string $requested_delivery_time
 * @property double $food_cost_est
 * @property double $food_cost_act
 * @property double $total_cost_act
 * @property double $total_cost_est
 * @property double $shipping_cost_act
 * @property double $shipping_cost_est
 * @property string $total_price
 * @property string $sales_tax
 * @property string $total_weight
 * @property string $total_volume
 * @property string $create_time
 * @property string $update_time
 * @property string $shipping_configuration
 * @property string $special_instructions
 * @property string $estimated_delivery_date
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'supplier_id', 'location_id', 'shipping_address_id'], 'required'],
            [['id', 'parent_id', 'user_id', 'supplier_id', 'location_id', 'shipping_address_id'], 'integer'],
            [['requested_delivery_date', 'create_time', 'update_time', 'estimated_delivery_date'], 'safe'],
            [['food_cost_est', 'food_cost_act', 'total_cost_act', 'total_cost_est', 'shipping_cost_act', 'shipping_cost_est', 'total_price', 'sales_tax', 'total_weight', 'total_volume'], 'number'],
            [['shipping_configuration'], 'string'],
            [['requested_delivery_time'], 'string', 'max' => 12],
            [['special_instructions'], 'string', 'max' => 511],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'there can be a separate PO (or multiple) for shipping',
            'user_id' => 'needs to come from a user',
            'supplier_id' => 'needs to be to a supplier',
            'location_id' => 'needs to be for a location',
            'shipping_address_id' => 'Shipping Address ID',
            'requested_delivery_date' => 'when customer wants the order to be delivered',
            'requested_delivery_time' => 'am, pm or hour (if shipper supports that)',
            'food_cost_est' => 'total cost of all the items inside',
            'food_cost_act' => 'what distributo',
            'total_cost_act' => 'what distributo',
            'total_cost_est' => 'Total Cost Est',
            'shipping_cost_act' => 'actual shipper fees',
            'shipping_cost_est' => 'actual shipper fees',
            'total_price' => 'what the customer is charged, not used',
            'sales_tax' => 'collected from app',
            'total_weight' => 'Total Weight',
            'total_volume' => 'Total Volume',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'shipping_configuration' => 'boxes, trays, load in json format',
            'special_instructions' => 'Special Instructions',
            'estimated_delivery_date' => 'when availability manager calculates customer delivery',
        ];
    }
}
