

<h2><?=Yii::t('basicfield','Administrative Settings')?></h2>

<?php echo $form->field($model, 'time_zone')
	->dropDownList(\merchant\components\MerchantHelper::getTimeZone());
?>

<?php 
echo $form->field($model, 'date_format')->textInput(['placeholder' =>'d-m-Y']);

?>

    <small><?=Yii::t('basicfield','Note: must be a valid php date format')?></small>
    <p>
	<a href="http://php.net/manual/en/function.date.php">
	    http://php.net/manual/en/function.date.php
	    
	</a>
</p>

<?php echo $form->field($model, 'time_format')->textInput(['placeholder' =>'G:i:s']);?>


    <small><?=Yii::t('basicfield','Note: must be a valid php time format')?></small>
    <p>
	<a href="http://php.net/manual/en/function.date.php">
	    http://php.net/manual/en/function.date.php
	    
	</a>
</p>

<?php echo $form->field($model, 'date_picker_format')
	->dropDownList(\merchant\components\MerchantHelper::$dateFormat);
?>

<?php echo $form->field($model, 'time_picker_format')
	->dropDownList(\merchant\components\MerchantHelper::$timeFormat);
?>

<?php echo $form->field($model, 'currency_id')
	->dropDownList(yii\helpers\ArrayHelper::map(common\models\Currency::find()->all(), 'currency_code', 'currency_code'));
?>

