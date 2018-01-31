<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel measurement\models\search\MeasurementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Measurements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createMeasurement'))
            echo Html::a(Yii::t('app', 'Create measurement'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

    <h1>Single avarage density is 4.55 KG/GAL</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'short_name',
            'coefficient',
            [
                'attribute'=>'type',
                'value'=>function($data){
                    return $data->typeText;
                },
                'filter'=>$searchModel->typeValues,
            ],

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
                        if(Yii::$app->user->can('viewMeasurement', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ];
                        if(Yii::$app->user->can('updateMeasurement', ['model' => $model]))
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
                        if(Yii::$app->user->can('deleteMeasurement', ['model' => $model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
