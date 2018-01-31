<?php

namespace item\models\query;
use item\models\Item;

/**
 * This is the ActiveQuery class for [[\item\models\Item]].
 *
 * @see \item\models\Item
 */
class ItemQuery extends \yii\db\ActiveQuery
{
    public function onlyRaw()
    {
        return $this->andWhere(['item_type'=>Item::TYPE_RAW]);
    }

    /**
     * @inheritdoc
     * @return \item\models\Item[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \item\models\Item|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
