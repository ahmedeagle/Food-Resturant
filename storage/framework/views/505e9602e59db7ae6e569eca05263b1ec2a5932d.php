<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <main class="page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">أهلا وسهلا بك في خدمة مجرّب</h1>
            <p class="description text-gray font-body-md mt-3">يرجى تحديد موقع المطعم عبر الخريطة</p>
            
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">
                    <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">
                        
                                

                        
                        <div id="map" class="embed-responsive-item"></div>
                        
                    </div>
                    <form action="<?php echo e(url("/restaurant/complete-profile/map")); ?>" method="POST">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" id="register-latlng" name="latLng" />
                        <input type="hidden" id="register-lat" name="lat" />
                        <input type="hidden" id="register-lng" name="lng" />
                        
                         
                        <Button type="submit" id="submitmap" class="btn btn-primary px-5 no-decoration"> موقعي الحالي</Button>
                        
                        <?php if($errors->has('lat')): ?>
                            <div class="alert alert-danger top-margin">
                                <?php echo e($errors->first('lat')); ?>

                            </div>
                        <?php endif; ?>
                    </form>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&language=ar&callback=initMap">
    </script>

 
    <script>
    
    
    $( "#map" ).click(function() {
       $( "#submitmap" ).text( "متابعه" );
    });
           
            
    var map, infoWindow , marker ,geocoder;
        
    var messagewindow;
    var markers = [];

    var prevlat;
    var prevLng

    var SelectedLatLng = "";
    var SelectedLocation = "";
 

        initMap();

      

  function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseInt(prevlat), lng: parseInt(prevLng)},
            zoom: 6
        });
        
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder();

        // Try HTML5 geolocation.

        if($("#register-latlng").val() === ""){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    //infoWindow.setPosition(pos);
                   // infoWindow.setContent('Location found.');
                   // infoWindow.open(map);
                    map.setCenter(pos);
                    
                     var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(pos),
                              
                            map: map,
                            title: 'موقعك الحالي'
                        });
                         
                         
                          markers.push(marker);
                           
                    
                        marker.addListener('click', function() {
                           
                                 
                                geocodeLatLng(geocoder, map, infoWindow,marker);
                                
                                
                        });
        
  
                        // to get current position address on load 
                        google.maps.event.trigger(marker, 'click');
                        
                        
                        
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        //addMarker(parseInt($(".shipping-latLng").val()));
        var geocoder = new google.maps.Geocoder();

        if($("#register-latlng").val() !== ""){
            addMarker( "(" + parseInt($('#register-lat').val()) + "," + parseInt($('#register-lng').val()) +")");
        }else{

            google.maps.event.addListener(map, 'click', function(event) {
                
                   
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                            splitLatLng(String(event.latLng));
                            $("#register-latlng").val(SelectedLatLng);
                            
                           $("#register-map-address").val(SelectedLocation);
                            
                            
                        
                        }
                    }
                });
            });

        }


     //used only to get current position address name 

        function geocodeLatLng(geocoder, map, infowindow,markerCurrent) {
           
          
         var latlng = {lat: markerCurrent.position.lat(), lng: markerCurrent.position.lng()};
         
         
                                    $("#register-lat").val(markerCurrent.position.lat());
                                    $("#register-lng").val(markerCurrent.position.lng());
                                    $("#register-latlng").val("("+markerCurrent.position.lat()+','+markerCurrent.position.lng()+")");
                                    
                                
         
            geocoder.geocode({'location': latlng}, function(results, status) {
              if (status === 'OK') {
                if (results[0]) {
                  map.setZoom(8);
                  var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                  });
                  
                   markers.push(marker);
                   
                  infowindow.setContent(results[0].formatted_address);
                   SelectedLocation = results[0].formatted_address;
                    $("#register-map-address").html(results[0].formatted_address);
                  
                  infowindow.open(map, marker);
                } else {
                  window.alert('No results found');
                }
              } else {
                window.alert('Geocoder failed due to: ' + status);
              }
            });
        
        
        SelectedLatLng =(markerCurrent.position.lat(),markerCurrent.position.lng());
       
      }
      
      
      
       function DeleteMarkers() {
        //Loop through all the markers and remove
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    };
    

        function addMarker(location) {
            // var marker = new google.maps.Marker({
            //     position: location,
            //     map: map
            // });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( parseInt($("#latitude").val()),parseInt($("#longitude").val())),
                map: map,
                title: 'dfkdfk'
            });
            

            var contentString = '<div id="content" style="width: 200px; height: 200px;"><h1>Overlay</h1></div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                        }
                    }
                });
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);

        }



        function addMarkerRunTime(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function splitLatLng(latLng){

        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];

        $("#register-lat").val(lat);
        $("#register-lng").val(Lng);
    }
         
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Provider.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>