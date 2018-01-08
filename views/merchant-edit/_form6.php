<h2><?=Yii::t('basicfield','Payment settings')?></h2>
<?php echo $form->field($model,'is_paypall_sandbox')->radioList([
    '0' => 'No',
    '1' => 'Yes'
]); ?>
<?php echo $form->field($model,'paypall_id')->textInput(); ?>
<?php echo $form->field($model,'paypall_pass')->passwordInput(); ?>
<?php echo $form->field($model,'paypal_client_id')->textInput(); ?>
<?php echo $form->field($model,'paypal_client_secret')->textInput(); ?>