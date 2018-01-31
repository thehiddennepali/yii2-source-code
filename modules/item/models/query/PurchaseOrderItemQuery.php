<?php

namespace item\models\query;

use item\models\PurchaseOrderItem;
use Yii;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\item\models\PurchaseOrderItem]].
 *
 * @see \item\models\PurchaseOrderItem
 */
class PurchaseOrderItemQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        return $this->from(['po_item'=>PurchaseOrderItem::tableName()]);
    }
    public function lastActual($on_hand)
    {

        //here first must be subquery, because I must order records by create_time to get the last records
        $query = new self(PurchaseOrderItem::className());

        $subQuery = $this;
        $subQuery->received();
        $subQuery->dateOrderDesc();
        $query->from(['ordered_po_item'=>"({$subQuery->createCommand()->rawSql})"]);

        //here is condition, it will get records until count reached on_hand in inventory
        Yii::$app->db->createCommand("SET @count=0;")->execute();
        $query->addSelect(['*', new Expression("@count:=@count+quantity")]);
        $query->andWhere("@count<'$on_hand'");
        return $query;
    }
    public function received()
    {
        $this->andWhere(['status'=>PurchaseOrderItem::STATUS_RECEIVED]);
        return $this;
    }

    public function dateOrder()
    {
        $this->orderBy('create_time');
        return $this;
    }

    public function dateOrderDesc()
    {
        $this->orderBy('create_time DESC');
        return $this;
    }

    /**
     * @inheritdoc
     * @return \item\models\PurchaseOrderItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \item\models\PurchaseOrderItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}