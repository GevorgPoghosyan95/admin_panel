<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();
        return view('pages.index',compact('pages'));
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
        $page = new Page;
        $page->title = $request->input('title');
        $page->body = $request->input('content');
        $page->image = $image;
        $page->save();

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
    public function destroy($id)
    {
        Page::find($id)->delete();
        MenuItem::where('page_id',$id)->delete();
        return redirect('pages')->with('success', 'Page deleted successfully');
    }
}
