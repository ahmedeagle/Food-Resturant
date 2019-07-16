<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
class PageController extends Controller
{
    public function get_page($id){

        $data['page'] = Page::find($id);

        if(!$data['page']){
            return redirect("/user/dashboard");
        }
        $data['title'] = " - " . $data['page']->ar_title;
        $data['class'] = "front-page page-template";

        return view("User.pages.page.page", $data);
    }
}
