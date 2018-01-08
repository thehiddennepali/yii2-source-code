<div class="box box-primary">
    <?php
    Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget');
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'service-subcategory-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => ['enctype' => 'multipart/form-data']
    )); ?>

    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>

    <div class="box-body">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                Yii::t('default', 'Main Info') => $this->renderPartial('_form1', ['model' => $model, 'form' => $form], true),
                Yii::t('default', 'Schedule') => $this->renderPartial('_form2', ['model' => $model, 'form' => $form], true),
                Yii::t('default', 'Extra Schedule') => $this->renderPartial('_form3', ['model' => $model, 'form' => $form], true),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
        ));
        ?>
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
