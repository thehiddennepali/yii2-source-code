<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CategoryHasMerchantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Category Has Merchants');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield', 'Manage Single Services')?></h1>
    </div>
    <div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            array(
                'attribute' => 'category_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\ServiceCategory::find()->all(), 'id', 'title'),
                'value' => function($model){
                    return $model->subcategory->title;
                }
            ),
            'title',
            array(
                'attribute' => 'is_active',
                'filter' => array('1' => Yii::t('basicfield','yes'), '0' => Yii::t('basicfield','no')),
                'value' => function($model){
                    return $model->is_active ? Yii::t("basicfield","yes") : Yii::t("basicfield","no") ;
                }
            ),
            'price',
            'time_in_minutes',
            
            'additional_time',
            'service_time_slot',
            // 'title',
            // 'group_people',
            // 'is_group',
            // 'staff_id',
            // 'color',
            // 'description:ntext',

            ['class' => 'yii\grid\ActionColumn', 
                'template' => '{update}{delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
</div>
