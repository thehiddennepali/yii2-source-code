<?php

namespace measurement\models;

use Yii;

/**
 * This is the ActiveQuery class for [[MeasurementItem]].
 *
 * @see MeasurementItem
 */
class MeasurementItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MeasurementItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MeasurementItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}