<div class="box box-primary"><?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'review-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

        <?php echo $form->textFieldGroup($model, 'merchant_id', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'client_id', array('class' => 'span5')); ?>

        <?php echo $form->textAreaGroup($model, 'review', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

        <?php echo $form->textFieldGroup($model, 'rating', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'status', array('class' => 'span5', 'maxlength' => 100)); ?>

        <?php echo $form->textFieldGroup($model, 'date_created', array('class' => 'span5')); ?>

        <?php echo $form->textFieldGroup($model, 'ip_address', array('class' => 'span5', 'maxlength' => 50)); ?>

        <?php echo $form->textFieldGroup($model, 'order_id', array('class' => 'span5', 'maxlength' => 14)); ?>
    </div>
    <div class="box-footer">
        <?php $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Create' : 'Save',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
