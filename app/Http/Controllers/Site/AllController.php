<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class AllController extends Controller
{
    public function index(){
        return view('site.index');
    }

    public function page($route){
        if(Page::where('path','/'.$route)->exists()){
            $page = Page::where('path','/'.$route)->first();
            return view('site.page',compact('page'));
        }else{
            abort('404');
        }

    }
}
