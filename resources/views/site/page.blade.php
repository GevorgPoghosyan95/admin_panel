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
