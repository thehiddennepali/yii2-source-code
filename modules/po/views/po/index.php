<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel measurement\models\search\MeasurementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'PurchaseOrders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="po-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Alert::widget() ?>
        <?php
		if(Yii::$app->user->can('createPo'))
            echo Html::a(Yii::t('app', 'Create Purchase Order'), ['create'], ['class' => 'btn btn-success']);
        ?>
    </p>

   

</div>
