<?php

namespace inventory\models\query;

/**
 * This is the ActiveQuery class for [[\inventory\models\Location]].
 *
 * @see \inventory\models\Location
 */
class LocationQuery extends \yii\db\ActiveQuery
{

    /**
     * @inheritdoc
     * @return \inventory\models\Location[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\Location|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
