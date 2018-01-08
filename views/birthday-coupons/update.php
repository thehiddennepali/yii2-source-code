<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Voucher */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Coupon',
]) . $model->voucher_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->voucher_id, 'url' => ['view', 'id' => $model->voucher_id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="voucher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
