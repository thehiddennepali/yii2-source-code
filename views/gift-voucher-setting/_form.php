<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GiftVoucherSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

	<?= $form->field($model, 'delivery_options')->checkboxList($model::deliveryOption(),  
		[
		    'onchange'=>'
			var checkbox = $(this).find("input[type=\'checkbox\']");
			var len = checkbox.length;
			for (var i=0; i<len; i++) {
			    if(checkbox[i].checked){
				checkedValue = checkbox[i].value;
				
				if(checkedValue == 1){
					$(".field-giftvouchersetting-is_delivery_free").show();
					$(".field-giftvouchersetting-delivery_fee").show();
				}else{
					$(".field-giftvouchersetting-is_delivery_free").hide();
					$(".field-giftvouchersetting-delivery_fee").hide();
				}
			   }
			}
		    '
		    ]) ?>
	
	<?= $form->field($model, 'is_delivery_free')->radioList($model::deliverFree())->label(false) ?>
	
	

	<?= $form->field($model, 'delivery_fee')->textInput() ?>

	<?= $form->field($model, 'payment')->checkboxList($model::payment()) ?>



	<?= $form->field($model, 'receive_loyalty_points')->checkbox() ?>

	<?= $form->field($model, 'use_loyalty_points')->checkbox() ?>



	<?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>

	<?= $form->field($model, 'updated_at')->textInput(['readonly' => true]) ?>
    </div>

    <div class="box-footer">
	<?= Html::submitButton($model->isNewRecord ? Yii::t('basicfield', 'Create') : Yii::t('basicfield', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php 
$this->registerJs('
	var checkbox = $("#giftvouchersetting-delivery_options").find("input[type=\'checkbox\']");
	var len = checkbox.length;
	for (var i=0; i<len; i++) {
		if(checkbox[i].checked){
			checkedValue = checkbox[i].value;

			if(checkedValue == 1){
				$(".field-giftvouchersetting-is_delivery_free").show();
				$(".field-giftvouchersetting-delivery_fee").show();

			}else{
				$(".field-giftvouchersetting-is_delivery_free").hide();
				$(".field-giftvouchersetting-delivery_fee").hide();
			}
		}else{
			 $(".field-giftvouchersetting-is_delivery_free").hide();
			 $(".field-giftvouchersetting-delivery_fee").hide();
		 }
	}')
?>
