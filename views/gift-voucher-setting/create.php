<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\GiftVoucherSetting */

$this->title = Yii::t('basicfield', 'Gift Voucher Setting');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Gift Voucher Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gift-voucher-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
