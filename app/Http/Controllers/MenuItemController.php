<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use App\Page;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function build(Request $request, $id)
    {

        $pages = Page::all();
        $items = MenuItem::where('menu_id', $id)->get();
        $menu = Menu::find($id);
        return view('menu.builder', compact('pages', 'items', 'menu'));
    }

    public function build_edit(Request $request, $id)
    {
        $itemsWithChildrens = $this->getChildrens($id);

        return json_encode($itemsWithChildrens);

    }

    public function getChildrens($menu_id, $parent_id = null, $orderBy = 'asc')
    {
        return MenuItem::with('children')
            ->where(['menu_id' => $menu_id, 'parent_id' => $parent_id])->select('id', 'order', 'title')
            ->orderBy('order', $orderBy)
            ->get();
    }

    public function create(Request $request)
    {
        $data = json_decode($request->input('list'));

        $id = $this->saveList($data, $request->input('menu_id'));
        return json_encode(['status' => 'success', 'id' => $id, 'message' => 'Changed successfully']);
    }

    function saveList($list, $menu_id, $parent_id = null, $m_order = 0)
    {
        foreach ($list as $item) {
            $m_order++;
            MenuItem::where('menu_id', $menu_id)->where('id', $item->id)->update(['title' => $item->title, 'parent_id' => $parent_id, 'order' => $m_order]);

            if (property_exists($item, 'children')) {
                if (!empty($item->children)) {
                    $this->saveList($item->children, $menu_id, $item->id, $m_order);
                }
            }
        }
    }

    function menu_item_add(Request $request)
    {
        $current_order = MenuItem::where('menu_id', $request->input('menu_id'))->max('order');
        $current_order ? $curr = $current_order : $curr = 1;
        $menu_item = new MenuItem;
        $menu_item->page_id =  $request->input('page_id');
        $menu_item->menu_id = $request->input('menu_id');
        $menu_item->title = $request->input('title');
        $menu_item->slug = strtolower($request->input('title'));
        $menu_item->order = $current_order + 1;
        $menu_item->save() ? $ret = json_encode(['status' => 'success', 'id' => $menu_item->id, 'message' => 'Added successfully']) : $ret = json_encode(['status' => 'fail', 'message' => 'Error adding item']);
        return $ret;
    }

    function menu_item_edit(Request $request)
    {
        dd($request->input('id'));
    }

    function menu_item_delete(Request $request)
    {
        $id = MenuItem::find($request->input('item_id'))->delete();
        if ($id) {
            return json_encode(['status' => 'success', 'message' => 'Deleted successfully']);
        } else {
            return json_encode(['status' => 'fail', 'message' => 'Error deleting item']);
        }

    }
}
