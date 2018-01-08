<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 22-Feb-16
 * Time: 18:42
 */
?>
    <h2><?=Yii::t('default','Schedule')?></h2>
<?php
$list = CHtml::listData(ScheduleDaysTemplate::model()->findAll('merchant_id = ' . Yii::app()->user->id), 'id', 'title');
$m = $model->lastSchedule ? $model->lastSchedule : new MerchantScheduleHistory();
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