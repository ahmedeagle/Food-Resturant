<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Validator;
class Branch extends Controller {

    function __construct()
    {

    }

    public function view($id){
		$data['title'] = 'عرض تفاصيل المطعم';
		$data['branch']  = DB::table("branches")
                            ->where("branches.id" , $id)
                            ->join("providers" , "providers.id" , "branches.provider_id")
                            ->join("categories" , "categories.id" , "providers.category_id")
                            ->join("congestion_settings" , "congestion_settings.id" , "branches.congestion_settings_id")
                            ->select(
                                        "branches.*",
                                        "providers.ar_name AS provider_ar_name",
                                        "categories.ar_name AS cat_name",
                                        "congestion_settings.ar_name AS cons_name"
                                    )
                            ->first();

        $rates = DB::table('rates')
            ->where('branch_id' ,$id)
            ->select(
                DB::raw("SUM(service) AS service_sum"),
                DB::raw("SUM(quality) AS quality_sum"),
                DB::raw("SUM(Cleanliness) AS cleanliness_sum"),
                DB::raw("COUNT(id) AS count")
            )->first();

        if($rates->count != 0){

            $s = $rates->service_sum / $rates->count;
            $q = $rates->quality_sum / $rates->count;
            $c = $rates->cleanliness_sum / $rates->count;

            $data['branch']->average_service_rate     = round($s);
            $data['branch']->average_quality_rate     = round($q);
            $data['branch']->average_cleanliness_rate = round($c);
            $data['branch']->total_average_rate = round(($s + $q + $c) / 3);
        }else{
            $data['branch']->average_service_rate     = 0.0;
            $data['branch']->average_quality_rate     = 0.0;
            $data['branch']->average_cleanliness_rate = 0.0;
            $data['branch']->total_average_rate = 0.0;
        }

		$avg = DB::table("meals")
                        ->where("branch_id" , $id)
                        ->select(
                            DB::raw("AVG('meals.price') AS average_price")
                        )->first();

        if($avg){
            $data['meal_avg'] = $avg->average_price;
        }else{
            $data['meal_avg'] = 0 ;
        }
		$data["branch_images"] = DB::table("branch_images")
                                    ->join("images" , "images.id" , "branch_images.image_id")
                                    ->where("branch_images.branch_id" , $id)
                                    ->select("images.name")
                                    ->get();




        $data["comments"] = DB::table("comments")
                            ->join("users" , "users.id" , "comments.user_id")
                            ->leftjoin("images" , "images.id" , "users.image_id")
                            ->where("branch_id" , $id)
                            ->select(
                                "comments.*",
                                "users.name AS username",
                                DB::raw("CONCAT('". url('/') ."','/storage/app/public/users/', images.name) AS user_image_url")
                            )
                            ->get();


        return view("admin_panel.branches.view", $data);
	}

	public function stop_comment($id){
        App()->setLocale("ar");
        $comment = DB::table("comments")
                        ->where("id", $id)
                        ->first();
        if(!$comment){
            return redirect("/admin/dashboard");
        }

        DB::table("comments")
                    ->where("id", $id)
                    ->update([
                        "stopped" => "1"
                    ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }
    public function play_comment($id){
        App()->setLocale("ar");
        $comment = DB::table("comments")
                    ->where("id", $id)
                    ->first();
        if(!$comment){
            return redirect("/admin/dashboard");
        }

        DB::table("comments")
            ->where("id", $id)
            ->update([
                "stopped" => "0"
            ]);
        return redirect()->back()->with("success", trans("messages.success"));
    }
}
