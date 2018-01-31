<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model measurement\models\MeasurementItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Measurement Items'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurement-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
		if(Yii::$app->user->can('updateMeasurementItem', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteMeasurementItem', ['model' => $model]))
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
            'item_id',
            'master_unit',
            'name',
            'factor',
        ],
    ]) ?>

</div>
