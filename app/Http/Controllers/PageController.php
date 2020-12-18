<?php

namespace App\Http\Controllers;

use App\Ekeng\PageManager;
use App\MenuItem;
use App\Page;
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
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        $file = $request->file('photos')[0];
        if($file){
            $imagedata = file_get_contents($file);
            $image = base64_encode($imagedata);
        }else{
            $image = null;
        }
        Page::create([
            'title'=>$request->get('title'),
            'body'=>$request->get('content'),
            'image'=>$image
        ]);

        return redirect('pages')->with('success', 'Page created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $page = Page::where('id',$id)->first();
        return view('pages.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Page $page)
    {
        $file = $request->file('photos')[0];
        $base64 = '';
        if( $file !== null){
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
        }
        if($request->input('img') === null && $file !== null){
            $imagedata = file_get_contents($file);
            $base64 = base64_encode($imagedata);
        }
        if($request->input('img') !== null) {
            $base64 = $page->image;
        }

        $page->update(['title' => $request->input('title'),'body' => $request->input('content'),'image' => $base64]);
        return redirect('pages')->with('success', 'Page Was Update Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        MenuItem::where('page_id',$page->id)->delete();
        $page->delete();
        return redirect('pages')->with('success', 'Page deleted successfully');
    }

    public function foreach(Request $request)
    {
        return $this->pageManager->pages_table($request);
    }

    public function search(Request $request)
    {
        return $this->pageManager->search($request);
    }
}
