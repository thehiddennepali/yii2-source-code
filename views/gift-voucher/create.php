<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GiftVoucher */

$this->title = Yii::t('basicfield', 'Create Gift Voucher');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Gift Vouchers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-voucher-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
