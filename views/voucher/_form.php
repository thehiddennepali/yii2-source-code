<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use demogorgorn\ajax\AjaxSubmitButton;
/* @var $this yii\web\View */
/* @var $model common\models\Voucher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin([
        'id' => 'voucher-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('basicfield', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

    

    <?= $form->field($model, 'voucher_name')->textInput(['maxlength' => true]) ?>

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
                    'format' => \common\components\Helper::dateFormat()
                ]
        ]);?>
        </div>

    <?= $form->field($model, 'status')->checkBox() ?>
        
    
    
     <?php  echo $form->field($model, 'service_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\CategoryHasMerchant::find()->where(['merchant_id'=> Yii::$app->user->id])->all(), 'id', 'title'),
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?>
    
    <?php echo $form->field($model , 'apply_all_services')->checkBox();?>
    
    
    <?= $form->field($model, 'date_created')->textInput(['readonly' => true]) ?>
    
    <?= $form->field($model, 'date_modified')->textInput(['readonly' => true]) ?>
    </div>
    
    <div class="box-footer">
      <?php
       
        if( Yii::$app->controller->action->id =='create'){?>
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
        <?php }else { ?>
            <?php
            
                AjaxSubmitButton::begin([
                    
    'label' => Yii::t('basicfield','Update'),
    'ajaxOptions' => [
        'type' => 'POST',
        'url' => Yii::$app->urlManager->createUrl(['voucher/update','id'=>$model->voucher_id]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#voucher-form")[0])'),
        'cache'=> 'false',
                'contentType'=> false,
                'processData'=> false,
        'success' => new \yii\web\JsExpression('function(html){
            $("#w0").yiiGridView("applyFilter");
            
        }'),
    ],
    'options' => [
        'class' => 'btn btn-primary',
        'type' => 'button',
        'id' => 'addButtonFotThis'.'update' 
    ]
]);

AjaxSubmitButton::end();
            }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
