<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
$this->context->menu = false;
?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?= Yii::t('basicfield','Reviews')?></h1>
    </div>
    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            
            'review:ntext',
            'rating',
            
            
            array(
                'attribute' => 'status',
                'filter' => array('1' => 'Yes', '0' => 'No'),
                'value' => function($model){
                    return $model->status ? "Yes" : "No" ;
                }
            ),
            // 'ip_address',
            // 'order_id',
            // 'name',
            // 'email:email',
            // 'food_review',
            // 'price_review',
            // 'punctuality_review',
            // 'courtesy_review',

//            ['class' => 'yii\grid\ActionColumn', 
//                'template' => '{update}{delete}'],
        ],
    ]); ?>
</div>
