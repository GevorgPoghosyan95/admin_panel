<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ekeng\PageManager;
use App\Factory\Page\PageCreator;
use App\Factory\Page\StandardPageCreator;
use App\Factory\Page\VideoGalleryCreator;
use App\Folder;
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


    public function createPage(PageCreator $creator)
    {
        return $creator->create();
    }


    public function updatePage(PageCreator $creator)
    {
        return $creator->update();
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
        $categories = Category::all();
        $folders = Folder::pluck('name', 'id');
        $menus = Menu::where('name', '<>', 'Main')->get();
        return view('pages.create', compact('pageTypes', 'categories', 'menus', 'folders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {

        switch ($request->get('type')) {
            case "Content":
            case "News":
                $this->createPage(new StandardPageCreator($request));
                break;
            case "VideoGallery":
                $this->createPage(new VideoGalleryCreator($request));
                break;
        }

        return redirect()->back()->with('success', 'Page created successfully');
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
        $categories = Category::where('name', '<>', null);
        $menus = Menu::where('name', '<>', 'Main')->get();
        $pageTypes = PageTypes::All;
        $folders = Folder::pluck('name', 'id');
        return view('pages.edit', compact('page', 'categories', 'menus', 'pageTypes', 'folders'));
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
        switch ($request->get('type')) {
            case "Content":
            case "News":
                $this->updatePage(new StandardPageCreator($request,$page));
                break;
            case "VideoGallery":
                $this->updatePage(new VideoGalleryCreator($request,$page));
                break;
        }
        return redirect()->back()->with('success', 'Page Was Update Successfully');
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
