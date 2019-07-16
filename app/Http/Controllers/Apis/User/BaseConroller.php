<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class BaseConroller extends Controller
{
    public function get_user_data(User $user){
        if($user->gender == "male"){
            $gender = (App()->getLocale() == "en")? "male" : "ذكر";
        }elseif($user->gender == "female"){
            $gender = (App()->getLocale() == "en") ? "female" : "انثى";
        }else{
            $gender = "";
        }
        return [
            "name"                => $user->name,
            "email"               => $user->email,
            "phone"               => $user->phone,
            "date_of_birth"       => ($user->date_of_birth == null) ? "" : $user->date_of_birth,
            "gender"              => $gender,
            "image"               => ( $user->image != null ) ? url('/storage/app/public/users/') ."/".$user->image->name : "",
            //"country"             => App()->getLocale() == "ar" ? $user->country->ar_name : $user->country->en_name,
            "country_id"          => $user->country_id,
            "city"                => $user->city_id,
            //"city"                => App()->getLocale() == "ar" ? $user->city->ar_name : $user->city->en_name,
            "is_phone_activated"  => $user->isActive(),
            'access_token'        => $user->token
        ];
    }

    public function setLang(Request $request){
        $lang = $request->input("lang");
        (!$lang || $lang == "ar") ? (new GeneralController())->setLang("ar") : (new GeneralController())->setLang("en");
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Vincenty formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function getDistance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return round(($miles * 1.609344));
        } else if ($unit == "N") {
            return round(($miles * 0.8684));
        } else {
            return round($miles);
        }
        
        
        
    }

    public function saveImage($data, $image_ext, $path){

        if(!empty($data)){
            $data = str_replace('\n', "", $data);
            $data = base64_decode($data);

            $im   = imagecreatefromstring($data);

            if ($im !== false) {
                $name = str_random(40).'.'.$image_ext;
                if ($image_ext == "png"){
                    imagepng($im, $path . $name, 9);
                }else{
                    imagejpeg($im, $path . $name, 100);
                }
                return $name;
            } else {
                return "";
            }
        }else{
            return "";
        }
    }
}
