<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = Yii::t('basicfield', 'Merchant Schedules');
$this->params['breadcrumbs'][] = $this->title;

$this->context->menu = false;
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Merchant History')?></h1>
    </div>
    <div class="box-body">
        
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

                'id',
                'work_date',
                array(
                    'attribute' => 'schedule_days_template_id',
                    'filter' => \yii\helpers\ArrayHelper::map(common\models\ScheduleDaysTemplate::find()->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','title'),
                    'value' => function($model){
                        if($model->scheduleDaysTemplate){
                            return $model->scheduleDaysTemplate->title;
                        }else{
                            return 'Free Day';
                        }
                    }
                ),
                'reason',
                // 'schedule_days_template_id',

               // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php /*$this->widget('booster.widgets.TbGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'work_date',
                array(
                    'name' => 'schedule_days_template_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(ScheduleDaysTemplate::model()->findAllByAttributes(['merchant_id'=>Yii::app()->user->id]),'id','title'),
                    'value' => '$data->scheduleDaysTemplate->title',
                ),
                'reason',
            ),
        ));*/ ?>
    </div>
</div>