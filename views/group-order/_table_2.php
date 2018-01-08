
<?php  $sd = SingleScheduleHelper::getEmptyDays($model->id); if($sd){ ?>

<div class='calendar-<?= $model->id ?>'></div>


<script>

    $(document).ready(function () {
        $('.calendar-<?=$model->id?>').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            'firstDay': 1,
            defaultDate: '<?=date('Y-m-d')?>',
            hiddenDays: <?=$sd?>,
            weekends: true,
            businessHours: true, // display business hours
           // editable: true,
            events: {
                url: 'order/getEvents/<?=$model->id?>',
                error: function() {
                    $('#script-warning').show();
                }
            },

            timeFormat: 'H(:mm)',
            slotLabelFormat:"HH:mm",
            minTime: '07:00:00',
            maxTime: '20:00:00',
            eventClick: function(event) {
                
                if (event.url) {
                    if(event.url.indexOf('updateInst')>0) {
                        $.ajax(event.url, {type: 'post', dataType: 'json'}).done(function (data) {

                            $("#order-popup-form")[0].reset();
                            $('#category_id_modal').val(data.cat)
                            //$('#find-staff-val').val(data.time);
                            $('#staff_id_modal').html(data.staff);

                            $('.deleteOrder').attr('data-id', event.id);
                            $('.deleteOrder').attr('data-staff-id', data.staff_id);
                            $('.deleteOrder').attr('disabled', false);

                            $('.single-price').html(data.price);
                            $('#single-cat-price').html(data.cat_price);
                            $('#SingleOrder_addons_list').html(data.add_ons);

                            $('#order_id').val(data.id);
                            $('#find-date-val').val(data.date);
                            $('#find-min-val').val(data.time_sum);
                            $(".time-in-min").html(data.time_sum);
                            $('#free_time_list').html(data.time);
                            $('#SingleOrder_client_name').val(data.name)
                            $('#SingleOrder_client_phone').val(data.phone)
                            $('#SingleOrder_client_email').val(data.email)
                        });
                    }
                    else{
                        $.ajax(event.url, {type: 'get', dataType: 'json'}).done(function (data) {

                            $('.group-popup-body').html(data.html);
                            $('.saveGroupOrder').attr('data-id','g-'+ data.timest+data.cat_id)
                            $('#gservice_id').val(data.cat_id)
                            $('#gorder_servise_date').val(data.order_time)
                            $('.group-price').html(data.price);
                            $('#group-cat-price').val(data.price);
                            $('#GroupOrder_addons_list').html(data.add_ons);
                            $('#g_cache').val(data.cache_id);

                            $('.group-booking-popup').animate({width:'toggle'},500);
                            $('html, body').animate({
                                scrollTop: $(".group-booking-popup").offset().top
                            }, 700);
                        });
                    }
                }
                return false;
            }

        });
    });

</script>
<?php } ?>