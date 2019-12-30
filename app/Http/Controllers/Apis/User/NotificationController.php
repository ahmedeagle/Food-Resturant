<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function get_notifications(Request $request){
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';

        $adminNotification = DB::table("admin_notifications_receivers")
                                        ->join("admin_notifications", "admin_notifications.id", "admin_notifications_receivers.notification_id")
                                        ->where("admin_notifications_receivers.actor_id", (new GeneralController())->get_id($request))
                                        ->where("admin_notifications.type", "users")
                                        ->select(
                                            "admin_notifications.id AS id",
                                            "admin_notifications.title AS title",
                                            "admin_notifications.content AS content",
                                            "admin_notifications_receivers.created_at",
                                            DB::raw("DATE(admin_notifications_receivers.created_at) AS create_date"),
                                            DB::raw("TIME(admin_notifications_receivers.created_at) AS create_time")
                                        )
                                        ->orderBy("admin_notifications.created_at", "DESC")
                                        ->get();


        $notifications = DB::table("notifications")
                            ->where("actor_id" , (new GeneralController())->get_id($request))
                            ->where("actor_type" , "user")
                            ->select(
                                "notifications.id AS id",
                                "notifications." . $name . "_title AS title",
                                "notifications." . $name . "_content AS content",
                                "notifications.created_at",
                                DB::raw("DATE(notifications.created_at) AS create_date"),
                                DB::raw("TIME(notifications.created_at) AS create_time")
                            )
                            ->orderBy("notifications.created_at", "DESC")
                            ->get();

        $results = array_merge($adminNotification->toArray(), $notifications->toArray());


        usort($results, function($a,$b) {
            if($a==$b) return 0;
             return (($a->created_at >  $b->created_at))?-1:1;
        });


        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new Laravel collection from the array data
        $itemCollection = collect($results);

        // Define how many items we want to be visible in each page
        $perPage = 10;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

        // set url path for generted links
        $paginatedItems->setPath(url()->current());


        // update seen notification
        DB::table("admin_notifications_receivers")
                        ->join("admin_notifications", "admin_notifications.id", "admin_notifications_receivers.notification_id")
                        ->where("admin_notifications_receivers.actor_id", (new GeneralController())->get_id($request))
                        ->where("admin_notifications.type", "users")
                        ->update([
                            "admin_notifications_receivers.seen" => "1",
                        ]);

        DB::table("notifications")
                    ->where("actor_id", (new GeneralController())->get_id($request))
                    ->where("actor_type", "user")
                    ->update([

                        "notifications.seen" => "1",

                    ]);

        return response()->json([
                "status" => true,
                "errNum" => 0,
                "msg"    => trans("messages.success"),
                "notifications" => $paginatedItems
        ]);
    }
    
    
    public function get_notification_count(Request $request)
    {
        
            (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';

        $adminNotification = DB::table("admin_notifications_receivers")
                                        ->join("admin_notifications", "admin_notifications.id", "admin_notifications_receivers.notification_id")
                                        ->where("admin_notifications_receivers.actor_id", (new GeneralController())->get_id($request))
                                        ->where("admin_notifications.type", "users")
                                        ->where("admin_notifications_receivers.seen","0")
                                        ->select(
                                            "admin_notifications.id AS id",
                                            "admin_notifications.title AS title",
                                            "admin_notifications.content AS content",
                                            DB::raw("DATE(admin_notifications_receivers.created_at) AS create_date"),
                                            DB::raw("TIME(admin_notifications_receivers.created_at) AS create_time")
                                        )
                                        ->orderBy("admin_notifications.id", "DESC")
                                        ->count();


        $notifications = DB::table("notifications")
                            ->where("actor_id" , (new GeneralController())->get_id($request))
                            ->where("actor_type" , "user")
                            ->where("notifications.seen" ,"0")
                            
                            ->select(
                                "notifications.id AS id",
                                "notifications." . $name . "_title AS title",
                                "notifications." . $name . "_content AS content",
                                DB::raw("DATE(notifications.created_at) AS create_date"),
                                DB::raw("TIME(notifications.created_at) AS create_time")
                            )
                            ->orderBy("notifications.id", "DESC")
                            ->count();

        $count = $adminNotification + $notifications;
 
 

        return response()->json([
                "status" => true,
                "errNum" => 0,
                "msg"    => trans("messages.success"),
                "notification_count" => $count
        ]);
        
    }
}
