<?php

namespace App\Ekeng;

use Illuminate\Support\Facades\Request;
use App\Page;

class PageManager
{

    public function pages_table($request)
    {
        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'body',
            3 => 'updated_at',
            4 => 'created_at',
            5 => 'image',
        );
        $totalData = Page::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $pages = Page::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $pages = Page::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Page::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->count();
        }
        $token = csrf_token();
        $data = $this->create_data($pages, $token);

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return json_encode($json_data);
    }

    public function search($request)
    {
        $token = csrf_token();
        $columns = $this->getSelectFields();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $params = $request->input('params');
        $totalData = Page::count();

        $query = Page::leftjoin('post_2_category', 'post_2_category.post_id', '=', 'pages.id')
            ->leftjoin('categories', 'post_2_category.category_id', '=', 'categories.id')
            ->select($this->getSelectFields());

        $session = [];
        foreach ($params as $item => $param) {
            if (!array_key_exists($param['name'], $session)) {
                if ($param['value']) {
                    $session[$param['name']] = $param['value'];
                } else {
                    continue;
                }
            } else {
                if ($param['value']) {
                    $session[$param['name']] = array($session[$param['name']], $param['value']);
                } else {
                    continue;
                }

            }
        }

        foreach ($session as $key => $value) {
            if ($value) {
                if (is_array($value)) {
                    if($key !== 'categories.name'){
                        $new_val = [];
                        array_push($new_val, date('Y-m-d', strtotime($value[0])));
                        array_push($new_val, date('Y-m-d', strtotime($value[1])));
                        $query->whereBetween($key, $new_val);
                    }else{
                        foreach ($value as $category){
                            $query->where($key, 'like', '%' . $category . '%');
                        }
                    }
                } else {
                    $query->where($key, 'like', '%' . $value . '%');
                }
            }
        }

        $totalFiltered = $query->count();
        $pages = $query->offset($start)
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            ->groupBy('id')
            ->get();

        $data = $this->create_data($pages, $token);
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return json_encode($json_data);
    }

    public function getSelectFields(){
        return [
            'pages.id as id',
            'title',
            'body',
            'image',
            'pages.created_at as created_at',
            'pages.updated_at as updated_at',
        ];
    }

    public function create_data($pages,$token){
        $data = array();
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $delete = route('pages.destroy', $page->id);
                $edit = route('pages.edit', $page->id);

                $nestedData['id'] = $page->id;
                $nestedData['title'] = $page->title;
                $nestedData['body'] = $page->body;
                $nestedData['image'] = $page->image ? "<img src='data:image/png;base64,$page->image' alt=''>" : '';
                $nestedData['updated_at'] = date('Y-m-d H:i:s', strtotime($page->updated_at));
                $nestedData['created_at'] = date('Y-m-d H:i:s', strtotime($page->created_at));
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
                                                                <input type="hidden" title="_method" value="DELETE"/>
                                                                <input type="hidden" title="_token" value="$token">
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
        return $data;
    }
}
