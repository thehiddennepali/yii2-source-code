<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model item\models\Item */

$this->title = Yii::t('app', 'Create recipe');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recipes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ingredients' => $ingredients,
    ]) ?>

</div>
