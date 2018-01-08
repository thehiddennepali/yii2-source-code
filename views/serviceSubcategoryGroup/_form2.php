<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 23-Mar-16
 * Time: 13:20
 */
$list = CHtml::listData(GroupScheduleDaysTemplate::model()->findAll('merchant_id = ' . Yii::app()->user->id), 'id', 'title');
$m = $model->lastSchedule ? $model->lastSchedule : new GroupScheduleHistory();
echo CHtml::activeHiddenField($m, 'id');
foreach (array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') as $val) {
    echo $form->dropDownListGroup($m, $val, array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-5',
        ),
        'widgetOptions' => array(
            'data' => $list,
            'htmlOptions' => array('prompt' => 'select time template or leave empty if it is free day'),
        )
    ));

}