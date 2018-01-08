<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryHasMerchant */

$this->title = Yii::t('app', 'Update Single Service', [
    'modelClass' => 'Category Has Merchant',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Has Merchants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="category-has-merchant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>