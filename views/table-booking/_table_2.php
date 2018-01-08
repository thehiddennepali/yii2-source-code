<?php /*$this->registerJsFile(
    '@web/js/locale-all.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);*/?>


<?php  $sd = common\extensions\SingleScheduleHelper::getEmptyDays($model->id); 

echo Yii::$app->language;

if($sd){ 
   // print_r($sd);
    ?>


<div  style="overflow-x:auto;" class='calendar-<?= $model->id ?>'></div>


<?php echo $this->registerJs("
    $(document).ready(function () {
    //console.log($('.calendar-".$model->id."'));
        //$('.calendar-".$model->id."').fullCalendar('render');
        
          
         $('a[data-toggle=\"tab\"]').on('shown.bs.tab', function (e) {
            $('.calendar-".$model->id."').fullCalendar('render');
        });
        
        
          

        $('.calendar-".$model->id."').fullCalendar({
            
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            locale: '".Yii::$app->language."',
            'firstDay': 1,
            defaultDate: '".date('Y-m-d')."',
            hiddenDays: ".$sd.",
            weekends: true,
            businessHours: true, // display business hours
           // editable: true,
            events: {
                url: 'order/get-events?id=".$model->id."',
                error: function() {
                    $('#script-warning').show();
                }
            },
             

            timeFormat: 'H(:mm)',
            slotLabelFormat:'HH:mm',
            minTime: '07:00:00',
            maxTime: '20:00:00',
	     eventMouseover: function(calEvent, jsEvent) { 
	     var tooltip = '<div class=\"tooltipevent\" style=\"width:150px;height:100px;background:#eaeaea;padding:10px;border:solid 1px #666;position:absolute;z-index:10001;\"> <small>' + calEvent.description + '</small></div>'; 
	     var tool = $(tooltip).appendTo('body');
		$(this).mouseover(function(e) {
		    $(this).css('z-index', 10000);
			    tool.fadeIn('500');
			    tool.fadeTo('10', 1.9);
		}).mousemove(function(e) {
		    tool.css('top', e.pageY + 10);
		    tool.css('left', e.pageX + 20);
		});
		},
		
		eventMouseout: function(calEvent, jsEvent) {
		$(this).css('z-index', 8);
		$('.tooltipevent').remove();
		},
		
		
            eventClick: function(event) {
                
                if (event.url) {
                    if(event.url.indexOf('update-inst')>0) {
                        $.ajax(event.url, {type: 'post', dataType: 'json'}).done(function (data) {
						$('.existing').hide();
						$('.field-singleorder-client_name').show();
						$('#client-type').hide();
                            $('#order-popup-form')[0].reset();
                            $('#category_id_modal').val(data.cat)
                            //$('#find-staff-val').val(data.time);
                            $('#staff_id_modal').html(data.staff);

                            $('.deleteOrder').attr('data-id', event.id);
                            $('.deleteOrder').attr('data-staff-id', data.staff_id);
                            $('.deleteOrder').attr('disabled', false);

                            $('.single-price').html(data.price);
                            $('#single-cat-price').html(data.cat_price);
                            $('#singleorder-addons_list').html(data.add_ons);

                            $('#order_id').val(data.id);
                            $('#find-date-val').val(data.date);
                            $('#find-min-val').val(data.time_sum);
                            $('.time-in-min').html(data.time_sum);
                            $('#free_time_list').html(data.time);
                            $('body #singleorder-client_name').val(data.name)
                            $('#singleorder-client_phone').val(data.phone)
                            $('#singleorder-client_email').val(data.email)
                            
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
                            $('#grouporder-addons_list').html(data.add_ons);
                            $('#g_cache').val(data.cache_id);
                            $('#grouporder-no_of_seats').val(data.no_of_seats);
                            $('.group-booking-popup').animate({width:'toggle'},500);
                            $('html, body').animate({
                                scrollTop: $('.group-booking-popup').offset().top
                            }, 700);
                        });
                    }
                }
                return false;
            }

        });
        });
    

");?>
<?php } ?>