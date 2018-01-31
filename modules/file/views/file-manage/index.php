<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;
use file\models\FileImage;

/* @var $this yii\web\View */
/* @var $searchModel file\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Alert::widget() ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //'id',
            [
                'attribute'=>'type',
                'value'=>function($data){
                        return $data->typeText;
                    },
                'filter'=>$searchModel->allTypeValues,
            ],
            [
                'attribute'=>'file_name',
                'format'=>'raw',
                'value'=>function($data){
                        return $data->icon;
                    },
                'filter'=>false
            ],
            [
                'attribute'=>'model_id',
                'format'=>'raw',
                /*'value'=>function($data){
                    return $data->model ? Html::a($data->model->id, [strtolower($data->shortModelName)."/view", 'id'=>$data->model_id]) : null;
                },*/
            ],
            [
                'attribute'=>'model_name',
                'value'=>function($data){
                        return $data->shortModelName;
                    },
                'filter'=>['User'=>'User', 'File'=>'File',],
            ],

            'title',
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
                        if(Yii::$app->user->can('view'.$model->shortModelName, ['model' => $model->model]))
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'update'=>function ($url, $model, $key){
                            $options = [
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ];
                            if(Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model]))
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
                        if(Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model]))
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
            ],

        ],
    ]); ?>

</div>
