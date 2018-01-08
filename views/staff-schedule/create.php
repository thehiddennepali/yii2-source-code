<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffSchedule */

$this->title = Yii::t('basicfield', 'Create Staff Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Staff Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
