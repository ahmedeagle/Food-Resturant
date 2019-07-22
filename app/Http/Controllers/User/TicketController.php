<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Ticket;
use Validator;
use Carbon\Carbon;
class TicketController extends Controller
{
    public function get_tickets_select(){

        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";
        return view("User.pages.ticket.tickets-select", $data);
    }


    public function open_new_ticket(){
        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";

        $data['types'] = DB::table("ticket_types")
                            ->select(
                                "id AS id",
                                "ar_name AS name"
                            )
                            ->get();
        return view("User.pages.ticket.open-new-ticket", $data);
    }

    public function post_new_ticket(Request $request){
      //  app()->setLocale("ar");
        $rules = [

            "type"        => "required|exists:ticket_types,id",
            "title"       => "required",
            "subject"     => "required"
        ];
        $messages = [
            "required"          => trans("messages.required"),
            "exists"            => trans("site.ticket-type-exists")
        ];


        $this->validate($request, $rules , $messages);

        $type = $request->input('type');
        $title = $request->input('title');
        $subject = $request->input('subject');

        $id = DB::table("tickets")
            ->insertGetId([
                "title" => $title,
                "type_id" => $type,
                "actor_id" => auth('web')->id(),
                "actor_type" => "user"
            ]);

        DB::table("ticket_replies")
            ->insert([
                "reply" => $subject,
                "ticket_id" => $id,
                "FromUser" => "1"
            ]);

        return redirect("/user/tickets/tickets/list")->with("success" , trans("messages.success"));

    }

    public function get_tickets(){
        $data['tickets'] = DB::table("tickets")
                                ->where("actor_id", auth('web')->id())
                                ->where("actor_type", "user")
                                ->select(
                                    "tickets.id",
                                    "tickets.title",
                                    DB::raw("DATE(tickets.created_at) AS created_at")
                                )
                                ->orderBy("tickets.id", "DESC")
                                ->paginate();

        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";

        return view("User.pages.ticket.tickets", $data);
    }

    public function get_ticket_details($id){
      //  App()->setLocale("ar");
        $ticketTest = Ticket::find($id);


        if(!$ticketTest){
            return redirect("/user/dashboard");
        }

        if($ticketTest->actor_id != auth('web')->id()){
            return redirect("/user/dashboard");
        }

        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";

        $data['ticket'] = DB::table("tickets")
                            ->join("users", "users.id", "tickets.actor_id")
                            ->leftjoin("images", "images.id", "users.image_id")
                            ->where("tickets.id", $id)
                            ->select(
                                "tickets.id AS ticket_id",
                                "tickets.title AS ticket_title",
                                "users.name AS user_name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url")
                            )->first();

        $data['replies'] = DB::table("ticket_replies")
            ->where("ticket_id", $data['ticket']->ticket_id)
            ->select(
                "reply",
                "FromUser",
                DB::raw("DATE(created_at) AS created_date")
            )->get();

        return view("User.pages.ticket.ticket-details", $data);

    }

    public function add_ticket_reply(Request $request){

      //  App()->setLocale("ar");
        $rules   = [
            "reply"     => "required",
            "ticket_id" => "required|exists:tickets,id",
        ];
        $messages   = [
            "required"   => 1,
            "exists"     => 2
        ];
        $msg        = [
            1  => trans("messages.required"),
            2  => trans("messages.ticket_id_exists"),
            3  => trans("messages.success"),
            4  => trans("messages.error"),
        ];
        $validator  = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        DB::table("ticket_replies")
            ->insert([
                "reply" => $request->input("reply"),
                "ticket_id" => $request->input("ticket_id"),
                "FromUser" => "1",
            ]);

        $mytime = \Carbon\Carbon::now();
        $date =  $mytime->toDateString();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3], "created_at" => $date]);
    }
}
