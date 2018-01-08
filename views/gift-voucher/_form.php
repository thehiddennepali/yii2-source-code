<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model common\models\GiftVoucher */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">

    <?php
    $form = ActiveForm::begin([
		'id' => 'gift-voucher-form'
    ]);
    ?>

    <div class="box-body">

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'type')->dropDownList(common\models\GiftVoucher::$type) ?>
	<div id="amount">
	    <?= $form->field($model, 'amount')->textInput() ?>
	</div>
	
	<?php 
	$service  = \yii\helpers\ArrayHelper::map(\common\models\CategoryHasMerchant::findAll(['is_group' => 0,
		    'merchant_id' => Yii::$app->user->id]), 'id', 'title');
	?>
	<div id="service">
	    <?= $form->field($model, 'service')->dropDownList(
		$service
		    ) ?>
	</div>
	<div id="package-service">
	    <?php  echo $form->field($model, 'services')->widget(
	     Select2::classname(), [
                'data' => $service,
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?> 
	</div>
	<div class="form-group field-voucher-expiration required">
            <label class="control-label"><?php echo Yii::t('basicfield', 'Expiration')?></label>
        <?= DatePicker::widget([
            'model' => $model,
            'attribute' => 'expire_at',
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

	<?= $form->field($model, 'status')->checkBox() ?>

	<?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>

	<?= $form->field($model, 'updated_at')->textInput(['readonly' => true]) ?>
    </div>

    <div class="box-footer">
	<?php if (Yii::$app->controller->action->id == 'create') { ?>
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

	<?php } else { ?>
		<?php
		AjaxSubmitButton::begin([

		    'label' => Yii::t('basicfield', 'Update'),
		    'ajaxOptions' => [
			'type' => 'POST',
			'url' => Yii::$app->urlManager->createUrl(['gift-voucher/update', 'id' => $model->id]),
			'data' => new \yii\web\JsExpression('new FormData($("#gift-voucher-form")[0])'),
			'cache' => 'false',
			'contentType' => false,
			'processData' => false,
			'success' => new \yii\web\JsExpression('function(html){
				$("#w0").yiiGridView("applyFilter");

			    }'),
		    ],
		    'options' => [
			'class' => 'btn btn-primary',
			'type' => 'button',
			'id' => 'addButtonFotThis' . 'update'
		    ]
		]);

		AjaxSubmitButton::end();
	}
	?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$this->registerJs("
	var type = $('#giftvoucher-type').val();
	
	if(type  == 0){
		$('#amount').show();
		$('#service').hide();
		$('#package-service').hide();
	
	}else if(type  == 1){
		$('#service').show();
		$('#amount').hide();
		$('#package-service').hide();
		
	}else if(type  == 2){
		$('#package-service').show();
		$('#amount').hide();
		$('#service').hide();
	}
	
	$('#giftvoucher-type').on('change', function(){
	
		var type = $(this).val();
	
		if(type  == 0){
			$('#amount').show();
			$('#service').hide();
			$('#package-service').hide();

		}else if(type  == 1){
			$('#service').show();
			$('#amount').hide();
			$('#package-service').hide();

		}else if(type  == 2){
			$('#package-service').show();
			$('#amount').hide();
			$('#service').hide();
		}
	
	})
	

	")

?>
