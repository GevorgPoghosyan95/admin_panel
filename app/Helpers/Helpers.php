<?php


use App\Menu;
use App\MenuItem;

function generate_sidebar_groups($array, $output)
{

    foreach ($array as $item => $val) {
        if (is_array($val)) {
            $output .= '<a href="javascript:;" class="nav-link nav-toggle">';
            $output .= ' <li class="nav-item">';
            $output .= '<i class="icon-briefcase"></i><span class="title">' . $item . '</span><span class="arrow"></span>';
            $output .= '</a>';
            $output .= '<ul class="sub-menu">';
            $output = generate_sidebar_groups($val, $output);
            $output .= '</ul>';
            $output .= '</li>';
        } else {
            $output .= '<li class="nav-item  "><a href="' . $val . '" class="nav-link"><span class="title">' . $item . '</span></a></li>';

        }
    }

    return $output;
}

function createPermission($group)
{
    $group = strtolower($group);
    return [$group . '-list', $group . '-create', $group . '-edit', $group . '-delete'];
}

//create menu dynamically

function showMenu($name)
{
    $data = getChilds($name);
    $html = '';
    return recursion($data, $html);
}

function recursion($data, $html)
{
    $html .= '<ul class="menu">';
    foreach ($data as $item) {
        if ($item->children()->exists()) {
            $class = 'parent';
        } else {
            if ($item->parent_id == null) {
                $class = 'parent';
            } else {
                $class = 'children';
            }
        }
        if ($item->path == null) {
            $content = $item->title;
        } else {
            $content = '<a href="'.'/'.app()->getLocale().$item->path.'">'.$item->title.'</a>';
        }
        if ($item->children()->exists()) {
            $html .= '<li class="' . $class . '">' . $content;
            $html = recursion($item->children, $html);
            $html .= '</li>';
        } else {
            $html .= '<li class="' . $class . '">' . $content . '</li>';
        }
    }
    $html .= '</ul>';
    return $html;
}

function getChilds($name, $parent_id = null, $orderBy = 'asc')
{
    return MenuItem::with('children')->leftJoin('menus', 'menus.id', '=', 'menu_items.menu_id')
        ->leftJoin('pages', 'pages.id', '=', 'menu_items.page_id')
        ->where(['name' => $name, 'parent_id' => $parent_id])->select('menu_items.id as id', 'menu_items.order as order', 'menu_items.title as title', 'pages.path as path')
        ->orderBy('order', $orderBy)
        ->get();
}

function showSubMenu($menu)
{
    $menu = Menu::where('name', $menu)->first();
    $menuHtml = '';
    foreach ($menu->menuItems()->orderBy('order','asc')->get() as $item) {
        $url = '/'.$item->page->lang.$item->page->path;
        $title = $item->page->title;
        strpos(request()->url(),$url) == false ? $class="":$class = "active";
        $menuHtml .= '<a class="'.$class.'" href="' . $url . '">' . $title . '</a>';
    }
    return $menuHtml;
}

function getFileNameByPath($path,$type){
    $parts = explode('/',$path);
    return str_replace('.'.$type,'',$parts[count($parts) - 1]);

}

