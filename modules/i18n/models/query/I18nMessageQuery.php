<?php

namespace i18n\models\query;

/**
 * This is the ActiveQuery class for [[\i18n\models\I18nMessage]].
 *
 * @see \i18n\models\I18nMessage
 */
class I18nMessageQuery extends \yii\db\ActiveQuery
{
    public function language()
    {
        return $this->andWhere("[[language]]='".\Yii::$app->language."'");
    }

    /**
     * @inheritdoc
     * @return \i18n\models\I18nMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \i18n\models\I18nMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
