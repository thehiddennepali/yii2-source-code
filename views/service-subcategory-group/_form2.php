<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 23-Mar-16
 * Time: 13:20
 */
$list = \yii\helpers\ArrayHelper::map(\common\models\GroupScheduleDaysTemplate::find()
        ->where('merchant_id = ' . Yii::$app->user->id)->all(), 'id', 'title');
$m = $model->lastSchedule ? $model->lastSchedule : new common\models\GroupScheduleHistory();


echo \yii\helpers\Html::hiddenInput('id',$m->id);
foreach (array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') as $val) {
    echo $form->field($m, $val)->dropDownList(
            $list , 
            ['prompt' => Yii::t('basicfield', 'select time template or leave empty if it is free day')]
            );

}