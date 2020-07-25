// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see the error "The Geolocation service
// failed.", it means you probably did not give permission for the browser to
// locate you.
var map, infoWindow , marker;
var messagewindow;
var markers = [];
var prevlat;
var prevLng;
// if($(".shipping-latLng").val() != ""){
//
//     var prevLlatLng = $(".shipping-latLng").val();
//     console.log("notsli" ,  prevLlatLng);
//     var newString = prevLlatLng.substr(0, prevLlatLng.length-1);
//     var newString2 = newString.substr(1);
//     var trainindIdArray = newString2.split(',');
//     prevlat = parseInt(trainindIdArray[0]);
//     prevLng  = parseInt(trainindIdArray[1]);
// }else{
    prevlat = -34.397;
    prevLng = 150.644;
// }
function initMap() {
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: prevlat, lng: prevLng},
        zoom: 6
    });
    
    
         

           
            
    infoWindow = new google.maps.InfoWindow;

    // Try HTML5 geolocation.

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            
            

            infoWindow.open(map);
            map.setCenter(pos);
            
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


    //addMarker(parseInt($(".shipping-latLng").val()));
    var geocoder = new google.maps.Geocoder();
    google.maps.event.addListener(map, 'click', function(event) {
        $("#register-latlng").val(event.latLng);
        splitLatLng(String(event.latLng));
        geocoder.geocode({
            'latLng': event.latLng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    deleteMarkers();
                    addMarker(event.latLng);
                    $("#register-map-address").html(results[0].formatted_address);
                }
            }
        });
    });

    function addMarker(location) {
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



     //used only to get current position address name 

        function geocodeLatLng(geocoder, map, infowindow,markerCurrent) {
          
           
         var latlng = {lat: markerCurrent.position.lat(), lng: markerCurrent.position.lng()};
         
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
                  
              //    $("#address-map").val(results[0].formatted_address); 
                  
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
      
    function splitLatLng(latLng){

        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];

        $("#register-lat").val(lat);
        $("#register-lng").val(Lng);
    }

}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

