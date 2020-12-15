<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:posts-list|posts-create|posts-edit|posts-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:posts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:posts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:posts-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $posts = Post::all();
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
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
        $post = new Post;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->image = $image;
        $post->save();

        return redirect('posts')->with('success', 'Post created successfully');
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
        $post = Post::where('id',$id)->first();
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
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
            $base64 = $post->image;
        }

        $post->update(['title' => $request->input('title'),'content' => $request->input('content'),'image' => $base64]);
        return redirect()->back()->with('success', 'Post updated successfully');
    }


    public function destroy(Post $post)
    {

    }
}
