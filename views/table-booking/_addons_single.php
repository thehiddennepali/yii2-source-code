<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 07-Jun-16
 * Time: 21:45
 * @var Addon[] $addons
 */
?>
<?php

//print_r($addons);
foreach($addons as  $val){
    
    echo '<label class="checkbox"><input placeholder="Checkboxes" class="single-checkbox-class" id="SingleOrder_addons_list_'.$val->id.'" value="'.$val->id.'" type="checkbox" data-price = "'.$val->price.'" data-time = "'.$val->time_in_minutes.'" name="SingleOrder[addons_list][]">'.$val->nameWithPriceAndTime.'</label>';
}