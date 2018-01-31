<?php

namespace inventory\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\inventory\models\ItemLocation]].
 *
 * @see \inventory\models\ItemLocation
 */
class ItemLocationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \inventory\models\ItemLocation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\ItemLocation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}