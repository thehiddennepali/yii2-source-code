<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel measurement\models\search\MeasurementItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Measurement Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurement-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createMeasurementItem'))
            echo Html::a(Yii::t('app', 'Create Measurement Item'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_list', ['model' => $model, 'key'=>$key, 'index'=>$index]);
        },
    ]) ?>

</div>
