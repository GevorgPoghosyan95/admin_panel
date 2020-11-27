<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use App\Page;
use CodexShaper\Menu\Models\MenuSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function build(Request $request, $id)
    {
        $pages = Page::all();
        $items = MenuItem::where('menu_id',$id)->get();

        return view('menu.builder',compact('pages','items'));
    }

    public function getChildrens($menu_id, $parent_id = null, $orderBy = 'asc')
    {
        return MenuItem::with('children')
            ->where(['menu_id' => $menu_id, 'parent_id' => $parent_id])->select('id','order','title' )
            ->orderBy('order', $orderBy)
            ->get();
    }


    /**
     * @param Request $request
     * @param $id
     */
    public function build_edit(Request $request, $id)
    {
        $itemsWithChildrens = $this->getChildrens($id);

        return json_encode($itemsWithChildrens);

    }

    public function create(Request $request)
    {
        $data =  json_decode($request->input('list'));

        $this->saveList($data,$request->input('menu_id'));

        return json_encode('success');
    }

    function saveList( $list, $menu_id, $parent_id = null, $m_order = 0) {
        foreach($list as $item) {
            $m_order++;
            $upd = MenuItem::where('menu_id',$menu_id)->where('id',$item->id)->update(['title'=> $item->title, 'parent_id' => $parent_id,'order' => $m_order]);

            if($upd == 0){
                $menu_item = new MenuItem;
                $menu_item->menu_id = $menu_id;
                $menu_item->title = $item->title;
                $menu_item->slug = $item->title;
                $menu_item->parent_id =$parent_id;
                $menu_item->order = $m_order;
                $menu_item->save();
            }
            if (property_exists($item,'children')) {
                if(!empty($item->children)){
                     $this->saveList($item->children, $menu_id, $item->id, $m_order);
                }
            }
        }
    }

    public function create_menu_item(Request $request)
    {
        $menu = new Menu;
        $menu->name = $request->input('name');
        $menu->slug = $request->input('name');
        $menu->save();
    }
}
