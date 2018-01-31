<?php

namespace measurement\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%measurement}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property double $coefficient
 * @property string $type
 * @property string $typeText
 * @property Measurement[] $Measurements
 */
class Measurement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%measurement}}';
    }

    public static $_measurement;
    public static function getMeasurements()
    {
        if(self::$_measurement)
            return self::$_measurement;
        return self::$_measurement = Measurement::find()->indexBy(function(Measurement $data){
            return $data->id;
        })->all();
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
            [['name', 'short_name', 'coefficient', 'type'], 'required'],
            [['coefficient'], 'number'],
            [['type'], 'string'],
            [['name', 'short_name', 'type'], 'default', 'value'=>''],
            [['coefficient'], 'default', 'value'=>0],
            [['name', 'short_name'], 'string', 'max' => 255]
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
            'short_name' => Yii::t('app', 'Short Name'),
            'coefficient' => Yii::t('app', 'Coefficient'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return \measurement\models\query\MeasurementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \measurement\models\query\MeasurementQuery(get_called_class());
    }


    public $typeValues = [
        'Volume'=>'Volume',
        'Weight'=>'Weight',
        'Other'=>'Other',
    ];
    public function getTypeText()
    {
        return isset($this->typeValues[$this->type]) ? $this->typeValues[$this->type]:null;
    }


}