<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Dashboard extends Controller {

	function __construct()
	{
// 		parent::__construct();
// 		if (!$this->session->has_userdata('login_data'))
//             redirect('admin_panel/login'); 
	}
	public function index()
	{

		$data['title'] = 'الاحصائيات';
		$data['users'] = DB::table("users")
		                        ->count();
		
        $data['offers'] = DB::table("offers")
		                        ->count();
		$data['providers'] = DB::table("providers")
		                        ->count();
		$data['orders'] = DB::table("orders")
		                        ->count();
		$data['main_content'] = 'admin_panel/dashboard';
		return view('admin_panel.dashboard',$data);
	}
}
