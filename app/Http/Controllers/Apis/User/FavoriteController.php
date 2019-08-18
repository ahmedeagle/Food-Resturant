<?php

namespace App\Http\Controllers\Apis\User;

use App\Branch;
use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\ProviderFavorit;
use DB;
use GoogleTranslate;
class FavoriteController extends Controller
{
    
      // edit to get only the selected branch not the main provider
      
    public function get_favorite_providers(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $lat   = $request->input('latitude');
        $long  = $request->input('longitude');
        
        
        $data = [];

      /*  $providers =  ProviderFavorit::join("providers" , "providers.id" ,"provider_favorits.provider_id")
                            ->join('images' , 'images.id' , 'providers.image_id')
                            ->where('provider_favorits.user_id' , (new GeneralController())->get_id($request))
                            ->select(
                                "providers.id AS provider_id",
                                "providers." .$name . "_name AS name",
                                  DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                            )
                            ->get();
                           

        $data = [];
        foreach($providers as $key => $provider){
            $branches = DB::table("branches")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->where('branches.provider_id' ,$provider->provider_id)
                            ->where('branches.published' , "1")
                            ->orderBy('branches.id' , 'DESC')
                            ->select(
                                     "branches.id AS branch_id",
                                     "branches.". $name ."_address AS address" ,
                                     "branches.latitude" ,
                                     "branches.longitude",
                                     "providers.id AS provider_id"
                                    )
                            ->get();
            if(count($branches) == 0){
                unset($providers[$key]);
                continue;
            }
            */
                                                    
                                                    //provider id in this version means one of the branches not the main provider
                $branches = ProviderFavorit::join("branches" , "branches.id" ,"provider_favorits.provider_id")
                                            ->join("providers" , "providers.id" , "branches.provider_id")
                                            ->join('images' , 'images.id' , 'providers.image_id')
                                            ->where('provider_favorits.user_id' , (new GeneralController())->get_id($request))
                                            ->where('branches.published' , "1")
                                            ->orderBy('branches.id' , 'DESC')
                                            ->select(
                                                     "branches.id AS branch_id",
                                                     "branches.ar_address AS address" ,
                                                     "branches.latitude" ,
                                                     "branches.longitude",
                                                      DB::raw("CONCAT(providers .".$name."_name,'-',branches .".$name."_name) AS name"),
                                                      DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url"),
                                                     "providers.id AS provider_id"
                                                    )
                                            ->get();
                    
            foreach($branches as $key => $branch){

               /* if( $name == 'en'){


                       $branch -> address =   (new GoogleTranslate()) -> setSourceLang('ar')
                                 ->setTargetLang('en')
                                 ->translate($branch -> address );
                    }*/


                if($lat && $long){
                    $branch->distance = (new BaseConroller())->getDistance($branch->latitude, $branch->longitude, $lat, $long, 'KM');
                }else{
                    $branch->distance =  -1;
                }
           
            
           /* $selectIndex = -1;
            $dis  = -1;
            
                 if($selectIndex == -1){
                    $selectIndex = 0;
                    $dis = $branch ->distance;
                }else{
                    if($branch -> distance < $dis){
                        $selectIndex = $key;
                        $dis = $branch ->distance;
                    }
                }
            
            */
            
            $dataArr = [
                "provider_id"     => $branch    -> provider_id,
                "name"            => $branch    ->name,
                "image_url"       => $branch    ->image_url,
                "address"         => $branch    ->address,
                "restautrant_id"  => $branch    ->branch_id
            ];
            $data[] = $dataArr;
     }

        return response()->json(['status' => true, 'errNum' => 0, 'msg' => trans('messages.success') , "providers" => $data]);
    }
    public function post_favorite_providers(Request $request){
        
         
 
        (new BaseConroller())->setLang($request);
        $rules      = [
            "id" => "required|exists:branches,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.provider_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.favorite.provide.exists"),
        ];
        
        $validator =  Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        $branch_id = $request->input("id");
        $check = ProviderFavorit::where("provider_id" , $branch_id)
                        ->where("user_id" , (new GeneralController())->get_id($request))
                        ->first();
        if($check){
            return response()->json(['status' => false, 'errNum' => 4, 'msg' => $msg[4]]);
        }
        ProviderFavorit::insert([
                    "user_id" => (new GeneralController())->get_id($request),
                    "provider_id" => $branch_id
                ]);
        return response()->json(['status' => true , "errNum" => 0 , "msg" => $msg[3]]);
    }
    
    public function remove_favorite_providers(Request $request){
        (new BaseConroller())->setLang($request);
        $rules      = [
            "id" => "required|exists:branches,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.provider_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.favorite.provide.exists"),
            5  => trans("messages.error")
        ];
        $validator =  Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $branch_id = $request->input("id");   // the id of the selected branch 
        $fav = ProviderFavorit::where("provider_id", $branch_id)->first();
        if(!$fav){
            return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
        }
        
          //delete specific branch from favourit list 
        ProviderFavorit::where("provider_id" , $branch_id)
            ->where("user_id" , (new GeneralController())->get_id($request))
            ->delete();
        return response()->json(['status' => true , "errNum" => 0 , "msg" => trans('messages.success')]);
    }
}
