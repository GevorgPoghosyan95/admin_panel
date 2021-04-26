@extends('site.layout.app')

@section('header')
    @include('site.layout.header')
@stop

@section('type')
    <style>
        .main_p {
            width: 50%;margin: 0 auto;text-align: center;
        }
        .main_p .personal {border-radius: 0}
        .main_p p {text-align: center;}
    </style>
{{--{{dd($staff)}}--}}
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
            <h1>Ղեկավար կազմ</h1>
            @foreach($staff as $person)
            <div class="main_p">
                {!! $person->posts[0]->content!!}
            </div>
            @endforeach
        </div>
    </div>
</div>

@stop

@section('footer')
    @include('site.layout.footer')
@stop()