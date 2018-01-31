<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/6/16
 * Time: 12:00 PM
 */
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php
Modal::begin([
    'id'=>'videoModal',
    'header' => '<h4 style="display:inline;">'.Yii::t('file', 'Video').'</h4>',
    'clientOptions' => ['show' => false],
]);
?>

<?php
Modal::end();
?>

