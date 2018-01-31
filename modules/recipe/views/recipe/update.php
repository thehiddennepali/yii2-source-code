<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model item\models\Item */

$this->title = Yii::t('app', 'Update recipe').': ' . $model->item_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ingredients' => $ingredients,
    ]) ?>

</div>
