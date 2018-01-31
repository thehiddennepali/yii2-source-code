<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 12/26/16
 * Time: 3:39 PM
 */

namespace recipe\models;


use item\models\Item;
use yii\behaviors\AttributeBehavior;
use Yii;


/**
 *
 * @property Ingredient[] $ingredients
 *
 *
 */

class Recipe extends Item
{
    const EVENT_AFTER_INSERT_DELAY = 'afterInsertDelay';

    public function behaviors()
    {
        $behaviours = parent::behaviors();
        return array_merge($behaviours, [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['item_type'],
                    self::EVENT_BEFORE_VALIDATE => 'item_type',
                ],
                'value' => function ($event) {
                    return self::TYPE_PRODUCT;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_AFTER_INSERT_DELAY => 'total_recipe_cost',
                    self::EVENT_BEFORE_UPDATE => 'total_recipe_cost',
                ],
                'value' => function ($event) {
                    /* @var $model Recipe */
                    $model = $event->sender;
                    $total_recipe_cost = 0;
                    foreach ($model->ingredients as $ingredient)
                        $total_recipe_cost+= $ingredient->item->poundPrice * $ingredient->amount;
                    return $model->total_recipe_cost = round($total_recipe_cost, 2);
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_AFTER_INSERT_DELAY => 'profit',
                    self::EVENT_BEFORE_UPDATE => 'profit',
                ],
                'value' => function ($event) {
                    /* @var $model Recipe */
                    $model = $event->sender;
                    return $model->selling_price - $model->total_recipe_cost;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_AFTER_INSERT_DELAY => 'cost_percent',
                    self::EVENT_BEFORE_UPDATE => 'cost_percent',
                ],
                'value' => function ($event) {
                    /* @var $model Recipe */
                    $model = $event->sender;
                    return round($model->total_recipe_cost*100 / $model->selling_price, 2);
                },
            ],
        ]);
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['selling_price', 'required'];
        return $rules;
    }


    public $ingredientAttribute;

    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['ingredientAttribute'] = 'Ingredients';
        return $labels;
    }

}