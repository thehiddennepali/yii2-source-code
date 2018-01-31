<?php

namespace recipe\models;

use Yii;

/**
 * This is the ActiveQuery class for [[Ingredient]].
 *
 * @see Ingredient
 */
class IngredientQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Ingredient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Ingredient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}