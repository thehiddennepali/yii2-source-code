<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 15-Mar-16
 * Time: 12:37
 */
?>
    <h2><?=Yii::t('basicfield','Extra Schedule')?></h2>
<?php
echo common\widgets\OneManyWidget::widget([
    'model' => $model, 'action' => 'OneMany'
]);

//$this->widget('OneManyWidget', ['model' => $model, 'action' => 'OneMany']);