<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class OfferController extends Controller
{
    // get all offers
    public function get_offers(Request $request){
        (new BaseConroller())->setLang($request);
        $name   = (App()->getLocale() == 'ar') ? 'ar' : 'en';
        $offers = DB::table("offers")
                    ->join("images", "images.id" , "offers.image_id")
                    ->join("providers", "providers.id" , "offers.provider_id")
                     ->join("branches", "providers.id" , "branches.provider_id")
                    ->where("offers.approved" , "1")
                    ->select(
                        "offers.provider_id",
                        "offers." .$name . "_title AS title",
                        "branches." .$name . "_address AS address",
                        "branches.id AS branch_id",
                        "offers.lft",
                        DB::raw("CONCAT('". url('/') ."','/storage/app/public/offers/', images.name) AS image_url"),
                        "providers.accept_order"
                    )
                    ->orderBy("offers.lft")
                    ->paginate(10);
      $offers = (new HomeController)->filter_offers_branches($request,$name,$offers);
        return response()->json([
            "status"      => true ,
            "errNum"      => 0,
            "msg"         => trans("messages.success"),
            "offers"      => $offers
        ]);
    }
}
