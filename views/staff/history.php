<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->context->menu = false;

$this->title = Yii::t('basicfield', 'Schedule and Vacation History');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield', 'Schedule and Vacation History')?></h1>
    </div>
    <div class="box-body">
        <?php /*$this->widget('booster.widgets.TbGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'work_date',
               
                array(
                    'name' => 'staff_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(Staff::model()->findAllByAttributes(['merchant_id'=>Yii::app()->user->id]),'id','name'),
                    'value' => '$data->staff->name',
                ),

                array(
                    'name' => 'schedule_days_template_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(ScheduleDaysTemplate::model()->findAllByAttributes(['merchant_id'=>Yii::app()->user->id]),'id','title'),
                    'value' => '$data->scheduleDaysTemplate?$data->scheduleDaysTemplate->title:""',
                ),

                'reason',
            ),
        )); */?>
        
        <?= GridView::widget([
        'dataProvider' => $dataProviderS,
        'filterModel' => $searchModelS,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'work_date',
            array(
                'attribute' => 'staff_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\Staff::find()->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','name'),
                'value' => function($model){
                    return $model->staff->name;
                }
            ),
                    
            array(
                'attribute' => 'schedule_days_template_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\ScheduleDaysTemplate::find()->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','title'),
                'value' => function($model){
                    return $model->scheduleDaysTemplate?$model->scheduleDaysTemplate->title:"";
                }
            ),
            
            'reason',
            // 'schedule_days_template_id',

           
        ],
    ]); ?>

        <?php /*$this->widget('booster.widgets.TbGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $modelV->search(),
            'filter' => $modelV,
            'columns' => array(
                'id',
                'start_date',
               'end_date',
                array(
                    'name' => 'staff_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(Staff::model()->findAllByAttributes(['merchant_id'=>Yii::app()->user->id]),'id','name'),
                    'value' => '$data->staff->name',
                ),
                'remark',
            ),
        ));*/ ?>
        
        <?= GridView::widget([
        'dataProvider' => $dataProviderV,
        'filterModel' => $searchModelV,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'start_date',
            'end_date',
            array(
                'attribute' => 'staff_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\Staff::find()->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','name'),
                'value' => function($model){
                    return $model->staff->name;
                },
            ),
            'remark',
                        
            
        ],
    ]); ?>
    </div>
</div>