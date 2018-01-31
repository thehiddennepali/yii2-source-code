<?php

namespace inventory\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\inventory\models\Category]].
 *
 * @see \inventory\models\Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \inventory\models\Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \inventory\models\Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}