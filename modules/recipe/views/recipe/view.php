<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use recipe\models\Ingredient;

/* @var $this yii\web\View */
/* @var $model item\models\Item */

$this->title = $model->item_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(Yii::$app->user->can('updateRecipe', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteRecipe', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'item_name',
            'inner_pack',
            'outer_pack',
            'size',
            'size_unit',
            [
                'attribute'=>'item_type',
                'value'=>$model->itemTypeText,
            ],
            'selling_price:currency',
            [
                'attribute'=>'cost_percent',
                'format'=>'raw',
                'value'=>$model->cost_percent.'%',
            ],
            'total_recipe_cost:currency',
            'profit:currency',
            [
                'attribute'=>'ingredientAttribute',
                'format'=>'raw',
                'value'=>\yii\grid\GridView::widget(
                    [
                        'dataProvider' => new \yii\data\ArrayDataProvider([
                            'allModels' => $model->ingredients,
                            'pagination'=>false,
                        ]),
                        'columns'=>[
                            [
                                'attribute'=>'item_id',
                                'format'=>'raw',
                                'value'=>function(Ingredient $data){
                                    return $data->item->item_name;
                                },
                            ],
                            [
                                'attribute'=>'amount',
                                'format'=>'raw',
                                'value'=>function(Ingredient $data){
                                    return $data->amount.' '.$data->unitText;
                                },
                            ],
                            [
                                'label'=>'Cost',
                                'format'=>'currency',
                                'value'=>function(Ingredient $data) use (&$model) {
                                    return $data->item->getConvertedPoundPrice($data->unit) * $data->amount;
                                },
                            ]
                        ]
                    ]
                ),
            ],
            /*
            'create_time',
            'update_time',
            'gtin',
            'published',
            'unit_measure',
            'purchasable',
            'item_description',
            'categories_json:ntext',
            'ingredients_json:ntext',
            'diet_labels:ntext',
            'alergens:ntext',
            'short_name',
            'image_url:url',
            'sku',
            'has_ingredients',
            'height',
            'width',
            'depth',
            'cube_unit',
            'orig_id',
            'weight',
            'weight_interval',
            'prep',
            'bricks',
            'yield',
            'unit_weight',
            'prod_pounds_per_man_hour',
            'assembly_people_count',
            'assembly_units_hour',
            'labor_process',
            'container_type_id',*/
        ],
    ]) ?>

</div>
