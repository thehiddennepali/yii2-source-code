<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model measurement\models\MeasurementItem */

$this->title = Yii::t('app', 'Create measurement Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Measurement Items'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurement-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
