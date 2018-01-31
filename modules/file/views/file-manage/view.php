<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use file\models\File;
use file\models\FileImage;

/* @var $this yii\web\View */
/* @var $model file\models\File */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        if(Yii::$app->user->can('update'.$model->shortModelName, ['model' => $model->model])){
            ?>
            <?=Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], [
                'class' => 'btn btn-primary',
            ]);?>
            <?=Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);?>
            <?php
        }

        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=>'type',
                'value'=>$model->typeText,
            ],
            [
                'attribute'=>'file_name',
                'format'=>'raw',
                'value'=>$model->icon,
            ],
            [
                'attribute'=>'model_id',
                'format'=>'raw',
            ],
            'model_name',
            'title',
            'created_at:datetime',
        ],
    ]) ?>

</div>
