@extends('site.layout.app')

@section('header')
    @include('site.layout.header')
@stop

@section('content')
    <!-- START CONTENT -->

    <div class="line1">
        <div class="line2">

            <!-- START COLUM LEFT 1 -->

            <div class="left">

                <!-- START MENU 2 -->

                <div class="menu2">

                    <nav>

                        {!! showSubMenu('About Us') !!}

                    </nav>

                </div>

                <!-- END MENU 2 -->

            </div>

            <!-- END COLUM LEFT 1 -->


            <!-- START CONTENT COLUM 2 -->

            <div class="content wrapper">
                {!! $page->body !!}
            </div>

            <!-- END CONTENT COLUM 2 -->

        </div>
    </div>

    <!-- END CONTENT -->
@stop

@section('footer')
    @include('site.layout.footer')
@stop()
