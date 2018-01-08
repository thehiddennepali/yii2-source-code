<h2><?=Yii::t('default','Main Info')?></h2>
<?php   Yii::import('site.protected.vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget'); ?>
<?= CHtml::image($model->imageBehavior->getImageUrl(), 'image', ['style' => 'width:150px;']) ?>
<?php echo $form->fileFieldGroup($model, 'image'); ?>
<?= CHtml::image($model->imageBehavior2->getImageUrl(), 'image_big', ['style' => 'width:150px;']) ?>
<?php echo $form->fileFieldGroup($model, 'image_big'); ?>
<?php echo $form->textFieldGroup($model, 'service_name', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->label($model,'description') ?>
<?php $this->widget('ImperaviRedactorWidget', array(
    // You can either use it for model attribute
    'model' => $model,
    'attribute' => 'description',
)); ?>


<?php echo $form->textFieldGroup($model, 'service_phone', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php echo $form->textFieldGroup($model, 'contact_name', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->textFieldGroup($model, 'contact_phone', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php echo $form->textFieldGroup($model, 'contact_email', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->textFieldGroup($model, 'country_code', array('class' => 'span5', 'maxlength' => 3)); ?>

<?php echo $form->textAreaGroup($model, 'street', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<?php echo $form->textFieldGroup($model, 'city', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->textFieldGroup($model, 'state', array('class' => 'span5', 'maxlength' => 255)); ?>

<?php echo $form->textFieldGroup($model, 'post_code', array('class' => 'span5', 'maxlength' => 100)); ?>

<?php /* echo $form->dropDownListGroup($model,'subcategory_id'
    ,array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-5',
        ),
        'widgetOptions' => array(
            'data' => CHtml::listData(ServiceCategory::model()->findAll(),'id','title'),
            'htmlOptions' => array('prompt'=>'select category'),
        )
    )
 );*/
?>

<?php echo $form->checkBoxGroup($model, 'status'); ?>

<?php echo $form->hiddenField($model, 'gmap_altitude', ['id' => 'altitude']); ?>
<?php echo $form->hiddenField($model, 'gmap_latitude', ['id' => 'latitude']); ?>

<?php echo $form->textFieldGroup($model, 'address', ['widgetOptions' => array(
    'htmlOptions' => array(
        'id' => 'address'
    )
)]); ?>
<button onclick="initMarker(); return false"><?=Yii::t('default','search')?></button>
<div id="map" style="height: 400px; width: 600px">

</div>


<script>

    // The following example creates a marker in Stockholm, Sweden using a DROP
    // animation. Clicking on the marker will toggle the animation between a BOUNCE
    // animation and no animation.

    var marker;
    var map;
    var is_marker = '<?php echo(!empty($model->gmap_altitude)&&!empty($model->gmap_latitude))?1:0?>';

    var lat = '<?=$model->gmap_latitude?>';
    var lng = '<?=$model->gmap_altitude?>';

    function initMarker() {

        if ($('#address').val()) {
            var addr = $('#address').val()
        } else {
            var addr = 'Germany, Berlin'
        }

        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': addr}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                console.log(marker)
                marker.setPosition(results[0].geometry.location)
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13
            // center: {lat: 59.325, lng: 18.070}
        });

        if (is_marker) {
            if ($('#address').val()) {
                var addr = $('#address').val()
            } else {
                var addr = 'Germany, Berlin'
            }

            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': addr}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    marker = new google.maps.Marker({
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                        map: map,
                        position: results[0].geometry.location
                    });
                    $('#latitude').val(results[0].geometry.location.lat())
                    $('#altitude').val(results[0].geometry.location.lng())
                    google.maps.event.addListener(marker, 'click', toggleBounce);
                    google.maps.event.addListener(marker, 'dragend', dragBounce);

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });

        } else {
            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: {lat: parseInt(lat), lng: parseInt(lng)}
            });
            google.maps.event.addListener(marker, 'click', toggleBounce);
            google.maps.event.addListener(marker, 'dragend', dragBounce);

        }


    }

    function dragBounce() {
        console.log(marker.getPosition().lat())
        $('#latitude').val(marker.getPosition().lat())
        $('#altitude').val(marker.getPosition().lng())
    }

    function toggleBounce() {

        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0ObSpw_DOJbv8vi68SS4c9Kuds6rir1I&signed_in=true&callback=initMap"></script>



