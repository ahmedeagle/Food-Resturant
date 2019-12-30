<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Carbon;
use Validator;
class Notifications extends Controller {

    function __construct()
    {

    }
	public function index($type){
        if($type == "users"){
            $data['title'] = "اشعارات المستخدمين";
            $name = "name";
        }elseif($type == "providers" ){
            $data['title'] = "اشعارات المطاعم";
            $name = "ar_name";
        }else{
            return redirect("/admin/dashboard");
        }
        $data["type"] = $type;
        $data['notifications'] = DB::table("admin_notifications")
                                ->where("admin_notifications.type" , $type)
                                ->select(
                                    "admin_notifications.id AS notification_id",
                                    "admin_notifications.title",
                                    "admin_notifications.content",
                                    "admin_notifications.created_at"
                                )
                                ->get();
        foreach ($data['notifications'] as $n){
            $users = DB::table("admin_notifications_receivers")
                ->where("admin_notifications_receivers.notification_id" , $n->notification_id)
                ->join($type , $type. ".id" , "admin_notifications_receivers.actor_id")
                ->leftjoin("images" , "images.id" , $type . ".image_id")
                ->select(
                    $type.".id AS user_id",
                    $type."." . $name . " AS user_name",
                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/". $type ."/', images.name) AS user_image_url")
                )->get();

            foreach($users as $user){
                $order = DB::table("orders")->where("user_id" , $user->user_id)->count();
                $user->number_of_orders = $order;
            }
            $n->users = $users;
        }

        return view("admin_panel.notifications.list" , $data);
    }
    public function get_add($type){
        $data['title'] = 'ارسال اشعار جديد';
        if($type == "users"){
            $data['receivers'] = DB::table("users")
                        ->leftjoin("images" , "images.id" , "users.image_id")
                        ->select(
                            "users.name",
                            "users.id",
                            DB::raw("CONCAT('". url('/') ."','/storage/app/public/". $type ."/', images.name) AS user_image_url")
                        )
                        ->get();
            foreach($data['receivers'] as $user){
                $order = DB::table("orders")->where("user_id" , $user->id)->count();
                $user->number_of_orders = $order;
            }
        }else{
            $data['receivers'] = DB::table("providers")
                ->leftjoin("images" , "images.id" , "providers.image_id")
                ->select(
                    "providers.ar_name AS name",
                    "providers.id",
                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/". $type ."/', images.name) AS user_image_url")
                )
                ->get();
            foreach($data['receivers'] as $user){
                $order = DB::table("branches")->where("provider_id" , $user->id)->count();
                $user->number_of_branches = $order;
            }
        }

        $data['type'] = $type;
        return view("admin_panel.notifications.add",$data);
    }
    public function post_add(Request $request){

        $title    = $request->input("title");
        $content  = $request->input("content");
        $option   = $request->input("option_type");
        $type     = $request->input("type");
        $count    = $request->input("count");

        $id = [];
        if($option == 2){
            for($i = 0 ; $i <= $count; $i++){
                $id[] = $request->input("r_id" . $i);
            }
        }

        if($type == "users"){
            if($option == 2){
                $users = DB::table("users")
                            ->whereIn("id" , $id)
                            ->select("id" ,"device_reg_id")
                            ->get();
            }else{
                $users = DB::table("users")->get();
            }
        }else{
            if($option == 2){
                $users = DB::table("providers")
                    ->whereIn("id" , $id)
                    ->get();
            }else{
                $users = DB::table("providers")->get();
            }
        }

        if($type == "users"){

            $notify_id = DB::table("admin_notifications")
                ->insertGetId([
                    "title" => $title,
                    "content" => $content,
                    "type" => $type
                ]);

        }elseif ($type == "providers") {

            $notify_id = DB::table("admin_notifications")
                ->insertGetId([
                    "title" => $title,
                    "content" => $content,
                    "type" => $type,
                 ]);
        }



        foreach($users as $user){
            if($type == "users"){

                DB::table("admin_notifications_receivers")
                    ->insert([
                        "notification_id" => $notify_id,
                        "actor_id"   => $user->id
                    ]);
                // push notification

                $notif_data = array();

                $notif_data['title']   = $title;
                $notif_data['body']    = $content;
                $notif_data['id']      = $notify_id;
                $notif_data['notification_type']      = 4;


                if($user->device_reg_id != null){
                       $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);
                }

            }elseif ($type =="providers"){
                // send notification to provider.


                DB::table("admin_notifications_receivers")
                    ->insert([
                        "notification_id" => $notify_id,
                        "actor_id"        => $user->id
                    ]);
                // push notification

                $notif_data = array();
                $notif_data['title']                 = $title;
                $notif_data['body']                   = $content;
                $notif_data['id']                     = $notify_id;
                $notif_data['notification_type']      = 4;


                if($user->device_reg_id != null){
                      $push = (new \App\Http\Controllers\Apis\User\PushNotificationController())->send($user->device_reg_id,$notif_data);
                }


            }
        }
        return response()->json(["status" => true]);

    }
    public function delete($id){
        $data = DB::table("admin_notifications")
                    ->where("id" , $id)
                    ->first();
        if ($data) {
            $type = $data->type;
            DB::table("admin_notifications")->where("id" , $id)->delete();
            DB::table("admin_notifications_receivers")->where("notification_id" , $id)->delete();
            return redirect("/admin/notifications/list/" . $type)->with("success", "تمت العملية بنجاح");
        }else{
            return redirect()->back()->with("error", "حدث خطأ برجاء المحاولة مرة اخرى");
        }
    }
}
