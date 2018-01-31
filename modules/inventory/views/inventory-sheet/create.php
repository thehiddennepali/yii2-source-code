<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use inventory\models\Location;
use inventory\models\Category;

/* @var $this yii\web\View */
/* @var $model inventory\models\InventorySheet */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Take inventory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventory Sheets'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inventory-sheet-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataProvider' => $dataProvider,
        'inventory_location_manual_counts' => $inventory_location_manual_counts,
    ]) ?>

</div>

