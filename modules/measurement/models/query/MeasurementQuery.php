<?php

namespace measurement\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\measurement\models\Measurement]].
 *
 * @see \measurement\models\Measurement
 */
class MeasurementQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \measurement\models\Measurement[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \measurement\models\Measurement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}