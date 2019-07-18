<?php

namespace App\Http\Controllers\Provider;

use App\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Hash;
class ProfileController extends Controller
{
    public function get_profile(){

        $data['provider'] = DB::table("providers")
                                ->leftjoin("images", "images.id", "providers.image_id")
                                ->join("cities", "cities.id", "providers.city_id")
                                ->join("countries", "countries.id", "providers.country_id")
                                ->join("categories", "categories.id", "providers.category_id")
                                ->where("providers.id", auth('provider')->id())
                                ->select(
                                    "providers.ar_name",
                                    "providers.en_name",
                                    "providers.ar_description",
                                    "providers.en_description",
                                    "providers.email",
                                    "providers.phone",
                                    "providers.accept_order AS order_status",
                                    "providers.city_id",
                                    "providers.country_id",
                                    "providers.category_id",
                                    "providers.accept_online_payment",
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS provider_image_url")
                                )->first();

        $data['countries'] = DB::table("countries")
                                ->get();
 // get categories list
        $data['cats'] = DB::table("categories")->get();


        foreach ($data['countries'] as $key => $value){
            if($value->active == "0" && $value->id != auth("provider")->user()->country_id){
                unset($data['countries'][$key]);
            }
        }
        $data['cities'] = DB::table("cities")
                            ->where("country_id", $data['provider']->country_id)
                            ->get();

        foreach ($data['cities'] as $key => $value){
            if($value->active == "0" && $value->id != auth("provider")->user()->city_id){
                unset($data['cities'][$key]);
            }
        }
        $data['categories'] = DB::table("categories")
                                ->get();

        $data['title'] = "- ملف المطعم";
        $data['class'] = "page-template profile edit";

        return view("Provider.pages.profile", $data);
    }

    public function post_profile(Request $request){


        App()->setLocale("ar");

        $provider = Provider::find(auth("provider")->id());
        $rules = [
            "ar_name"         => "required",
            "en_name"         => "required",
            "country"         => "required|exists:countries,id",
            "city"            => "required|exists:cities,id",
            "accept_order"    => "required|not_in:0",
            "ar_description"  => "required",
            "en_description"  => "required",

        ];
        if($provider->phone != $request->input("phone-number")){
            $rules['phone-number'] = array('required','regex:/^(05|5)([0-9]{8})$/','numeric','unique:providers,phone|unique:branches,phone');
        }else{
            $rules['phone-number'] = array('required','regex:/^(05|5)([0-9]{8})$/','numeric');
        }

        if($provider->email != $request->input("email")){
            $rules['email'] = "required|email|unique:providers,email";
        }else{
            $rules['email'] = "required";
        }

        $messages = [
            "required"                      => trans("messages.required"),
            "country.exists"                => trans("messages.error"),
            "city.exists"                   => trans("messages.error"),
            "phone-number.numeric"          => trans("messages.phone_numeric"),
            "email"                         => trans("messages.email"),
            "email.unique"                  => trans("messages.email_unique"),
            "accept_order"                  => trans("messages.required"),
            "phone-number.unique"           => trans("messages.phone_unique"),
            "phone-number.regex"           => trans("messages.phonenotcorrect"),
            
        ];


        $this->validate($request, $rules , $messages);

        // insert into database
        $data = [
            'ar_name'                   => $request->input("ar_name"),
            'en_name'                   => $request->input("en_name"),
            'phone'                     => $request->input("phone-number"),
            'email'                     => $request->input("email"),
            'country_id'                => $request->input("country"),
            'city_id'                   => $request->input("city"),
            'ar_description'            => $request->input("ar_description"),
            'en_description'            => $request->input("en_description"),
            'accept_order'              => $request->input("accept_order"),
            'category_id'               => $request->input("service-provider"),
            'online_list'               => $request->input("automatic-list"),
            'accept_online_payment'     => $request->input("accept-online-payment"),
            
        ];

        $id = DB::table("providers")
            ->where("id", auth("provider")->id())
            ->update($data);

        return redirect()->back()->with("success", trans("messages.success"));
    }

    public function edit_logo(Request $request){
        App()->setLocale("ar");

        $rules = [
            "image"                     => "required"
        ];
        $messages = [
            "required"                      => 1,
        ];

        $msg = [
            1  => trans("messages.required"),
            2 => trans("messages.success")
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }


        if($request->hasFile("image")){

            $request->image->store('providers', 'public');
            $img_id = DB::table("images")
                ->insertGetId([
                    "name" => $request->image->hashName()
                ]);
            DB::table("providers")
                    ->where("id", auth('provider') -> id())
                    ->update([
                        "image_id" => $img_id
                    ]);

        }

        // return redirect to food menu selection
        return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg"    => $msg[2],
        ]);
    }

    public function change_password(Request $request){

        App()->setLocale("ar");

        $rules = [
            "old-password"    => "required",
            "password"        => "required|min:6|confirmed",
        ];


        $messages = [
            "required"              => trans("messages.required"),
            "min"                   => trans("messages.pasword_min"),
            "password.confirmed"    => trans("messages.confirm_pasword_same")
        ];


        $validator =  Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect("/restaurant/profile#editpasswordform")->withErrors($validator)->withInput();
        }

        if(!Hash::check($request->input("old-password"), auth("provider")->user()->password)){
            return redirect("/restaurant/profile#editpasswordform")->with("edit-password-error", "الرقم السرى غير صحيح");
        }
        // insert into database

        DB::table("providers")
            ->where("id", auth("provider")->id())
            ->update([
                'password'  => bcrypt($request->input("password"))
            ]);

        return redirect("/restaurant/profile#editpasswordform")->with("edit-password-success", trans("messages.success"));

    }

    public function change_meal_type(){
        $data['title'] = " - ملف المطعم - تغيير نوع الطعام";
        $data['class']  = "page-template password change";

        $data['cats'] = DB::table("mealsubcategories")
                            ->select(
                                "id",
                                "ar_name AS name"
                            )
                            ->get();

        $provivderFood = DB::table("provider_mealsubcategories")
                            ->where("provider_id", auth("provider")->id())
                            ->select(
                                "provider_mealsubcategories.Mealsubcategory_id AS id"
                            )->get();




        foreach($data['cats'] as $cat){
           
           if(isset($provivderFood) && $provivderFood -> count() > 0){
            foreach($provivderFood as $food){
                if($food->id == $cat->id){
                    $cat->selected = "1";
                    break;
                }else{
                    $cat->selected = "0";
                }
            }
          }else{
              $cat->selected = "0";
          }

        }

        return view("Provider.pages.change-meal-type", $data);
    }
    
    
public function change_resturant_categories(){
        $data['title'] = " - ملف المطعم - تغيير  تصنيفات المطعم  ";
        $data['class']  = "page-template password change";
                  
          $data['cats'] = DB::table("subcategories")
                                    ->select(
                                        "id",
                                        "ar_name AS name"
                                    )
                                    ->get();
        
        
        $providerCats =  DB::table("provider_subcategories") -> where('provider_id',auth("provider")->id()) -> select('provider_subcategories.Subcategory_id AS id') -> get();
         


     if(isset($providerCats) && $providerCats -> count() > 0){
         
         
            foreach($data['cats'] as $cat){

            foreach($providerCats as $provCat){

                if($provCat->id == $cat->id){
                    $cat->selected = "1";
                    break;
                }else{
                    $cat->selected = "0";
                }
            }

        }
         
     }else{
         
         
         
         foreach($data['cats'] as $cat){
             
             
             $cat->selected = "0";
             
         }
         
     }
     
     
     

     
        
        
    //    return $data['cats'];

        return view("Provider.pages.change-cats-type", $data);
    }



public function post_change_meal_type(Request $request){

        App()->setLocale("ar");
        $food = explode(",", $request->input('food'));

        DB::table("provider_mealsubcategories")
                    ->where("provider_id", auth("provider")->id())
                    ->delete();

        foreach($food as $f){

            DB::table("provider_mealsubcategories")
                ->insert([
                    "provider_id" => auth('provider')->id(),
                    "Mealsubcategory_id" => $f
                ]);
        }

        return response()->json(['status' => true, "errNum" => 0, "msg" => trans("messages.success")]);
    }
    
  
  public function post_change_resturant_categories(Request $request){
        

        App()->setLocale("ar");
        //$cats = explode(",", $request->input('cats'));
        
         
        
       $cats = $request->input('cats');

        DB::table("provider_subcategories")
                    ->where("provider_id", auth("provider")->id())
                    ->delete();
                    
            if(!$cats){
                
                  return redirect() -> back() -> with('success',' لم يتم حفظ اي بيانات');
                
            }

        foreach($cats as $c){

            DB::table("provider_subcategories")
                ->insert([
                    "provider_id" => auth('provider')->id(),
                    "Subcategory_id" => $c
                ]);
        }

     //  return response()->json(['status' => true, "errNum" => 0, "msg" => trans("messages.success")]);
        return redirect() -> back() -> with('success','تمت العملية بنجاح');
    }


    public function change_map_address(){
        $data['title'] = " - ملف المطعم - تغيير عنوان المطعم على الخارطة";
        $data['class'] = "page-template register address";
        
        $data['branch']  = DB::table('providers') -> where('id',auth("provider")->id()) -> select('latitude','longitude','ar_name') -> first();
        

        return view("Provider.pages.change-map-address", $data);
    }

    public function post_change_map_address(Request $request){

         App()->setLocale("ar");
        $rules = [

            "new-lat"   => "required",
            "new-lng"   => "required"
        ];
        $messages = [
            "required"   => trans("messages.location-empty"),
        ];


        $this->validate($request, $rules , $messages);

        $lat = $request->input('new-lat');
        $lng = $request->input('new-lng');

        DB::table("providers")
                    ->where("id", auth("provider")->id())
                    ->update([
                        "latitude"  => $lat,
                        "longitude" => $lng
                    ]);

        return redirect("/restaurant/profile")->with("success", trans("messages.success"));
    }
    public function download_rules(){
        $filename = "Menu and meals regulations _ ضوابط معلومات قوائم الطعام و الوجبات.docx";
        return response()->download(storage_path("app/public/settings/{$filename}"));
    }
    
    
    public function storebrowsertoken(Request $request){
        
        
         $actor = $request -> actor;
        if($actor =='providers')
        {
         
             $provider = DB::table('providers') -> whereId(auth('provider')->id()) ;
            
            if($provider){
                 
                $provider -> update(['webtokenSubscribe' => $request -> token]);
            }
        }
        
        if($actor == 'branches'){
            
            
             $branch = DB::table('branches') -> whereId(auth('branch')->id()) ;
            
            if($branch){
                 
                $branch -> update(['webtokenSubscribe' => $request -> token]);
            }
            
            
        }
        
        
        
         
    }


    public function get_notifications(){
  
     $data['notifications'] = \App\Http\Controllers\Provider\HelperController::get_provider_notifications(auth("provider")->id(),'list','providers');

     $data['title']         = "اشعارات الاداره ";

         return view("Provider.pages.notifications", $data);

    }
    
    
}
