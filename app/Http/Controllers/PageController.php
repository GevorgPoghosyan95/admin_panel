<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ekeng\PageManager;
use App\Http\Requests\PageRequest;
use App\Menu;
use App\MenuItem;
use App\Page;
use App\Statics\PageTypes;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageManager;

    function __construct(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;
        $this->middleware('permission:pages-list|pages-create|pages-edit|pages-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:pages-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pages-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pages-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTypes = PageTypes::All;
        $categories = Category::where('name', '<>', 'FAQ')->get();
        $menus = Menu::where('name', '<>', 'Main')->get();
        return view('pages.create', compact('pageTypes', 'categories','menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $file = $request->file('photos')[0];
        if ($file) {
            $imagedata = file_get_contents($file);
            $image = base64_encode($imagedata);
        } else {
            $image = null;
        }
        $pageData = $request->all();
        $pageData['image'] = $image;
        Page::create($pageData);
        return redirect('pages')->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::where('id', $id)->first();
        $categories = Category::where('name', '<>', 'FAQ')->pluck('name','id');
        $menus = Menu::where('name', '<>', 'Main')->get();
        $pageTypes = PageTypes::All;
        return view('pages.edit', compact('page','categories','menus','pageTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $pageData = $request->all();
        $file = $request->file('photos')[0];
        $base64 = '';
        if ($file !== null) {
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
        }
        if ($request->input('img') === null && $file !== null) {
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
        }
        if ($request->input('img') !== null) {
            $base64 = $page->image;
        }
        $pageData['img'] = $base64;
        $page->update($pageData);
        return redirect('pages')->with('success', 'Page Was Update Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        MenuItem::where('page_id', $page->id)->delete();
        $page->delete();
        return redirect('pages')->with('success', 'Page deleted successfully');
    }

    public function foreach(Request $request)
    {
        return $this->pageManager->pages_table($request);
    }

    public function deleteChecked(Request $request)
    {
        try {
            MenuItem::whereIn('page_id', $request->get('params'))->delete();
            Page::whereIn('id', $request->get('params'))->delete();
            return response()->json(['status' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => ['message' => 'Deleting problem!']]);
        }
    }

}
