<?php

namespace App\Http\Controllers\User;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

//use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class NotificationController extends Controller
{
    public function get_notifications(){
        $data['title'] = ' - الإشعارات';
        $data['class'] = 'front-page page-template';

        $data["notification"] = self::getUserNotification();

        // update seen notification
        DB::table("admin_notifications_receivers")
                    ->join("admin_notifications", "admin_notifications.id", "admin_notifications_receivers.notification_id")
                    ->where("admin_notifications_receivers.actor_id", auth('web')->id())
                    ->where("admin_notifications.type", "users")
                    ->update([
                        "admin_notifications_receivers.seen" => "1",
                    ]);

        DB::table("notifications")
                    ->where("actor_id", auth('web')->id())
                    ->where("actor_type", "user")
                    ->update([
                        "notifications.seen" => "1",
                    ]);

        return view("User.pages.notification.notifications", $data);
    }

    public static function getUserNotification($count = false){


        $adminNotification = DB::table("admin_notifications_receivers")
                                ->join("admin_notifications", "admin_notifications.id", "admin_notifications_receivers.notification_id")
                                ->where("admin_notifications_receivers.actor_id", auth('web')->id())
                                ->where("admin_notifications.type", "users")
                                ->select(
                                    "admin_notifications.title AS notification_title",
                                    "admin_notifications.content AS notification_content",
                                    "admin_notifications_receivers.seen",
                                    DB::raw("DATE(admin_notifications_receivers.created_at) AS create_date")
                                )
                                ->orderBy("admin_notifications.id", "DESC")->get();


        $notifications = DB::table("notifications")
                            ->where("actor_id", auth('web')->id())
                            ->where("actor_type", "user")
                            ->select(
                                "notifications.ar_title AS notification_title",
                                "notifications.ar_content AS notification_content",
                                "notifications.seen",
                                DB::raw("DATE(notifications.created_at) AS create_date")
                            )
                            ->orderBy("notifications.id", "DESC")->get();

        $results = array_merge($adminNotification->toArray(), $notifications->toArray());

        usort($results, function($a,$b) {
            if($a==$b) return 0;
            return (($a->create_date >  $b->create_date))?-1:1;
        });



        if($count){

            $seen = 0;
            foreach($results as $result){

                if($result->seen == "0"){
                    $seen++;
                }

            }
            return $seen;

        }


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

        //$paginator = new Paginator($results, count($results),$page);

        return  $paginatedItems;
    }
}
