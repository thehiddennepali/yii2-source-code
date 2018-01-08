<?php
Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget');
?>
<div class="box box-primary">
    <?php
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
        <?= CHtml::image($model->imageBehavior->getImageUrl(), 'image', ['style' => 'width:150px;']) ?>
        <?php echo $form->fileFieldGroup($model, 'image'); ?>
        <?php echo $form->textFieldGroup($model, 'title', array('class' => 'span5')); ?>
        <?php echo $form->checkBoxGroup($model, 'is_active'); ?>
        <?php echo $form->dropDownListGroup($model, 'cat_id'
            , array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => CHtml::listData(ServiceCategory::model()->findAllByAttributes(['is_active' => 1]), 'id', 'title'),
                    'htmlOptions' => array('prompt' => 'select category', 'id' => 'cat_id',
                        'ajax' => array(
                            'type' => 'POST', //request type
                            'url' => Controller::createUrl('serviceSubcategory/getCats'), //url to call.
                            'update' => '#category_id', //selector to update
                            'data' => 'js:{cat_id:$(this).val()}'
                        )
                    ),
                )
            )); ?>


        <?php echo $form->dropDownListGroup($model, 'category_id'
            , array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-5',
                ),
                'widgetOptions' => array(
                    'data' => CHtml::listData(ServiceSubcategory::model()->findAllByAttributes(['category_id' => $model->subcategory ? $model->subcategory->category_id : 0]), 'id', 'title'),
                    'htmlOptions' => array('prompt' => 'select subcategory', 'id' => 'category_id'),
                )
            )); ?>

        <?php echo $form->label($model,'description') ?>
        <?php $this->widget('ImperaviRedactorWidget', array(
            // You can either use it for model attribute
            'model' => $model,
            'attribute' => 'description',
        )); ?>

        <?php echo $form->textFieldGroup($model, 'price', array('class' => 'span5')); ?>
        <?php echo $form->textFieldGroup($model, 'time_in_minutes', array('class' => 'span5')); ?>
        <?php echo $form->textFieldGroup($model, 'additional_time', array('class' => 'span5')); ?>

        <?= $form->dropDownListGroup($model, 'service_time_slot', array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-5',
            ),
            'widgetOptions' => array(
                'data' => CategoryHasMerchant::getTimeSlots(),
                'htmlOptions' => array('prompt' => 'select time slot'),
            )
        )); ?>

        <div class="form-group">
            <?php
            echo $form->label($model, 'addon_list');
            $this->widget(
                'booster.widgets.TbSelect2',
                array(
                    'options' => [],
                    'model' => $model,
                    'attribute' => 'addon_list',
                    'form' => $form,
                    'data' => CHtml::listData(Addon::model()->with('merchant')->findAll('merchant.merchant_id = ' . Yii::app()->user->id), 'id', 'name'),
                    'htmlOptions' => array(
                        'multiple' => 'multiple',
                        'class' => 'form-control select2 select2-hidden-accessible',
                        'style' => "width: 100%;"
                    ),
                )
            );
            ?>
        </div>
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