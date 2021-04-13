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

                <!-- END MENU 2 -->
            </div>


            <div class="content wrapper">

                <h1>Որոնման արդյունքը</h1>

                <!-- SEARCH RESULTS -->

                <script async src="https://cse.google.com/cse.js?cx=8a688df2910cb487a"></script>
                <div class="gcse-searchresults-only"></div>

                <!-- END SEARCH RESULTS -->
                {!! $posts->render() !!}
                <br>
                <br>
                <div class=hr></div>
                @foreach($posts as $post)
                    {!! \App\Ekeng\Post\PostRepository::createDesign($post) !!}
                @endforeach
                <br>
                <br>
                <p class="button" style="text-align:center"><a href="javascript:history.back()"
                                                               rel="nofollow">Վերադառնալ</a></p>
                <br>
                <br>
                <br>

            </div>
        </div>
    </div>

    <!-- END CONTENT -->
@stop

@section('footer')
    @include('site.layout.footer')
@stop()
