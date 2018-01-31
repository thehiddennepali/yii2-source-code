<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use recipe\models\Recipe;
use recipe\models\Ingredient;
use recipe\models\search\RecipeSearch;


/* @var $this yii\web\View */
/* @var $searchModel item\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Recipes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        if(Yii::$app->user->can('createRecipe'))
            echo Html::a(Yii::t('app', 'Create Recipe'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            //'id',
            'item_name',
            //'create_time',
            //'update_time',
            // 'gtin',
            // 'published',
            // 'unit_measure',
            // 'purchasable',
            // 'item_description',
            // 'categories_json:ntext',
            // 'ingredients_json:ntext',
            // 'diet_labels:ntext',
            // 'alergens:ntext',
            // 'short_name',
            // 'image_url:url',
            // 'sku',
            // 'has_ingredients',

            // 'height',
            // 'width',
            // 'depth',
            // 'cube_unit',
            // 'orig_id',
            // 'weight',
            // 'weight_interval',

            //'prep',
            // 'bricks',
             //'yield',
             //'unit_weight',
            [
                'attribute'=>'item_type',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->itemTypeText;
                },
                'filter'=>$searchModel->typeValues,
            ],
            'selling_price:currency',
            [
                'attribute'=>'cost_percent',
                'format'=>'raw',
                'value'=>function(RecipeSearch $data){
                    return $data->cost_percent.'%';
                },
            ],
            'total_recipe_cost:currency',
            'profit:currency',
            [
                'attribute'=>'ingredientAttribute',
                'format'=>'raw',
                'value'=>function(RecipeSearch $model) use ($searchModel){
                    ob_start();
                    echo GridView::widget(
                        [
                            'dataProvider' => new ArrayDataProvider([
                                'allModels' => $model->ingredients,
                                'pagination'=>false,
                            ]),
                            'columns'=>[
                                [
                                    'attribute'=>$searchModel->getAttributeLabel('item_id'),
                                    'value'=>function(Ingredient $data){
                                        return $data->item->item_name;
                                    },
                                ],
                                [
                                    'attribute'=>$searchModel->getAttributeLabel('amount'),
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
                    );
                    $content = ob_get_contents();
                    ob_end_clean();

                    return $content;
                },
            ],
            // 'prod_pounds_per_man_hour',
            // 'assembly_people_count',
            // 'assembly_units_hour',
            // 'labor_process',
            // 'container_type_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete}',
                'buttons'=>[
                    'view'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('viewRecipe', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateRecipe', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                    },
                    'delete'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('deleteRecipe', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
