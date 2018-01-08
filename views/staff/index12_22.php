<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('basicfield', 'Staff');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield', 'Manage')?> <?=Yii::t('basicfield', 'Staff')?></h1>
    </div>
        <div class="box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            array(
                'attribute' => 'category_id',
                'filter' => \yii\helpers\ArrayHelper::map(common\models\CategoryHasMerchant::find()->where(['merchant_id' => Yii::$app->user->id])->all(), 'id', 'title'),
                'value' => function($model){
                    return $model->allCatForEcho;
                }
            ),
            

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
</div>
