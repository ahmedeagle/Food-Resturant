<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Validator;
class Comments extends Controller {

    function __construct()
    {

    }
	public function index(){

        $data['title'] = "التعليقات";

        $data['comments'] = DB::table("comments")
                                ->join("users", "users.id", "comments.user_id")
                                ->join("branches", "branches.id", "comments.branch_id")
                                ->join("providers", "providers.id", "branches.provider_id")
                                ->select(
                                    "comments.*",
                                    "providers.ar_name as provider_name",
                                    "users.name as user_name"
                                )
                                ->get();

        return view("admin_panel.comments.list" , $data);
    }
}
