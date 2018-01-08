<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LoyaltyPoints */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('basicfield', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
        
    <?= $form->field($model, 'is_active')->checkBox() ?>

    <div class="alert alert-info">
<!--            <strong><?=Yii::t('basicfield', 'Important')?>!</strong>-->
            <?=Yii::t('basicfield', 'Important! Under count, we mean, how much points user get for each move')?>
        </div>

    <?php // $form->field($model, 'count_on_order')->textInput() ?>

    <?= $form->field($model, 'count_on_like')->textInput() ?>

    

    <?= $form->field($model, 'count_on_comment')->textInput() ?>

    <?= $form->field($model, 'count_on_rate')->textInput() ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield', 'Create') : Yii::t('basicfield', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
