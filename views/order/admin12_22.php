<?php

use yii\helpers\Html;
use yii\grid\GridView;


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
        
        
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    'attribute' => 'order_time',
                    //'filter' => $catList,
                    'value' => function($model){
                        return date('d-m-Y H:i:s', strtotime($model->order_time));
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
                'filter' => kartik\daterange\DateRangePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'fromTo',
                    'convertFormat'=>true,
                    'pluginOptions'=>[
                        'timePicker'=>false,
                        'timePickerIncrement'=>30,
                        'locale'=>[
                            'format'=>'d-m-Y'
                        ]
                    ]
                ]),
                'value' => function($model){
                    return date('d-m-Y H:i:s', strtotime($model->create_time));
               
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

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'],
        ],
    ]); ?>
    </div>
</div>