<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;

class Meals extends Controller
{

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
        foreach ($data['meals'] as $meal) {
            $image = DB::table("meal_images")
                ->join("images", "meal_images.image", "images.id")
                ->where("meal_images.meal_id", $meal->id)
                ->select(
                    "images.name AS image_url"
                )
                ->first();
            $meal->image_url = isset($image->image_url) ? $image->image_url : "";
        }

        return view("admin_panel.meals.list", $data);
    }

    public function view($id)
    {
        $data['title'] = 'عرض تفاصيل الوجبة';
        $data['meal'] = DB::table("meals")
            ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
            ->where("meals.id", $id)
            ->select("meals.*", "mealcategories.ar_name AS cat_name")
            ->first();
        $data["meal_images"] = DB::table("meal_images")
            ->join("images", "images.id", "meal_images.image")
            ->where("meal_images.meal_id", $id)
            ->select("images.name")
            ->get();
        $data['provider'] = DB::table("meals")
            ->join("branches", "meals.branch_id", "branches.id")
            ->join("providers", "providers.id", "branches.provider_id")
            ->join("images", "images.id", "providers.image_id")
            ->join("countries", "countries.id", "providers.country_id")
            ->join("cities", "cities.id", "providers.city_id")
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
            ->where("actor_id", $data['provider']->id)
            ->where("actor_type", "provider")
            ->first();
        $data["sizes"] = DB::table("meal_sizes")
            ->where("meal_id", $id)
            ->get();

        $data["adds"] = DB::table("meal_adds")
            ->where("meal_id", $id)
            ->get();

        $data["options"] = DB::table("meal_options")
            ->where("meal_id", $id)
            ->get();

        return view("admin_panel.meals.view", $data);
    }


    public function get_add()
    {
        //     App()->setLocale("ar");
        $data['title'] = " وجبة جديدة  ";
        $data['class'] = "page-template food-menu";
        $data['cats'] = DB::table("mealcategories")
            ->where("provider_id", auth("provider")->id())
            ->select(
                "id AS id",
                "ar_name AS name"
            )->get();

        $data['providers'] = DB::table("providers")
            ->select(
                "id",
                "ar_name AS name"
            )
            ->get();

        return view("admin_panel.meals.add", $data);
    }


    public function load_branches(Request $request)
    {
        $parent_id = 0;
        if ($request->parent_id) {
            $parent_id = $request->parent_id;
        }

        $branches = DB::table("branches")
            ->where('provider_id', $parent_id)
            ->select(
                "id",
                "ar_name AS name"
            )
            ->get();

        $categories = DB::table('mealcategories')->where('provider_id', $parent_id)->select(
            "id",
            "ar_name AS name"
        )
            ->get();

        $viewBranches = view('admin_panel.branches.branches', compact('branches'))->renderSections();
        $viewCategories = view('admin_panel.branches.footListCategories', compact('categories'))->renderSections();
        return response()->json([
            'branches' => $viewBranches['main'],
            'appendFootListCategories' => $viewCategories['main'],
        ]);
    }


    public function post_add_meal(Request $request)
    {
        // App()->setLocale("ar");

        $rules = [
            "ar_name" => "required",
            "en_name" => "required",
            "category" => "required|exists:mealcategories,id",
            "component" => "required",
            "available" => "required|in:0,1",
            "spicy" => "required|in:0,1",
            "vegetable" => "required|in:0,1",
            "gluten" => "required|in:0,1",
            "calorie" => "required|numeric",
            "ar_description" => "required",
            "en_description" => "required",
            "size1" => "required",
            "price1" => "required|numeric",
            "recommended" => "required|in:1,0",
        ];
        $messages = [
            "required" => 1,
            "category.exists" => 2,
            "in" => 3,
            "calorie.numeric" => 4,
            "price1.numeric" => 5,
        ];

        $msg = [
            1 => trans("messages.required"),
            2 => trans("messages.success"),
            3 => trans("messages.error"),
            4 => trans("provider.calorie_numeric"),
            5 => trans("provider.price_numeric"),
            6 => trans("messages.success"),
            7 => trans("messages.error"),
            8 => trans("messages.recommended_number")
        ];

        if ($request->input("spicy") == "1") {
            $rules['spicy-degree'] = "required";
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'errNum' => (int)$error, 'msg' => $msg[$error]]);
        }

        if ($request->input("recommended") == "1") {

            $recommend = DB::table("meals")
                ->where("mealCategory_id", $request->input("category"))
                ->where("recommend", "1")
                ->where("branch_id", $request->input("branch"))
                ->get();

            if (count($recommend) >= 3) {
                return response()->json(['status' => false, 'errNum' => 8, 'msg' => $msg[8]]);
            }
        }

        $data = [
            "ar_name" => $request->input("ar_name"),
            "en_name" => $request->input("en_name"),
            "ar_description" => $request->input("ar_description"),
            "en_description" => $request->input("en_description"),
            "calories" => $request->input("calorie"),
            "mealCategory_id" => $request->input("category"),
            "price" => $request->input("price1"),
            "recommend" => $request->input("recommended"),
            "available" => $request->input("available"),
            "spicy" => $request->input("spicy"),
            "vegetable" => $request->input("vegetable"),
            "gluten" => $request->input("gluten"),
        ];


        if ($request->input("spicy") == "1") {
            $data["spicy_degree"] = $request->input("spicy-degree");
        }

        if ($request->input("branch") != 0) {
            $data["branch_id"] = $request->input("branch");
            $allBranches = false;
            // insert meal data
            $meal = DB::table("meals")
                ->insertGetId(
                    $data
                );

            $this->storeMealData($meal, $request);
        } else {


            $allBranches = true;

            $branches = DB::table("branches")
                ->where("provider_id", $request->input("provider_id"))
                ->where("deleted", "0")
                ->where("published", "1")
                ->select('id')
                ->get();

            if (isset($branches) && $branches->count() > 0) {
                foreach ($branches as $branch) {

                    $data["branch_id"] = $branch->id;

                    // insert meal data
                    $meal = DB::table("meals")
                        ->insertGetId(
                            $data
                        );

                    if ($request->hasFile("0")) {

                        for ($i = 0; $i <= $request->input("count") - 1; $i++) {

                            $request->$i->store('meals', 'public');

                            $img_id = DB::table("images")
                                ->insertGetId([
                                    "name" => $request->$i->hashName()
                                ]);

                            DB::table("meal_images")
                                ->insert([
                                    "meal_id" => $meal,
                                    "image" => $img_id
                                ]);
                        }

                    }
                    $this->storeMealData($meal, $request);
                }
            }

        }

        $componentArr = explode(",", $request->input("component"));

        foreach ($componentArr as $c) {

            DB::table("meal_component")
                ->insert([
                    "ar_name" => (string)$c,
                    "en_name" => (string)$c,
                    "meal_id" => $meal
                ]);
        }

        if ($request->input("branch") != 0) {

            if ($request->hasFile("0")) {

                for ($i = 0; $i <= $request->input("count") - 1; $i++) {

                    $request->$i->store('meals', 'public');

                    $img_id = DB::table("images")
                        ->insertGetId([
                            "name" => $request->$i->hashName()
                        ]);

                    DB::table("meal_images")
                        ->insert([
                            "meal_id" => $meal,
                            "image" => $img_id
                        ]);
                }
            }
        }

        return response()->json(["status" => true, "errNum" => 0, "msg" => trans("messages.success")]);
    }


    public function storeMealData($meal, $request)
    {

        $this->add_meal_size($meal, $request->input("size1"), $request->input("size1_en"), $request->input("price1"));

        if ($request->filled("size2") && $request->filled("price2")) {
            $this->add_meal_size($meal, $request->input("size2"), $request->input("size2_en"), $request->input("price2"));
        }
        if ($request->filled("size3") && $request->filled("price3")) {
            $this->add_meal_size($meal, $request->input("size3"), $request->input("size3_en"), $request->input("price3"));
        }

        if ($request->filled("size4") && $request->filled("price4")) {
            $this->add_meal_size($meal, $request->input("size4"), $request->input("size4_en"), $request->input("price4"));
        }

        if ($request->filled("size5") && $request->filled("price5")) {
            $this->add_meal_size($meal, $request->input("size5"), $request->input("size5_en"), $request->input("price5"));
        }

        if ($request->filled("add1") && $request->filled("add-price1")) {

            $this->add_meal_adds($meal, $request->input("add1"), $request->input("add1_en"), $request->input("add-price1"));
        }

        if ($request->filled("add2") && $request->filled("add-price2")) {
            $this->add_meal_adds($meal, $request->input("add2"), $request->input("add2_en"), $request->input("add-price2"));
        }
        if ($request->filled("add3") && $request->filled("add-price3")) {
            $this->add_meal_adds($meal, $request->input("add3"), $request->input("add3_en"), $request->input("add-price3"));
        }
        if ($request->filled("add4") && $request->filled("add-price4")) {
            $this->add_meal_adds($meal, $request->input("add4"), $request->input("add4_en"), $request->input("add-price4"));
        }
        if ($request->filled("add5") && $request->filled("add-price5")) {
            $this->add_meal_adds($meal, $request->input("add5"), $request->input("add5_en"), $request->input("add-price5"));
        }


        if ($request->filled("option1") && $request->filled("option-price1")) {
            $this->add_meal_options($meal, $request->input("option1"), $request->input("option1_en"), $request->input("option-price1"));
        }

        if ($request->filled("option2") && $request->filled("option-price2")) {
            $this->add_meal_options($meal, $request->input("option2"), $request->input("option2_en"), $request->input("option-price2"));
        }
        if ($request->filled("option3") && $request->filled("option-price3")) {
            $this->add_meal_options($meal, $request->input("option3"), $request->input("option3_en"), $request->input("option-price3"));
        }
        if ($request->filled("option4") && $request->filled("option-price4")) {
            $this->add_meal_options($meal, $request->input("option4"), $request->input("option4_en"), $request->input("option-price4"));
        }
        if ($request->filled("option5") && $request->filled("option-price5")) {
            $this->add_meal_options($meal, $request->input("option5"), $request->input("option5_en"), $request->input("option-price5"));
        }

    }


    public function get_edit($id)
    {

        $data["meal"] = DB::table("meals")
            ->join("mealcategories", "mealcategories.id", "meals.mealCategory_id")
            ->where("meals.id", $id)
            ->select(
                "meals.*",
                "mealcategories.id AS cat_id",
                "mealcategories.ar_name AS cat_name"
            )->first();

        if (!$data['meal']) {
            return redirect("/admin/dashboard");
        }

        $data["images"] = DB::table("meal_images")
            ->join("images", "images.id", "meal_images.image")
            ->where("meal_images.meal_id", $id)
            ->select(
                "images.id AS image_id",
                DB::raw("CONCAT('" . url('/') . "','/storage/app/public/meals/', images.name) AS meal_image_url")
            )->get();

        $data['sizes'] = DB::table("meal_sizes")
            ->where("meal_id", $id)
            ->select(
                "id AS size_id",
                "ar_name AS size_name",
                "price AS price"
            )->get();


        $data['cats'] = DB::table("mealcategories")
            ->select(
                "id AS id",
                "ar_name AS name"
            )->get();

        $data['providers'] = DB::table("providers")
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
        foreach ($component as $key => $c) {

            $delimeter = ($key == "") ? "" : ",";
            $data["component"] .= $delimeter . $c->name;
        }
        $data['title'] = "تعديل الوجبة";
        return view("admin_panel.meals.edit", $data);
    }

    public function post_edit(Request $request)
    {


        App()->setLocale("ar");

        $rules = [
            "ar_name" => "required",
            "en_name" => "required",
            "cat" => "required|exists:mealcategories,id",
            "available" => "required|in:0,1",
            "spicy" => "required|in:0,1",
            "vegetable" => "required|in:0,1",
            "gluten" => "required|in:0,1",
            "calorie" => "required|numeric",
            "ar_description" => "required",
            "en_description" => "required",
            "size1" => "required",
            "price1" => "required|numeric",
            "recommended" => "required|in:0,1",
        ];
        $messages = [
            "required" => trans("messages.required"),
            "cat.exists" => trans("messages.success"),
            "in" => trans("messages.error"),
            "calorie.numeric" => trans("provider.calorie_numeric"),
            "price1.numeric" => trans("provider.price_numeric"),
        ];

        $msg = [

        ];

        if ($request->input("spicy") == "1") {
            $rules['spicy-degree'] = "required";
        }
        $this->validate($request, $rules, $messages);


        $meal = $request->input("meal_id");

        // insert meal data

        $data = [
            "ar_name" => $request->input("ar_name"),
            "en_name" => $request->input("en_name"),
            "ar_description" => $request->input("ar_description"),
            "en_description" => $request->input("en_description"),
            "calories" => $request->input("calorie"),
            "mealCategory_id" => $request->input("cat"),
            "price" => $request->input("price1"),
            "recommend" => $request->input("recommended"),
            "available" => $request->input("available"),
            "spicy" => $request->input("spicy"),
            "vegetable" => $request->input("vegetable"),
            "gluten" => $request->input("gluten"),
        ];

        if ($request->input("spicy") == "1") {
            $data["spicy_degree"] = $request->input("spicy-degree");
        } else {
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

        if ($request->input("size2") && $request->input("price2")) {
            $this->add_meal_size($meal, $request->input("size2"), $request->input("price2"));
        }
        if ($request->input("size3") && $request->input("price3")) {
            $this->add_meal_size($meal, $request->input("size3"), $request->input("price3"));
        }

        if ($request->input("size4") && $request->input("price4")) {
            $this->add_meal_size($meal, $request->input("size4"), $request->input("price4"));
        }

        if ($request->input("size5") && $request->input("price5")) {
            $this->add_meal_size($meal, $request->input("size5"), $request->input("price5"));
        }

        // delete meal adds
        DB::table("meal_adds")
            ->where("meal_id", $meal)
            ->delete();

        if ($request->input("add1") && $request->input("add-price1")) {
            $this->add_meal_adds($meal, $request->input("add1"), $request->input("add-price1"));
        }

        if ($request->input("add2") && $request->input("add-price2")) {
            $this->add_meal_adds($meal, $request->input("add2"), $request->input("add-price2"));
        }
        if ($request->input("add3") && $request->input("add-price3")) {
            $this->add_meal_adds($meal, $request->input("add3"), $request->input("add-price3"));
        }
        if ($request->input("add4") && $request->input("add-price4")) {
            $this->add_meal_adds($meal, $request->input("add4"), $request->input("add-price4"));
        }
        if ($request->input("add5") && $request->input("add-price5")) {
            $this->add_meal_adds($meal, $request->input("add5"), $request->input("add-price5"));
        }


        // delete meal options
        DB::table("meal_options")
            ->where("meal_id", $meal)
            ->delete();

        if ($request->input("option1") && $request->input("option-price1")) {
            $this->add_meal_options($meal, $request->input("option1"), $request->input("option-price1"));
        }

        if ($request->input("option2") && $request->input("option-price2")) {
            $this->add_meal_options($meal, $request->input("option2"), $request->input("option-price2"));
        }
        if ($request->input("option3") && $request->input("option-price3")) {
            $this->add_meal_options($meal, $request->input("option3"), $request->input("option-price3"));
        }
        if ($request->input("option4") && $request->input("option-price4")) {
            $this->add_meal_options($meal, $request->input("option4"), $request->input("option-price4"));
        }
        if ($request->input("option5") && $request->input("option-price5")) {
            $this->add_meal_options($meal, $request->input("option5"), $request->input("option-price5"));
        }


        return redirect("/admin/meals")->with("success", trans("messages.success"));
    }

    protected function add_meal_size($meal_id, $ar_name, $en_name, $price)
    {
        DB::table("meal_sizes")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "price" => $price
            ]);
    }

    protected function add_meal_adds($meal_id, $ar_name, $en_name, $price)
    {
        DB::table("meal_adds")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "added_price" => $price
            ]);
    }

    protected function add_meal_options($meal_id, $ar_name, $en_name, $price)
    {
        DB::table("meal_options")
            ->insert([
                "meal_id" => $meal_id,
                "ar_name" => $ar_name,
                "en_name" => $en_name,
                "added_price" => $price
            ]);
    }

    public function delete($id)
    {
        if ($id) {
            $this->db->where('id', $id)->delete('categories');
            $this->session->set_flashdata('message', notify('تم حذف التصنيف بنجاح', 'success'));
            redirect('admin_panel/categories');
        }
    }

    public function stop($id)
    {
        App()->setLocale('ar');

        if (!auth("admin")->check()) {
            return redirect("/");
        }

        DB::table("meals")
            ->where("id", $id)
            ->update([
                "published" => "0"
            ]);

        return redirect()->back()->with("success", trans("messages.success"));

    }

    public function publish($id)
    {
        App()->setLocale('ar');

        if (!auth("admin")->check()) {
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
