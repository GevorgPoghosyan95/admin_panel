<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ekeng\Post\PostRepository;
use App\Ekeng\PostManager;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    protected $postManager;
    protected $postRepository;

    function __construct(PostManager $postManager, PostRepository $postRepository)
    {
        $this->postManager = $postManager;
        $this->postRepository = $postRepository;
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
        $categories = Category::pluck('name', 'name')->all();
        array_unshift($categories, "");
        return view('posts.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $this->postRepository->create($request);
        return redirect('posts')->with('success', 'Post created successfully');
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
        $categories = Category::pluck('name', 'id')->all();
        $post = Post::where('id', $id)->first();

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->postRepository->update($request, $post);
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

    public function deleteChecked(Request $request)
    {
        try {
            Post::whereIn('id', $request->get('params'))->delete();
            return response()->json(['status' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => ['message' => 'Deleting problem!']]);
        }
    }
}
