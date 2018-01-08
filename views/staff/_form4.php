<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 15-Mar-16
 * Time: 12:37
 */
echo common\widgets\OneManyWidget::widget(['model' => $model,
    'action' => 'OneMany',
    'saction' => 'OneMany2',
    'field' => 'oneMany2',
    'behaviour' => 'vacationBehavior']);

