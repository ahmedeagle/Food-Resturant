<?php

namespace App\Http\Controllers\Provider;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function __construct()
    {
        //App()->setLocale("ar");
        if(!(auth("provider")->check() || auth("branch")->check())){
            return redirect("/login");
        }
    }

    public function get_page($id){

        $data['page'] = Page::find($id);

        if(!$data['page']){
            return redirect("/restaurant/dashboard");
        }
        $data['title'] = " - " . $data['page']->ar_title;
        $data['class'] = "page-template page";

        return view("Provider.pages.page", $data);
    }
}
