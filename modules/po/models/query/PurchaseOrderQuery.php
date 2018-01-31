<?php

namespace po\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\po\models\PurchaseOrder]].
 *
 * @see \po\models\PurchaseOrder
 */
class PurchaseOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \po\models\PurchaseOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \po\models\PurchaseOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}