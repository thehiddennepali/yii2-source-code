<?php 
use yii\helpers\Html;
use vova07\imperavi\Widget;
?>


<h2><?=Yii::t('basicfield','Main Info')?></h2>


<?= Html::img($model->behaviors['imageBehavior']->getImageUrl(), ['style' => 'width:150px;']) ?>
<?php echo $form->field($model, 'image')->fileInput(); ?>
<?= Html::img($model->behaviors['imageBehavior2']->getImageUrl(), ['style' => 'width:150px;']) ?>
<?php echo $form->field($model, 'image_big')->fileInput();; ?>


<?php 
echo $form->field($model, 'service_name')->textInput();
?>

<?php  echo $form->field($model, 'description')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ]);?>

<?php echo $form->field($model, 'language_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Language::find()->all(), 'id', 'name'), [
            'prompt' => 'Select Language'
        ]); ?>


<?php echo $form->field($model, 'service_phone'); ?>

<?php echo $form->field($model, 'contact_name'); ?>

<?php echo $form->field($model, 'contact_phone'); ?>

<?php echo $form->field($model, 'contact_email'); ?>

<?php echo $form->field($model, 'website_url'); ?>

<?php echo $form->field($model, 'country_code'); ?>

<?php echo $form->field($model, 'street')->textArea(); ?>

<?php echo $form->field($model, 'city'); ?>

<?php echo $form->field($model, 'state'); ?>

<?php echo $form->field($model, 'post_code'); ?>

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

<?php echo $form->field($model, 'status')->checkBox(); ?>

<?php echo $form->field($model, 'gmap_altitude')->hiddenInput(['id' => 'altitude'])->label(false); ?>
<?php echo $form->field($model, 'gmap_latitude')->hiddenInput(['id' => 'latitude'])->label(false); ?>

<?php echo $form->field($model, 'address'); ?>
<button onclick="initMarker(); return false"><?=Yii::t('basicfield','search')?></button>
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

        if ($('#merchant-address').val()) {
            var addr = $('#merchant-address').val()
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
            if ($('#merchant-address').val()) {
                var addr = $('#merchant-address').val()
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



