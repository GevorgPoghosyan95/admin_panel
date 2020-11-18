<?php
namespace App\Ekeng;

use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Permission;

class PermissionManager {

    public function permissions_table($request){
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'created_at',
            3 => 'updated_at',
        );
        $totalData = Permission::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $permissions = Permission::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $permissions = Permission::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Permission::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }
        $token = csrf_token();
        $data = array();
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $delete = route('permissions.destroy', $permission->id);
                $edit = route('permissions.edit', $permission->id);

                $nestedData['id'] = $permission->id;
                $nestedData['name'] = $permission->name;
                $nestedData['updated_at'] = date('Y-m-d H:i:s', strtotime($permission->updated_at));
                $nestedData['created_at'] = date('Y-m-d H:i:s', strtotime($permission->created_at));
                $nestedData['options'] = <<<EOD
                                            <div class="btn-group">
                                                <button class="btn btn-xs green dropdown-toggle" type="button"
                                                        data-toggle="dropdown"
                                                        aria-expanded="false"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-left" role="menu">
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-docs"></i>
                                                            <form method="POST" style="display:inline;" action="$delete">
                                                                <input type="hidden" name="_method" value="DELETE"/>
                                                                <input type="hidden" name="_token" value="$token">
                                                                <input type="submit" value="Delete" class="btn btn-danger btn-xs">
                                                            </form>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-tag"></i>
                                                            <form method="GET" style="display:inline;" action="$edit">
                                                                    <input type="submit" value="Edit" class="btn btn-primary btn-xs">
                                                                </form>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
<script src="/js/sweetAlert.js"></script>
EOD;
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return json_encode($json_data);
    }
}
