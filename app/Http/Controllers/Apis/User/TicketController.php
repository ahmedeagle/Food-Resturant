<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
class TicketController extends Controller
{
    public function get_ticket_types(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $types = DB::table("ticket_types")
                    ->select(
                        "ticket_types.id AS type_id",
                        "ticket_types.". $name ."_name AS type_name"
                    )
                    ->get();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => trans('success') , "types" => $types]);
    }
    public function add_ticket(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "title"       => "required",
            "description" => "required",
            "type"        => "required|exists:ticket_types,id",
        ];
        $messages   = [
            "required"       => 1,
            "exists"         => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.ticket.type.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $title = $request->input("title");
        $desc  = $request->input("description");
        $type  = $request->input("type");
        $ticket_id = DB::table("tickets")
                        ->insertGetId([
                           "title"       => $title,
                           "type_id"     => $type,
                           "actor_id"    => (new GeneralController())->get_id($request),
                           "actor_type"  => "user"
                        ]);
        DB::table("ticket_replies")
                ->insert([
                    "ticket_id" =>$ticket_id,
                    "reply"  => $desc,
                    "FromUser" => "1"
                 ]);
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }
    public function get_tickets(Request $request){

        $tickets = DB::table("tickets")
                    ->where("actor_id" , (new GeneralController())->get_id($request))
                    ->where("actor_type" , "user")
                    ->select(
                            "tickets.id",
                            "tickets.title",
                            DB::raw("DATE(tickets.created_at) AS create_date"),
                            DB::raw("Time(tickets.created_at) AS create_time")
                        )
                    ->orderBy("tickets.id" , "DESC")
                    ->get();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => trans('success') , "tickets" => $tickets]);
    }

    public function get_ticket_messages(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "id"    => "required|exists:tickets,id",
        ];
        $messages   = [
            "required"       => 1,
            "exists"         => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.ticket.id.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id = $request->input("id");
        $ticket_info = DB::table("tickets")
                        ->where("id" ,$id)
                        ->select(
                            "tickets.id",
                            "tickets.title",
                            "tickets.type_id",
                            DB::raw("DATE(tickets.created_at) AS create_date"),
                            DB::raw("Time(tickets.created_at) AS create_time")
                        )
                        ->first();

        $ticketTypes = DB::table("ticket_types")
                        ->select(
                             "id",
                             $name . "_name AS type"
                            )
                        ->get();

        foreach($ticketTypes as $type){
            if($type->id == $ticket_info->type_id){
                $type->selected = true;
            }else{
                $type->selected = false;
            }
        }

        $replies = DB::table("ticket_replies")
                        ->join("tickets" , "tickets.id" , "ticket_replies.ticket_id")
                        ->join("users" , "users.id" , "tickets.actor_id")
                        ->join("ticket_types" , "ticket_types.id" , "tickets.type_id")
                        ->where("ticket_replies.ticket_id" , $request->input("id"))
                        ->where("tickets.actor_id" , (new GeneralController())->get_id($request))
                        ->where("tickets.actor_type" , "user")
                        ->select(
                                   "users.name AS username",
                                   "ticket_replies.reply",
                                   "ticket_replies.FromUser",
                                   DB::raw("DATE(ticket_replies.created_at) AS reply_create_date"),
                                   DB::raw("TIME(ticket_replies.created_at) AS reply_create_time")
                                )
                        ->orderBy("ticket_replies.id" , "DESC")
                        ->paginate(10);
        DB::table("ticket_replies")
                        ->where("ticket_id" , $id)
                        ->where("FromUser", "0")
                        ->update(["seen" => "1"]);
        if($request->input("page") > 1){
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3] , "replies" => $replies]);
        }
        else{
            return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3], "ticket_info" => $ticket_info , "ticket_types" => $ticketTypes ,"replies" => $replies]);
        }
    }

    public function add_message(Request $request){
        (new BaseConroller())->setLang($request);
        $name  = (App()->getLocale() == 'ar') ? 'ar' : 'en' ;
        $rules      = [
            "id"        => "required|exists:tickets,id",
            "message"   => "required",
        ];
        $messages   = [
            "required"       => 1,
            "exists"         => 2,
        ];
        $msg        = [
            1   => trans("messages.required"),
            2   => trans("messages.ticket.id.exists"),
            3   => trans("messages.success"),
            5   => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }
        $id      = $request->input("id");
        $message = $request->input("message");
        $ticket = DB::table("tickets")
                        ->where("id" ,$id)
                        ->where("actor_type" ,"user")
                        ->select("actor_id")
                        ->first();
        if($ticket){
            if($ticket->actor_id != (new GeneralController())->get_id($request)){
                return response()->json(['status' => false, 'errNum' => 5, 'msg' => $msg[5]]);
            }
        }
        DB::table("ticket_replies")
                ->insert([
                   "reply" => $message,
                   "ticket_id" => $id,
                   "FromUser" => "1"
                ]);
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3]]);
    }
}
