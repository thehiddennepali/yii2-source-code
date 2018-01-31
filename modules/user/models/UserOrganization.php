<?php

namespace user\models;

use Yii;
use yii\behaviors\AttributeBehavior;


/**
 * This is the model class for table "{{%user_organization}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $organization_id
 * @property string $user_type
 * @property string $update_time
 */
class UserOrganization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_organization}}';
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
            [['user_id', 'organization_id'], 'required'],
            [['user_id', 'organization_id'], 'integer'],
            [['update_time'], 'safe'],
            [['user_type', 'update_time'], 'default', 'value'=>NULL],
            [['user_id', 'organization_id'], 'default', 'value'=>0],
            [['user_type'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'organization_id' => Yii::t('app', 'Organization ID'),
            'user_type' => Yii::t('app', 'User Type'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return \user\models\query\UserOrganizationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \user\models\query\UserOrganizationQuery(get_called_class());
    }



}