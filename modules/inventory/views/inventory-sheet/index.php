<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
use inventory\models\Location;
use inventory\models\Category;
use user\models\User;
use inventory\models\InventorySheet;




        $created_atFrom = DateTimePicker::widget([
            'name' => 'created_atFrom',
            'value'=>isset($_GET['created_atFrom']) ? $_GET['created_atFrom']:null,
            //'model' => $searchModel,
            //'attribute' => 'created_at',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd H:i',
                'todayHighlight' => true
            ]
        ]);
        $created_atTo = DateTimePicker::widget([
            'name' => 'created_atTo',
            'value'=>isset($_GET['created_atTo']) ? $_GET['created_atTo']:null,
            //'model' => $searchModel,
            //'attribute' => 'created_at',
            'options' => ['placeholder' => 'Select time'],
            'convertFormat' => true,
            'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
            ]
        ]);

/* @var $this yii\web\View */
/* @var $searchModel inventory\models\search\InventorySheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inventory Sheets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-sheet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createInventorySheet'))
            echo Html::a(Yii::t('app', 'Take inventory'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'attribute'=>'location_id',
                'format'=>'raw',
                'value'=>function(InventorySheet $data){
                    return $data->location ? $data->location->nickname:null;
                },
                'filter'=>ArrayHelper::map(Yii::$app->user->identity->locations, 'id', 'nickname'),
            ],
            'sub_location_id',
            [
                'attribute'=>'category_id',
                'format'=>'raw',
                'value'=>function(InventorySheet $data){
                    return $data->category ? $data->category->category_name:null;
                },
                'filter'=>ArrayHelper::map(Category::find()->all(), 'id', 'category_name'),
            ],
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
                'filter'=>$created_atFrom.' '.$created_atTo,
            ],
            /*[
                'attribute'=>'status',
                'value'=>function($data){
                    return $data->statusText;
                },
                'filter'=>$searchModel->statusValues,
            ],*/
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
                        if(Yii::$app->user->can('viewInventorySheet', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateInventorySheet', ['model' => $model]))
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
                        if(Yii::$app->user->can('deleteInventorySheet', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
