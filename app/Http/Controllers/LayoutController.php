<?php

namespace App\Http\Controllers;

use App\Layout;
use App\Menu;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function header($lang)
    {
        $menus= Menu::where('lang',$lang)->pluck('name','id');
        $data = Layout::where('lang',$lang)->where('name','header')->first();
        return view('layouts.header',compact('menus','data','lang'));
    }
    public function header_store(Request $request)
    {

//        dd($request->input('old_pic'));
        $title = Layout::where('name',$request->input('name'))->get();
        if($request->input('old_pic') == 1){
            $image= $title[0]['image'];
        }
        if($request->input('old_pic') == 0){
            $image= '';
        }
        if($request->input('old_pic') == 2){
            if($request->file('site_logo')) {
                $file = $request->file('site_logo');
                $image = base64_encode(file_get_contents($file));
            }
        }
        if(count($title) > 0) {
            Layout::where('name',$request->input('name'))->update([
                'menu_id' => $request->input('menu_id'),
                'body' => $request->input('body'),
                'image' => $image
            ]);
        } else{
            $data = new Layout;
            $data->name = 'header';
            $data->menu_id = $request->input('menu_id');
            $data->body = $request->input('body');
            $data->image = $image;
            $data->lang = $request->input('lang');
            $data->save();
        }

        return redirect()->back()->with('success');
    }

    public function footer()
    {
        $data = Layout::where('name','footer')->first();
        $menus= Menu::pluck('name','id');
        return view('layouts.footer',compact('menus','data'));
    }

    public function footer_store(Request $request)
    {
        $title = Layout::where('name',$request->input('name'))->get();
//        dd($request->all());
        if(count($title) > 0) {
            Layout::where('name',$request->input('name'))->update([
                'menu_id' => $request->input('menu_id'),
                'body' => $request->input('body'),
                'bottom_content' => $request->input('bottom_content'),
            ]);
        } else {
            $data = new Layout;
            $data->name = 'footer';
            $data->menu_id = $request->input('menu_id');
            $data->body = $request->input('body');
            $data->lang = $request->input('lang');
            $data->bottom_content = $request->input('bottom_content');
            $data->save();
        }
        return redirect()->back()->with('success');
    }

}
