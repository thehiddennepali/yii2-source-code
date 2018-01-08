<?php
$this->breadcrumbs = array(
    Yii::t('default','Table Booking') => array('index'),
    Yii::t('default','Manage'),
);
?>

<h1>Table Booking</h1>

<?php
$tabs = [];
foreach ($staffs as $key =>  $staff) {
    $tabs[] = ['label'=>$staff->name . ' ID:' . $staff->id,'active' => $key?false:true, 'content' =>$this->renderPartial('_table_2', ['model' => $staff, 'timestamp' => $timestamp,
        'staff_min_range' => $staffs_min_range[$staff->id],
        'staffInfo' => isset($staffsInfo[$staff->id]) ? $staffsInfo[$staff->id] : null], true)];
}
?>
<div style="position: relative">
<?php $this->renderPartial('_groupPopup') ?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-default collapsed-box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?=Yii::t('default','Free Orders')?> (<?=count($freeOrders)?>)</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
               <?php
               foreach($freeOrders as $val){
                echo '<div class="external-event data-id="'.$val->id.'" style="background-color: '. $val->category->color.'!important;"">'.$val->client_name.'</div>';
               }
               ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /. box -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?=Yii::t('default','Create/Update Event')?></h3>
            </div>
            <div class="box-body">

                <?php
                $model = new SingleOrder();
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => 'order-popup-form',
                    'enableAjaxValidation' => false,
                )); ?>

                <?php echo $form->hiddenField($model, 'id', array('id' => 'order_id')); ?>
                <?php
                $cats_merch = CategoryHasMerchant::model()->findAllByAttributes(['is_active' => 1, 'merchant_id' => Yii::app()->user->id, 'is_group' => 0]);
                echo $form->dropDownListGroup($model, 'category_id'
                    , array(
                        'widgetOptions' => array(
                            'data' => CHtml::listData($cats_merch, 'id', 'titleWithPriceAndTime'),
                            'htmlOptions' => array('prompt' => 'select category', 'class' => 'span5', 'required'=>'required',
                                'id' => 'category_id_modal',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('tableBooking/getPrice'),
                                    'success' => 'function(data){$("#find-min-val").val(data.min); $(".time-in-min").html(data.min); $("#staff_id_modal").html(data.dd);   $("#single-cat-price").val(data.price);$(".single-price").html(data.price);}',
                                    'dataType' =>'json',
                                    'data' => 'js:{cat_id:$(this).val()}'
                                )
                            ),
                        )
                    )
                ); ?>

                <?php echo CHtml::hiddenField('find-min-val',0); ?>

                <?php echo $form->datepickerGroup($model, 'order_date', array('widgetOptions' => array(
                        'options' => array(
                            'format' => 'yyyy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'select date',
                            'id' => 'find-date-val',
                            'required'=>'required',
                        )
                    ),

                    )
                ); ?>

                <?php
                echo CHtml::label('Time req','find-staff-val');
                $this->widget(
                    'booster.widgets.TbTimePicker',
                    array(
                        'model'=>$model,
                        'attribute'=> "free_time",
                        'id'=>"find-staff-val",
                        'noAppend' => true, // mandatory
                        'options' => array(
                            'disableFocus' => true, // mandatory
                            'showMeridian' => false, // irrelevant
                            'minuteStep'=>15,
                            'defaultTime'=>'12:00'
                        ),

                        'htmlOptions' => array('class' => 'form-control'),
                    )
                );
                ?>
                <br>

                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'info',
                        'label' => Yii::t('default','Find staff'),
                        'url' => '#',
                        'htmlOptions' => array('class' => 'find-staff', 'id' => 'find-staff'),
                    )
                ); ?>
                <br><br>
                <?php echo $form->dropDownListGroup($model, 'staff_id'
                    , array(
                        'widgetOptions' => array(
                            'data' => [],
                            'htmlOptions' => array('prompt' => Yii::t('default','Select Staff'), 'class' => 'span5',
                                'id' => 'staff_id_modal', 'required'=>'required',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('tableBooking/getStaffFreeTime'),
                                    'success'=>'function(data){ $(".single-price").html($("#single-cat-price").val()); $("#SingleOrder_addons_list").html(data.add_ons);}',
                                    'dataType' =>'json',
                                   // 'update' => '#free_time_list', //selector to update
                                    'data' => 'js:{staff_id:$(this).val(),date_val:$("#find-date-val").val(),min_val:$("#find-min-val").val(),update:$("#order_id").val()?$("#order_id").val():0}'
                                )
                            ),
                        )
                    )
                ); ?>
                <?php echo $form->checkboxListGroup(
                    $model,
                    'addons_list',
                    array(
                        'widgetOptions' => array(
                            'data' => [],
                        ),
                    )
                ); ?>
                <?php echo $form->hiddenField($model, 'price', array( 'id' => 'single-cat-price',)); ?>
                <div ><?=Yii::t('default','Time/Price')?>: <span class="time-in-min"></span> / <span class="single-price"></span></div>
                <br>

                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                       // 'buttonType' => 'ajaxButton',
                        'context' => 'info',
                        'label' => Yii::t('default','Find Free Time Slots'),
                        //'url' => Yii::app()->createUrl('tableBooking/getStaffFreeTime'),
                        'htmlOptions' => array('class' => 'find-ts', 'id' => 'find-ts',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('tableBooking/getStaffFreeTime'),
                                'success'=>'function(data){ $("#free_time_list").html(data.dd); }',
                                'dataType' =>'json',
                                // 'update' => '#free_time_list', //selector to update
                                'data' => 'js:{staff_id:$("#staff_id_modal").val(),date_val:$("#find-date-val").val(),min_val:$("#find-min-val").val(),update:$("#order_id").val()?$("#order_id").val():0}'
                            )
                        ),
                    )
                ); ?>
                <br><br>
                <?php echo $form->hiddenField($model, 'memcache_key', array( 'id' => 'memcache_key',)); ?>
                <?php echo $form->dropDownListGroup($model, 'free_time_list', array(
                        'widgetOptions' => array(
                            'data' => [],
                            'htmlOptions' => array('prompt' => Yii::t('default','Select Free Time'), 'class' => 'span5',
                                'id' => 'free_time_list',  'required'=>'required',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('tableBooking/addSingleMemcachedOrder'),
                                    'success'=>'function(data){$("#memcache_key").val(data)}',
                                    //'dataType' =>'json',
                                    // 'update' => '#free_time_list', //selector to update
                                    'data' => 'js:{staff_id:$("#staff_id_modal").val(),date_val:$("#find-date-val").val(),free_time_list:$("this").val(),min_val:$("#find-min-val").val(),u_id:$("#memcache_key").val(),update:$("#order_id").val()?$("#order_id").val():0}'
                                )
                            ),
                        )
                    )
                ); ?>



                <?php echo $form->textFieldGroup($model, 'client_name',   [ 'widgetOptions' => array('htmlOptions' => array( 'required'=>'required'))]); ?>
                <?php echo $form->textFieldGroup($model, 'client_phone',  [ 'widgetOptions' => array('htmlOptions' => array( 'required'=>'required'))]); ?>
                <?php echo $form->textFieldGroup($model, 'client_email',  [ 'widgetOptions' => array('htmlOptions' => array( 'required'=>'required'))]); ?>

            </div>

            <div class="box-footer">
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'primary',

                        'label' => Yii::t('default','Save'),
                        'url' => '#',
                        'htmlOptions' => array('class' => 'saveOrder','type'=>'submit'),
                    )
                ); ?>
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'warning',
                        'label' => Yii::t('default','Clear'),
                        'url' => '#',
                        'htmlOptions' => array('class' => 'clearOrder'),
                    )
                ); ?>
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'error',
                        'label' => Yii::t('default','Delete'),
                        'url' => '#',
                        'htmlOptions' => array('class' => 'deleteOrder', 'disabled'=>'disabled'),
                    )
                ); ?>
            </div>
            <?php $this->endWidget(); ?>

        </div>
    </div>

    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body no-padding" >
                <?php
                foreach($cats_merch as $val){
                    echo '<span style="padding:20px"><i class="fa fa-circle-o" style="color: '. $val->color.'!important;"></i> <span>'.$val->title.'</span></span>';
                }
                ?>
            </div>
            <div class="box-body no-padding" style="position: relative">

                <?php
                $this->widget( 'booster.widgets.TbTabs',
                    array(
                        'type' => 'tabs', // 'tabs' or 'pills'
                    'tabs' => $tabs,
                ));
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>
</div>

<?php Yii::app()->clientScript->registerCss('css',
    '.tab-content{
    position:relative;
    min-height:370px
    }
    .tab-content>.active{
        z-index:1000!important;
    }
    .tab-content>.tab-pane{
     display:block!important;
      position:absolute;
    z-index:10;
    background-color:#ffffff
    }
    .tab-content a:visited{
    color:#ffffff!important
    }
    .tab-content a{
    color:#ffffff!important
    }
    ')?>
