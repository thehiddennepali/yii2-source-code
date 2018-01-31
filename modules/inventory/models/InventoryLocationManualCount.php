<?php

namespace inventory\models;

use common\models\User;
use Yii;
use yii\behaviors\AttributeBehavior;
use item\models\Item;
use inventory\models\Location;
use yii\db\AfterSaveEvent;
use yii\helpers\VarDumper;
use measurement\models\Measurement;
use measurement\models\MeasurementItem;

/**
 * This is the model class for table "{{%inventory_location_manual_count}}".
 *
 * @property integer $item_id
 * @property integer $location_id
 * @property string $create_time
 * @property integer $on_hand_quantity
 * @property integer $unit
 * @property string $unitText
 * @property float $cost
 * @property string $count
 * @property string $countCost
 * @property integer $active
 * @property integer $user_id
 * @property string $end_time
 * @property integer $id
 * @property Item $item
 * @property Location $location
 */
class InventoryLocationManualCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_location_manual_count}}';
    }


    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => function ($event) {
                    /* @var $model self */
                    $model = $event->sender;
                    return Yii::$app->user->id;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'create_time',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->on(static::EVENT_AFTER_INSERT, [$this, 'sendAlert']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'sendAlert']);
    }
    public function sendAlert(AfterSaveEvent $event)
    {
        /* @var $model self */
        $model = $event->sender;
        $itemLocation = $model->item->getItemLocation()->andOnCondition(['location_id'=>$model->location_id])->one();
        if($itemLocation && $itemLocation->alert_email
            && $itemLocation->alert_user_id
            && $model->on_hand_quantity<=$itemLocation->low_amount){
            $user = User::findOne($itemLocation->alert_user_id);
            $countToBuy = $itemLocation->par - $model->on_hand_quantity;
            return Yii::$app->mailer->compose()
                ->setTo([$user->email=>$user->fullName])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setSubject("You must buy.")
                ->setTextBody("You must buy {$model->item->item_name} $countToBuy CS")
                ->send();
        }
    }

    public $low_par;

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

    public function getCost()
    {
        $item = $this->item;
        return $this->on_hand_quantity*$item->getConvertedPoundPrice($this->unit);
    }

    public function getCount()
    {
        $return = '';
        if($this->on_hand_quantity>0)
            $return.="$this->on_hand_quantity $this->unitText";
        if($return=='')
            $return=null;
        return $return;
    }

    public function getCountCost()
    {
        if($this->count)
            return $this->count.' = '.Yii::$app->formatter->asCurrency($this->cost);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'location_id'], 'required'],
            [['item_id', 'location_id', 'active', 'user_id'], 'integer'],
            [['create_time', 'end_time', 'unit'], 'safe'],
            [['on_hand_quantity'], 'number'],
            [['create_time',  'active', 'end_time'], 'default', 'value'=>NULL],
            [['unit','on_hand_quantity'], 'default', 'value'=>0],
            [['item_id', 'location_id', 'user_id'], 'default', 'value'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app', 'Item ID'),
            'location_id' => Yii::t('app', 'Location ID'),
            'create_time' => Yii::t('app', 'Create Time'),
            'active' => Yii::t('app', 'Active'),
            'user_id' => Yii::t('app', 'User ID'),
            'end_time' => Yii::t('app', 'End Time'),
            'id' => Yii::t('app', 'ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \inventory\models\query\InventoryLocationManualCountQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \inventory\models\query\InventoryLocationManualCountQuery(get_called_class());
    }


    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'location_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}