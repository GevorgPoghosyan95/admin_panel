<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use App\Page;
use CodexShaper\Menu\Models\MenuSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    protected $order = [];
    protected $childrens = [];
    protected $parents = [];
    protected $depth = 0;
    protected $root = null;
    protected $root_depth = 0;


    public function index()
    {
        $menus = Menu::all();
        return view('menu.index',compact('menus'));
    }

    public function create_menu(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:menus|max:255',
        ]);

        if($validator->fails()){
            return back()->withErrors(['name already in use']);
        } else {
            $menu = new Menu;
            $menu->name = $request->input('name');
            $menu->slug = $request->input('name');
            $menu->save();

            return back()->with('message','success');
        }

    }
}
