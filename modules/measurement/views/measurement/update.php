<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model measurement\models\Measurement */

$this->title = Yii::t('app', 'Update measurement: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Measurements'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="measurement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
