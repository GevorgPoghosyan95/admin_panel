<!-- START TOP BLOK -->

<div class="line1 shapka1">
    <div class="line2 shapka2">
        <div class=cell1>
            <a href="/"><img src="data:image/png;base64,{{$header_data->image}}"
                                                 alt="Շուկայի վերահսկողության տեսչական մարմին"
                                                 class="logotop"></a></div>
        <div class=cell2>

            <!-- START PHONE NAMBER -->

{{--            <span class="hotline"><span>ԹԵԺ ԳԻԾ</span> 010 23 56 00</span>--}}
            {!! $header_data->body!!}

            <!-- END PHONE NAMBER -->
        </div>

{{--        <div class=cell3>--}}
{{--            <img src="/site/img/gerb.png" alt="Շուկայի վերահսկողության տեսչական մարմին">--}}
{{--        </div>--}}

    </div>
</div>

<!-- END TOP BLOK -->

<div class="line1 shapka3">
    <div class="line2">

        <!--  START HORIZONTAL MENU -->
        <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder">&nbsp;</i>Մենյու</a>

        <nav>
            {!! showMenu($header_data->menu->name,$header_data->menu->id) !!}
        </nav>

        <!-- START SEARCH -->

        <div class="search">

            <form method="get" action="search.html" class="search-bar">
                <input type="search" placeholder="Որոնում" name="q" required>
                <button class="search-btn" type="submit">&nbsp;</button>
            </form>

        </div>

        <!-- END SEARCH -->

        <!--  END HORIZONTAL MENU -->

    </div>
</div>
