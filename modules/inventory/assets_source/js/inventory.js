/**
 * Created by nurbek on 10/11/16.
 */

if(window.is_new_record!== 'undefined' && is_new_record){
    var $name = $('[name="InventorySheet[name]"]');
    var $location_id = $('[name="InventorySheet[location_id]"]');
    var $category_id = $('[name="InventorySheet[category_id]"]');

    $('[name="InventorySheet[location_id]"], [name="InventorySheet[location_id]"], [name="InventorySheet[category_id]"]').change(function(){
        var name = date;
        if($location_id.val())
            name+=' - '+$location_id.find('option:selected').text();
        if($category_id.val())
            name+=' - '+$category_id.find('option:selected').text();
        $name.val(name);
    });
}

$('.inventory-count input').keyup(function(){
    var $td = $(this).parents('td');
    var $case = $td.find('input');
    var $unit = $td.find('select');
    if($case.val() && $unit.val())
        $.ajax({
                    url: baseUrl+'/item/item/cost',
                    data:{
                        item_id:$td.data('item_id'),
                        case:$case.val(),
                        unit:$unit.val()
                    },
                    success:function(data)
                    {
                        $td.next().html(data);
                    }
            });
    else
        $td.next().html('');
});
$('.inventory-count select').change(function () {
    var $td = $(this).parents('td');
    var $case = $td.find('input');
    $case.trigger('keyup');
});

$("body").on('keydown', '.inventory-count input', function(e) {
    var $td = $(this).parents('td');

    var keyCode = e.keyCode || e.which;

    if (keyCode == 9) {
        e.preventDefault();
        $td.parents('tr').next().find('.inventory-count input').eq(0).select();
    }
});

$(document).on('click', '.parLink',function(){
    var $form = $('#parForm');
    var $parLink = $(this);
    var item_id = $parLink.data('item_id');
    var par = $parLink.data('par');
    var low_amount = $parLink.data('low_amount');
    var alert_user_id = $parLink.data('alert_user_id');
    var alert_email = $parLink.data('alert_email');
    var location_id = $('[name="InventorySheet[location_id]"]').val();

    $form.prop('action', baseUrl+'/inventory/inventory-sheet/par?item_id='+item_id+'&location_id='+location_id);
    jQuery('#parForm').data('yiiActiveForm').settings.validationUrl = $form.prop('action');
    $('[name="ItemLocation[item_id]"]').val(item_id);
    $('[name="ItemLocation[location_id]"]').val(location_id);
    $('[name="ItemLocation[par]"]').val(par);
    $('[name="ItemLocation[low_amount]"]').val(low_amount);
    $('[name="ItemLocation[alert_user_id]"]').val(alert_user_id);
    if(alert_email==1)
        $('[name="ItemLocation[alert_email]"][value=1]').prop('checked', true);
    else
        $('[name="ItemLocation[alert_email]"][value=0]').prop('checked', true);
    $('#parModal').modal('show');
    return false;
});


$(document).on('click', '.addAltUnit',function(){
    var $form = $('#altForm');
    var $link = $(this);
    var item_id = $link.data('item_id');

    $form.prop('action', baseUrl+'/measurement/measurement-item/add?item_id='+item_id);
    jQuery('#altForm').data('yiiActiveForm').settings.validationUrl = $form.prop('action');
    $('#altModal').modal('show');
    return false;
});