/**
 * Created by home on 25-Feb-16.
 */
//----------------------------------------------
console.log(baseUrl);
function clearSingleForm(){
    $('#client-type').show();
    $("#order-popup-form")[0].reset();
    $('#staff_id_modal').html('')
    $('#free_time_list').html('')
    $('#order_id').val('')
    $('.single-price').html('');
    $('.time-in-min').html('');
    $('#find-min-val').val('')
    $('#memcache_key').val('');
    $('#singleorder-addons_list').html('');
    $('.deleteOrder').attr('data-id','')
    $('.deleteOrder').attr('data-staff-id','')
    $('.deleteOrder').attr('disabled', 'disabled');
}

function clearGroupForm(){
    $('#g_cache').val('');
    $('#gorder_id').val();
    $('#gorder_servise_date').val();
    $('#gservice_id').val();
    $("#order-group-popup-form")[0].reset();
    $('#group-order-grid').remove();
}

$(function(){


    $('.saveOrder').on('click',function(e){
        e.preventDefault();
        
        var obj = $(this);
        obj.prop("disabled",true);
        $('.loading').show();
        
        $.ajax(baseUrl + 'order/add',{'data':$('#order-popup-form').serialize(),type:'post',dataType :'json'}).done(function(data){
            data.type = 1;
            if($('.deleteOrder').attr('data-id')){
                if($('.deleteOrder').attr('data-type')){
                    $('.deleteOrder').removeAttr('data-type');
                    $('.external-event[data-id='+$('.deleteOrder').attr('data-id')+']').remove()

                }else{
                    $('.calendar-'+ data.staff_id).fullCalendar('removeEvents',$('.deleteOrder').attr('data-id'));
                    data.data_id = $('.deleteOrder').attr('data-id');
                    data.type = 2;
                }


            }
            
            $('body .help-block').remove();
            
            if(data.success == false){
                
                obj.prop("disabled",false);
                $('.loading').hide();
                
                $.each(data.response, function(key, val) {
                    console.log(key);
                    if(key == 'category_id'){
                        $('#category_id_modal').after('<div class=\"help-block\">'+val+'</div>');
                        $('#category_id_modal').closest('.form-group').addClass('has-error');
                        
                    }
                    
                    if(key == 'order_time'){
                        $('#find-date-val').after('<div class=\"help-block\">'+val+'</div>');
                        $('#find-date-val').closest('.form-group').addClass('has-error');
                        
                    }
                    
                    if(key == 'staff_id'){
                        $('#staff_id_modal').after('<div class=\"help-block\">'+val+'</div>');
                        $('#staff_id_modal').closest('.form-group').addClass('has-error');
                        
                    }
                    
                    if(key == 'free_time_list'){
                        $('#free_time_list').after('<div class=\"help-block\">'+val+'</div>');
                        $('#free_time_list').closest('.form-group').addClass('has-error');
                        
                    }
                    
                    if(key == 'dob'){
                        $('#singleorder-birthday').after('<div class=\"help-block\">'+val+'</div>');
                        $('#singleorder-birthday').closest('.form-group').addClass('has-error');
                        
                    }
                    if(key == 'email_address'){
                        $('#singleorder-client_email').after('<div class=\"help-block\">'+val+'</div>');
                        $('#singleorder-client_email').closest('.form-group').addClass('has-error');
                        
                    }
                    
                    $('body #singleorder-'+key).after('<div class=\"help-block\">'+val+'</div>');
                    $('body #singleorder-'+key).closest('.form-group').addClass('has-error');

                });
            }else{
                $('.loading').hide();
                obj.prop("disabled",false);
                console.log(data);

                socket.emit("order", data);
                clearSingleForm()
            }

        });
        return false;
    })


    //-----------------------------group
    $('body').on('submit','#order-group-popup-form',function(e){
        e.preventDefault();
        $.ajax(baseUrl + 'order/group-add',{'data':$('#order-group-popup-form').serialize(),
            type:'post',dataType :'json'}).done(function(data){
            data.data_id = $('.saveGroupOrder').attr('data-id');
            if(data.data_id)
            data.type = 7;
            else
                data.type = 3;
            
            console.log(data);
            $('body .help-block').remove();
            if(data.success == false){
                $.each(data.response, function(key, val) {
                    console.log(key);
                    $('#grouporder-'+key).after('<div class=\"help-block\">'+val+'</div>');
                    $('#grouporder-'+key).closest('.form-group').addClass('has-error');

                });
            }else{

                socket.emit("order", data);
                //$.pjax.defaults.timeout = false;
                //$.pjax.reload({container:'#group-booking'});

                $("#w0").yiiGridView("applyFilter");
                $('#gorder_id').val('');
                $('.group-price').html($('#group-cat-price').val());
                $("#order-group-popup-form")[0].reset();
            }

        });
        
        
        return false;

    })


    //-----------------------------group order

    $('body').on('click','.groupDeleteLink',function(event){
        event.preventDefault()
        var t = $(this);
        if (confirm('Are you sure?')){
            $.ajax($(this).attr('href'),{type:'post',dataType :'json'}).done(function(data){
                data.data_id = $('.saveGroupOrder').attr('data-id');
                data.type = 4;
                socket.emit("order", data);
                $("#w0").yiiGridView("applyFilter");

            });
        }
    })

    //-----find free staff
    $('body').on('click','#find-staff',function(event){
        event.preventDefault()
        $.ajax(baseUrl + 'order/get-free-staff',{'data':{time_val:$('#find-staff-val').val(), date_val:$('#find-date-val').val(), min_val:$('#find-min-val').val(), cat:$('#category_id_modal').val(),update:$("#order_id").val()?$("#order_id").val():0},type:'post'}).done(function(data){
            $('#staff_id_modal').html(data)
        });

    })

    $('body').on('click','.clearOrder',function(event){
        event.preventDefault()
        clearSingleForm()
    })

    $('body').on('click','.deleteOrder',function(event){
        event.preventDefault();
        if(confirm('Are you sure ?')){

            $.ajax(baseUrl + 'order/delete-single-order?id='+$(this).attr('data-id'),{type:'post',dataType :'json'}).done(function(data){
                data.type = 5;
                data.data_id = $('.deleteOrder').attr('data-id')
                socket.emit("order", data);

                clearSingleForm()
            });


        }

    })

    $('body').on('click','.external-event',function(e){
        e.preventDefault();

        $.ajax(baseUrl + 'order/update-inst?id=' + $(this).attr('data-id'), {type: 'post', dataType: 'json'}).done(function (data) {

            $('.existing').hide();
            $('.field-singleorder-client_name').show();
            $('#client-type').hide();
            
            //$('#free_time_list').empty();
            
            $('.deleteOrder').attr('data-id', data.id);
            $('.deleteOrder').attr('data-type', 1);

            $('.deleteOrder').attr('disabled', false);

            $("#order-popup-form")[0].reset();
            $('#category_id_modal').val(data.cat)
            $('#free_time_list').val(data.time);



            $('.single-price').html(data.price);
            $('#single-cat-price').html(data.cat_price);
            $('#singleorder_addons_list').html(data.add_ons);

            $('#order_id').val(data.id);
            $('#find-date-val').val(data.date);
            $('#find-min-val').val(data.time_sum);
            $(".time-in-min").html(data.time_sum);
            //$('#free_time_list').html(''); //
            
            $('#free_time_list').html(data.time);
            $('body #singleorder-client_name').val(data.name)
            $('#singleorder-client_phone').val(data.phone)
            $('#singleorder-client_email').val(data.email)
        });
    })


    $('body').on('click','.group-popup-close',function(){
        $(this).parent().parent().animate({width:'toggle'},350);
        clearGroupForm()

    })

    $('body').on('click','.groupEditLink',function(e){
        e.preventDefault()
        $('#gorder_id').val();
        $('.group-price').html($('#group-cat-price').val());
        $("#order-group-popup-form")[0].reset();
        $.ajax($(this).attr('href'),{type:'post', dataType: 'json'}).done(function(data){
            $('#gorder_id').val(data.id);
            $('#gorder_servise_date').val(data.date);
            $('#gservice_id').val(data.cat);
            $('#grouporder-client_name').val(data.name)
            $('#grouporder-client_phone').val(data.phone)
            $('#grouporder-client_email').val(data.email)
            $('#grouporder-more_info').val(data.more_info)
            $('.group-price').html(data.price);
            $('.group-cat-price').html(data.cat_price);
            $('#grouporder-no_of_seats').val(data.no_of_seats);

            $.each(data.add_ons, function(index, value) {

                $('.group-checkbox-class[value='+value+']').prop('checked', true);
            });
            
            

        });
        
        //$.pjax({container: '#w1'});
        return false;
    })
});

$('#notif-new-order-total').on('hide.bs.dropdown', function(){

        setTimeout(function(){
            //$('.notif').html('0');
        },500)
})

$('body').on('change',".group-checkbox-class",function(){
    if(this.checked) {

        $('.group-price').html(parseFloat($('.group-price').html())+parseFloat($(this).attr('data-price')))
    }else{
        $('.group-price').html(parseFloat($('.group-price').html())-parseFloat($(this).attr('data-price')))
    }
});

$('body').on('change',".single-checkbox-class",function(){
    if(this.checked) {

        $('.single-price').html(parseFloat($('.single-price').html())+parseFloat($(this).attr('data-price')))
        console.log(parseInt($('#find-min-val').val()));
        console.log(parseInt($(this).attr('data-time')));
        $('#find-min-val').val(parseInt($('#find-min-val').val())+parseInt($(this).attr('data-time')))
        console.log($('.find-min-val'));
        $('.time-in-min').html(parseInt($('.time-in-min').html())+parseInt($(this).attr('data-time')))
    }else{
        $('.single-price').html(parseFloat($('.single-price').html())-parseFloat($(this).attr('data-price')))
        $('#find-min-val').val(parseInt($('#find-min-val').val())-parseInt($(this).attr('data-time')))
        $('.time-in-min').html(parseInt($('.time-in-min').html())-parseInt($(this).attr('data-time')))
    }
});
$('body').on('click',".push-for-check",function(e){
    e.preventDefault();
    var a = $(this);
    if(confirm('Are you merchant info is ready for purchase?')) {
        $.ajax('merchantEdit/push', {type: 'post'}).done(function (data) {
            a.remove();
            alert('Well done! Waiting for answer')
        });
    }
    return false;
});