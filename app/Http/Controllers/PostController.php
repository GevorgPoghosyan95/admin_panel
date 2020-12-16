<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ekeng\PostManager;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $postManager;
    function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
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
        $categories = Category::pluck('name','name')->all();
        array_unshift($categories,"");
        return view('posts.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name','id')->all();
        array_unshift($categories,"");
        return view('posts.create',compact('categories'));
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
        if($request->get('category') !== 0){
            $post->categories()->sync([$request->get('category')]);
        }

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
        $categories = Category::pluck('name','id')->all();
        $post = Post::where('id',$id)->first();

        return view('posts.edit',compact('post','categories'));
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
        if($request->get('category')){
            $post->categories()->sync($request->get('category'));
        }else{
            $post->categories()->sync([]);
        }
        return redirect()->back()->with('success', 'Post updated successfully');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully');
    }

    public function foreach(Request $request)
    {
        return $this->postManager->posts_table($request);
    }

    public function search(Request $request)
    {
        return $this->postManager->search($request);
    }
}
