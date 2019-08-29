<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Hash;
use Validator;
class Customers extends Controller {

    function __construct()
    {

    }
	public function index($active=null){
        $data['title'] = 'العملاء';
        if ($active == 'activated'){
            $data['title'] = 'العملاء المفعلين';
        	$data['customers'] = DB::table("users")
                                    ->where("phoneactivated" , "1")
                                    ->leftjoin("images" , "images.id" , "users.image_id")
                                    ->join("countries" , "countries.id" , "users.country_id")
                                    ->join("cities" , "cities.id" , "users.city_id")
                                    ->select(
                                        "users.*",
                                        "images.name AS filename",
                                        "countries.ar_name AS country",
                                        "cities.ar_name AS city"
                                    )
                                    ->get();
        }
        elseif ($active == 'deactivated'){
            $data['title'] = 'العملاء الغير مفعلين';
            $data['customers'] = $data['customers'] = DB::table("users")
                                    ->where("phoneactivated" , "0")
                                    ->leftjoin("images" , "images.id" , "users.image_id")
                                    ->join("countries" , "countries.id" , "users.country_id")
                                    ->join("cities" , "cities.id" , "users.city_id")
                                    ->select(
                                        "users.*",
                                        "images.name AS filename",
                                        "countries.ar_name AS country",
                                        "cities.ar_name AS city"
                                    )
                                    ->get();
        }
        else{
        	$data['customers'] =  $data['customers'] = DB::table("users")
                                    ->leftjoin("images" , "images.id" , "users.image_id")
                                    ->join("countries" , "countries.id" , "users.country_id")
                                    ->join("cities" , "cities.id" , "users.city_id")
                                    ->select(
                                        "users.*",
                                        "images.name AS filename",
                                        "countries.ar_name AS country",
                                        "cities.ar_name AS city"
                                    )
                                    ->get();
        }
        return view("admin_panel.customers.list" ,$data);
		$this->load->view('admin_panel/blank',$data);
    }
    
    public function get_edit($user_id){
        
        $user = User::findOrFail($user_id);
        
        $data['title'] = " - تعديل الملف الشخصي";
 
        $data['countries'] = DB::table("countries")
                                ->get();

        foreach ($data['countries'] as $key => $value){
            if($value->active == "0" && $value->id != $user -> country_id){
                unset($data['countries'][$key]);
            }
        }
        
        $data['cities'] = DB::table("cities")
                               ->where("country_id", $user->country_id)
                               ->get();

        foreach ($data['cities'] as $key => $value){
            if($value->active == "0" && $value->id != $user->city_id){
                unset($data['cities'][$key]);
            }
        }
        
        $data['img'] = 'bm';
        $data['user'] = $user;


        return view("admin_panel.customers.edit", $data);

    }
    
    
    public function post_edit($user_id , Request $request){
           
           
           
           $messages = [
                "required"                          => 'هذا الحقل  مطلوب',
                "user-phone.numeric"                => trans("messages.phone_numeric"),
                "user-age.date_format"              => trans("messages.reservation.date.format.error"),
                "user-email.unique"                 => trans("messages.email_unique"),
                "user-email.email"                  => trans("messages.email"),
                "user-phone.unique"                 => trans("messages.phone_unique"),
              
            ];
            $rules = [
                
                'name'                    => 'required',
                "email"                   => "required|email|unique:users,email,".$user_id,
                "country"                 => "required|exists:countries,id",
                "city"                    => "required|exists:cities,id",
                "gender"                  => "required|in:1,2",
                "phone"                   => "required|numeric|unique:users,phone,".$user_id,
                "date_of_birth"           => 'required|date_format:Y-m-d',
                 
             ];
            $this->validate($request, $rules , $messages);
             
            
             $data =[
                 
                    'name'             => $request -> name,
                    'email'            => $request -> email,
                    'country_id'       => $request -> country,
                    'city_id'          => $request -> city,
                    'gender'           => ($request->input("gender") == 1) ? "male" : "female",
                    'date_of_birth'    => $request -> date_of_birth,
                    'phone'            => $request -> phone,
                    
                 ];
                 
                 
                 User::where('id',$user_id) -> update($data);
                 
                   return redirect()->back()->with("success", trans("messages.success"));
       
    }
    
    
    
    public function post_changePassword($user_id ,Request $request){
                 
                   
            $messages = [
                "required"                          => 'هذا الحقل  مطلوب',
                "password.min"                      =>'لأابد ان تكون كلمه المرور ثمان اخرف علي الاقل ',
                "password.confirmed"                => 'كلمة المرور غير متطابقة',
                "old_password.unique"                 => trans("messages.email_unique"),
               
            ];
            
            $rules = [
                
                "password"                              => 'required|min:6|confirmed',
                 "password_confirmation"                 => "required",
                 
             ];
            

             $validator =  Validator::make($request -> all(),$rules,$messages);
             
   //          $validator = $this->validate($request, $rules , $messages);
          
          
            
	        if ($validator->fails()) {
     
                  return redirect()->back()->with('errors',$validator->errors());
                
             }
             
            
                    $user = User::find($user_id);
                    
                    $hashedPassword = $user->password;
             
                    
             
            		   $user ->fill([
            		        'password' => Hash::make(request()->input('password'))
            		    ])->save();
            		     
            		    return redirect()->back()->with("success", trans("messages.success"));
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
    
    
      public function get_balance_user($id){
        $balance = DB::table("balances")
            ->where("actor_id" , $id)
            ->where("actor_type" , "user")
            ->first();
        if(!$balance){
            return 0;
        }else{
            return $balance->balance;
        }
    }
    
    
    
    public function view($id){
    	$data['title'] = 'تفاصيل المستخدم';
        $data['customer'] = DB::table("users")
                            ->where("users.id" , $id)
                            ->join("countries" , "countries.id" , "users.country_id")
                            ->join("cities" , "cities.id" , "users.city_id")
                            ->leftjoin("images" , "images.id", "users.image_id")
                            ->select(
                                "users.*",
                                "countries.ar_name AS country_name",
                                "cities.ar_name AS city_name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url")
                            )
                            ->first();
        $data['main_orders'] = DB::table("orders")
                                ->where("user_id" , $id)
                                ->join("order_statuses" , "order_statuses.id" , "orders.order_status_id")
                                ->join("payment_methods" , "payment_methods.id" , "orders.payment_id")
                                ->select(
                                    "orders.*",
                                    "order_statuses.ar_name AS status",
                                    "payment_methods.ar_name AS payment_method"
                                )
                                ->get();

        $data['tickets'] = DB::table("tickets")
                            ->where("actor_id" , $id)
                            ->where("actor_type" , "user")
                            ->join("users" , "users.id" , "tickets.actor_id")
                            ->select(
                                "tickets.*",
                                "users.name AS username"
                            )
                            ->get();
        foreach($data['tickets'] as $t){
            $replies = DB::table("ticket_replies")
                        ->where("ticket_id" , $t->id)
                        ->get();
            $t->replies = $replies;
        }
        $data['title'] = "تفاصيل المستخدم";
        return view("admin_panel.customers.view" , $data);

    }
    public function activate($id){
		$store['status'] = 2;
		$customer = get_this('customers',['id'=>$id, 'status'=>1]);
		$this->Main_model->update('customers',['id'=>$customer['id']],$store);
        $this->session->set_flashdata('message','تم التفعيل واشعار التاجر بتفعيل الحساب');
		redirect('admin_panel/customers');																
		

		
	}
	
 
	
}
