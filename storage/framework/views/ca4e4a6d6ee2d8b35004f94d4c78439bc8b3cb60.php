<?php $__env->startSection("title"); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("class"); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>


    <main class="main-content page-content py-5">
        <div class="container">
            <div class="row">

                <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">تفاصيل الطلب</h4>
                    </div>


                                  <?php if(Session::has('closed')): ?>
                                  
                                    <div class="alert alert-danger top-margin">
                                           <?php echo e(Session::get('closed')); ?> 
                                    </div>
                                 <?php endif; ?>
                                 
                                   <?php if(Session::has('outWork')): ?>
                                  
                                    <div class="alert alert-danger top-margin">
                                           <?php echo e(Session::get('outWork')); ?> 
                                    </div>
                                 <?php endif; ?>
                                 
                                  


                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white">

                        <form id="complete-order-form" method="POST" action="<?php echo e(url("/user/cart/complete-order")); ?>">
                            <?php echo e(csrf_field()); ?>

                            
                                
                                
                                        
                                    
                                    
                                    
                                    
                                    
                                    
                                
                            


                            
                            
                                
                                    
                                        
                                        
                                        
                                        
                                    
                                
                                
                                    
                                        
                                        
                                        
                                        
                                    
                                
                                
                                    
                                        
                                        
                                    
                                
                            


                            <label for="delivery-method" class="font-body-bold">وقت التسليم</label>
                            <div class="d-flex justify-content-center flex-column flex-sm-row">

                                <select form="complete-order-form" name="in_future" class="custom-select text-gray font-body-md border-gray font-body-md"
                                        id="in-future">
                                    <option value="">برجاء تحديد وقت التسليم</option>
                                    <option value="0" <?php if(old("in_future") == "0"): ?> selected <?php endif; ?>>طلب مباشر</option>
                                    <option value="1" <?php if(old("in_future") == "1"): ?> selected <?php endif; ?>>طلب لوقت لاحق</option>
                                </select>

                            </div>

                            <?php if($errors->has("in_future")): ?>

                                <div class="alert alert-danger top-margin">
                                    <?php echo e($errors->first("in_future")); ?>

                                </div>

                            <?php endif; ?>

                            <div class="<?php if(old('in_future')): ?> <?php if(old('in_future') == "0"): ?> hidden-element <?php endif; ?> <?php else: ?> hidden-element <?php endif; ?> order-date-container form-group my-2">
                                <label for="people-count">التاريخ</label>
                                <input type="date" name="date" value="<?php echo e(old("date")); ?>" class="form-control border-gray">

                                <input type="hidden" value="<?php echo e($delivery_price); ?>" id="delivery_price_input" />

                                <input type="hidden"
                                       name="latLng"
                                       id="branch-latLng" />

                                <input type="hidden"
                                       name="lat"
                                       value="<?php echo e(old("lat")); ?>"
                                       id="branch-lat" />
                                <input type="hidden"
                                       name="lng"
                                       value="<?php echo e(old("lng")); ?>"
                                       id="branch-lng" />

                                <?php if($errors->has("date")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("date")); ?>

                                    </div>

                                <?php endif; ?>
                            </div>

                            <div class="<?php if(old('in_future')): ?> <?php if(old('in_future') == "0"): ?> hidden-element <?php endif; ?> <?php else: ?> hidden-element <?php endif; ?> order-time-container form-group my-2">
                                <label for="people-count">الساعة</label>
                                <input type="time" id="time" name="time" value="<?php echo e(old("time")); ?>" class="form-control border-gray">
                                <?php if($errors->has("time")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("time")); ?>

                                    </div>

                                <?php endif; ?>
                            </div>

                        </form>

                    </div>

                    <div class="rounded-lg shadow-around mt-3 font-body-bold bg-white">
                        <div class="p-3">
                            <div class="form-group mb-1">
                                <label for="delivery-method" class="font-body-bold">طريقة التسليم</label>
                                <div class="d-flex justify-content-center flex-column flex-sm-row">
                                    <select form="complete-order-form" name="delivery_method" class="custom-select text-gray font-body-md border-gray font-body-md"
                                            id="delivery-method">
                                        <option value="0" <?php if(old("delivery_method") == "0"): ?> selected <?php endif; ?>>استلام من المطعم</option>
                                        <option value="1" <?php if(old("delivery_method") == "1"): ?> selected <?php endif; ?>>توصيل</option>

                                    </select>

                                    <button id="complete-order-location-btn" class="<?php if(old('delivery_method')): ?> <?php if(old('delivery_method') == "0"): ?> hidden-element <?php endif; ?> <?php else: ?> hidden-element <?php endif; ?> btn btn-primary font-body-bold px-lg-5 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto"
                                            type="button">تحديد العنوان</button>

                                </div>
                                <?php if($errors->has("delivery_method")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("delivery_method")); ?>

                                    </div>

                                <?php endif; ?>

                                <?php if($errors->has("lat")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("lat")); ?>

                                    </div>

                                <?php endif; ?>

                            </div>
                        </div>
                    </div>




                    
                       
                            
                                
                                
                                    
                                            
                                        
                                        
                                        

                                    

                                    
                                            

                                
                            
                        
                    



                    <div class="rounded-lg shadow-around mt-3 font-body-bold bg-white">
                        <form class="p-3">
                            <label class="my-1">طريقة الدفع</label>
                            <div class="form-row my-1 mr-4">
                                <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col">
                                    <div class="custom-control custom-radio">
                                        <input form="complete-order-form" type="radio" id="customRadio_<?php echo e($method->id); ?>" value="<?php echo e($method->id); ?>" name="payment_method" class="custom-control-input">
                                        <label class="custom-control-label text-gray font-body-md" for="customRadio_<?php echo e($method->id); ?>"><?php echo e($method->name); ?></label>
                                    </div>
                                </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                            <?php if($errors->has("payment_method")): ?>

                                <div class="alert alert-danger top-margin">
                                    <?php echo e($errors->first("payment_method")); ?>

                                </div>

                            <?php endif; ?>
                        </form>
                    </div>


                    <div class="p-3 rounded-lg shadow-around mt-3 font-body-md bg-white">

                        <div class="row">
                            <div class="col-sm-6 col ">
                                <p class="mb-2">قيمة التوصيل</p>
                                <p class="mb-2">قيمة نسبة الضريبة</p>
                                <p class="mb-2">قيمة الطلب</p>
                                <p class="mb-2">المجموع النهائي</p>
                            </div>
                            <div class="col-sm-6 col text-gray">
                                <p class="mb-2"><span class="delivery_price_span"><?php if(old('delivery_method')): ?> <?php if(old("delivery_method") == "1"): ?> <?php echo e($delivery_price); ?> <?php else: ?> 0 <?php endif; ?>  <?php else: ?> 0 <?php endif; ?></span> ر.س </p>
                                <p class="mb-2"><?php echo e($tax); ?> % ر.س </p>
                                <p class="mb-2"> <span class="order_price"><?php echo e($total_price); ?></span> ر.س </p>
                                <p class="mb-2 text-primary"><span class="total_paid_value2"><?php echo e($total_paid_value); ?></span> ر.س </p>
                            </div>
                        </div>

                      <input type="hidden" value="<?php echo e($tax); ?>" id="tax">
                      
 
                            <div id="checkBalanceStatus" class="alert alert-success" style="display:none;">
                                   
                            </div>

                     </div>

                    <!-- <button type="submit" class="btn btn-primary px-5 mt-3">
                        إدفع
                    </button> -->

                    <!-- For Test --><button form="complete-order-form" type="submit" class="btn btn-primary px-5 mt-3">اكمال الطلب</button><!-- For Test -->

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

    <main id="map-content" class="hidden-element map-content page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">تحديد الموقع</h1>
            <p class="description text-gray font-body-md mt-3">يرجى تحديد موقع الاستلام عبر الخريطة</p>
            
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">
                    <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                        <div id="map" class="embed-responsive-item"></div>

                    </div>

                    <Button type="button" id="confirm-user-location" class="btn btn-primary px-5 no-decoration">تأكيد</Button>
                    <Button type="button" id="decline-user-location" class="btn btn-default px-5 no-decoration">رجوع</Button>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>

 

<?php $__env->startSection('script'); ?>

<script>


  
	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
var orderTotal = <?php echo e($total_paid_value); ?>;



$(document).ready(function(){
    
         $.ajax({
           	  	  
           	  	  url:  '/user/cart/check_balance',
           	  	  
           	  	  data:{
        
                         'orderTotal'      : parseFloat($(".total_paid_value2").html())
                         
            	  	  } ,
                   type: 'post',
           	  	  success:function(data){
                          
                          
                        if(data.balanceMessage && data.type!=0){
                            
                            $('#checkBalanceStatus').empty().show().append(data.balanceMessage);
                              
                        }
                       
         
           	  	  },
           	  	  error:function(reject){
           	  	     
                        
            	  	  }
                 
                });

 
    
});

   $("#delivery-method").on("change", function () {
       
       $('#checkBalanceStatus').hide();

        var method = $(this).find(":selected").val();
        
        var delivery_price = parseFloat($("#delivery_price_input").val());

        var total_paid_value = parseFloat($(".total_paid_value2").html());
        
        var tax              = parseFloat($('#tax').val());

        if(method == "1"){

            $("#complete-order-location-btn").removeClass("hidden-element");
            
            $(".delivery_price_span").html(delivery_price);
            
               var total = total_paid_value + delivery_price;
            
            
            $(".total_paid_value2").html(total);
                 
                 orderTotal  = total;

        }else{

            $("#complete-order-location-btn").addClass("hidden-element");
            $(".delivery_price_span").html("0");
            var total = total_paid_value - delivery_price;
            $(".total_paid_value2").html(total);
             
            orderTotal = total;

        }
        
        
                $.ajax({
           	  	  
           	  	  url:  '/user/cart/check_balance',
           	  	  
           	  	  data:{
        
                         'orderTotal'      : orderTotal
                         
            	  	  } ,
                   type: 'post',
           	  	  success:function(data){
                          
                          
                        if(data.balanceMessage && data.type!=0){
                            
                            $('#checkBalanceStatus').empty().show().append(data.balanceMessage);
                              
                        }
                       
         
           	  	  },
           	  	  error:function(reject){
           	  	     
                        
            	  	  }
                 
                });


    });
    

 
 
   
</script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&callback=initMap">
    </script>

    <script>
        
              
    var map, infoWindow , marker ,geocoder;
        
    var messagewindow;
    var markers = [];

    var prevlat;
    var prevLng

    var SelectedLatLng = "";
    var SelectedLocation = "";

    $("#new-branch-map-btn, #complete-order-location-btn").on("click", function () {
        $(".main-content").addClass("hidden-element");
        $(".map-content").removeClass("hidden-element");

        window.scrollTo(0,200);

        if($("#branch-latLng").val() != ""){
            prevlat = $("#branch-lat").val();
            prevLng = $("#branch-lng").val();
        }else{
            prevlat = -34.397;
            prevLng = 150.6444;
        }

        initMap();

    });

    $("#decline-branch-location, #decline-user-location").on("click", function () {
        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }


    });

    $("#confirm-branch-location, #confirm-user-location").on("click", function () {

        if(SelectedLatLng == ""){
            notif({
                msg: "برجاء تحديد الموقع",
                type: "warning"
            });
            return false;
        }

        

        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }

    });
  

 

  function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseInt(prevlat), lng: parseInt(prevLng)},
            zoom: 6
        });
        
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder();

        // Try HTML5 geolocation.

        if($("#branch-latLng").val() === ""){
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

        if($("#branch-latLng").val() !== ""){
            addMarker( "(" + parseInt($('#branch-lat').val()) + "," + parseInt($('#branch-lng').val()) +")");
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
                        }
                    }
                });
            });

        }


     //used only to get current position address name 

        function geocodeLatLng(geocoder, map, infowindow,markerCurrent) {
          
           
         var latlng = {lat: markerCurrent.position.lat(), lng: markerCurrent.position.lng()};
         
            
            
           $('#branch-latLng').val("("+markerCurrent.position.lat() +","+markerCurrent.position.lng()+")");
           $('#branch-lat').val(markerCurrent.position.lat());
            $('#branch-lng').val(markerCurrent.position.lng());
            
           
         
         
         
            geocoder.geocode({'location': latlng}, function(results, status) {
              if (status === 'OK') {
                if (results[0]) {
                  map.setZoom(11);
                  var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                  });
                  infowindow.setContent(results[0].formatted_address);
                   SelectedLocation = results[0].formatted_address;
                  
                  $("#address-map").val(results[0].formatted_address); 
                  
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
      
      

        function addMarker(location) {
            // var marker = new google.maps.Marker({
            //     position: location,
            //     map: map
            // });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( parseInt($("#latitude").val()),parseInt($("#longitude").val())),
                map: map,
                title: $("#branch_name").val()
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
                            
                             splitLatLng(String(event.latLng));
                            $("#branch-latlng").val(SelectedLatLng);
                            $("#address-map").val(SelectedLocation);
                           
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

        $("#branch-lat").val(lat);
        $("#branch-lng").val(Lng);
    }
         
        
    </script>
    


<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>