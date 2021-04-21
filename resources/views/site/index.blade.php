@extends('site.layout.app')

@section('header')
    @include('site.layout.header')
@stop

@section('type')
    @if($homePage->car_template != 't1')
        <style>
            .slider-wrapper {
                width: 100%
            }

            .nivoSlider {
                height: 600px
            }

            .newshome {
                width: 1352px;
                margin: 0 auto;
                position: relative;
                display: block
            }

            .newshome div {
                width: 30%;
            }
        </style>
    @endif
    <!-- START SLIDER AND NEWS -->
    <div class="line1">
        <div class="line2 slidnews">
            <!-- START SLIDER -->
            <div class="slider-wrapper">
                <h2 class="icon_news">Նորություններ</h2>
                <div id="slider" class="nivoSlider">
                    @if(!empty($Car_news))
                        @foreach($Car_news as $item)
                            <a href="/post/more/{{$item->id}}"><img src="data:image/png;base64,{{$item->image}}" alt="2"
                                            title="{{$item->title}}"></a>
                        @endforeach
                    @else
                        @foreach($homePage->mainCarousel->files as $image)
                            <a href=""><img src="{{$image->path}}" alt="2"
                                            title="{{$image->title}}"></a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- END SLIDER -->

            <!-- START NEWS -->
            @if($homePage->car_template != 't1')
                @php
                    $pad = "padding: 10px";
                @endphp
        </div>
        @else
            {{--                 </div>--}}
            @php
                $pad = null;
            @endphp
        @endif
        <div class="newshome">
            @foreach($allnews as $n)
                @if($n->video == null)
                    <div  style="{{$pad}}"><img src="data:image/png;base64,{{$n->image}}" alt="" width=240>
                        <span class="data">{{Carbon\Carbon::parse($n->created_at)->formatLocalized('%d, %B %Y')}}</span>
                        <a href="/post/more/{{$n->id}}" class=newlink><p>
                                {!! Str::words(strip_tags($n->title), $words = 9, $end = '...') !!}</p>
                        </a>
                    </div>
                @else
                    <div style="{{$pad}}">
                        <video width="240" height="auto" controls="controls"
                               style="min-width: 200px; max-width: 600px; float:left; margin-right: 14px; margin-top: 0;"
                               poster="video/25.02.2021.png">
                            <source src="{{$n->video}}" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                        </video>

                        <span class="data">{{Carbon\Carbon::parse($n->created_at)->formatLocalized('%d, %B %Y')}}</span>
                        <a href="/post/more/{{$n->id}}" class=newlink>
                            <p>  {!! Str::words(strip_tags($n->title), $words = 15, $end = '...') !!}</p></a>
                    </div>
                @endif
            @endforeach
            <p style="text-align: center; margin-bottom: 24px;"><a href="/{{app()->getLocale()}}/news" class="newlink">Բոլոր
                    նորությունները
                    &#10140;</a></p>
        </div>
        <!-- END NEWS -->
        @if($homePage->car_template != 't1')
            {{--            </div>--}}
        @else
    </div>
    @endif

    </div>
    <!-- END SLIDER AND NEWS -->


    <!-- START SERVICE -->
    <div class="line1 bggrey">
        <div class="line2">

            <h2 class="icon_service">Ծառայություններ</h2>

            <div class="service">

                @foreach ($menu->menuItems()->orderBy('order','asc')->get() as $item)
                    <div class="plus">
                        <a href="{!! '/'.$item->page->lang.$item->page->path !!}"
                           onmouseover="this.style='background-color:{{$item->page->color}};';"
                           onmouseout="this.style='background-color:{{$item->page->bg_color}}';"
                           style="background-image: 'data:image/png;base64'{{$item->page->image}};background-color: {{$item->page->bg_color}};">
                            <div class="ico">
                                <div class="icoim1"
                                     style="background: url('data:image/gif;base64,{{$item->page->image}}');background-size: 40px">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="ca-content">
                                <h4 class="ca-main">{!! $item->page->title !!}</h4>
                            </div>
                        </a></div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- END SERVICE -->

    <!-- START VIDEO -->
    @if($homePage->video_block == 'on')
        <div class="line1">
            <div class="line2">
                <h2 class="icon_video">Տեսանյութեր</h2>
                <div class=video>
                    @foreach($video_links as $video)
                        @if (strpos($video, 'youtube') !== false)
                            <div>
                                <iframe width="560" height="340" src="{{$video->url}}"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        @else
                            <div>
                                <video width="800" height="auto" controls="controls"
                                       style="min-width: 200px; max-width: 610px; float:left; margin-right: 14px; margin-top: 0;"
                                       poster="video/25.02.2021.png">
                                    <source src="{{$video->url}}" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                                </video>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- END VIDEO -->


    <!-- START PARTNER -->
    @if($homePage->partners_carousel == 'on')
        <div class="line1 bggrey">
            <div class="line2">
                <h2 class="icon_partner">Գործընկերներ</h2>
                <div class="partner">
                    <a id="prev" href="#"></a>
                    <div id="carousel">
                        @foreach($partners as $partner)
                            <div class="partner_bl" style="float: left" data-id="{{$partner->id}}">
                                <span aria-hidden="true" class="rem"><i class="fa fa-close img_del"></i></span>
                                <a href="{{$partner->url}}" target="_blank">
                                    <img src="data:image/png;base64,{{$partner->image}}" width="280"
                                         height="90"
                                         alt="{{$partner->description}}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <a id="next" href="#"></a>
                </div>
            </div>
        </div>
    @endif
    <!-- END PARTNER -->

    <!-- START CHAT -->

    <div class="line1">
        <div class="line2">

            <h2 class="icon_chat">Առցանց դիմում</h2>

            <div class="chat">

                <div class="plus">
                    <a href="https://e-request.am/hy/" class="icop1" target=_blank>
                        <div class="ico">
                            <div class="icoim1"></div>
                        </div>
                        <div class="ca-content">Առցանց հարցում</div>
                    </a>
                </div>

                <div class="plus">
                    <a href="doc/Դիմում-բողոք ներկայացնելու ձև.docx" class="icop2" target=_blank>
                        <div class="ico">
                            <div class="icoim2"></div>
                        </div>
                        <div class="ca-content">Դիմում-բողոքի օրինակելի ձև</div>
                    </a>
                </div>

                <div class="plus"><a href="doc/Տեղեկատվություն ստանալու նամակի ձև.docx" class="icop3">
                        <div class="ico">
                            <div class="icoim3"></div>
                        </div>
                        <div class="ca-content">Տեղեկատվություն ստանալու օրինակելի ձև</div>
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- END CHAT -->

    <!-- START RATING -->

    <div class="line1 bggrey">
        <div class="line2">

            <h2 class="icon_rate">Վարկանիշ</h2>

            <div class="rate">

                <div>
                    <span class=user1><img src="/site/img/star4.png" width=90 height=18 alt="rate 4"></span>
                    <h4>Օրինակելի տնտեսվարող</h4>

                    <ol>
                        <li>ՍԻՓԻԷՍ ՕԻԼ ՍՊԸ - Նավթամթերքի իրացում</li>
                        <li>ԵՐԵՎԱՆ ԱՐԱՐԱՏ ԿՈՆՅԱԿԻ-ԳԻՆՈՒ-ՕՂՈՒ ԿՈՄԲԻՆԱՏ ԲԲԸ - Ալկոհոլային խմիչքների արտադրություն, իրացում
                        </li>
                        <li>"ՄՐԳԱՆՈՒՇ" ԳԻՆՈՒ-ԿՈՆՅԱԿԻ ԳՈՐԾԱՐԱՆ ՍՊԸ - Գյուղմթերքների մթերում, ալկոհոլային խմիչքներ
                            արտադրություն և իրացում
                        </li>
                        <li>ՍԱՄԿՈՆ ՍՊԸ - Ալկոհոլային խմիչքներ արտադրություն և իրացում</li>
                    </ol>

                    <a href="rating.html">Մանրամասն &#10140;</a>

                </div>

                <div>
                    <span class=user2><img src="/site/img/star1.png" width=90 height=18 alt="rate 1"></span>
                    <h4>Ոչ օրինակելի տնտեսվարող</h4>
                </div>

            </div>

        </div>
    </div>

    <!-- END RATING -->
@stop

@section('footer')
    @include('site.layout.footer')
@stop()
