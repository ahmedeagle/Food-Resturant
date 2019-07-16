<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SearchController extends Controller
{
    public function search(Request $request){

        App()->setLocale("ar");

        $query = $request->input("query");

        if(empty($query)){
            return redirect()->back()->with("empty-query", trans("site.search-empty-query"));
        }
        $data['providers'] =  DB::table("providers")
                                ->join("images" , "images.id" ,"providers.image_id")
                                ->where("providers.ar_name" , "LIKE" , "%" . $query . "%")
                                ->orWhere("providers.en_name" , "LIKE" , "%" . $query . "%")
                                ->where("providers.phoneactivated" , "1")
                                ->where("providers.accountactivated" , "1")
                                ->select(
                                    "providers.id AS provider_id",
                                    "providers.ar_name AS name",
                                    DB::raw("CONCAT('". url('/') ."','/storage/app/public/providers/', images.name) AS image_url")
                                )
                                ->paginate(30);

        (new HelperController())->filter_providers_branches_by_rate($data['providers']);

        $data['title'] =  " - " . $query;
        $data['class'] = "front-page page-template";

        $data['query'] = $query;
        
        return view("Site.pages.search", $data);

    }
    
    public function get_search(){
        return redirect("/");
    }
}
