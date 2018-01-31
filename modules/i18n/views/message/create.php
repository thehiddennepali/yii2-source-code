<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model i18n\models\I18nMessage */

$this->title = Yii::t('app', 'Create I18n Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'I18n Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
