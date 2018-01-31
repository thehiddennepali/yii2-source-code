<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model measurement\models\Measurement */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Measurements'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurement-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
		if(Yii::$app->user->can('updateMeasurement', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteMeasurement', ['model' => $model]))
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
            'name',
            'short_name',
            'coefficient',
            [
                'attribute'=>'type',
                'value'=>$model->typeText,
            ],
        ],
    ]) ?>

</div>
