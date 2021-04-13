<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Layout;
use App\Menu;
use App\Page;
use App\Partner;
use App\Post;
use App\VideoLink;
use Faker\Provider\File;
use Illuminate\Http\Request;

class AllController extends Controller
{
    public function index($lang)
    {
        $Car_news = [];
        $homePage = Page::where('path', '/')->where('lang', $lang)->first();
        if ($homePage) {
            $menu = Menu::where('name', 'Banner')->first();
            $video_links = VideoLink::take(2)->get()->sortBy('id');
            $partners = Partner::all();
            $allnews = Post::leftjoin('post_2_category', 'post_2_category.post_id', '=', 'posts.id')
                ->leftjoin('categories', 'post_2_category.category_id', '=', 'categories.id')->
                where('post_2_category.category_id', $homePage->categoryID)
                ->where('posts.lang', $lang)->take(3)->orderBy('posts.id', 'desc')
                ->select('posts.title as title', 'posts.image as image', 'posts.created_at as created_at', 'posts.video as video', 'posts.id as id')->get();;
            if ($homePage->carouselType == 1) {
                $Car_news = Post::leftjoin('post_2_category', 'post_2_category.post_id', '=', 'posts.id')
                    ->leftjoin('categories', 'post_2_category.category_id', '=', 'categories.id')->
                    where('post_2_category.category_id', $homePage->carouselNewsCategory)
                    ->where('posts.lang', $lang)->take(3)
                    ->select('posts.title as title', 'posts.image as image', 'posts.created_at as created_at', 'posts.video as video', 'posts.id as id')->get();
            }
            return view('site.index', compact('homePage', 'allnews', 'Car_news', 'menu', 'video_links', 'partners'));
        } else {
            return redirect('/hy');
        }

    }

    public function page($lang, $path)
    {
        if (Page::where('path', '/' . $path)->where('lang', $lang)->exists()) {
            $page = Page::where('path', '/' . $path)->where('lang', $lang)->first();
            return view('site.page', compact('page'));
        } else {
            abort('404');
        }

    }

    public function search(Request $request)
    {
        $params = $request->get('params');
        $posts = Post::join('post_2_category', 'post_2_category.post_id', '=', 'posts.id')
            ->join('categories', 'categories.id', '=', 'post_2_category.category_id')
            ->where('categories.id', 4)
            ->where('posts.lang', app()->getLocale())->where('title', 'like', '%' . $params . '%')->orderBy('posts.id', 'desc')
            ->select('posts.id as id','posts.title as title','posts.content as content','posts.image as image')->paginate(10);
        return view('site.search', compact('posts'));
    }

}
