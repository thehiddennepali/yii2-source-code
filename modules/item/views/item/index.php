<?php

use yii\helpers\Html;
use yii\grid\GridView;
use item\models\Item;

/* @var $this yii\web\View */
/* @var $searchModel item\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        if(Yii::$app->user->can('createItem'))
            echo Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'item_name',
            'inner_pack',
            'outer_pack',
            'size',
            [
                'attribute'=>'size_unit',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->size_unitText;
                },
            ],
            /*[
                'attribute'=>'Unit',
                'value'=>function($data){
                    return $data->unit;
                },
            ],
            [
                'attribute'=>'pounds',
                'value'=>function($data){
                    return $data->pounds;
                },
            ],*/
            [
                'label'=>'Case Price',
                'format'=>'currency',
                'value'=>function(Item $data){
                    return $data->casePrice;
                },
            ],
            [
                'label'=>'Each Price',
                'format'=>'currency',
                'value'=>function(Item $data){
                    return $data->price;
                },
            ],
            [
                'attribute'=>'poundPrice',
                'format'=>'raw',
                'value'=>function(Item $data){
                    if($data->poundPrice)
                        return Yii::$app->formatter->asCurrency($data->poundPrice).' / '.$data->size_unitText;
                },
            ],
            [
                'label'=>'Raw pound price',
                'format'=>'currency',
                'value'=>function(Item $data){
                    return $data->getRawPrice($data->poundPrice);
                },
            ],
            'yield',
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
            // 'prep',
            // 'bricks',
            // 'yield',
            // 'unit_weight',
            // 'item_type',
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
                        if(Yii::$app->user->can('viewItem', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateItem', ['model' => $model]))
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
                        if(Yii::$app->user->can('deleteItem', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
