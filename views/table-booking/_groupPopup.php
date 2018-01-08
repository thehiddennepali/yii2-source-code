<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
                <h3 class="box-title"><?=Yii::t('basicfield', 'Create/Update Group Event')?></h3>
            </div>
            <div class="box-body">

                <?php
                $model = new \common\models\GroupOrder();
                 ?>
                
                <?php $form = ActiveForm::begin([
                    'id' => 'order-group-popup-form',
                    //'enableClientValidation' => true,
                ]); ?>

                <?php echo $form->field($model, 'id')->hiddenInput(array('id' => 'gorder_id'))->label(false); ?>
                <?php echo $form->field($model, 'g_cache')->hiddenInput(array('id' => 'g_cache'))->label(false); ?>

                <?php echo $form->field($model, 'category_id')->hiddenInput(array('id' => 'gservice_id'))->label(false); ?>
                <?php echo $form->field($model, 'client_name'); ?>
                <?php echo $form->field($model, 'client_phone'); ?>
                <?php echo $form->field($model, 'client_email'); ?>
                
                <?php echo $form->field($model, 'no_of_seats'); ?>
                <?php echo $form->field($model,'addons_list')->checkBoxList([]); ?>
                <?php echo $form->field($model, 'more_info'); ?>
                <?php echo $form->field($model, 'order_time')->hiddenInput(array( 'id' => 'gorder_servise_date'))->label(false); ?>
                <?php echo $form->field($model, 'price')->hiddenInput(array( 'id' => 'group-cat-price'))->label(false); ?>
                <div ><?=Yii::t('basicfield','Price')?>: <span class="group-price"></span></div>
            </div>

            <div class="box-footer">
                <?php  
                echo Html::submitButton(Yii::t('basicfield','Save'), ['class' => 'saveGroupOrder  btn btn-primary']) ;
                ?>
                <?php 
                echo Html::submitButton(Yii::t('basicfield','Clear'), ['class' => 'saveGroupOrder btn btn-warning']) ;
                ?>
            </div>
            <?php ActiveForm::end(); ?>

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