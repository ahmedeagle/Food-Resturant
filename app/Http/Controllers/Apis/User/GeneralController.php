<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Apis\User\SmsController;
use App\User;
use Carbon\Carbon;
use DB;
class GeneralController extends Controller
{
    public function echo_Empty(){
        return "";
    }
    public function sendActivationPhone($id)
    {
        $user = User::find($id);
        $code = $this->generate_random_number(4);
        $user->activate_phone_hash = json_encode([
            'code'   => $code,
            'expiry' => Carbon::now()->addDays(1)->timestamp,
        ]);
        $user->save();
        $message = (App()->getLocale() == "en")?
            "Your Activation Code is :- " . $code :
            $code . "رقم الدخول الخاص بك هو :- " ;


        (new SmsController())->send($message , $user->phone);
        //\Illuminate\Support\Facades\Mail::to($member)->send(new AccountConfirmation($member));
    }
    public function generate_random_number($digits){
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }

    public function setLang($lang){
        ($lang == "en") ? App()->setLocale("en"): App()->setLocale("ar");
    }



    function getRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    public function get_address_from_location($lat , $lng , $language){
          $geolocation = $lat.','.$lng;
        $request ='https://maps.googleapis.com/maps/api/geocode/json?&language='.$language.'&latlng='.$geolocation.'&key=AIzaSyAjZMZO0NND0J5jwZUR9Y6RcgOIBH-3hlM';

        $json = json_decode( file_get_contents( $request ) );

        if(count($json->results) == 0){
            return "";
        }
        $results  = $json->results[0];
        $addr = $results->formatted_address;
        $comp = $results->address_components;

        $response=array();

        foreach( $comp as $i => $obj ){
            if( in_array( 'political', $obj->types ) ) $response[]=$obj->long_name;
        }

        return $addr;
        //print_r( $response );
    }

    public function get_id(Request $request){
        $user =  DB::table("users")
                    ->where("token" , $request->input('access_token'))
                    ->select('id')
                    ->first();
                    
        return $user->id;
    }


     // depricated
    public function numberTranslator($num,$lang){

            $eastern_arabic = array('0','1','2','3','4','5','6','7','8','9');
           // $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
            $western_arabic = array('0','1','2','3','4','5','6','7','8','9');

            if($lang == 'ar')
            {
                
                return $num = str_replace($western_arabic, $eastern_arabic, $num);
            } 
             
             return $num ;
    }
}
