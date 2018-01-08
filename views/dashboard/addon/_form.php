<div class="box box-primary">
    <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'addon-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    )); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">

        <?= CHtml::image($model->imageBehavior->getImageUrl(), 'image', ['style' => 'width:150px;']) ?>
        <?php echo $form->fileFieldGroup($model, 'image'); ?>

        <?php echo $form->textFieldGroup($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>

        <?php echo $form->textFieldGroup($model, 'price', array('class' => 'span5')); ?>
        <?php echo $form->textFieldGroup($model, 'time_in_minutes', array('class' => 'span5')); ?>
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
