<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 12/26/16
 * Time: 3:39 PM
 */

namespace recipe\models\search;


use recipe\models\Ingredient;

class RecipeSearch extends \item\models\search\ItemSearch
{

    public function behaviors()
    {
        return [];
    }

    public function search($params)
    {
        $dataProvider =  parent::search($params);
        $query = $dataProvider->query;
        $query->andWhere([ 'item_type'=> [self::TYPE_PRODUCT]]);
        return $dataProvider;
    }

    public $ingredientAttribute;
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['ingredientAttribute'] = 'Ingredients';
        return $labels;
    }

    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['parent_id' => 'id']);
    }
}