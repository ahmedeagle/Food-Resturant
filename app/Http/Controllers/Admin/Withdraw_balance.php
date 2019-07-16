<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Withdraw_balance extends Controller {

    function __construct()
    {

    }
	public function index()
	{
        $data['title'] = 'طلبات سحب الرصيد';
        $data['requests'] = DB::table("withdraws")
                            ->join("providers" , "providers.id" , "withdraws.provider_id")
                            ->select(
                                "withdraws.*",
                                "providers.ar_name AS username",
                                "providers.id AS provider_id"
                            )
                            ->get();

        return view("admin_panel.withdraw_balance.list", $data);
    }
    public function accept($id){
        $request =   DB::table("withdraws")
                        ->join("providers" , "providers.id" , "withdraws.provider_id")
                        ->where("withdraws.id" , $id)
                        ->select(
                            "withdraws.*",
                            "providers.ar_name AS username",
                            "providers.id AS provider_id"
                        )
                        ->first();
        if(!$request){
            return redirect("/admin/withdraws")->with("error", "حدث خطأ من فضلك حاول مرة اخرة");
        }
        $balance = DB::table("balances")
                    ->where("actor_id" , $request->provider_id)
                    ->where("actor_type" , "provider")
                    ->first();

        $newBalance = $balance->balance - $request->withdrawn_amount;

        DB::table("balances")
                ->where("actor_id" , $request->provider_id)
                ->where("actor_type" , "provider")
                ->update([
                    "balance" => $newBalance
                ]);
        DB::table("withdraws")
                ->where("id" , $id)
                ->update([
                    "is_finished" => "1"
                ]);

        return redirect("/admin/withdraws")->with("success" , "تمت العملية بنجاح");

	}
}
