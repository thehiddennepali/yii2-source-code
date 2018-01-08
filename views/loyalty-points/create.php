<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LoyaltyPoints */

$this->title = Yii::t('basicfield', 'Create Loyalty Points');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Loyalty Points'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loyalty-points-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
