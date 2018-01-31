<?php

namespace inventory\models;

use Yii;

/**
 * This is the model class for table "{{%location}}".
 *
 * @property integer $id
 * @property integer $organization_id
 * @property string $nickname
 * @property string $region_name
 * @property integer $enabled
 * @property integer $timezone
 * @property string $availability_cut_off_time
 * @property string $foodbuy_id
 *
 * @property Organization $organization
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%location}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'enabled', 'timezone'], 'integer'],
            [['nickname'], 'required'],
            [['availability_cut_off_time'], 'safe'],
            [['nickname'], 'string', 'max' => 50],
            [['region_name'], 'string', 'max' => 45],
            [['foodbuy_id'], 'string', 'max' => 255],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::className(), 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'organization_id' => Yii::t('app', 'Organization ID'),
            'nickname' => Yii::t('app', 'Nickname'),
            'region_name' => Yii::t('app', 'Region Name'),
            'enabled' => Yii::t('app', 'Enabled'),
            'timezone' => Yii::t('app', 'Timezone'),
            'availability_cut_off_time' => Yii::t('app', 'Availability Cut Off Time'),
            'foodbuy_id' => Yii::t('app', 'Foodbuy ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\query\LocationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \inventory\models\query\LocationQuery(get_called_class());
    }
}
