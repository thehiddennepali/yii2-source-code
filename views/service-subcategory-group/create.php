<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CategoryHasMerchant */

$this->title = Yii::t('basicfield', 'Create Group Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Single Service'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-has-merchant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
