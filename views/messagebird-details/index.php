<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MessagebirdDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SMS Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messagebird-details-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'merchant_id',
            'access_key',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
