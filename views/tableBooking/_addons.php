<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 07-Jun-16
 * Time: 21:45
 */
?>
<?php
foreach($addons as  $val){
    echo '<label class="checkbox"><input placeholder="Checkboxes" class="group-checkbox-class" id="GroupOrder_addons_list_'.$val->id.'" value="'.$val->id.'" type="checkbox" data-price = "'.$val->price.'" name="GroupOrder[addons_list][]">'.$val->nameWithPriceAndTime.'</label>';
}