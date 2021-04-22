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
use App\Partner;
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
        $h_page = Page::where('type','HomePage')->first();
//        if(!empty($h_page)){
//            $pos = array_search('Home Page', $pageTypes);
//            unset($pageTypes[$pos]);
//        }
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
        if($page->type == 'HomePage'){
            $carousels = Folder::where('name','like','%carousel%')->pluck('name','id');
            $categories = Category::pluck('name','id');
            $partners = Partner::all();
            return view('home.edit', compact('page', 'categories', 'carousels','partners'));
        }
        $categories = Category::where('name', '<>', null);
        $menus = Menu::where('name', '<>', 'Main')->where('lang',$page->lang)->get();
        $pageTypes = PageTypes::All;
        unset($pageTypes[3]);
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
                $this->updatePage(new StandardPageCreator($request, $page));
                break;
            case "VideoGallery":
                $this->updatePage(new VideoGalleryCreator($request, $page));
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

    public function homePage($lang)
    {
        $carousels = Folder::where('name','like','%carousel%')->get();
        $categories = Category::where('lang',$lang)->get();
        $partners = Partner::where('lang',$lang)->get();
        return view('home.index',compact('carousels','categories','partners'));
    }

    public function home_store(Request $request){
//        dd($request->all());
        Page::create([
            'title'=>'Home',
            'path'=>'/',
            'lang'=>$request->get('lang'),
            'categoryID'=>$request->get('categoryID'),
            'car_template'=>$request->get('car_template'),
            'mainCarouselID'=>$request->get('carouselId'),
            'mainCarouselStatus'=>$request->get('mainCarouselStatus'),
            'carouselNewsCategory'=>$request->get('carouselNewsCategory'),
            'carouselType'=>$request->get('carouselType'),
            'video_block'=>$request->get('video_block'),
            'partners_carousel'=>$request->get('partners_carousel'),
            'type'=>'HomePage'
            ]);
        return redirect()->back();
    }

    public function home_update(Request $request){
//        dd($request->all());
        unset($request['_token']);
        Page::where('id',$request->get('id'))->update($request->all());
        return redirect()->back();
    }
    public function addPartner(Request $request)
    {
        if($request->hasFile('file')){
            $file =  $request->file('file');
            $image = base64_encode(file_get_contents($file));
            try{
                $data = new Partner;
                $data->url = $request->get('url');
                $data->lang = $request->get('lang');
                $data->image = $image;
                $data->save();
                return response()->json(['status' => 'success', 'id' => $data->id,'image' => $data->image, 'message' => 'added successfully']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Deleting problem!']);
            }

        }
    }

    public function removePartner($id)
    {
        Partner::where('id',$id)->delete();
        return response()->json(['status' => 'success', 'message' => 'deleted successfully','id' => $id]);
    }

}
