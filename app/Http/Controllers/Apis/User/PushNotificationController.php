<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class PushNotificationController extends Controller
{
    // set variables
 

    public $server_key  = "AAAAY0P9fWY:APA91bH0yXkRUDwFGYsyIaX75n2QWAbf4YzxksxK-o3yl-euM5m1uC95XwQr0AfgJEEWqMfIGUd4dq2qmqEza2kCE907qJHbJj9sLItpFWuzLnUimxZ9ZiLxwl3qVUeinXcT_Lw6hykS";
    
       
    function send($device_token , $data) {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
                'to' => $device_token,
                'notification' => $data
        );
        $fields = json_encode ( $fields );
        $headers = array (
                'Authorization: key=' . $this->server_key,
                'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
      
        return $result;

    }
    
    
    function sendNotificationToWebBrowser($subscribeToken,$data){
         
                    //FCM key
                
                $server_key  = "AAAA6rW-n98:APA91bFE83nx5zmyzBC1y-3l7tj5EUDZe1j8PQ2eMnPr_rmcx0GLDiKwHQ7aPNs8kD64Ql37962h2JfKazeUTyns2OalDx6T7pea6KZbWb_60V_Gk1EIRob2tm89Occgaz_jZyN62ALy";
                 
                     $url = 'https://fcm.googleapis.com/fcm/send';
                    $fields = array (
                            'to' => $subscribeToken,
                            'notification' => $data
                    );
                    $fields = json_encode ( $fields );
                    $headers = array (
                            'Authorization: key=' . $server_key,
                            'Content-Type: application/json'
                    );
                    $ch = curl_init ();
                    curl_setopt ( $ch, CURLOPT_URL, $url );
                    curl_setopt ( $ch, CURLOPT_POST, true );
                    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            
                    $result = curl_exec ( $ch );
                    curl_close ( $ch );
                  
                    return $result;
        
    }
}
