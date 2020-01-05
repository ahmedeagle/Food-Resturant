<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;

class Tickets extends Controller
{

    function __construct()
    {

    }

    public function index($type = null)
    {
        if ($type == 0) {
            $data['title'] = 'تذاكر المطاعم';
            $actorType = "provider";
            $column = "ar_name";
            $table = "providers";
        } else {
            $data['title'] = 'تذاكر العملاء';
            $actorType = "user";
            $column = "name";
            $table = "users";
        }

        $data['type'] = $type;
        $data['tickets'] = DB::table("tickets")
            ->join("ticket_types", "ticket_types.id", "tickets.type_id")
            ->where("actor_type", $actorType)
            ->select(
                "tickets.*",
                "ticket_types.ar_name AS type_name",
                "actor_id",
                DB::raw("(SELECT({$column}) FROM  {$table} WHERE {$table}.id = tickets.actor_id) AS name ")
            )
            ->get();
        //$data['tickets'] = get_table('tickets',['type'=>$type, 'status_id'=>$status_id],['id','DESC']);
        //$data['main_content'] = 'admin_panel/tickets/list';
        return view("admin_panel.tickets.list", $data);
    }

    public function get_reply($id)
    {

        $data['ticket'] = DB::table("tickets")
            ->join("ticket_types", "ticket_types.id", "tickets.type_id")
            ->where("tickets.id", $id)
            ->select(
                "tickets.*",
                "ticket_types.ar_name AS type_name"
            )
            ->first();

        if ($data['ticket']->actor_type == "provider") {
            $data['type'] = 0;
            $data['title'] = 'تذاكر التجار';
            $name = DB::table("providers")->where("id", $data['ticket']->actor_id)->first();
            $data['username'] = $name->ar_name;
        } else {
            $data['type'] = 1;
            $data['title'] = 'تذاكر العملاء';
            $name = DB::table("users")->where("id", $data['ticket']->actor_id)->first();
            $data['username'] = $name->name;
        }

        DB::table("ticket_replies")
            ->where("ticket_id", $id)
            ->where("FromUser", "1")
            ->update([
                "seen" => "1"
            ]);

        $data['ticket_replys'] = DB::table("ticket_replies")
            ->where("ticket_id", $id)
            ->get();

        return view("admin_panel.tickets.reply", $data);

    }

    public function post_reply(Request $request)
    {
        $messages = [
            'content.required' => 'برجاء ادخال الرد'
        ];
        $rules = [
            'content' => 'required'
        ];
        $this->validate($request, $rules, $messages);


        $ticket = DB::table('tickets')->where('id', $request->input("ticket_id"))->first();
        if (!$ticket) {
            $redValue = "/admin/tickets/reply/" . $request->input("ticket_id");
            return redirect($redValue)->with("error", "التذكره غير موجوده ");
        }

        DB::table("ticket_replies")
            ->where("ticket_id", $request->input("ticket_id"))
            ->insert([
                "reply" => $request->input("content"),
                "ticket_id" => $request->input("ticket_id"),
                "FromUser" => "0"
            ]);
        //send notification to resturant main provider

        $title = $ticket->title;
        $push_notif_title = "     رد علي التذكره  - " . $title;
        $post_id = $ticket->id;
        $post_title = " تم الرد علي يذكره خاصه بكم من قبل الاداره الرجاء الدخول الي تذاكري لعرض التفاصيل   ";

        $notif_data = array();

        $notif_data['title'] = $push_notif_title;
        $notif_data['body'] = $post_title;
        $notif_data['id'] = $post_id;
        $notif_data['notification_type'] = 5;  // messages


        DB::table("notifications")
            ->insert([
                "en_title" => "Reply on Ticket",
                "ar_title" => $push_notif_title,
                "en_content" => "There is a response to your  ticket {$title}, Login To You Account to See More Details",
                "ar_content" => $post_title,
                "notification_type" => 5,
                "actor_id" => $ticket->actor_id,
                "actor_type" => "provider",
                "action_id" => $post_id

            ]);

        $redValue = "/admin/tickets/reply/" . $request->input("ticket_id");
        return redirect($redValue)->with("success", "تمت العملية بنجاح");
    }
}
