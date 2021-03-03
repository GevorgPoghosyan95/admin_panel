<?php


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

function createPermission($group){
    $group = strtolower($group);
    return [$group.'-list',$group.'-create',$group.'-edit',$group.'-delete'];
}

//create menu dynamically

 function showMenu($name){
    $data = getChilds($name);
    $html = '';
    return recursion($data,$html);
}

 function recursion($data,$html){
    $html .= '<ul>';
    foreach ($data as $item) {
        if($item->children()->exists()){
            $class = 'parent';
        }else{
            if($item->parent_id == null){
                $class = 'parent';
            }else{
                $class = 'children';
            }
        }
        if($item->url == null){
            $content = $item->title;
        } else {
            $content = "<a href='$item->url'>$item->title</a>";
        }
        if($item->children()->exists()){
            $html .= '<li class="'.$class.'">'.$content;
            $html = recursion($item->children,$html);
            $html.='</li>';
        }else {
            $html .= '<li class="'.$class.'">'.$content.'</li>';
        }
    }
    $html.='</ul>';
    return $html;
}

 function getChilds($name, $parent_id = null, $orderBy = 'asc')
{
    return MenuItem::with('children')->leftJoin('menus','menus.id','=','menu_items.menu_id')
        ->where(['name' => $name, 'parent_id' => $parent_id])->select('menu_items.id as id', 'menu_items.order as order', 'title')
        ->orderBy('order', $orderBy)
        ->get();
}