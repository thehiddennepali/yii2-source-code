<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = Yii::t('user', 'Edit profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    //print_r(Yii::$app->user->identity->roles);
    Pjax::begin([
        'id'=>'pjaxForForm',
        //'enablePushState'=>false,
    ]);

        if(Yii::$app->session->hasFlash('success'))
            echo Alert::widget([
                'options' => [
                    'class' => 'alert-success',
                ],
                'body' => Yii::$app->session->getFlash('success', null, true),
            ]);
        else
        {
            ?>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            <?php
        }


    Pjax::end();
/*    $script = <<<script
        $(document).on('submit', '#formProfile', function(event) {
          $.pjax.submit(event, '#pjaxForForm', {"push":false});
        });
script;
    $this->registerJs($script);*/

    ?>
</div>
