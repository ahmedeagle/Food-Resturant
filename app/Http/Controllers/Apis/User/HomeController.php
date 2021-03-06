<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GoogleTranslate;

class HomeController extends Controller
{
    //get home page screen data
    public function get_home_page(Request $request)
    {

        (new BaseConroller())->setLang($request);

        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';

        $cats = $this->getSubCategoriesList($name, 7);

         $offers = $this->getOffersList($request, $name);

        //get nearst provider branches 
        $providersList = $this->getProvidersList($request, $name, 7);

        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';

        if ($request->input("access_token")) {
            $user = DB::table("users")
                ->where("token", $request->input("access_token"))
                ->select("*")
                ->first();
            if (!$user) {
                return response()->json(["status" => false,
                    "errNum" => 1,
                    "msg" => trans('messages.error')
                ]);
            }
            $notifications = DB::table("notifications")
                ->where("actor_id", $user->id)
                ->where("actor_type", "user")
                ->where("seen", "0")
                ->count();

            $admin_notification = DB::table("admin_notifications_receivers")
                ->join("admin_notifications", "admin_notifications.id", "admin_notifications_receivers.notification_id")
                ->where("admin_notifications.type", "users")
                ->where("admin_notifications_receivers.actor_id", $user->id)
                ->where("admin_notifications_receivers.seen", "0")
                ->count();

            $notifications_number = (int)$notifications + (int)$admin_notification;
        } else {
            $notifications_number = 0;
        }

        return response()->json(["status" => true,
            "errNum" => 0,
            "msg" => trans('messages.success'),
            "notifications_number" => $notifications_number,
            "cats" => $cats,
            "offers" => $offers,
            "providers" => $providersList
        ]);
    }

    public function getSubCategoriesList($name, $limit = null)
    {
        return DB::table('subcategories')
            ->join('images', 'images.id', 'subcategories.image_id')
            ->select(
                "subcategories.id",
                "subcategories." . $name . "_name AS name",
                DB::raw("CONCAT('" . url('/') . "','/storage/app/public/subcategories/', images.name) AS image_url")
            )
            ->take($limit)
            ->orderBy("subcategories.id", "DESC")
            ->get();
    }

    protected function getOffersList(Request $request, $name)
    {
        $offers = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->join("providers", "providers.id", "offers.provider_id")
            ->join("branches", "providers.id", "branches.provider_id")
            ->join("offers_branches", "branches.id", "offers_branches.branch_id")
            ->where("offers.approved", "1")
            ->where("branches.published",'1')
            ->where("providers.accept_order",'1')
            ->select(
                "branches.id AS branch_id",
                "branches.longitude",
                "branches.latitude",
                "branches." . $name . "_address AS address",
                "offers.provider_id",
                "offers.id as offer_id",
                "offers.lft",
                "offers." . $name . "_title AS title",
                "branches." . $name . "_name AS restaurant_name",
                "offers." . $name . "_notes AS notes",

                DB::raw("CONCAT('" . url('/') . "','/storage/app/public/offers/', images.name) AS image_url"),
                "providers.accept_order"
            )
            ->orderBy("offers.lft")
            ->get();

        $_offers = $offers->groupBy('offer_id');
        $offers = $this->filter_offers_branches_app($request, $name, $_offers);

        return $offers;

    }

    public function filter_offers_branches(Request $request, $name, $branches)
    {
        $data = [];
        foreach ($branches as $key => $_branch) {


            /*if( $name == 'en'){

                   $branch -> address =   (new GoogleTranslate()) -> setSourceLang('ar')
                             ->setTargetLang('en')
                             ->translate($branch -> address );
                }*/



            if ($request->input('latitude') && $request->input('longitude')) {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
                $distance = (new BaseConroller())->getDistance($_branch->longitude, $_branch->latitude, $longitude, $latitude, "KM");
            } else {
                $distance = -1;
            }
          //  $first_branch->distance = $distance;

            $dataarr = [
                "restaurant_id" => $_branch->branch_id,
                "address" => $_branch->address,
                "restaurant_name" => isset($_branch->restaurant_name) ? $_branch->restaurant_name : "",
                "title" => $_branch->title,
                "image_url" => $_branch->image_url,
                "notes" => $_branch->notes,
                "accept_order" => $_branch->accept_order,
                "distance" => $distance,
             ];

            $data[] = $dataarr;
        }

        return $data;
    }

    public function filter_offers_branches_app(Request $request, $name, $branches)
    {
        $data = [];
        foreach ($branches as $key => $_branch) {

            $collect = collect($_branch);
            $first_branch = $collect->first();

            if ($request->input('latitude') && $request->input('longitude')) {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
                $distance = (new BaseConroller())->getDistance($first_branch->longitude, $first_branch->latitude, $longitude, $latitude, "KM");
            } else {
                $distance = -1;
            }
            //  $first_branch->distance = $distance;

            $dataarr = [
                "restaurant_id" => $first_branch->branch_id,
                "address" => $first_branch->address,
                "restaurant_name" => isset($first_branch->restaurant_name) ? $first_branch->restaurant_name : "",
                "title" => $first_branch->title,
                "image_url" => $first_branch->image_url,
                "notes" => $first_branch->notes,
                "accept_order" => $first_branch->accept_order,
                "distance" => $distance,
                "offer_id" => $first_branch->offer_id
            ];

            $data[] = $dataarr;
        }

        return $data;
    }

    public
    function getProvidersList(Request $request, $name)
    {

       // $providersHasBranches = DB::table('providers')->join('branches', 'providers.id', '=', 'branches.provider_id')
         //   ->where("branches.published", "1")->select('providers.id')->distinct()->get();


        $providers = DB::table("providers")
            ->join("images", "images.id", "providers.image_id")
            ->join('branches', 'branches.provider_id', '=', 'providers.id')
            // ->where("providers.phoneactivated" , "1")
            ->where("providers.accountactivated", "1")
            ->where("branches.published", "1")
            ->where("providers.accept_order",'1')
            ->select(
                "providers.id AS provider_id",
                "branches.id AS id",
                "branches.id AS id",
                "branches.has_delivery",
                "branches.has_booking",
                "branches.longitude",
                "branches.latitude",
                "branches.ar_address AS address",
                "branches.average_price AS mealAveragePrice",
                DB::raw("CONCAT(providers ." . $name . "_name,'-',branches ." . $name . "_name) AS name"),
                DB::raw("CONCAT('" . url('/') . "','/storage/app/public/providers/', images.name) AS image_url")
            )
            ->take(17)
            ->get();


        $this->filter_providers_branches($request, $name, $providers);

        // filter based on distance
        $providers = $providers->sortBy(function ($item) {
            return $item->distance;
        })->values();


        return $providers;
    }

    public
    function filter_providers_branches(Request $request, $name, $providers, $type = 0)
    {
        //
        foreach ($providers as $branch) {


            /* if( $name == 'en'){

                    $branch -> address =   (new GoogleTranslate()) -> setSourceLang('ar')
                              ->setTargetLang('en')
                              ->translate($branch -> address );
                 }*/


            $rates = DB::table('rates')
                ->where('rates.branch_id', $branch->id)
                ->select(
                    DB::raw("COUNT(rates.id) AS number_of_rates"),
                    DB::raw("SUM(rates.service) AS sum_of_service"),
                    DB::raw("SUM(rates.quality) AS sum_of_quality"),
                    DB::raw("SUM(rates.Cleanliness) AS sum_of_Cleanliness")
                )
                ->first();

            $numberOfRates = $rates->number_of_rates;
            $serviceRate = $rates->sum_of_service;
            $qualityRate = $rates->sum_of_quality;
            $cleanRate = $rates->sum_of_Cleanliness;
            if ($numberOfRates != 0 && $numberOfRates != null) {
                $totalAverage = round((($serviceRate / $numberOfRates) + ($qualityRate / $numberOfRates) + ($cleanRate / $numberOfRates)) / 3);


            } else {
                $totalAverage = 0;
            }
            $meals = DB::table("meals")
                ->where("meals.branch_id", $branch->id)
                ->where("meals.published", "1")
                ->select(
                    DB::raw("COUNT(meals.id) AS number_of_meals"),
                    DB::raw("SUM(meals.price) AS sum_of_price")
                )
                ->first();
            if ($meals->number_of_meals != 0 && $meals->number_of_meals != null) {
                $priceAverage = round((double)($meals->sum_of_price / $meals->number_of_meals));
            } else {
                $priceAverage = 0;
            }

            $branch->mealAveragePrice = $priceAverage;
            $branch->averageRate = $totalAverage;

            if ($request->input('latitude') && $request->input('longitude')) {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');
                $distance = (new BaseConroller())->getDistance($branch->longitude, $branch->latitude, $longitude, $latitude, "KM");
            } else {
                $distance = -1;
            }

            $branch->distance = $distance;

            $branch->has_delivery = $branch->has_delivery;
            $branch->has_booking = $branch->has_booking;
            $branch->averageRate = $branch->averageRate;
            unset($branch->provider_id);
            unset($branch->provider_name);
            unset($branch->providertypeId);
            unset($branch->foodcategoryIds);
            unset($branch->foodtypeIds);
            unset($branch->featureIds);
            // $provider->id               = $branch->branch_id;
            //  $branch->distance         =   (new GeneralController())->numberTranslator( $distance,App()->getLocale());

        }
    }


    public
    function filter_providers_branches_by_distance(Request $request, $name, $providers, $type = 0)
    {
        foreach ($providers as $key => $provider) {
            $branches = DB::table('branches')
                ->where("branches.provider_id", $provider->provider_id)
                ->where("branches.published", "1")
                ->select(
                    "branches.id AS id",
                    "branches.has_delivery",
                    "branches.has_booking",
                    "branches.longitude",
                    "branches.latitude",
                    "branches." . $name . "_address AS address",
                    "branches.average_price AS mealAveragePrice"
                )
                ->orderBy('branches.id', 'DESC')
                ->get();

            if (count($branches) == 0) {
                unset($providers[$key]);
                continue;
            }
            foreach ($branches as $branch) {
                $rates = DB::table('rates')
                    ->where('rates.id', $branch->id)
                    ->select(
                        DB::raw("COUNT(rates.id) AS number_of_rates"),
                        DB::raw("SUM(rates.service) AS sum_of_service"),
                        DB::raw("SUM(rates.quality) AS sum_of_quality"),
                        DB::raw("SUM(rates.Cleanliness) AS sum_of_Cleanliness")
                    )
                    ->first();
                $numberOfRates = $rates->number_of_rates;
                $serviceRate = $rates->sum_of_service;
                $qualityRate = $rates->sum_of_quality;
                $cleanRate = $rates->sum_of_Cleanliness;
                if ($numberOfRates != 0 && $numberOfRates != null) {
                    $totalAverage = (($serviceRate / $numberOfRates) + ($qualityRate / $numberOfRates) + ($cleanRate / $numberOfRates)) / 3;
                } else {
                    $totalAverage = 0;
                }
                $meals = DB::table("meals")
                    ->where("meals.branch_id", $branch->id)
                    ->where("meals.published", "1")
                    ->select(
                        DB::raw("COUNT(meals.id) AS number_of_meals"),
                        DB::raw("SUM(meals.price) AS sum_of_price")
                    )
                    ->first();
                if ($meals->number_of_meals != 0 && $meals->number_of_meals != null) {
                    $priceAverage = round((double)($meals->sum_of_price / $meals->number_of_meals));
                } else {
                    $priceAverage = 0;
                }

                $branch->mealAveragePrice = $priceAverage;
                $branch->averageRate = $totalAverage;

                if ($request->input('latitude') && $request->input('longitude')) {
                    $latitude = $request->input('latitude');
                    $longitude = $request->input('longitude');
                    $distance = (new BaseConroller())->getDistance($branch->longitude, $branch->latitude, $longitude, $latitude, "KM");
                } else {
                    $distance = -1;
                }

                $branch->distance = $distance;

                $provider->has_delivery = $branch->has_delivery;
                $provider->has_booking = $branch->has_booking;
                $provider->mealAveragePrice = $branch->mealAveragePrice;
                $provider->averageRate = $branch->averageRate;
                unset($provider->provider_id);
                $provider->id = $branch->id;
                $provider->distance = $branch->distance;

            }
        }
    }


}
