<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GiftVoucherSetting */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Gift Voucher Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-voucher-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('basicfield', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('basicfield', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('basicfield', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'delivery_options',
            'payment',
            'delivery_fee',
            'receive_loyalty_points',
            'use_loyalty_points',
            'merchant_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
