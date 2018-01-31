<?php

namespace inventory\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\inventory\models\InventorySheet]].
 *
 * @see \inventory\models\InventorySheet
 */
class InventorySheetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \inventory\models\InventorySheet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\InventorySheet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}