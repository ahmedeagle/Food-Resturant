<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Tickets extends Controller {

    function __construct()
    {

    }
	public function index($type=null){
        if($type == 0){
           $data['title'] = 'تذاكر المطاعم';
           $actorType = "provider";
        }else{
           $data['title'] = 'تذاكر العملاء';
           $actorType = "user";
        }
        $data['type'] = $type;
        $data['tickets'] = DB::table("tickets")
                                ->join("ticket_types" , "ticket_types.id" , "tickets.type_id")
                                ->where("actor_type" , $actorType)
                                ->select(
                                    "tickets.*",
                                    "ticket_types.ar_name AS type_name"
                                )
                                ->get();
        //$data['tickets'] = get_table('tickets',['type'=>$type, 'status_id'=>$status_id],['id','DESC']);
		//$data['main_content'] = 'admin_panel/tickets/list';
        return view("admin_panel.tickets.list" , $data);
    }
    public function get_reply($id){

        $data['ticket'] = DB::table("tickets")
                            ->join("ticket_types" , "ticket_types.id" , "tickets.type_id")
                            ->where("tickets.id" , $id)
                            ->select(
                                "tickets.*",
                                "ticket_types.ar_name AS type_name"
                            )
                            ->first();

        if($data['ticket']->actor_type == "provider"){
            $data['type'] = 0;
            $data['title'] = 'تذاكر التجار';
            $name = DB::table("providers")->where("id", $data['ticket']->actor_id)->first();
            $data['username'] = $name->ar_name;
        }else{
            $data['type'] = 1;
            $data['title'] = 'تذاكر العملاء';
            $name = DB::table("users")->where("id", $data['ticket']->actor_id)->first();
            $data['username'] = $name->name;
        }

        DB::table("ticket_replies")
            ->where("ticket_id" , $id)
            ->where("FromUser" , "1")
            ->update([
                "seen" => "1"
            ]);

        $data['ticket_replys'] = DB::table("ticket_replies")
                                    ->where("ticket_id" , $id)
                                    ->get();

        return view("admin_panel.tickets.reply" , $data);

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

        DB::table("ticket_replies")
                    ->where("ticket_id" , $request->input("ticket_id"))
                    ->insert([
                        "reply" => $request->input("content"),
                        "ticket_id" => $request->input("ticket_id"),
                        "FromUser" => "0"
                    ]);
        $redValue = "/admin/tickets/reply/" . $request->input("ticket_id");
        return redirect($redValue)->with("success" , "تمت العملية بنجاح");
    }
}
