<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Meals extends Controller {

    function __construct()
    {

    }
	public function index()
	{
        $data['title'] = 'الوجبات';
        $data['meals'] = DB::table("meals")
                            ->join("branches", "branches.id", "meals.branch_id")
                            ->join("providers", "providers.id", "branches.provider_id")
                            ->select(
                                "meals.*",
                                "providers.ar_name AS provider_name"
                            )
                            ->get();
        foreach($data['meals'] as $meal){
            $image = DB::table("meal_images")
                        ->join("images", "meal_images.image" , "images.id")
                        ->where("meal_images.meal_id" , $meal->id)
                        ->select(
                            "images.name AS image_url"
                        )
                        ->first();
            $meal->image_url = $image->image_url;
        }

        return view("admin_panel.meals.list" , $data);
    }
    public function view($id){
		$data['title'] = 'عرض تفاصيل الوجبة';
		$data['meal']  = DB::table("meals")
                            ->join("mealcategories" , "mealcategories.id" , "meals.mealCategory_id")
                            ->where("meals.id" , $id)
                            ->select("meals.*" , "mealcategories.ar_name AS cat_name")
                            ->first();
		$data["meal_images"] = DB::table("meal_images")
                                    ->join("images" , "images.id" , "meal_images.image")
                                    ->where("meal_images.meal_id" , $id)
                                    ->select("images.name")
                                    ->get();
        $data['provider'] = DB::table("meals")
                                ->join("branches" , "meals.branch_id" , "branches.id")
                                ->join("providers" , "providers.id" , "branches.provider_id")
                                ->join("images" , "images.id" , "providers.image_id")
                                ->join("countries" , "countries.id" , "providers.country_id")
                                ->join("cities" , "cities.id" , "providers.city_id")
                                ->select(
                                    "providers.ar_name",
                                    "providers.id",
                                    "providers.phone",
                                    "providers.email",
                                    "providers.en_name",
                                    "providers.phoneactivated",
                                    "providers.accountactivated",
                                    "images.name AS provider_image_url",
                                    "countries.ar_name AS country_name",
                                    "cities.ar_name AS city_name",
                                    "providers.created_at",
                                    "providers.order_app_percentage",
                                    "providers.has_subscriptions",
                                    "providers.subscriptions_amount",
                                    "providers.subscriptions_period"
                                )->first();
        $data['provider_balances'] = DB::table("balances")
                                        ->where("actor_id" , $data['provider']->id)
                                        ->where("actor_type" , "provider")
                                        ->first();
        $data["sizes"] = DB::table("meal_sizes")
                            ->where("meal_id" , $id)
                            ->get();

        $data["adds"] = DB::table("meal_adds")
                            ->where("meal_id" , $id)
                            ->get();

        $data["options"] = DB::table("meal_options")
                            ->where("meal_id" , $id)
                            ->get();

        return view("admin_panel.meals.view", $data);
	}

	public function get_edit($id){

        $data["meal"] = DB::table("meals")
            ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
            ->where("meals.id", $id)
            ->select(
                "meals.*",
                "mealcategories.id AS cat_id",
                "mealcategories.ar_name AS cat_name"
            )->first();

        if(!$data['meal']){
            return redirect("/admin/dashboard");
        }

        $data["images"] = DB::table("meal_images")
                            ->join("images", "images.id", "meal_images.image")
                            ->where("meal_images.meal_id", $id)
                            ->select(
                                "images.id AS image_id",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/meals/', images.name) AS meal_image_url")
                            )->get();

        $data['sizes'] = DB::table("meal_sizes")
            ->where("meal_id", $id)
            ->select(
                "id AS size_id",
                "ar_name AS size_name",
                "price AS price"
            )->get();


        $data['cats']  = DB::table("mealcategories")
                            ->select(
                                "id AS id",
                                "ar_name AS name"
                            )->get();

        $data['branches'] = DB::table("branches")
            ->where("provider_id", auth("provider")->id())
            ->select(
                "id",
                "ar_name AS name"
            )
            ->get();

        $component = DB::table("meal_component")
            ->where("meal_id", $id)
            ->select(
                "ar_name AS name"
            )->get();

        $data['adds'] = DB::table("meal_adds")
            ->where("meal_id", $id)
            ->select(
                "id AS add_id",
                "ar_name AS name",
                "added_price AS price"
            )->get();


        $data['options'] = DB::table("meal_options")
            ->where("meal_id", $id)
            ->select(
                "id AS option_id",
                "ar_name AS name",
                "added_price AS price"
            )->get();

        $data['component'] = "";
        foreach ($component as $key => $c){

            $delimeter = ($key == "") ? "" : ",";
            $data["component"] .= $delimeter . $c->name;
        }
        $data['title'] = "تعديل الوجبة";
        return view("admin_panel.meals.edit", $data);
    }
    public function post_edit(Request $request){
        
         
         App()->setLocale("ar");

        $rules = [
            "ar_name"           => "required",
            "en_name"           => "required",
            "cat"          => "required|exists:mealcategories,id",
            "available"         => "required|in:0,1",
            "spicy"             => "required|in:0,1",
            "vegetable"         => "required|in:0,1",
            "gluten"            => "required|in:0,1",
            "calorie"           => "required|numeric",
            "ar_description"    => "required",
            "en_description"    => "required",
            "size1"             => "required",
            "price1"            => "required|numeric",
            "recommended"       => "required|in:0,1",
        ];
        $messages = [
            "required"              => trans("messages.required"),
            "cat.exists"            => trans("messages.success"),
            "in"                    => trans("messages.error"),
            "calorie.numeric"       => trans("provider.calorie_numeric"),
            "price1.numeric"        => trans("provider.price_numeric"),
        ];

        $msg = [
       
        ];

        if($request->input("spicy") == "1"){
            $rules['spicy-degree'] = "required";
        }
         $this->validate($request, $rules , $messages);
         
          
        $meal = $request->input("meal_id");
 
        // insert meal data

        $data = [
            "ar_name"           => $request->input("ar_name"),
            "en_name"           => $request->input("en_name"),
            "ar_description"    => $request->input("ar_description"),
            "en_description"    => $request->input("en_description"),
            "calories"          => $request->input("calorie"),
            "mealCategory_id"   => $request->input("cat"),
            "price"             => $request->input("price1"),
            "recommend"         => $request->input("recommended"),
            "available"         => $request->input("available"),
            "spicy"             => $request->input("spicy"),
            "vegetable"         => $request->input("vegetable"),
            "gluten"            => $request->input("gluten"),
        ];

        if($request->input("spicy") == "1"){
            $data["spicy_degree"] = $request->input("spicy-degree");
        }else{
            $data['spicy_degree'] = 0;
        }



         DB::table("meals")
                    ->where("id", $meal)
                    ->update($data);


        // delete meal sizes
        DB::table("meal_sizes")
                    ->where("meal_id", $meal)
                    ->delete();

        $this->add_meal_size($meal, $request->input("size1"), $request->input("price1"));

        if($request->input("size2") && $request->input("price2")) {
            $this->add_meal_size($meal, $request->input("size2"), $request->input("price2"));
        }
        if($request->input("size3") && $request->input("price3")) {
            $this->add_meal_size($meal, $request->input("size3"), $request->input("price3"));
        }

        if($request->input("size4") && $request->input("price4")) {
            $this->add_meal_size($meal, $request->input("size4"), $request->input("price4"));
        }

        if($request->input("size5") && $request->input("price5")) {
            $this->add_meal_size($meal, $request->input("size5"), $request->input("price5"));
        }

        // delete meal adds
        DB::table("meal_adds")
            ->where("meal_id", $meal)
            ->delete();

        if($request->input("add1") && $request->input("add-price1")) {
            $this->add_meal_adds($meal, $request->input("add1"), $request->input("add-price1"));
        }

        if($request->input("add2") && $request->input("add-price2")) {
            $this->add_meal_adds($meal, $request->input("add2"), $request->input("add-price2"));
        }
        if($request->input("add3") && $request->input("add-price3")) {
            $this->add_meal_adds($meal, $request->input("add3"), $request->input("add-price3"));
        }
        if($request->input("add4") && $request->input("add-price4")) {
            $this->add_meal_adds($meal, $request->input("add4"), $request->input("add-price4"));
        }
        if($request->input("add5") && $request->input("add-price5")) {
            $this->add_meal_adds($meal, $request->input("add5"), $request->input("add-price5"));
        }


        // delete meal options
        DB::table("meal_options")
            ->where("meal_id", $meal)
            ->delete();

        if($request->input("option1") && $request->input("option-price1")) {
            $this->add_meal_options($meal, $request->input("option1"), $request->input("option-price1"));
        }

        if($request->input("option2") && $request->input("option-price2")) {
            $this->add_meal_options($meal, $request->input("option2"), $request->input("option-price2"));
        }
        if($request->input("option3") && $request->input("option-price3")) {
            $this->add_meal_options($meal, $request->input("option3"), $request->input("option-price3"));
        }
        if($request->input("option4") && $request->input("option-price4")) {
            $this->add_meal_options($meal, $request->input("option4"), $request->input("option-price4"));
        }
        if($request->input("option5") && $request->input("option-price5")) {
            $this->add_meal_options($meal, $request->input("option5"), $request->input("option-price5"));
        }

       
        return redirect("/admin/meals")->with("success", trans("messages.success"));
    }
    
    
        protected function add_meal_size($meal_id, $ar_name, $price, $en_name = ""){
        DB::table("meal_sizes")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "price"   => $price
            ]);
    }

    protected function add_meal_adds($meal_id, $ar_name, $price, $en_name = ""){
        DB::table("meal_adds")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "added_price"   => $price
            ]);
    }

    protected function add_meal_options($meal_id, $ar_name, $price, $en_name = ""){
        DB::table("meal_options")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "added_price"   => $price
            ]);
    }
    
    public function delete($id){
		if ($id) {
			$this->db->where('id',$id)->delete('categories');
			$this->session->set_flashdata('message',notify('تم حذف التصنيف بنجاح','success'));
			redirect('admin_panel/categories');
		}
	}
    public function stop($id){
        App()->setLocale('ar');

        if(!auth("admin")->check()){
            return redirect("/");
        }

        DB::table("meals")
            ->where("id", $id)
            ->update([
                "published" => "0"
            ]);

        return redirect()->back()->with("success", trans("messages.success"));

    }

    public function publish($id){
        App()->setLocale('ar');

        if(!auth("admin")->check()){
            return redirect("/");
        }

        DB::table("meals")
            ->where("id", $id)
            ->update([
                "published" => "1"
            ]);

        return redirect()->back()->with("success", trans("messages.success"));
    }
}
