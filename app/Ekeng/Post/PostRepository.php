<?php

namespace App\Ekeng\Post;

use App\Category;
use App\Ekeng\PostManager;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostRepository
{


    public function create(Request $request)
    {
        $video_link = $this->getVideoLink($request);

        $file = $request->file('photos')[0];
        if ($file) {
            $imagedata = file_get_contents($file);
            $image = base64_encode($imagedata);
        } else {
            $image = null;
        }
        $post = Post::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'image' => $image,
            'lang' => $request->get('lang'),
            'video' => $video_link
        ]);
        if (!empty($request['category'])) {
            $post->categories()->sync($request->get('category'));
        }
    }

    public function update(Request $request, Post $post)
    {
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
            $base64 = $post->image;
        }
        $updatedData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $base64,
        ];

        if (isset($request['video_link']) || isset($request['video'])) {
            $video_link = $this->getVideoLink($request);
            $updatedData['video'] = $video_link;
        }


        $post->update($updatedData);
        if ($request->get('category')) {
            $post->categories()->sync($request->get('category'));
        } else {
            $post->categories()->sync([]);
        }
    }

    /** create video link (downloaded video or youtube)
     * @param $request
     * @return string
     */

    public function getVideoLink($request)
    {
        $video_link = $request->get('video_link');

        if ($request->file('video')) {
            $video = $request->file('video');
            $name = $video->getClientOriginalName();
            Storage::disk('post_videos')->put($name, File::get($video));
            $video_link = '/site/post/videos/' . $name;
        }
        return $video_link;
    }

    /**
     * @param Post $post
     * @return string
     * Create post design
     */
    static function createDesign(Post $post)
    {
        $videoPart = null;
        $imagePart = null;
        if ($post->video) {
            strpos($post->video, '/site/post/videos/') === false ? $videoPart = '<iframe width="400" height="220" style="min-width: 200px; max-width: 600px; float:left; margin-right: 14px; margin-top: 0;" src="' . $post->video . '"
                            ></iframe>' : $videoPart = '
                                <video width="400" height="auto" controls="controls"
                                       style="min-width: 200px; max-width: 600px; float:left; margin-right: 14px; margin-top: 0;">
                                    <source src="' . $post->video . '" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'>
                                </video>';
        }
        if ($post->image && $videoPart == null) {
            $imagePart = <<<EOD
                        <img src="data:image/png;base64, $post->image" width=400 alt="">
EOD;

        }

        $content = substr(strip_tags($post->content), 0, 500);
        $date = date('j, F Y', strtotime($post->created_at));

        $html = <<<EOD
                            <div class="news">
                                $videoPart
                                $imagePart
                                <span class="data">$date</span>
                                <h3> $post->title </h3>
                                <p>
                                    $content
                                </p>
                                <p><a href="/post/more/$post->id" class="newlink">Մանրամասն</a></p>
                            </div>
<div class=hr></div>
EOD;
        return $html;
    }


    static function faq()
    {
        $faqCategory = Category::where('name', 'FAQ')->first();
        $posts = $faqCategory->posts;
        $html='';
        foreach ($posts as $post) {
            $html .= <<<EOD
                     <div class="accordion"><b>$post->title</b></div>
                    <div class="panel">
                        $post->content
                    </div><br>
EOD;
        }
        return $html;

    }

}
