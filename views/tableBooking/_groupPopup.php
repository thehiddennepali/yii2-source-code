<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 25-May-16
 * Time: 15:50
 */
?>
<div class="row group-booking-popup" style="position:absolute; z-index:2000;background-color: #d7d7d7; height: 850px; margin-left: 0; width: 100%; display: none">
    <div class="box-header with-border text-center" style="background-color: #00733e">
        <a href="#" class="group-popup-close" style="height: 30px; font-weight: bold">X</a>
    </div>
    <div class="col-md-3">
        <!-- /. box -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?=Yii::t('default', 'Create/Update Group Event')?></h3>
            </div>
            <div class="box-body">

                <?php
                $model = new GroupOrder();
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'order-group-popup-form',
                    'enableAjaxValidation' => false,
                )); ?>

                <?php echo $form->hiddenField($model, 'id', array('id' => 'gorder_id')); ?>
                <?php echo $form->hiddenField($model, 'g_cache', array('id' => 'g_cache')); ?>

                <?php echo $form->hiddenField($model, 'category_id', array('id' => 'gservice_id')); ?>
                <?php echo $form->textFieldGroup($model, 'client_name',  [ 'widgetOptions' => array('htmlOptions' => array( 'required'=>'required'))]); ?>
                <?php echo $form->textFieldGroup($model, 'client_phone', [ 'widgetOptions' => array('htmlOptions' => array( 'required'=>'required'))]); ?>
                <?php echo $form->textFieldGroup($model, 'client_email',  [ 'widgetOptions' => array('htmlOptions' => array( 'required'=>'required'))]); ?>
                <?php echo $form->checkboxListGroup(
                    $model,
                    'addons_list',
                    array(
                        'widgetOptions' => array(
                            'data' => [],
                        ),
                    )
                ); ?>
                <?php echo $form->textFieldGroup($model, 'more_info'); ?>
                <?php echo $form->hiddenField($model, 'order_time', array( 'id' => 'gorder_servise_date',)); ?>
                <?php echo $form->hiddenField($model, 'price', array( 'id' => 'group-cat-price'))->label(false); ?>
                <div ><?=Yii::t('default','Price')?>: <span class="group-price"></span></div>
            </div>

            <div class="box-footer">
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'primary',

                        'label' => Yii::t('default','Save'),
                        'url' => '#',
                        'htmlOptions' => array('class' => 'saveGroupOrder', 'type' => 'submit'),
                    )
                ); ?>
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'warning',
                        'label' => Yii::t('default','Clear'),
                        'url' => '#',
                        'htmlOptions' => array('class' => 'clearGroupOrder'),
                    )
                ); ?>
            </div>
            <?php $this->endWidget(); ?>

        </div>
    </div>

    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body no-padding group-popup-body" >

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>