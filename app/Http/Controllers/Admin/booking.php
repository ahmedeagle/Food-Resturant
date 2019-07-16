<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class booking extends Controller {

    function __construct()
    {

    }
    public function index()
    {
        $data['title'] = 'الحجوزات';
        $data['reservations'] = DB::table("reservations")
                                ->join("users" , "users.id" , "reservations.user_id")
                                ->join("branches" , "branches.id" , "reservations.branch_id")
                                ->join("providers" , "providers.id" , "branches.provider_id")
                                ->join("reservation_statuses" , "reservation_statuses.id" , "reservations.status_id")
                                ->select(
                                    "reservations.*",
                                    "providers.ar_name AS provider_name",
                                    "users.name AS user_name",
                                    "users.phone AS user_phone",
                                    "users.email AS user_email",
                                    "reservation_statuses.ar_name AS status"
                                )
                                ->get();
        return view("admin_panel.reservations.list" , $data);
    }
}
