<?php

namespace App\Http\Controllers;

use App\Ekeng\MenuManager;
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
    protected $parents = [];
    protected $depth = 0;
    protected $root = null;
    protected $menuManager;

    function __construct(MenuManager $menuManager)
    {
        $this->menuManager = $menuManager;
        $this->middleware('permission:menu-list|menu-create|menu-edit|menu-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:menu-create', ['only' => ['create_menu', 'store']]);
        $this->middleware('permission:menu-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function create_menu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:menus|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['name already in use']);
        } else {
            $menu = new Menu;
            $menu->name = $request->input('name');
            $menu->slug = $request->input('name');
            $menu->lang = $request->input('lang');
            $menu->save();

            return back()->with('message', 'success');
        }

    }

    public function delete($id)
    {
        Menu::find($id)->delete();
        MenuItem::where('menu_id',$id)->delete();
        return redirect()->back()->with('success', 'Menu deleted successfully!');
    }

    public function edit(Request $request, $id)
    {
        Menu::where('id',$id)->update([
            'name' => $request->get('menu_name'),
            'slug' => strtolower($request->get('menu_name'))
        ]);
        return redirect()->back()->with('success', 'Menu name changed!');
    }

    public function foreach(Request $request)
    {
        return $this->menuManager->menus_table($request);
    }
}
