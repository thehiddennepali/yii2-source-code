<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Voucher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('basicfield', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

    <?= $form->field($model, 'status')->checkBox() ?>

    

    <?= $form->field($model, 'voucher_type')->dropDownList(common\models\Voucher::getTypes(), [
        'prompt' => Yii::t('basicfield', 'Select')
    ]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>
        
    <div class="form-group field-voucher-expiration required">
        <label class="control-label"><?php echo Yii::t('basicfield', 'Expiration')?></label>
    <?= DatePicker::widget([
        'model' => $model,
        'attribute' => 'expiration',
        'template' => '{input}{addon}',
            'clientOptions' => [
                'startDate'=> "today",
                'autoclose' => true,
                'defaultDate' =>  'today',
                'minDate' => 'today',
                'format' => 'yyyy-mm-dd'
            ]
    ]);?>
    </div>

        

    
        
    
    
     
    
    
    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'date_modified')->textInput(['readonly' => true]) ?>
    </div>
    
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield', 'Create') : Yii::t('basicfield', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
