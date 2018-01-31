<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \i18n\models\I18nSourceMessage;

/* @var $this yii\web\View */
/* @var $searchModel i18n\models\search\I18nMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'I18n Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create I18n Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'language',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->languageText;
                },
                'filter'=>(new I18nSourceMessage())->languageValues,
            ],
            'translation:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
