<?php

namespace App\Http\Controllers\Site;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PageController extends Controller
{
    public function get_page($id){

        $page = DB::table("pages")
                    ->where("id", $id)
                    ->select(
                        "ar_title AS title",
                        "ar_content AS content"
                    )->first();
        if(!$page){
            return redirect("/");
        }

        $data = [
            "title" => $page->title,
            "class" => "page-template page",
            "page" => $page
        ];
        return view("Site.pages.page", $data);
    }
}
