<?php

use yii\helpers\Html;
use kartik\grid\GridView;


$this->title = Yii::t('basicfield', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?= Yii::t('default', 'Manage')?> <?=Yii::t('default','Orders')?></h1>
    </div>
    <div class="box-body">
        <?php 
	
	
        
        $cats_merch = \common\models\CategoryHasMerchant::find()->where(['is_active' => 1, 'merchant_id' => Yii::$app->user->id, 'is_group' => 0])->all();
        $catList = \yii\helpers\ArrayHelper::map($cats_merch, 'id', 'titleWithPriceAndTime');
        
        /*$this->widget('booster.widgets.TbGridView', array(
            'id' => 'order-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'order_id',
                array(
                    'name' => 'is_group',
                    'type' => 'raw',
                    'filter' => array('1' => Yii::t('default','yes'), '0' => Yii::t('default','no')),
                    'value' => '$data->is_group ? Yii::t("default","yes") : Yii::t("default","no") ',
                ),
                
                array(
                    'name' => 'category_id',
                    'type' => 'raw',
                    'filter' => $catList,
                    'value' => '$data->category->title',
                ),
                'order_time',
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'filter' => SingleOrder::getOrderStatuses(),
                    'value' => 'Order::getOrderStatuses()[$data->status]',
                ),
                array(
                    'name' => 'payment_type',
                    'type' => 'raw',
                    'filter' => array('1' => Yii::t('default', 'On Spot'), '0' => 'Paypal'),
                    'value' => '$data->payment_type ? Yii::t("default","On Spot") : "Paypal" ',
                ),
                'client_name',
                'client_phone',
                'order_time',
                /*
                'client_email',
                'order_time',
                'category_id',
                
                
                
                
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); */?>
        
        <?php //echo \common\components\Helper::getDateFormatGrid(\common\components\Helper::dateFormat() );?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            'export' => false,
            'pjax' => true,
            'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,

                    'id'=>'w0',
			'timeout' =>  false


                ],
            ],
            
                'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            
                'pager' => [
                    'class' => \liyunfang\pager\LinkPager::className(),
                    
                    'prevPageLabel' => '<<',   // Set the label for the "previous" page button
                    'nextPageLabel' => '>>',   // Set the label for the "next" page button
                    'firstPageLabel'=>'First',   // Set the label for the "first" page button
                    'lastPageLabel'=>'Last',    // Set the label for the "last" page button
                    'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                    'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                    'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                    'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                    'maxButtonCount'=>10,
                    'template' => '{pageButtons}  {pageSize}',
                    //'pageSizeList' => [10, 20, 30, 50],
//                    'pageSizeMargin' => 'margin-left:5px;margin-right:5px;',
                    'pageSizeOptions' => ['class' => 'form-control box-alignment','style' =>  Yii::$app->params['pageSizeStyle']],
//                    'customPageWidth' => 50,
//                    'customPageBefore' => ' Jump to ',
//                    'customPageAfter' => ' Page ',
//                    'customPageMargin' => 'margin-left:5px;margin-right:5px;',
                    //'customPageOptions' => ['class' => 'form-control','style' => 'display: inline-block;margin-top:0px;'],
                ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            array(
                'attribute' => 'is_group',
                'filter' => array('1' => Yii::t('default','yes'), '0' => Yii::t('default','no')),
                'value' => function($model){
                   return $model->is_group ? Yii::t("default","yes") : Yii::t("default","no") ;
                }
            ),
            array(
                    'attribute' => 'category_id',
                    'filter' => $catList,
                    'value' => function($model){
                        return $model->category->title;
                    }
                ),
                        
            array(
                    'attribute' => 'create_time',
                    //'filter' => $catList,
                    'value' => function($model){
			
						$dateFormat = \common\components\Helper::showDateFormat();
						$timeFormat = \common\components\Helper::showTimeFormat();
						if(!empty($model->create_time)){
							return date("$dateFormat $timeFormat", strtotime($model->create_time));
						}
                    }
                ),
                
                array(
                    'attribute' => 'status',
                    'filter' => common\models\SingleOrder::getOrderStatuses(),
                    'value' => function($model){
                        return \common\models\Order::getOrderStatuses()[$model->status];
                    }
                ),
                array(
                    'attribute' => 'payment_type',
                    'filter' => array('2' => Yii::t('default', 'On Spot'), '1' => 'Paypal'),
                    'value' => function($model){
                        return ($model->payment_type == 2) ? Yii::t("default","On Spot") : "Paypal" ;
                    }
                ),
                'client_name',
                'client_phone',
                        
                        
                [
					'label' => Yii::t('basicfield', 'From - To'),
					'attribute' => 'fromTo',
					'filterType' => GridView::FILTER_DATE_RANGE,
					
					'filterWidgetOptions' => [
						'pluginOptions' => [
							
						'locale'=>[
									'format'=> \common\components\Helper::getDateFormatGrid(\common\components\Helper::dateFormat() ),
									'language' => 'sk',
								],
						'autoclose' => true,
						'todayHighlight' => true,
						]
					],
					'value' => function($model){

							$dateFormat = \common\components\Helper::showDateFormat();
							$timeFormat = \common\components\Helper::showTimeFormat();

							return date("$dateFormat $timeFormat", strtotime($model->order_time));


					}

				],
					
					
                        
                array(
                    'label' => Yii::t('basicfield', 'Commission'),
                    'attribute' => 'commission',
                    'filter' => array('1' => Yii::t('basicfield', 'No'), '2' => Yii::t('basicfield','Yes')),
                    'value' => function($model){
                        if(!empty($model->total_commission)){
                            return 'Yes';
                        }else{
                            return 'No';
                        }
                    }
                ),
						
				array(
                    'label' => Yii::t('basicfield', 'Staff'),
                    'attribute' => 'staff_id',
                    'filter' => yii\helpers\ArrayHelper::map(common\models\Staff::find()->where(['merchant_id' => Yii::$app->user->id])->all(), 'id', 'name'),
                    'value' => function($model){
                        return $model->staff->name;
                    }
                ),
               // 'order_time',
            // 'client_phone',
            // 'client_email:email',
            // 'order_time',
            // 'category_id',
            // 'staff_id',
            // 'merchant_id',
            // 'create_time',
            // 'is_group',
            // 'source_type',
            // 'order_id',
            // 'price',
            // 'more_info',
            // 'discounted_amount',
            // 'discount_percentage',
            // 'percent_commision',
            // 'total_commission',
            // 'commision_ontop',
            // 'merchant_earnings',
            // 'voucher_code',
            // 'voucher_amount',
            // 'voucher_type',
            // 'voucher_id',

//            [   'class' => 'yii\grid\ActionColumn',
//                    'template' => '{view}',
//                    'buttons' => [
//                        'view' => function ($url, $model) {
//                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                                        'title' => Yii::t('yii', 'View'),
//                                        'data-pjax'=>'w0',
//                            ]);
//                        }
//                    ]
//                    ],
        ],
    ]); ?>
    </div>
</div>


<?php /*
$this->registerJs("
$(document).on('pjax:complete', function() {
    $('#ordersearch-fromto').daterangepicker();
});")*/
?>