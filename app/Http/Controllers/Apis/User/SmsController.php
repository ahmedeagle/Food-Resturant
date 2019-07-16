<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Apis\User\ConfigurationController as ConfigController;
use MobilySms;
class SmsController extends Controller
{
    public function send($message,$phone)
    {
        $curl = new \App\Support\SMS\Curl();
        $username     = "Mjrb";		// The user name of gateway
        $password     = "7633835"; 			// the password of gateway
        $sender = "MJRB";
        $url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$phone&message=$message&sender=$sender";
        $urlDiv = explode("?", $url);
        $result = $curl->_simple_call("post", $urlDiv[0], $urlDiv[1], array("TIMEOUT" => 3));
        return $result;
    }
    

}
