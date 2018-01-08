<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GiftVoucherSetting */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Gift Voucher Setting',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Gift Voucher Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="gift-voucher-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
