<?php

namespace App\Http\Controllers;

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
        $imagedata = file_get_contents($file);
        $base64 = base64_encode($imagedata);
        $page = new Page;
        $page->title = $request->input('title');
        $page->body = $request->input('content');
        $page->image = $base64;
        $page->save();

        return redirect('pages')->with('success', 'Page Was Create Successfully');
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
//        var_dump($request->all());
//        dd($request->file('doc'));
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




    public function delete(Request $request)
    {
       $result = Page::where('id',$request->input('id'))->delete();
       if($result){
           return 'success';
       } else {
           return 'fail';
       }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('ok');
    }
}
