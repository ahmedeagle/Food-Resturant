<?php

namespace App\Http\Controllers\Apis\User;

use App\UserMealSubcategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\User;
use App\Mealsubcategories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
class UserController extends Controller
{
    public function post_user_meal_sub_categories(Request $request){
        (new BaseConroller())->setLang($request);
        $StringId = $request->input("id");
        $ids      = explode("," , $StringId);
        $msg = [
            1 => trans('messages.required'),
            2 => trans('messages.meal_sub_id_numeric')
        ];

        $checkValidFoodTypes = $this->checkValidFoodTypes($ids);
        
        if($checkValidFoodTypes != 3){
            
            return response()->json([
                        'status'  => false , 
                        'errNum'  => (int)$checkValidFoodTypes , 
                        'msg'     => $msg[$checkValidFoodTypes] 
                 ]);
        }
        
        $this->InsertUserFoodTypes($ids,$request);
        return response()->json(['status' => true , 'errNum' => 0 , 'msg' => trans('messages.success')]);
    }

    //get neatest providers
    public function get_nearest_providers(Request $request){
        (new BaseConroller())->setLang($request);
        
        
        
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
  
              $providerspag =   DB::table("providers")
                        ->join("images" , "images.id" ,"providers.image_id")
                        ->join('branches','branches.provider_id','=','providers.id')
                        // ->where("providers.phoneactivated" , "1")
                        ->where("providers.accountactivated" , "1")
                        ->where("branches.published" , "1")
                        
                         
                      
                        ->select(
                            "providers.id AS provider_id",
                             "branches.id AS id",
                             "branches.id AS id",
                             "branches.has_delivery",
                             "branches.has_booking",
                             "branches.longitude",
                             "branches.latitude",
                             "branches." .$name ."_address AS address",
                             "branches.average_price AS mealAveragePrice",
                                        
                            DB::raw("CONCAT(providers .".$name."_name,'-',branches .".$name."_name) AS name"),
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                        )
                        -> paginate(10);
                    
                      
        (new HomeController())->filter_providers_branches($request,$name ,$providerspag);
        
                        
                        
            $providers =  $providerspag->sortBy(function($item){
                return $item->distance;
            })->values();
            
             
         $providers = new LengthAwarePaginator(
                                $providers,
                                $providerspag->total(),
                                $providerspag->perPage(),
                                $request->input("page"),
                                ["path" => url()->current()]

        );
            
                        
     // (new HomeController())->filter_providers_branches_by_distance($request,$name ,$providers);
        return response()->json([
            "status"         => true ,
            "errNum"         => 0,
            "msg"            => trans("messages.success"),
            "providers"      => $providers
        ]);
    }

    public function prepare_update_user_profile(Request $request){
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        
        $user = \App\User::find((new GeneralController())->get_id($request));
        
        $users = (new BaseConroller())->get_user_data($user);
        
        $countries   = DB::table("countries")
                        ->where("countries.active" , "1")
                        ->select(
                            "countries.id AS country_id",
                            "countries.". $name ."_name AS country_name",
                            "countries.active"
                        ) -> get() ;

         foreach($countries    as $key => $country){
            if($country->country_id == $users['country_id']){
                $country->selected = true;
            }else{
                if($country->active == "0"){
                    unset($countries[$key]);
                }
                $country->selected = false;
            }
            unset($country->active);
        } 
        
        
         $cities = DB::table("cities")
                    ->where("cities.country_id" , $users['country_id'])
                    ->select(
                        "cities.id AS city_id",
                        "cities.". $name ."_name AS city_name",
                        "cities.active"
                    )->get();

        foreach($cities as $key => $city){
            if($city->city_id == $users['city']){
                $city->selected = true;
            }else{
                if($city->active == "0"){
                    unset($cities[$key]);
                }
                $city->selected = false;
            }
            unset($city->active);
        }
        
        
        


        $meals = DB::table("user_meal_subcategories")
                        ->where("user_meal_subcategories.user_id" , $user->id)
                        ->select(
                            "user_meal_subcategories.meal_subcategory_id AS id"
                        )->get();


        $FoodType = DB::table("mealsubcategories")
            ->select(
                "mealsubcategories.id",
                "mealsubcategories." . $name . "_name AS name"
            )->get();
        $mealArray = [];
        foreach($meals as $meal){
            $mealArray[] = $meal->id;
        }

        foreach ($FoodType as $item){
            if(in_array($item->id , $mealArray)){
                $item->selected = true;
            }else{
                $item->selected = false;
            }
        }



         return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg"    => trans("messages.success"),
            "user"   => $users,
            "cities" => $cities,
            "countries" => $countries,
            "foodType"  => $FoodType
        ]);
    }
    public function update_user_profile(Request $request){
 
        (new BaseConroller())->setLang($request);
        $rules    = [
            'name'             => 'required',
            'date_of_birth'    => 'required|date_format:Y-m-d',
            'gender'           => 'required|in:male,female',
            'country_id'       => 'required|exists:countries,id',
            'city_id'          => 'required|exists:cities,id',
            'foodType'         => 'required'
        ];
        $messages = [
            'required'              => 1,
            'email'                 => 2,
            'email.unique'          => 3,
            'age.numeric'           => 4,
            'gender.in'             => 5,
            'country_id.exists'     => 6,
            'city_id.exists'        => 7,
            'phone.numeric'         => 8,
            'phone.unique'          => 9,
            'success'               => 12,
            "error"                 => 13,
            "date_of_birth.date_format" => 16,
            "phone.regex"          => 17
        ];
        $msg = [
            1  => trans("messages.required"),
            2  => trans("messages.email"),
            3  => trans("messages.email_unique"),
            4  => trans("messages.age_numeric"),
            5  => trans("messages.gender_in"),
            6  => trans("messages.country_id_exists"),
            7  => trans("messages.city_id_exists"),
            8  => trans("messages.phone_numeric"),
            9  => trans("messages.phone_unique"),
            12 => trans("messages.register.check.phone"),
            13 => trans("messages.error"),
            14 => trans("messages.success"),
            15 => trans('messages.meal_sub_id_numeric'),
            16 => trans("messages.date_of_birth_format"),
            17 => trans("messages.phonenotcorrect"),
        ];
        $user = User::find((new GeneralController())->get_id($request));

        $input = $request->only('name', 'email' , 'phone',  'gender','date_of_birth', 'city_id' , 'country_id');
        
        if($input['email'] != $user->email){
            $rules['email'] = "required|unique:users,email|email";
        }else{
            $rules['email'] = "required|email";
        }

        if($input['phone'] != $user->phone){
            $rules['phone'] =  array('required','regex:/^(05|5)([0-9]{8})$/' ,'numeric','unique:users,phone'); 
        }else{
            $rules['phone'] = array('required','regex:/^(05|5)([0-9]{8})$/' ,'numeric');  
        }

        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        if($input['phone'] != $user->phone){
            $code = (new GeneralController())->generate_random_number(4);
            $input['activate_phone_hash'] = json_encode([
                'code'   => $code,
                'expiry' => Carbon::now()->addDays(1)->timestamp,
            ]);
            $input['phoneactivated'] = "0";
            $message = (App()->getLocale() == "en")?
                "Your Activation Code is :- " . $code :
                $code . "رقم الدخول الخاص بك هو :- " ;

            (new SmsController())->send($message , $user->phone);

            $isPhoneChanged = true;
        }else{
            $isPhoneChanged = false;
        }

        if($request->input('image')){
            $image  = $request->input('image');
            $path   = "storage/app/public/users/";
            if($user->image_id != null){
                Storage::delete('public/users/'.$user->image->name); 
                \App\Image::find($user->image_id)->delete();
            }
            $path   = (new BaseConroller())->saveImage($image, 'png', $path);
            if($path == ""){
                return response()->json(["status" => false , "errNum" => 13 , 'msg' => $msg[13] ]);
            }
            $image = \App\Image::create([
                        "name" => $path
                    ]);
            $input['image_id'] = $image->id;
        }
        if($request->input("foodType")){
            $StringId = $request->input("foodType");
            $ids      = explode("," , $StringId);
            $checkValidFoodTypes = $this->checkValidFoodTypes($ids);
        
            if($checkValidFoodTypes != 3){
                $ErrorNumber = ($checkValidFoodTypes == 2) ? 15 : 1;
                return response()->json([
                            'status'  => false , 
                            'errNum'  => (int)$ErrorNumber , 
                            'msg'     => $msg[$ErrorNumber] 
                     ]);
            }
            
            $this->DeleteUserFoodTypes($ids,$request);
            $this->InsertUserFoodTypes($ids,$request);
        }
        $user = User::where("id" , (new GeneralController())->get_id($request))
                    ->update($input);
        $user = User::find((new GeneralController())->get_id($request));

        $userData = ( new BaseConroller())->get_user_data($user);
        if($isPhoneChanged){
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[12], 'isPhoneChanged' => $isPhoneChanged , 'activation_code' => $code , 'user' => $userData]);
        }else{
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[14], 'isPhoneChanged' => $isPhoneChanged ,'user' => $userData]);
        }
    }
    
    public function change_password(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "password"      => "required",
            "new_password"  => "required|min:6"
        ];
        $messages   = [
            "required"   => 1,
            "min"        => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.pasword_min"),
            3  => trans("messages.success"),
            4  => trans("messages.password_not_correct")
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        
        // check if password exists in database
        $user = User::find((new GeneralController())->get_id($request));
        $password = $request->input("password");
        $NewPassword = $request->input("new_password");


        $hasher = app('hash');
        if (!$hasher->check($password, $user->password)) {
            return response()->json(["status" => false , "errNum" => 4 , "msg" => $msg[4]]);
        }

        // store new user password into database
        User::find((new GeneralController())->get_id($request))
                ->update([
                        "password" => bcrypt($NewPassword) 
                ]);
        return response()->json(["status" => true , "errNum" => 0 , "msg" => $msg[3]]);
    }
    
    public function send_verified_code(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "phone"      => "required|numeric|exists:users,phone"
        ];
        $messages   = [
            "required"   => 1,
            "numeric"    => 2,
            "exists"     => 3
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.phone_numeric"),
            3   => trans("messages.phone_exists"),
            4   => trans("messages.success")
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $user = User::find((new GeneralController())->get_id($request));
        
        $code = (new GeneralController())->generate_random_number(4);
        $message = (App()->getLocale() == "en")?
            "Your Activation Code is :- " . $code :
            $code . "رقم الدخول الخاص بك هو :- " ;
        
        $user->activate_phone_hash = json_encode([
            'code'   => $code,
            'expiry' => Carbon::now()->addDays(1)->timestamp,
        ]);
        $user->save();
        
        (new SmsController())->send($message , $user->phone);
        
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[4] , 'code' => $code]);
    }
    protected function checkvalidFoodTypes($ids){
        
        foreach($ids as $id){

            if($id == "" || $id == null)
            {
                 return 1;
            }

            if(!is_numeric($id))
            {
                return 2;
            }

            $meals = Mealsubcategories::select("id")->get();
            
            $mealArr = [];
            foreach($meals as $meal){
                $mealArr[] = $meal->id;
            }
            if(!in_array($id ,$mealArr))
            {
                return 2;
            }
        }
        return 3;
    }
    protected function InsertUserFoodTypes($ids , Request $request){
        foreach ($ids as $id){
            // insert this user data into database
            $userCat  = new UserMealSubcategories();
            $userCat->user_id = (new GeneralController())->get_id($request);
            $userCat->meal_subcategory_id = $id;
            $userCat->save();
        }
    }
    
    protected function DeleteUserFoodTypes($ids,Request $request){
        $userCat  = UserMealSubcategories::where("user_id" , (new GeneralController())->get_id($request))->delete();
    }
}
