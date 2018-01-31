<?php

namespace inventory\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\inventory\models\InventoryLocationManualCount]].
 *
 * @see \inventory\models\InventoryLocationManualCount
 */
class InventoryLocationManualCountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \inventory\models\InventoryLocationManualCount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\InventoryLocationManualCount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}