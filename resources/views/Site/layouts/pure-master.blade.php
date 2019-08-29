<!doctype html>
<html lang="ar">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url("/") }}">
    <link rel="manifest" href="{{ asset('assets/site/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('assets/site/icons/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/site/icons/icon.png') }}">

    <title>مجرِّب @yield('main-title')</title>


@if(LaravelLocalization::getCurrentLocale() =='ar')
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/site/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/fonts/dinnext/dinnext.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/notifIt.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/custom.css') }}">

   
@else

 <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="{{ asset('assets/site/css/bootstrap/bootstrap_en.css') }}">

     <link rel="stylesheet" href="{{ asset('assets/site/fonts/dinnext/dinnext.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/style_en.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/notifIt.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/custom_en.css') }}">

@endif

    <style>
    
                .modall {
                display:    none;
                position:   fixed;
                z-index:    1000;
                top:        0;
                left:       0;
                height:     100%;
                width:      100%;
                background: rgba( 255, 255, 255, .8 ) 
                            url('https://i.stack.imgur.com/FhHRx.gif') 
                            50% 50% 
                            no-repeat;
            }
            
            /* When the body has the loading class, we turn
               the scrollbar off with overflow:hidden */
            body.loading .modall {
                overflow: hidden;   
            }
            
            /* Anytime the body has the loading class, our
               modal element will be visible */
            body.loading .modall {
                display: block;
            }
 


        @yield('main-style')    
    </style>
    
    
    
   <link rel="manifest" href="manifest.json">
  <script src="https://www.gstatic.com/firebasejs/6.0.1/firebase.js"></script>
  
  
  
  <script>
 
   var firebaseConfig = {
    apiKey: "AIzaSyC2EDRjKbtmmwbBCoAoU6hT5Vu-IG-AI1g",
    authDomain: "webfirebasenotify.firebaseapp.com",
    databaseURL: "https://webfirebasenotify.firebaseio.com",
    projectId: "webfirebasenotify",
    storageBucket: "webfirebasenotify.appspot.com",
    messagingSenderId: "1008071516127",
  //  appId: "1:1008071516127:web:8f9db19d1f30435d"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  
  </script>
  
     
</head>

<body class="@yield('main-class')">
    
 

    @yield('main-content')






<div class="modall"><!-- Place at bottom of page --></div>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script defer src="{{ asset("assets/site/fonts/fontawesome/fontawesome-all.min.js") }}"></script>
<script>
    window.jQuery || document.write('<script src="{{ asset("assets/site/js/vendor/jquery-3.3.1.min.js") }}"><\/script>');
</script>
<script src="{{ asset("assets/site/js/vendor/popper.min.js") }}"></script>
<script src="{{ asset("assets/site/js/vendor/bootstrap.min.js") }}"></script>

<!-- Main JS -->
<script src="{{ asset("assets/site/js/main.js") }}"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
</script>
<script src="{{ asset("/assets/site/js/notifIt.min.js") }}"></script>
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<script src="{{ asset("/assets/site/js/sitee_script.js") }}"></script>

<script>
    $('#myStateButton').on('click', function () {
        $(this).button('complete') // button text will be "finished!"
    });
    
    
       $body = $("body");
       
      

        $(document).on({
              ajaxStart: function() { $body.addClass("loading");    },
              ajaxStop: function() { $body.removeClass("loading"); }    
        });


 


</script>


<script>
 
    // [START get_messaging_object]
// Retrieve Firebase Messaging object.
const messaging = firebase.messaging();
// [END get_messaging_object]
// IDs of divs that display Instance ID token UI or request permission UI.
const tokenDivId = 'token_div';
const permissionDivId = 'permission_div';
// [START refresh_token]
// Callback fired if Instance ID token is updated.
messaging.onTokenRefresh(function() {
  messaging.getToken()
  .then(function(refreshedToken) {
    console.log('Token refreshed.');
    // Indicate that the new Instance ID token has not yet been sent to the
    // app server.
    setTokenSentToServer(false);
    // Send Instance ID token to app server.
    sendTokenToServer(refreshedToken);
    // [START_EXCLUDE]
    // Display new Instance ID token and clear UI of all previous messages.
    resetUI();
    // [END_EXCLUDE]
  })
  .catch(function(err) {
    console.log('Unable to retrieve refreshed token ', err);
    showToken('Unable to retrieve refreshed token ', err);
  });
});
// [END refresh_token]
// [START receive_message]
// Handle incoming messages. Called when:
// - a message is received while the app has focus
// - the user clicks on an app notification created by a sevice worker
//   `messaging.setBackgroundMessageHandler` handler.
messaging.onMessage(function(payload) {
   
  
    
  // [START_EXCLUDE]
  // Update the UI to include the received message.
  appendMessage(payload);
  // [END_EXCLUDE]
});
// [END receive_message]
function resetUI() {
  clearMessages();
  showToken('loading...');
  // [START get_token]
  // Get Instance ID token. Initially this makes a network call, once retrieved
  // subsequent calls to getToken will return from cache.
  messaging.getToken()
  .then(function(currentToken) {
    if (currentToken) {
      sendTokenToServer(currentToken);
      updateUIForPushEnabled(currentToken);
    } else {
      // Show permission request.
      console.log('No Instance ID token available. Request permission to generate one.');
      requestPermission()
      // Show permission UI.
      updateUIForPushPermissionRequired();
      setTokenSentToServer(false);
    }
  })
  .catch(function(err) {
    console.log('An error occurred while retrieving token. ', err);
    showToken('Error retrieving Instance ID token. ', err);
    setTokenSentToServer(false);
  });
}
// [END get_token]
function showToken(currentToken) {
  // Show token in console and UI.
  console.log("showToken: ", currentToken)
  // var tokenElement = document.querySelector('#token');
  // tokenElement.textContent = currentToken;
}
// Send the Instance ID token your application server, so that it can:
// - send messages back to this app
// - subscribe/unsubscribe the token from topics
function sendTokenToServer(currentToken) {
   
    
    @if(auth('provider') -> check())
    
                  $.ajax({
                    type:'POST',
                    url:'/{{LaravelLocalization::getCurrentLocale()}}/restaurant/storebrowsertoken',
                    data:{token : currentToken,actor:'providers' ,_token: "<?php echo csrf_token(); ?>"},
                    success:function(data){
                        $("#msg").html(data);
                    }
                }); 
    
    
         setTokenSentToServer(true);
          
          console.log('Token already sent to server so won\'t send it again ' +
        'unless it changes');
         
    @elseif(auth('branch') -> check())
    
          $.ajax({
            type:'POST',
            url:'/{{LaravelLocalization::getCurrentLocale()}}/restaurant/storebrowsertoken',
            data:{token : currentToken,actor: 'branches', _token: "<?php echo csrf_token(); ?>"},
            success:function(data){
                $("#msg").html(data);
            }
        }); 
    
     setTokenSentToServer(true);
      console.log('Token already sent to server so won\'t send it again ' +
        'unless it changes');
    
    @else
    
     
     
      setTokenSentToServer(false);
      console.log('Login to Send Token.');
    
    
    @endif
    
      
    
}
function isTokenSentToServer() {
  if (window.localStorage.getItem('sentToServer') == 1) {
        return true;
  }
  return false;
}
function setTokenSentToServer(sent) {
  window.localStorage.setItem('sentToServer', sent ? 1 : 0);
}
function showHideDiv(divId, show) {
  // const div = document.querySelector('#' + divId);
  if (show) {
    console.log("should show div:", divId)
    // div.style = "display: visible";
  } else {
    console.log("should hide div:", divId)
    // div.style = "display: none";
  }
}
function requestPermission() {
  console.log('Requesting permission...');
  // [START request_permission]
  messaging.requestPermission()
  .then(function() {
    console.log('Notification permission granted.');
    // TODO(developer): Retrieve an Instance ID token for use with FCM.
    // [START_EXCLUDE]
    // In many cases once an app has been granted notification permission, it
    // should update its UI reflecting this.
    resetUI();
    // [END_EXCLUDE]
  })
  .catch(function(err) {
    console.log('Unable to get permission to notify.', err);
  });
  // [END request_permission]
}
function deleteToken() {
  // Delete Instance ID token.
  // [START delete_token]
  messaging.getToken()
  .then(function(currentToken) {
    messaging.deleteToken(currentToken)
    .then(function() {
      console.log('Token deleted.');
      setTokenSentToServer(false);
      // [START_EXCLUDE]
      // Once token is deleted update UI.
      resetUI();
      // [END_EXCLUDE]
    })
    .catch(function(err) {
      console.log('Unable to delete token. ', err);
    });
    // [END delete_token]
  })
  .catch(function(err) {
    console.log('Error retrieving Instance ID token. ', err);
    showToken('Error retrieving Instance ID token. ', err);
  });
}
// Add a message to the messages element.
function appendMessage(payload) {
  console.log("appendMessage", payload)
  // const messagesElement = document.querySelector('#messages');
  // const dataHeaderELement = document.createElement('h5');
  // const dataElement = document.createElement('pre');
  // dataElement.style = 'overflow-x:hidden;'
  // dataHeaderELement.textContent = 'Received message:';
  // dataElement.textContent = JSON.stringify(payload, null, 2);
  // messagesElement.appendChild(dataHeaderELement);
  // messagesElement.appendChild(dataElement);
}
// Clear the messages element of all children.
function clearMessages() {
   // const messagesElement = document.querySelector('#messages');
  // while (messagesElement.hasChildNodes()) {
  //   messagesElement.removeChild(messagesElement.lastChild);
  // }
}
function updateUIForPushEnabled(currentToken) {
  showHideDiv(tokenDivId, true);
  showHideDiv(permissionDivId, false);
  showToken(currentToken);
}
function updateUIForPushPermissionRequired() {
  showHideDiv(tokenDivId, false);
  showHideDiv(permissionDivId, true);
}
resetUI();

 

 

</script>

        
@yield('main-script')


</body>

</html>