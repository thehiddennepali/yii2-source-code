<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Gift Voucher Sales');
$this->params['breadcrumbs'][] = $this->title;
$this->context->menu = false;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
            'pjax' => true,
            'pjaxSettings' => [
            'options' => [
                    'enablePushState' => false,

                    'id'=>'w0',


                ],
            ],
            
//                'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            
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

			'id',
			
			[
				'attribute'=>'voucher_type',
				'value'=>function($model){
					 return \common\models\GiftVoucher::$type[$model->voucher->type];
		
				} 
			],
			
			'client_name',
			'client_phone',
			'price',
			'payment_status',
			
			[
				'attribute'=>'delivery_option',
				'value'=>function($model){
					 return frontend\models\Order::$deliveryOption[$model->delivery_option];
		
				} 
			],
			'voucher_note',
			'order_time',
			'commision_ontop',
			[	
				'attribute'=>'reciever',
				'value'=>function($model){
					return $model->reciever;
				},
			],
					
			[
				'label' => 'Is Delivered/Picked Up',
				'attribute' => 'is_delivered_pickup',
				'format' => 'raw',
				'value' => function ($model){
					if($model->is_delivered_pickup == 0){
						return 'No '.\yii\helpers\Html::a('Change', ['order/change-delivery','id'=> $model->id]);
					}else{
						return 'Yes'.\yii\helpers\Html::a('Change', ['order/change-delivery','id'=> $model->id]);
					}
				    //return \yii\helpers\Html::a($model->service_name, ['rpt-merchante-sales/details','merchantId'=> $model->merchant_id],['target' => '_blank']);
				}
			],		

		
        ],
    ]); ?>
</div>
