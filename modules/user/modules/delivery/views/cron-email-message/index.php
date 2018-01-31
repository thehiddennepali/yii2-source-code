<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel delivery\models\search\CronEmailMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Report of cron email messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cron-email-message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Cron Email Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //'id',
            'created_date',
            'recipient_email:email',
            //'recipient_name',
            'sender_email:email',
             //'sender_name',
             'subject',
             //'body',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->statusText;
                },
                'filter'=>$searchModel->statusValues,
            ],
             'sent_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
