<?php


$this->title = Yii::t('basicfield', 'Table Bookings');
$this->params['breadcrumbs'][] = $this->title;
use yii\bootstrap\Tabs;
use dosamigos\datepicker\DatePicker;
use demogorgorn\ajax\AjaxSubmitButton;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
?>

<h1>Table Booking</h1>

<?php
$tabs = [];
foreach ($staffs as $key =>  $staff) {
    $tabs[] = [
        'label'=>$staff->name . ' ID:' . $staff->id,
        //'headerOptions' => ['id' => 'staff-'.$staff->id],
        //'options' => ['class' => 'calendar-'.$staff->id],
        'active' => $key?false:true,
        'content' => '<div>'.$this->render('_table_2', ['model' => $staff, 'timestamp' => $timestamp,
        'staff_min_range' => $staffs_min_range[$staff->id],
        'staffInfo' => isset($staffsInfo[$staff->id]) ? $staffsInfo[$staff->id] : null]
            ).'</div>'
        ];
    
}
?>
<div style="position: relative">
<?php echo $this->render('_groupPopup') ?>
<div class="row">
    <div class="col-md-3">
        <div class="box box-basicfield collapsed-box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
        <?=Yii::t('basicfield','Free Orders')?> (<?=count($freeOrders)?>)</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-plus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
               <?php
               foreach($freeOrders as $val){
                echo '<div class="external-event" data-id="'.$val->id.'" style="background-color: '. $val->category->color.'!important;"">'.$val->client_name.'</div>';
               }
               ?>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /. box -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?=Yii::t('basicfield','Create/Update Event')?></h3>
            </div>
            <div class="box-body">

                <?php
                $model = new common\models\SingleOrder();
                ?>
                
                <?php $form = ActiveForm::begin([
                    'id' => 'order-popup-form',
                ]); ?>

                <?php echo $form->field($model, 'id')->hiddenInput(array('id' => 'order_id'))->label(false); ?>
                
                    
                    <?php
                
                $cats_merch = common\models\CategoryHasMerchant::find()->where(['is_active' => 1,
                    'merchant_id' => Yii::$app->user->id, 'is_group' => 0])->all();
                echo $form->field($model, 'category_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map($cats_merch, 'id', 'titleWithPriceAndTime'),
                        
                        [
                            'prompt' => 'select category', 'class' => 'span5', 'required'=>'required',
                            'id' => 'category_id_modal',
                            'onchange' => "
                            $.ajax ({
                                'type' : 'POST',
                                'url' : '".Yii::$app->urlManager->createUrl('table-booking/get-price')."',
                                    'dataType' :'json',
                                'data' : {cat_id:$(this).val()},
                                'success' : function(data){
                                $('#find-min-val').val(data.min);
                                $('.time-in-min').html(data.min); 
                                $('#staff_id_modal').html(data.dd);
                                $('#single-cat-price').val(data.price);
                                $('.single-price').html(data.price);
                                }
                                
                            
                            });",
                            'class' => 'span5 form-control'
                            ]
                        
                    
                ); ?>

                <?php echo Html::hiddenInput('find-min-val',0, ['id' => 'find-min-val']); ?>

                    <div class="form-group">
                <label class="control-label"><?php echo Yii::t('basicfield', 'Order Date')?></label>
                <?= DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'order_date',
                    'options' => [
                        'id' => 'find-date-val'
                    ]
                    ,
                    'template' => '{input}{addon}',
                        'clientOptions' => [
                            'startDate'=> "today",
                            'autoclose' => true,
                            'defaultDate' =>  'today',
                            'minDate' => 'today',
                            'format' => 'yyyy-mm-dd'
                        ]
                ]);?>
                    </div>
                <div class="form-group">
                    <label class="control-label"><?php echo Yii::t('basicfield', 'Time req')?></label>
                <?php
                
                echo TimePicker::widget([
                    'model' => $model,
                    'attribute' => 'free_time', 
                    'options' => [
                    'id'=>"find-staff-val",
                        ],
                    'value' => '11:24 AM',
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 15,

                    ]
                ]);
                
                ?>
                </div>
                <br>

                <?php 
                
                echo Html::button(Yii::t('basicfield','Find Staff'), ['class' => 'find-staff btn btn-info', 'id' => 'find-staff']) ;
                ?>
                <br><br>
                <?php echo $form->field($model, 'staff_id')
                        ->dropDownList([],array(
                            'prompt' => Yii::t('basicfield','Select Staff'), 'class' => 'span5',
                            'id' => 'staff_id_modal',
                            'required'=>'required',
                            'class' => 'span5 form-control',
                            'onchange' =>"
                            $.ajax ({
                                'type' : 'POST',
                                'url' : '".Yii::$app->urlManager->createUrl('table-booking/get-staff-free-time')."',
                                    'dataType' :'json',
                                'data' : {staff_id:$(this).val(),date_val:$('#find-date-val').val(),min_val:$('#find-min-val').val(),update:$('#order_id').val()?$('#order_id').val():0},
                                'success' : function(data){
                                $('.single-price').html($('#single-cat-price').val());
                                 $('#singleorder-addons_list').html(data.add_ons);
                                }
                                
                            
                            });",
                            
                        
                    )
                ); ?>
                <?php echo $form->field($model,'addons_list')->checkBoxList([]); ?>
                
                <?php echo $form->field($model, 'price')->hiddenInput(array( 'id' => 'single-cat-price',)); ?>
                <div ><?=Yii::t('basicfield','Time/Price')?>: <span class="time-in-min"></span> / <span class="single-price"></span></div>
                <br>

                <?php
                
                echo Html::button(Yii::t('basicfield','Find Free Time Slots'), ['class' => 'find-ts btn btn-info', 'id' => 'find-ts']) ;
                
                /*AjaxSubmitButton::begin([
                    'label' => 'Find Free Time Slots',
                    'ajaxOptions' => [
                        'type' => 'POST',
                        'url' => Yii::$app->urlManager->createUrl('table-booking/get-staff-free-time'),
                        'dataType' =>'json',
                        'cache' => false,
                        'data' => '{staff_id:$(\"#staff_id_modal\").val(),date_val:$(\"#find-date-val\").val(),min_val:$(\"#find-min-val\").val(),update:$(\"#order_id\").val()?$(\"#order_id\").val():0}',
                        'success' => new \yii\web\JsExpression('function(html){
                            $("#free_time_list").html(data.dd);
                        }'),
                    ],
                    'options' => [
                        'type' => 'button',
                        'id' => 'find-ts',
                        'class' => 'btn btn-info'
                    ]
                ]);

                AjaxSubmitButton::end();
                */
                ?>
                <br><br>
                <?php echo $form->field($model, 'memcache_key')->hiddenInput(array( 'id' => 'memcache_key'))->label(false); ?>
                <?php echo $form->field($model, 'free_time_list')->dropDownList([],[
                        'id' => 'free_time_list',  'required'=>'required',
                        'onchange' =>"
                            $.ajax ({
                                'type' : 'POST',
                                'url' : '".Yii::$app->urlManager->createUrl('table-booking/add-single-memcached-order')."',
                                'dataType' :'json',
                                'data' : {staff_id:$('#staff_id_modal').val(),date_val:$('#find-date-val').val(),free_time_list:$('this').val(),min_val:$('#find-min-val').val(),u_id:$('#memcache_key').val(),update:$('#order_id').val()?$('#order_id').val():0},
                                'success' : function(data){
                                $('#memcache_key').val(data)
                                }
                                
                            
                            });",
                    ]
                        
                ); ?>



                <?php echo $form->field($model, 'client_name')->textInput(['required'=> true]); ?>
                <?php echo $form->field($model, 'client_phone')->textInput(['required'=> true]); ?>
                <?php echo $form->field($model, 'client_email')->textInput(['required'=> true]); ?>

            </div>

            <div class="box-footer">
                <?php 
                echo Html::submitButton(Yii::t('basicfield','Save'), ['class' => 'saveOrder btn btn-primary']) ;
                 ?>
                <?php 
                
                echo Html::submitButton(Yii::t('basicfield','Clear'), ['class' => 'clearOrder btn btn-warning']) ;
                ?>
                
                <?php 
                
                 echo Html::submitButton(Yii::t('basicfield','Delete'),
                         ['class' => 'deleteOrder btn'
                     , 'disabled'=>'disabled']) ;
                ?>
            </div>
                <?php ActiveForm::end(); ?>

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
                echo Tabs::widget([
                    'items' => // 'tabs' or 'pills'
                            $tabs,
                        
                    ]);
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>
</div>

<?php $this->registerCss(
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
    ');


$this->registerJs("
    $('#find-ts').on('click', function(){
    
    console.log('i m ajhre')
    $.ajax({
        type : 'post',
        url : '".Yii::$app->urlManager->createUrl('table-booking/get-staff-free-time')."',
        dataType : 'json',
        data : {staff_id : $(\"#staff_id_modal\").val(),date_val:$(\"#find-date-val\").val(), min_val:$(\"#find-min-val\").val(),update:$(\"#order_id\").val()?$(\"#order_id\").val():0},
        success :  function(data){
            $('#free_time_list').html(data.dd);
        }
        })
        })")
?>


