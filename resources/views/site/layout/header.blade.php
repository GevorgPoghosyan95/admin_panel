<!-- START TOP BLOK -->
<style>
    .menu .active {background-color: #ffa82b;color: #fff}
</style>
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

            <form method="get" action="/{{app()->getLocale()}}/search" class="search-bar">
                <input type="search" placeholder="Որոնում" name="params" required>
                <button class="search-btn" type="submit">&nbsp;</button>
            </form>

        </div>

        <!-- END SEARCH -->

        <!--  END HORIZONTAL MENU -->

    </div>
</div>
<script>
 $(document).ready(function () {
    let menu = $('.menu li');
     menu.click(function () {
         $(this).addClass('active');
         menu.not(this).removeClass('active');
     });
     menu.each(function () {
         let href = $(this).find('a').prop('href');
         let item = href.split('/');
         let hash = item[item.length - 1];
         let win_href = window.location.href;
         let win_href_item = win_href.split('/');
         if (win_href_item[win_href_item.length -1] === hash || win_href_item[win_href_item.length -2] === hash) {
             console.log($(this).closest('.parent').addClass('active'));
             $(this).find('.parent').addClass('active');
             // $('.m_menu[href*="'+ item[4]+'"]').addClass('active');
         }
     });
 })
</script>
