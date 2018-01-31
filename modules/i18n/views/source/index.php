<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel i18n\models\search\I18nSourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'I18n Source Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-source-message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create I18n Source Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute'=>'category',
                'filter'=>$searchModel->categoryValues,
            ],
            [
                'attribute'=>'message',
                'value'=>function($data){
                    return Yii::$app->formatter->asTextLimit($data->message, 50) ;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
