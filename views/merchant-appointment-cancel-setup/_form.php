<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model common\models\MerchantAppointmentCancelSetup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

	<?php $form = ActiveForm::begin(['id' => 'merchant-appointment-cancel-setup-form']); ?>
	<div class="box-body">
		
	    
	    <?= $form->field($model, 'cancel_hour_from')->textInput() ?>

		<?= $form->field($model, 'cancel_hour_to')->textInput() ?>

		<?= $form->field($model, 'cancel_percent')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>

		<?= $form->field($model, 'updated_at')->textInput(['readonly' => true]) ?>
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
			    'url' => Yii::$app->urlManager->createUrl(['merchant-appointment-cancel-setup/update','id'=>$model->id]),
			    /*'cache' => false,*/
			    'data'=> new \yii\web\JsExpression('new FormData($("#merchant-appointment-cancel-setup-form")[0])'),
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
