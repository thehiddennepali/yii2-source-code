<h2><?=Yii::t('default','Username and Passwords')?></h2>
<?php echo $form->textFieldGroup($model, 'username', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->passwordFieldGroup($model, 'new_password', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php echo $form->passwordFieldGroup($model, 'new_password_repeat', array('class' => 'span5', 'maxlength' => 100)); ?>
<br/><br/>
<?php echo $form->textFieldGroup($model, 'manager_username', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->passwordFieldGroup($model, 'manager_new_password', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php echo $form->passwordFieldGroup($model, 'manager_new_password_repeat', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php echo $form->checkBoxGroup($model, 'manager_extended'); ?>