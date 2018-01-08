<?php

use yii\helpers\Html;
use yii\grid\GridView;

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