<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Orders extends Controller {

    function __construct()
    {

    }
	public function index()
	{
        $data['title'] = 'الطلبات';
        $data['orders'] = DB::table("orders")
                            ->join("users" , "users.id" , "orders.user_id")
                            ->join("branches" , "branches.id" , "orders.branch_id")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->select(
                                "orders.*",
                                "users.name AS username",
                                "users.email AS user_email",
                                "users.phone AS user_phone",
                                "providers.ar_name AS provider_name"
                            )
                            ->get();
        return view("admin_panel.orders.list" , $data);
    }
    public function view($id){
		$data['title'] = 'عرض الفاتورة';
		$data['order'] = DB::table("orders")
                            ->join("users" , "users.id" , "orders.user_id")
                            ->join("order_statuses" , "order_statuses.id" , "orders.order_status_id")
                            ->where("orders.id" , $id)
                            ->select(
                                "orders.*",
                                "users.name AS username",
                                "users.phone AS userphone",
                                "users.gender AS usergender",
                                "order_statuses.ar_name AS status"
                            )
                            ->first();
		$data['settings'] = DB::table("app_settings")->where("id" , 1)->first();

		// $latitude = $data['order']['latitude'];
		// $langitude = $data['order']['langitude'];
		// $this->load->library('googlemaps');
		// $config['center'] = $latitude.', '.$langitude;
		// $config['zoom'] = 'auto';
		// $this->googlemaps->initialize($config);
		// $marker = array();
		// $marker['position'] = $latitude.', '.$langitude;
		// $this->googlemaps->add_marker($marker);
		// $data['map'] = $this->googlemaps->create_map();
        return view("admin_panel.orders.view" , $data);
	}
	public function details($id){
		$data['title'] = 'تفاصيل الطلب';
		$data['order'] = DB::table("orders")
                            ->join("branches" , "branches.id" , "orders.branch_id")
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->join("order_statuses" , "order_statuses.id" , "orders.order_status_id")
                            ->join("payment_methods" , "payment_methods.id" , "orders.payment_id")
                            ->where("orders.id" , $id)
                            ->select(
                                "providers.ar_name AS provider_name",
                                "providers.phone AS branch_phone",
                                "providers.email AS branch_email",
                                "orders.is_delivery",
                                "orders.created_at",
                                "orders.id AS order_id",
                                "orders.total_price",
                                "orders.delivery_price",
                                "orders.order_tax",
                                "orders.app_percentage",
                                "orders.used_user_balance",
                                "payment_methods.ar_name AS payment_name"
                            )->first();
		$data['meals'] = DB::table("order_meals")
                        ->join("meals" , "meals.id" , "order_meals.meal_id")
                        ->join("meal_sizes" , "meal_sizes.id" , "order_meals.meal_size_id")
                        ->where("order_meals.order_id" , $data['order']->order_id)
                        ->select(
                            "meals.*",
                            "order_meals.meal_price",
                            "order_meals.quantity",
                            "meal_sizes.ar_name AS size_name",
                            "order_meals.id AS order_meal_id"
                        )->get();
		foreach ($data['meals'] as $meal){
		    $adds = DB::table("order_meals_adds")
                        ->where("order_meals_adds.order_meals_id" , $meal->order_meal_id)
                        ->join("meal_adds" , "meal_adds.id" , "order_meals_adds.add_id")
                        ->select(
                            "order_meals_adds.added_price",
                            "meal_adds.ar_name AS name"
                        )->get();
		    $meal->adds = $adds;

            $options = DB::table("order_meals_options")
                        ->where("order_meals_options.order_meals_id" , $meal->order_meal_id)
                        ->join("meal_options" , "meal_options.id" , "order_meals_options.option_id")
                        ->select(
                            "order_meals_options.added_price",
                            "meal_options.ar_name AS name"
                        )->get();
            $meal->options = $options;
        }

//		$data['sub_orders'] = get_table('sub_orders',['main_order_id'=>$id]);
//		$data['settings'] = get_this('settings',['id'=>1]);
		// $latitude = $data['order']['latitude'];
		// $langitude = $data['order']['langitude'];
		// $this->load->library('googlemaps');
		// $config['center'] = $latitude.', '.$langitude;
		// $config['zoom'] = 'auto';
		// $this->googlemaps->initialize($config);
		// $marker = array();
		// $marker['position'] = $latitude.', '.$langitude;
		// $this->googlemaps->add_marker($marker);
		// $data['map'] = $this->googlemaps->create_map();
		return view("admin_panel.orders.details" , $data);
		$this->load->view('admin_panel/blank',$data);
	}
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('categories');
			$this->session->set_flashdata('message',notify('تم حذف التصنيف بنجاح','success'));
			redirect('admin_panel/categories');
		}
	}
}
