<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\VoucherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Coupons');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage Coupons')?></h1>
    </div>
    <div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'voucher_id',
            'voucher_name',
            //'voucher_type',
            array(
                'attribute' => 'voucher_type',
                'filter' => \common\models\Voucher::getTypes(),
                'value' => function($model){
                    return $model->voucherTypeName;
                }
            ),
            'amount',
            // 'voucher_type',
            // 'amount',
            // 'expiration',
            // 'status',
            // 'date_created',
            // 'date_modified',
            // 'used_once',
            // 'service_id',

            ['class' => 'yii\grid\ActionColumn', 
                'template' => '{update}{delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
</div>
