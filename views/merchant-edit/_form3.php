<h2><?=Yii::t('basicfield','Username and Passwords')?></h2>
<?php echo $form->field($model, 'username'); ?>

<?php echo $form->field($model, 'new_password')->passwordInput(); ?>

<?php echo $form->field($model, 'new_password_repeat')->passwordInput(); ?>
<br/><br/>
<?php echo $form->field($model, 'manager_username'); ?>

<?php echo $form->field($model, 'manager_new_password')->passwordInput(); ?>

<?php echo $form->field($model, 'manager_new_password_repeat')->passwordInput(); ?>

<?php echo $form->field($model, 'manager_extended')->checkBox(); ?>