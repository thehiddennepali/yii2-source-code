<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StaffSchedule */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Staff Schedule',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Staff Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="staff-schedule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
