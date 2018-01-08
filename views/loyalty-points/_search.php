<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LoyaltyPointsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loyalty-points-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'merchant_id') ?>

    <?= $form->field($model, 'count_on_order') ?>

    <?= $form->field($model, 'count_on_like') ?>

    <?= $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'count_on_comment') ?>

    <?php // echo $form->field($model, 'count_on_rate') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
