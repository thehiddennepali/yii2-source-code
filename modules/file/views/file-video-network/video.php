<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/6/16
 * Time: 11:31 AM
 */

use yii\helpers\Html;


?>

<?php
$video = $model;
if($video){
    ?>
    <?=$video->video;?>
    <?php
}
?>