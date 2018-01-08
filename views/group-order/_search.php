<?php 

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>
<h2><?php echo \common\models\CategoryHasMerchant::findOne($searchModel->category_id)->title . ' ' . $searchModel->order_time ?></h2>
<?php /*$this->widget('booster.widgets.TbGridView', array(
    'id' => 'group-order-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,

    'columns' => array(
        'id',
        'client_name',
        'client_phone',
        'client_email',
        'price',
       // 'is_payd',
        /*
        'servise_date',
        'more_info',
        'price',
        'is_payd',
        
        array(
            'header' => 'update',
            'urlExpression' => 'array("order/getGroupOrder","id"=>$data->id)',
            'linkHtmlOptions' => ['class' => 'groupEditLink'],
            'class' => 'CLinkColumn'
        ),
        array(
            'header' => 'remove',
            'urlExpression' => 'array("groupOrder/remove","id"=>$data->id)',
            'linkHtmlOptions' => ['class' => 'groupDeleteLink'],
            'class' => 'CLinkColumn'
        ),

    ),
));*/ ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'filterUrl' => yii\helpers\Url::to(["group-order/get-group-orders", 'id' => $searchModel->category_id, 'date_id' => strtotime($searchModel->order_time)]),
        'export' => false,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false,
               
                'id'=>'w0',
            
        
            ],
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            
            'client_name',
            'client_phone',
            'client_email:email',
            'no_of_seats',
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
            
//            array(
//                'header' => 'update',
//                'urlExpression' => 'array("order/getGroupOrder","id"=>$data->id)',
//                'linkHtmlOptions' => ['class' => 'groupEditLink'],
//                'class' => 'CLinkColumn'
//            ),
//            array(
//                'header' => 'remove',
//                'urlExpression' => 'array("groupOrder/remove","id"=>$data->id)',
//                'linkHtmlOptions' => ['class' => 'groupDeleteLink'],
//                'class' => 'CLinkColumn'
//            ),
            
            

            ['class' => 'yii\grid\ActionColumn', 
                'template' =>'{update}{remove}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        
                        $url = ['order/get-group-order','id'=>$model->id];
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => \Yii::t('yii', 'Update'),
                                    'data-pjax'          => '1',
                                    'data-toggle-active' => $model->id,
                            'class'=> 'groupEditLink'
                        ]);
                    },
                    
                    'remove' => function ($url, $model) {
                        

                        $url = array("group-order/remove","id"=>$model->id);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => \Yii::t('yii', 'Remove'),
                                    'data-pjax' => '0',
                            'class'=> 'groupDeleteLink'
                        ]);
                    }
                ]],
        ],
    ]); ?>

