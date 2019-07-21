<?php

namespace App\Http\Controllers\Provider;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Carbon\Carbon;
class TicketController extends Controller
{
    public function __construct()
    {
       // App()->setLocale("ar");
    }

    public function get_contact_page(){
        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";

        return view("Provider.pages.contact-us", $data);
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
        return view("Provider.pages.open-new-ticket", $data);
    }

    public function post_new_ticket(Request $request){
        //app()->setLocale("ar");
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
                    "actor_id" => auth("provider")->id(),
                    "actor_type" => "provider"
                ]);

        DB::table("ticket_replies")
                ->insert([
                    "reply" => $subject,
                    "ticket_id" => $id,
                    "FromUser" => "1"
                ]);

        return redirect("/restaurant/contact-us/tickets/list")->with("success" , trans("messages.success"));

    }

    public function get_tickets(){
        $data['tickets'] = DB::table("tickets")
                            ->where("actor_id", auth("provider")->id())
                            ->where("actor_type", "provider")
                            ->select(
                                "tickets.id",
                                "tickets.title",
                                DB::raw("DATE(tickets.created_at) AS created_at")
                            )
                            ->orderBy("tickets.id", "DESC")
                            ->paginate();

        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";

        return view("Provider.pages.tickets", $data);
    }

    public function get_ticket_details($id){

        $ticketTest = Ticket::find($id);


        if(!$ticketTest){
            return redirect("restaurant/dashboard");
        }

        if($ticketTest->actor_id != auth("provider")->id()){
            return redirect("restaurant/dashboard");
        }

        $data['title'] = " - اتصل بنا";
        $data['class'] = "front-page page-template";

        $data['ticket'] = DB::table("tickets")
                            ->join("providers", "providers.id", "tickets.actor_id")
                            ->join("images", "images.id", "providers.image_id")
                            ->where("tickets.id", $id)
                            ->select(
                                "tickets.id AS ticket_id",
                                "tickets.title AS ticket_title",
                                "providers.ar_name AS provider_name",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS provider_image_url")
                            )->first();

        $data['replies'] = DB::table("ticket_replies")
                            ->where("ticket_id", $data['ticket']->ticket_id)
                            ->select(
                                "reply",
                                "FromUser",
                                DB::raw("DATE(created_at) AS created_date")
                            )->get();

        return view("Provider.pages.ticket-details", $data);

    }

    public function add_ticket_reply(Request $request){

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

        $mytime = Carbon::now();
        $date =  $mytime->toDateString();
        return response()->json(['status' => true, 'errNum' => 0, 'msg' => $msg[3], "created_at" => $date]);
    }
}
