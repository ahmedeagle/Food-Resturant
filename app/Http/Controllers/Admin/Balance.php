<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Carbon;
use Validator;

class Balance extends Controller
{

    function __construct()
    {

    }

    public function index($type)
    {

        if ($type == "user") {
            $data['title'] = " ارصده  المستخدمين";
            $name = "name";
            $table = "users";
            $actorName = "name";

        } elseif ($type == "provider") {
            $data['title'] = "ارصده المطاعم";
            $name = "ar_name";
            $table = "providers";
            $actorName = "ar_name";
        } else {
            return redirect("/admin/dashboard");
        }
        $data["type"] = $type;
        $data['balances'] = DB::table("balances")
            ->join($table, 'balances.actor_id', $table . '.id')
            ->where("balances.actor_type", $type)
            ->select(
                "balances.id as balance_id",
                "{$table}.{$actorName} AS name",
                "balances.balance",
                'balances.updated_at as last_updated'
            )
            ->orderBy($table.'.id','DESC')
            ->get();
        return view("admin_panel.balances.list", $data);
    }


    public function update($balanceId,Request $request)
    {
        $messages = [
            'new_balance.required' => 'لأبد من ادخال قيمه الرصيد اولا ',
            'new_balance.numeric' => 'قيمة الرصيد غير صحيحة ',
        ];
        $rules = [
            'new_balance' => 'required|numeric',
        ];
        $this->validate($request, $rules, $messages);

        DB::table('balances') -> where('id',$balanceId) -> update(['balance' => $request ->  new_balance]);
        return redirect() -> back() ->with("success" , "تمت  العملية  بنجاح");
    }
}
