<?php

namespace item\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%po_item}}".
 *
 * @property integer $id
 * @property integer $po_id
 * @property integer $item_id
 * @property integer $vendor_id
 * @property integer $quantity
 * @property string $create_time
 * @property string $update_time
 * @property double $exp_cost
 * @property double $act_cost
 * @property string $status
 */
class PurchaseOrderItem extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%po_item}}';
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

    const STATUS_AWAITING='awaiting';
    const STATUS_RECEIVED='received';
    const STATUS_PARTIALLY_RECEIVED='partially_received';

    public $statusValues=[
        self::STATUS_AWAITING=>'Awaiting',
        self::STATUS_RECEIVED=>'received',
        self::STATUS_PARTIALLY_RECEIVED=>'partially_received',
    ];
    public function getStatusText()
    {
        return isset($this->statusValues[$this->status]) ? $this->statusValues[$this->status]:null;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['po_id', 'item_id', 'vendor_id', 'quantity'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['exp_cost', 'act_cost'], 'number'],
            [['status'], 'string'],
            [['po_id', 'item_id', 'vendor_id', 'quantity', 'create_time', 'update_time', 'exp_cost', 'act_cost', 'status'], 'default', 'value'=>NULL]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'po_id' => Yii::t('app', 'Po ID'),
            'item_id' => Yii::t('app', 'Item ID'),
            'vendor_id' => Yii::t('app', 'Vendor ID'),
            'quantity' => Yii::t('app', 'Quantity'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'exp_cost' => Yii::t('app', 'Exp Cost'),
            'act_cost' => Yii::t('app', 'Act Cost'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return \item\models\query\PurchaseOrderItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \item\models\query\PurchaseOrderItemQuery(get_called_class());
    }



}