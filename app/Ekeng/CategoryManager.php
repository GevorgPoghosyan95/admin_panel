<?php

namespace App\Ekeng;

use App\Category;
use Illuminate\Support\Facades\Request;
use App\Page;

class CategoryManager
{

    public function categories_table($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            3 => 'updated_at',
            4 => 'created_at',
        );
        $totalData = Category::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $categories = Category::offset($start)
                ->where('lang',$request->get('lang'))
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $categories = Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->where('lang',$request->get('lang'))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $token = csrf_token();
        $data = $this->create_data($categories, $token);

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return json_encode($json_data);
    }


    public function create_data($categories, $token)
    {
        $data = array();
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $delete = route('categories.destroy', $category->id);
                $edit = route('categories.edit', $category->id);
                $show = route('categories.show', $category->id);

                $nestedData['id'] = $category->id;
                $nestedData['name'] = $category->name;
                $nestedData['created_at'] = date('Y-m-d H:i:s', strtotime($category->created_at));
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
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-tag"></i>
                                                            <form method="GET" style="display:inline;" action="$show">
                                                                    <input type="submit" value="Show All Posts" class="btn btn-primary btn-xs">
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
        return $data;
    }
}
