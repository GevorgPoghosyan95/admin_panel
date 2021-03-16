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

    public function page($lang,$path){
        if(Page::where('path','/'.$path)->where('lang',$lang)->exists()){
            $page = Page::where('path','/'.$path)->where('lang',$lang)->first();
            return view('site.page',compact('page'));
        }else{
            abort('404');
        }

    }
}
