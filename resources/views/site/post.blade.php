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


            <!-- END COLUM LEFT 1 -->


            <!-- START CONTENT COLUM 2 -->
            <div class="content wrapper">
                <h1>{!! $post->title !!}</h1>

                <span class="data">{!! $post->created_at !!}</span>

                <div class="news">
                    {!! $post->content !!}
                </div>
                <br>
                <br>
                <p class="button" style="text-align:center"><a href="javascript:history.back()"
                                                               rel="nofollow">Վերադառնալ</a></p>
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
