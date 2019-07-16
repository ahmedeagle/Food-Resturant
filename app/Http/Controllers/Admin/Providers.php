<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Providers extends Controller {

    function __construct()
    {

    }
	public function index($active=null){
        $data['title'] = 'مقدمى الخدمة';
        if ($active == 'activated'){
        	$data['providers'] = DB::table("providers")
                                    ->where("accountactivated" , "1")
                                    ->join("images" , "images.id" , "providers.image_id")
                                    ->join("countries" , "countries.id" , "providers.country_id")
                                    ->join("cities" , "cities.id" , "providers.city_id")
                                    ->join("categories" , "categories.id" , "providers.category_id")
                                    ->select(
                                        "providers.*",
                                        "images.name AS filename",
                                        "countries.ar_name AS country",
                                        "cities.ar_name AS city",
                                        "categories.ar_name AS cat"
                                    )->get();
            $data['title'] = 'المطاعم المفعلة';
        }
        elseif ($active == 'deactivated'){
            $data['providers'] = DB::table("providers")
                                    ->where("accountactivated" , "0")
                                    ->join("images" , "images.id" , "providers.image_id")
                                    ->join("countries" , "countries.id" , "providers.country_id")
                                    ->join("cities" , "cities.id" , "providers.city_id")
                                    ->join("categories" , "categories.id" , "providers.category_id")
                                    ->select(
                                        "providers.*",
                                        "images.name AS filename",
                                        "countries.ar_name AS country",
                                        "cities.ar_name AS city",
                                        "categories.ar_name AS cat"
                                    )->get();
        	$data['title'] = 'المطاعم الغير مفعلة';
        }
        else {
            $data['providers'] = DB::table("providers")
                                    ->join("images" , "images.id" , "providers.image_id")
                                    ->join("countries" , "countries.id" , "providers.country_id")
                                    ->join("cities" , "cities.id" , "providers.city_id")
                                    ->join("categories" , "categories.id" , "providers.category_id")
                                    ->select(
                                        "providers.*",
                                        "images.name AS filename",
                                        "countries.ar_name AS country",
                                        "cities.ar_name AS city",
                                        "categories.ar_name AS cat"
                                    )->get();
        }

             
               $tax = DB::table("app_settings")
                    ->select("app_settings.order_tax")
                    ->first();
                    
                    if($tax){
                        $taxData = $tax->order_tax;
                    }else{
                        $taxData = 0;
                    }
        
        

        return view("admin_panel.merchants.list" , $data) ->with('app_percentage',$taxData);

    }

    public function get_add(){
        $data['title'] = 'اضافة مطعم جديد';
        $data['countries']  = DB::table("countries")->get();
        $data['cities']     = DB::table("cities")->get();
        $data['categories'] = DB::table("categories")->get();
        return view("admin_panel.providers.add",$data);
    }
    public function post_add(Request $request){
        $messages = [
            'en_title.required'      => 'برجاء ادخال عنوان العرض بالانجليزية',
            'ar_title.required'      => 'برجاء ادخال عنوان بالعربية',
            'provider_id.required'   => 'برجاء اختيار المطعم',
            'image.required'         => 'الصورة مطلوبة.',
            'image.mimes'            => 'نوع الصورة غير مدعوم.',
            'approved.required'      => 'برجاء اختيار حالة العرض'
        ];
        $rules = [
            'en_title'      => 'required',
            'ar_title'      => 'required',
            'provider_id'   => 'required',
            'approved'      => 'required',
            'image'         => 'required|mimes:jpg,jpeg,png',
        ];
        $this->validate($request, $rules , $messages);

        $image = DB::table("images")->insertGetId([
            'name' => $request->image->hashName()
        ]);

        $request->image->store('offers', 'public');

        DB::table("offers")
            ->insert([
                "ar_title"       => $request->input("ar_title"),
                "en_title"       => $request->input("en_title"),
                "image_id"       => $image,
                "provider_id"    => $request->input("provider_id"),
                "approved"       => $request->input("approved")
            ]);
        return redirect("/admin/offers/list/all")->with("success" , "تمت الاضافة بنجاح");
    }
    
    
    public function get_edit($provider_id){
        
        
         
        $data['provider'] = DB::table("providers")
                                ->leftjoin("images", "images.id", "providers.image_id")
                                ->join("cities", "cities.id", "providers.city_id")
                                ->join("countries", "countries.id", "providers.country_id")
                                ->join("categories", "categories.id", "providers.category_id")
                                ->where("providers.id",$provider_id)
                                ->select(
                                    "providers.id AS provider_id",
                                    "providers.ar_name",
                                    "providers.en_name",
                                    "providers.password",
                                    "providers.ar_description",
                                    "providers.en_description",
                                    "providers.email",
                                    "providers.phone",
                                    "providers.accept_order AS order_status",
                                    "providers.city_id",
                                    "providers.country_id",
                                    "providers.category_id",
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS provider_image_url")
                                )->first();
                                
                if(!$data['provider']){
                    
                    
                    return abort('404');
                }
                
                
                
 
        $data['countries'] = DB::table("countries")
                                ->get();

        foreach ($data['countries'] as $key => $value){
            if($value->active == "0"){
                unset($data['countries'][$key]);
            }
        }
        
        $data['cities'] = DB::table("cities")
                            ->where("country_id", $data['provider'] ->country_id)
                            ->get();

        foreach ($data['cities'] as $key => $value){
            if($value->active == "0" ){
                unset($data['cities'][$key]);
            }
        }
        $data['cats'] = DB::table("categories")
                                ->get();

        $data['title'] = "- ملف المطعم";
        


        return view("admin_panel.merchants.edit", $data);
    }
    
     public function edit_logo($provider_id,Request $request){
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
                    ->where("id",$provider_id)
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
    
    
    
    public function post_edit($provider_id , Request $request){
         
          
        App()->setLocale("ar");

        $provider = \App\Provider::find($provider_id);
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
            $rules['phone-number'] = "required|numeric|unique:providers,phone|unique:branches,phone";
        }else{
            $rules['phone-number'] = "required";
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
            "phone-number.unique"           => trans("messages.phone_unique")
            
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
            'accept_order'              => $request->input("accept_order")
        ];

        $id = DB::table("providers")
            ->where("id",$provider_id)
            ->update($data);

        return redirect()->back()->with("success", trans("messages.success"));
 
        
     
    }



   public function change_meal_type($provider_id){
       
       
         $data['title'] = " - ملف المطعم - تغيير نوع الطعام";
        $data['class']  = "page-template password change";

        $data['cats'] = DB::table("mealsubcategories")
                            ->select(
                                "id",
                                "ar_name AS name"
                            )
                            ->get();

        $provivderFood = DB::table("provider_mealsubcategories")
                            ->where("provider_id", $provider_id)
                            ->select(
                                "provider_mealsubcategories.Mealsubcategory_id AS id"
                            )->get();


        foreach($data['cats'] as $cat){

            foreach($provivderFood as $food){

                if($food->id == $cat->id){
                    $cat->selected = "1";
                    break;
                }else{
                    $cat->selected = "0";
                }
            }

        }
        
        
        $data['provider_id']  =$provider_id;


        return view("admin_panel.merchants.change-meal-type", $data);
       
       
       
   }
   
   
   
    public function post_change_meal_type($provider_id,Request $request){

        App()->setLocale("ar");
        $food = explode(",", $request->input('food'));

        DB::table("provider_mealsubcategories")
                    ->where("provider_id", $provider_id)
                    ->delete();

        foreach($food as $f){

            DB::table("provider_mealsubcategories")
                ->insert([
                    "provider_id" => $provider_id,
                    "Mealsubcategory_id" => $f
                ]);
        }

        return response()->json(['status' => true, "errNum" => 0, "msg" => trans("messages.success")]);
    }
    
    
   
    public function get_balance($id){
        $balance = DB::table("balances")
                        ->where("actor_id" , $id)
                        ->where("actor_type" , "provider")
                        ->first();
        if(!$balance){
            return 0;
        }else{
            return $balance->balance;
        }
    }
    public function view($id){
    	$data['title'] = 'مقدمى الخدمة';
    	$data['merchant'] = DB::table("providers")
                            ->where("providers.id" , $id)
                            ->join("countries" , "countries.id" , "providers.country_id")
                            ->join("cities" , "cities.id" , "providers.city_id")
                            ->join("categories" , "categories.id" , "providers.category_id")
                            ->leftjoin("images" , "images.id" , "providers.image_id")
                            ->select(
                                "providers.*",
                                "countries.ar_name AS country_name",
                                "cities.ar_name AS city_name",
                                "categories.ar_name AS cat_name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                            )
                            ->first();

        $b = DB::table("balances")
                    ->where("actor_id" , $data['merchant']->id)
                    ->where("actor_type" , "provider")
                    ->first();
        if($b){
            $data['merchant']->balance = $b->balance;
        }else{
            $data['merchant']->balance = 0;
        }

        $data['branches']  = DB::table("branches")
                            ->where("branches.provider_id" , $id)
                            ->get();

        foreach ($data['branches'] as $b){
            $img = DB::table("branch_images")
                        ->join("images" , "images.id" , "branch_images.branch_id")
                        ->where("branch_images.branch_id" , $b->id)
                        ->select(
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/branches/', images.name) AS branch_image_url")
                        )->first();

            if($img){
                $image = $img->branch_image_url;
            }else{
                $image = url("/storage/app/public/providers/picture_not_available_400-300.png");
            }
            $meal_count    = DB::table("meals")->where("branch_id" , $b->id)->count();
            $res_count     = DB::table("reservations")->where("branch_id" , $b->id)->count();
            $orders_count  = DB::table("orders")->where("branch_id" , $b->id)->count();
            $b->branch_image_url = $image;
            $b->meal_count       = $meal_count;
            $b->res_count        = $res_count;
            $b->orders_count     = $orders_count;
        }
    	//$data['meals'] = get_table('meals',['created_by'=>$id]);

        $data['tickets'] = DB::table("tickets")
            ->where("actor_id" , $id)
            ->where("actor_type" , "provider")
            ->join("providers" , "providers.id" , "tickets.actor_id")
            ->select(
                "tickets.*"
            )
            ->get();
        foreach($data['tickets'] as $t){
            $replies = DB::table("ticket_replies")
                ->where("ticket_id" , $t->id)
                ->get();
            $t->replies = $replies;
        }

    	return view("admin_panel.merchants.view" , $data);

    }

    public function change_subscription($id){

        $data['provider'] = DB::table("providers")->where("id", $id)->first();
        if(!$data['provider']){
            return redirect("/admin/dashboard");
        }
        $data['title'] = 'تعديل قيمة اشتراك المطعم';
        return view("admin_panel.merchants.subscription", $data);
    }
    public function post_change_subscription(Request $request){

        $messages = [
            'required'      => 'برجاء ادخال قيمة الحقل',
            'numeric'       => 'برجاء ادخال قيمة صحيحة',
            'in'            => 'برجاء ادخال قيمة صحيحة'
        ];
        $rules = [
            'sub'           => 'required|in:0,1',
        ];

        if($request->input("sub") == "1"){
            $rules['amount'] = "required|numeric";
            $rules['period'] = "required|in:1,2";
        }
        $this->validate($request, $rules , $messages);

        $id = $request->input("id");
        $data = [
            "has_subscriptions" => $request->input("sub")
        ];

        if($request->input("sub") == "1"){
            $data['subscriptions_period'] = $request->input("period");
            $data['subscriptions_amount'] = $request->input("amount");
        }else{
            $data['subscriptions_period'] = "0";
            $data['subscriptions_amount'] = "0";
        }
        DB::table("providers")
            ->where("id" , $id)
            ->update($data);
        return redirect("/admin/providers/all")->with("success" , "تمت العملية بنجاح");
    }
    
    
       
     
    public function approve($id){
        DB::table("providers")
                ->where("id" , $id)
                ->update([
                    "accountactivated" => "1"
                ]);
        return redirect("/admin/providers/activated")->with("success" , "تمت العملية بنجاح");
	}
    public function deactivate($id){
        DB::table("providers")
            ->where("id" , $id)
            ->update([
                "accountactivated" => "0"
            ]);
        return redirect("/admin/providers/deactivated")->with("success" , "تمت العملية بنجاح");
    }
}
