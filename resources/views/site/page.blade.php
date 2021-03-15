@extends('site.layout.app')

@section('header')
    @include('site.layout.header')
@stop

@section('type')
    <!-- START CONTENT -->

    <div class="line1">
        <div class="line2">

            <!-- START COLUM LEFT 1 -->

            <div class="left">

                <!-- START MENU 2 -->
                @if($page->leftMenu)
                    <div class="menu2">

                        <nav>
                            {!! showSubMenu($page->leftMenu->name) !!}
                        </nav>

                    </div>
            @endif
            <!-- END MENU 2 -->
            </div>


            <!-- END COLUM LEFT 1 -->


            <!-- START CONTENT COLUM 2 -->
            <div class="content wrapper">
                @if($page->type == 'Content')
                    <h1>{!! $page->title !!}</h1>
                    {!! $page->body !!}
                    <br>
                    <br>
                    @if($page->folders()->exists())
                        @if($page->galleryType == "photo")
                            <div class="gallery">
                                @foreach ($page->folders as $folder)
                                    @php $images = $folder->files()->paginate(15) @endphp
                                    @foreach ($images as $file)
                                        @if($file->type == 'image')
                                            <a href="{{$file->path}}"><img src="{{$file->path}}" alt=""></a>
                                            <span>&nbsp;</span>
                                        @endif
                                    @endforeach
                                @endforeach
                                <div class=clear></div>
                                <br>
                                {!! $images->render() !!}
                                <br>
                                <br>
                            </div>
                        @elseif($page->galleryType == "file")
                            @foreach ($page->folders as $folder)
                                @foreach ($folder->files as $file)
                                    <div class="{{$file->type}}"><a href="{{$file->path}}"
                                                                    target="blank">{!! getFileNameByPath($file->path,$file->type) !!}</a>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    @endif
                @elseif($page->type == 'News')
                    @if($page->style == 'classic')
                        <h1>{!! $page->title !!}</h1>
                        {!! $page->body !!}
                        @if($page->categories->posts()->exists())
                            @php $posts = $page->categories->posts()->paginate(2); @endphp
                            {!! $posts->render() !!}
                            <br>
                            <br>
                            <div class=hr></div>
                            @foreach($posts as $post)
                                {!! \App\Ekeng\Post\PostRepository::createDesign($post) !!}
                            @endforeach
                        @endif

                        <br>
                        <br>
                        {!! $posts->render() !!}
                        <br>
                        <br>

                    @elseif($page->style == 'accordion')
                        <h1>{!! $page->title !!}</h1>
                        {!! $page->body !!}
                        @if($page->categories->posts()->exists())
                            @foreach($page->categories->posts as $post)
                                {!! \App\Ekeng\Post\PostRepository::faq($post) !!}
                            @endforeach
                            <script src="/site/js/faq.js"></script>
                        @endif
                    @endif
                @elseif($page->type == 'VideoGallery')
                    @if($page->galleryType == "video")
                        <h1>{!! $page->title !!}</h1>
                            {!! $page->body !!}
                        <div class="video2">
                            @php $videos = $page->videoLinks()->orderBy('id','desc')->paginate(9) @endphp
                            @foreach ($videos as $video)
                                <iframe width="560" height="340" src="{{$video->url}}"
                                        allowfullscreen></iframe>
                            @endforeach
                            <div class=clear></div>
                            <br>
                            {!! $videos->render() !!}
                            <br>
                            <br>
                        </div>
                @endif
            @endif
            <!-- END CONTENT COLUM 2 -->
            </div>
        </div>
    </div>

    <!-- END CONTENT -->
@stop

@section('footer')
    @include('site.layout.footer')
@stop()
