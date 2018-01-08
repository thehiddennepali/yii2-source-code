<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StaffScheduleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-schedule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'work_date') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'schedule_days_template_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
