<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class HelperController extends Controller
{
    public function filter_providers_branches_by_rate($providers){
        foreach($providers as $key => $provider){
            $branches = DB::table('branches')
                ->where("branches.provider_id" , $provider->provider_id)
                ->where("branches.published" , "1")
                ->select(
                    "branches.id AS branch_id",
                    "branches.has_delivery",
                    "branches.has_booking",
                    "branches.longitude",
                    "branches.latitude",
                    "branches.ar_address AS address",
                    "branches.average_price AS mealAveragePrice"
                )
                ->orderBy('branches.id', 'DESC')
                ->get();
            if(count($branches) == 0){
                unset($providers[$key]);
                continue;
            }
            foreach ($branches as $branch){
                $rates = DB::table('rates')
                    ->where('rates.branch_id' , $branch->branch_id)
                    ->select(
                        DB::raw("COUNT(rates.id) AS number_of_rates"),
                        DB::raw("SUM(rates.service) AS sum_of_service"),
                        DB::raw("SUM(rates.quality) AS sum_of_quality"),
                        DB::raw("SUM(rates.Cleanliness) AS sum_of_Cleanliness")
                    )
                    ->first();
                $numberOfRates = $rates->number_of_rates;
                $serviceRate   = $rates->sum_of_service;
                $qualityRate   = $rates->sum_of_quality;
                $cleanRate     = $rates->sum_of_Cleanliness;
                if($numberOfRates != 0 && $numberOfRates != null){
                    $totalAverage  = ( ($serviceRate/$numberOfRates) + ($qualityRate/$numberOfRates) + ($cleanRate/$numberOfRates) ) /3;
                }else{
                    $totalAverage = 0;
                }

                $branch->averageRate = $totalAverage;

                $meals = DB::table("meals")
                    ->where("branch_id" , $branch->branch_id)
                    ->where("published" , 1)
                    ->where("deleted" , 0)
                    ->select(DB::raw("AVG(price) AS average_price"))
                    ->first();

                $branch->mealAveragePrice = ($meals->average_price == null) ? 0 : round((double) $meals->average_price);

                $branch->distance = -1;
            }

            $selectIndex = -1;
            $rate        = -1;
            foreach($branches as $key => $value){
                if($selectIndex == -1){
                    $selectIndex = 0;
                    $rate        = $value->averageRate;
                }else{
                    if($value->averageRate > $rate){
                        $selectIndex = $key;
                        $rate = $value->averageRate;
                    }
                }
            }

            $provider->has_delivery     = $branches[$selectIndex]->has_delivery;
            $provider->has_booking      = $branches[$selectIndex]->has_booking;
            $provider->mealAveragePrice = $branches[$selectIndex]->mealAveragePrice;
            $provider->averageRate      = round($branches[$selectIndex]->averageRate);
            unset($provider->provider_id);
            $provider->id               = $branches[$selectIndex]->branch_id;
            $provider->distance         = $branches[$selectIndex]->distance;
        }
    }
}
