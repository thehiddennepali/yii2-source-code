<?php

namespace i18n\models;

use Yii;

/**
 * This is the model class for table "{{%i18n_message}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 * @property string $languageText
 *
 * @property I18nSourceMessage $id0
 */
class I18nMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%i18n_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => I18nSourceMessage::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(I18nSourceMessage::className(), ['id' => 'id']);
    }



    /**
     * @inheritdoc
     * @return \i18n\models\query\I18nMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \i18n\models\query\I18nMessageQuery(get_called_class());
    }

    public function getLanguageText()
    {
        return (new I18nSourceMessage())->languageValues[$this->language];
    }
}
