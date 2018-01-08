<h2><?=Yii::t('basicfield','Administration info')?></h2>

<?php 
$value = Yii::$app->user->id.'_'.time();

$encrypted = urlencode(base64_encode($value));
?>

<?php echo $form->field($model, 'url')->textInput(['readonly' => true]); ?>


<div class="form-group">
<label class="control-label" for="merchant-ip_address">Widget</label>
<input  text="input" readonly="" class="form-control"
        value='<iframe src="<?php echo Yii::$app->getRequest()->getHostInfo().'/merchant/widgetview?id='.$encrypted;?>" width="100%" height="2000" frameborder="0"></iframe>'>

</div>

<div class="form-group">
<label class="control-label" for="merchant-ip_address">Facebook App</label>
<input  text="input" readonly="" class="form-control"
        value='<?php echo Yii::$app->getRequest()->getHostInfo().'/fbwidget/widgetview?id='.$encrypted;?>'>

</div>

<?php echo $form->field($model, 'date_created')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model, 'membership_purchase_date')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model, 'date_modified')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model, 'date_activated')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model, 'membership_expired')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model, 'ip_address')->textInput(['readonly' => true]); 


?>
