<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model inventory\models\InventorySheet */

$this->title = Yii::t('app', 'Update inventory sheet: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventory Sheets'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="inventory-sheet-update">


    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'inventory_location_manual_counts' => $inventory_location_manual_counts,
    ]) ?>

</div>
