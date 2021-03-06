<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Voucher */

$this->title = Yii::t('basicfield', 'Create Coupon');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Coupon'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voucher-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
