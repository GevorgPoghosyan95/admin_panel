<?php

namespace App\Ekeng;

use Illuminate\Support\Facades\Request;
use App\Menu;

class MenuManager
{

    public function menus_table($request)
    {
        $columns = array(
            0 => 'name',
            1 => 'created_at'
        );
        $totalData = Menu::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $menus = Menu::offset($start)
                ->where('lang', $request->get('lang'))
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $menus = Menu::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->where('lang', $request->get('lang'))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Menu::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $token = csrf_token();
        $data = $this->create_data($menus, $token);

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return json_encode($json_data);
    }


    public function create_data($menus, $token)
    {
        $data = array();
        if (!empty($menus)) {
            foreach ($menus as $menu) {
                $delete = route('menu_delete', $menu->id);
                $edit = route('menu_edit', $menu->id);
                $builder = route('menu_builder', $menu->id);
                $nestedData['name'] = $menu->name;
                $nestedData['options'] = <<<EOD
                                <td width="10%">
                                <!-- Delete form begin -->
                                    <form action="$delete" method="POST">
                                        <input type="hidden" name="_method" value="DELETE"/>
                                        <input type="hidden" name="_token" value="$token">
                                        <input type="submit" value="Delete" class="btn btn-sm btn-danger pull-right">
                                    </form>
                                <!-- Delete form end -->
                                <!-- Edit form begin -->
                                    <form method="GET"  action="$edit" class="dw">
                                       <input type="hidden" name="menu_name" value="$menu->name" class="form-control">
                                       <input type="submit" value="Edit" class="btn btn-sm btn-primary pull-right edit">
                                       <input type="submit" value="Save" class="btn btn-sm btn-primary pull-right save" style="display: none">
                                    </form>
                                <!-- Edit form end -->
                                <!-- Builder form begin -->
                                    <form method="GET"  action="$builder" class="del">
                                       <input type="hidden" name="menu_name" value="$menu->name" class="form-control">
                                       <input type="submit" value="Builder" class="btn btn-sm btn-primary pull-right">
                                    </form>
                                <!-- Builder form end -->
                                </td>
EOD;
                $nestedData['options'] .= <<<EOD
<script src="/js/sweetAlert.js"></script>
<script src="/js/menus/create.js"></script>
EOD;
                $data[] = $nestedData;

            }
        }
        return $data;
    }
}
