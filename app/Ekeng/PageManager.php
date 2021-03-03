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
            3 => 'path',
            4 => 'updated_at',
            5 => 'created_at',
            6 => 'image',
        );
        $totalData = Page::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $pages = Page::offset($start)
                ->where('lang',$request->get('lang'))
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $pages = Page::where('id', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%")
                ->where('lang',$request->get('lang'))
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


    public function create_data($pages, $token)
    {
        $data = array();
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $delete = route('pages.destroy', $page->id);
                $edit = route('pages.edit', $page->id);

                $nestedData['id'] = $page->id;
                $nestedData['title'] = $page->title;
                $nestedData['body'] = substr(strip_tags($page->body),0,30);
                $nestedData['image'] = $page->image ? "<img src='data:image/png;base64,$page->image' alt=''>" : '';
                $nestedData['path'] = $page->path ? $page->path : '';
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
        return $data;
    }
}
