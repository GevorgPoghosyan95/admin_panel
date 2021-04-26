<!-- START TOP BLOK -->
<style>
    .menu .active {background-color: #ffa82b;color: #fff}
    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
    }
</style>
<div class="line1 shapka1">
    <div class="line2 shapka2">
        <div class=cell1>
            <a href="/"><img src="/site/img/msib_logo.png"
                                                 alt="Շուկայի վերահսկողության տեսչական մարմին"
                                                 class="logotop"></a></div>
        <div class=cell2>

            <!-- START PHONE NAMBER -->

            <span class="hotline"><span>ԹԵԺ ԳԻԾ</span> 010 23 56 00</span>

            <!-- END PHONE NAMBER -->
        </div>

        <div class=cell3>
            <img src="/site/img/gerb.png" alt="Շուկայի վերահսկողության տեսչական մարմին">
        </div>

    </div>
</div>

<!-- END TOP BLOK -->

<div class="line1 shapka3">
    <div class="line2">

        <!--  START HORIZONTAL MENU -->
        <a id="touch-menu" class="mobile-menu" href="#"><i class="icon-reorder">&nbsp;</i>Մենյու</a>

        <nav>
            {!! showMenu("main",app()->getLocale()) !!}
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

<div class="hot-phone">
    <div class="hot-phone-icon">
        <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
            <div class="phonering-alo-ph-circle"></div>
            <div class="phonering-alo-ph-circle-fill">
                <a class="phone-img " href="tel:8107">
                    <img src="/images/icoim333.png" height="35px">
                </a>
            </div>

        </div>
    </div>
    <div class="number-phone tooltip" style="font-size: 12px"><span class="no_mobile">Թեժ գիծ</span> <br class="no_mobile">81 - 07</div>
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
<script>
    window.onscroll = function() {myFunction()};
    var header = $(".shapka3");
    var sticky = header.offset().top;

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.addClass("sticky");
        } else {
            header.removeClass("sticky");
        }
    }
</script>
