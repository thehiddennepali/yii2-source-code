<?php

namespace inventory\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\inventory\models\InventoryTransfer]].
 *
 * @see \inventory\models\InventoryTransfer
 */
class InventoryTransferQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \inventory\models\InventoryTransfer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\InventoryTransfer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}