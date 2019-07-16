<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){

          $data['offers'] = ( new \App\Http\Controllers\Site\HomeController() )->get_home_page_offers();
        $data['cats']   = ( new \App\Http\Controllers\Site\HomeController() )->get_home_page_cats(true);


        $data['title'] = ' - الرئيسية - لوحة التحكم';
        $data['class'] = 'front-page page-template';

        return view("User.pages.dashboard", $data);
    }
}
