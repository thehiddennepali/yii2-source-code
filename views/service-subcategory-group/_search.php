<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryHasMerchantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-has-merchant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'merchant_id') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'is_active') ?>

    <?= $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'time_in_minutes') ?>

    <?php // echo $form->field($model, 'additional_time') ?>

    <?php // echo $form->field($model, 'service_time_slot') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'group_people') ?>

    <?php // echo $form->field($model, 'is_group') ?>

    <?php // echo $form->field($model, 'staff_id') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
