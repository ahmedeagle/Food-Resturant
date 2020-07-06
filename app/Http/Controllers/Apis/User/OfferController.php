<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class OfferController extends Controller
{
    // get all offers
    public function get_offers(Request $request)
    {
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        $offers = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->join("providers", "providers.id", "offers.provider_id")
            ->join("branches", "providers.id", "branches.provider_id")
            ->join("offers_branches", "branches.id", "offers_branches.branch_id")
            ->where("offers.approved", "1")
            ->select(
                "offers.provider_id",
                "branches." . $name . "_name AS title",
                "offers." . $name . "_notes AS notes",
                "branches." . $name . "_address AS address",
                "providers." . $name . "_name AS restaurant_name",
                "branches.id AS branch_id",
                "offers.lft",
                DB::raw("CONCAT('" . url('/') . "','/storage/app/public/offers/', images.name) AS image_url"),
                "providers.accept_order"
            )
            ->orderBy("offers.lft")
            ->paginate(10);
        $offers = (new HomeController)->filter_offers_branches($request, $name, $offers);
        return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg" => trans("messages.success"),
            "offers" => $offers
        ]);
    }

    public function get_offersApp(Request $request)
    {
        (new BaseConroller())->setLang($request);
        $name = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        $offers = DB::table("offers")
            ->join("images", "images.id", "offers.image_id")
            ->join("providers", "providers.id", "offers.provider_id")
            ->join("branches", "providers.id", "branches.provider_id")
            ->join("offers_branches", "branches.id", "offers_branches.branch_id")
            ->where("offers.approved", "1")
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


        $offers = (new HomeController)->filter_offers_branches_app($request, $name, $_offers);
        return response()->json([
            "status" => true,
            "errNum" => 0,
            "msg" => trans("messages.success"),
            "offers" => $offers
        ]);
    }

}
