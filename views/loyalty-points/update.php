<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LoyaltyPoints */

$this->title = Yii::t('basicfield', 'Update Loyalty Points') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Loyalty Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');

$this->context->menu = false;
?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="alert alert-info">
        <strong><?=Yii::t('default', 'Important')?>!</strong>
        1 eur = <?= \common\models\Option::getValByName('website_loyalty_points') ?> <?=Yii::t('basicfield', 'points')?>.
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

