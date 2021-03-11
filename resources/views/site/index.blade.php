@extends('site.layout.app')

@section('header')
    @include('site.layout.header')
@stop

@section('content')

    <!-- START SLIDER AND NEWS -->

    <div class="line1">
        <div class="line2 slidnews">

            <!-- START SLIDER -->

            <div class="slider-wrapper">

                <h2 class="icon_news">Նորություններ</h2>

                <div id="slider" class="nivoSlider">
                    <a href="announcements.html"><img src="/site/slider/img/02.jpg" alt="2"
                                                      title="Մրցույթ՝ քաղաքացիական ծառայության թափուր պաշտոն զբաղեցնելու համար"></a>
                    <a href="22-09-2020.html"><img src="/site/slider/img/04.jpg" alt="3"
                                                   title="Փորձաքննության ենթարկված ալկոգելերում թունավոր նյութեր չեն հայտնաբերվել. ՇՎՏՄ"></a>
                    <a href="01-06-2018.html"><img src="/site/slider/img/01.jpg" alt="1"
                                                   title="ՀԱՊՀ ուսանողներին ներկայացվեցին շուկայի անվտանգության հետ կապված հարցեր"></a>
                </div>

            </div>

            <!-- END SLIDER -->

            <!-- START NEWS -->

            <div class="newshome">

                <div>
                    <video width="240" height="auto" controls="controls"
                           style="min-width: 200px; max-width: 600px; float:left; margin-right: 14px; margin-top: 0;"
                           poster="video/25.02.2021.png">
                        <source src="/site/video/25.02.2021.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>

                    <span class="data">25, Փետրվար  2021</span>
                    <a href="25-02-2021.html" class=newlink><p>
                            ՇՎՏՄ-ն սույն թվականի հունվար-փետրվար ամիսներին իրականացրել է իրազեկման գործընթաց ...</p></a>
                </div>

                <div><img src="/site/news/12.02.21-1-1.jpg" alt="" width=240>
                    <span class="data">12, Փետրվար  2021</span>
                    <a href="12-02-2021.html" class=newlink><p>
                            ՇՎՏՄ ղեկավարը և տեղակալը մասնակցել են ՀՀ էկոնոմիկայի նախարարությունում կայացած՝ չափումների
                            ...</p>
                    </a>
                </div>

                <div><img src="/site/news/01-02-2021_1.jpg" alt="" width=240>
                    <span class="data">1, Փետրվար  2021</span>
                    <a href="01-02-2021.html" class=newlink><p>ՇՎՏՄ 2020 թ. գործունեության տարեկան հաշվետվությունը
                            կառավարման խորհրդի նիստում արժանացավ ... </p></a>
                </div>


                <p style="text-align: center; margin-bottom: 24px;"><a href="news.html" class="newlink">Բոլոր
                        նորությունները
                        &#10140;</a></p>

            </div>

            <!-- END NEWS -->

        </div>
    </div>

    <!-- END SLIDER AND NEWS -->


    <!-- START SERVICE -->

    <div class="line1 bggrey">
        <div class="line2">

            <h2 class="icon_service">Ծառայություններ</h2>

            <div class="service">

                <div class="plus"><a href="consumer.html" class="icop1">
                        <div class="ico">
                            <div class="icoim1">&nbsp;</div>
                        </div>
                        <div class="ca-content">
                            <h4 class="ca-main">Սպառողին</h4>
                        </div>
                    </a></div>

                <div class="plus"><a href="applications.html" class="icop2">
                        <div class="ico">
                            <div class="icoim2">&nbsp;</div>
                        </div>
                        <div class="ca-content">
                            <h4 class="ca-main">Ստուգումների ծրագիր</h4>
                        </div>
                    </a></div>

                <div class="plus"><a href="technical_regulations.html" class="icop3">
                        <div class="ico">
                            <div class="icoim3">&nbsp;</div>
                        </div>
                        <div class="ca-content">
                            <h4 class="ca-main">Տեխնիկական կանոնակարգեր</h4>
                        </div>
                    </a></div>

                <div class="plus"><a href="business.html" class="icop4">
                        <div class="ico">
                            <div class="icoim4">&nbsp;</div>
                        </div>
                        <div class="ca-content">
                            <h4 class="ca-main">Տնտեսվարողին</h4>
                        </div>
                    </a></div>

                <div class="plus"><a href="services.html" class="icop5">
                        <div class="ico">
                            <div class="icoim5">&nbsp;</div>
                        </div>
                        <div class="ca-content">
                            <h4 class="ca-main">Ծառայություններ</h4>
                        </div>
                    </a></div>

            </div>

        </div>
    </div>

    <!-- END SERVICE -->

    <!-- START VIDEO -->

    <div class="line1">
        <div class="line2">

            <h2 class="icon_video">Տեսանյութեր</h2>

            <div class=video>
                <div>
                    <video width="800" height="auto" controls="controls"
                           style="min-width: 200px; max-width: 610px; float:left; margin-right: 14px; margin-top: 0;"
                           poster="video/25.02.2021.png">
                        <source src="/site/video/25.02.2021.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                    </video>
                </div>
                <div>
                    <iframe width="560" height="340" src="https://www.youtube.com/embed/qKESozBo3jk"
                            allowfullscreen></iframe>
                </div>

            </div>

        </div>
    </div>

    <!-- END VIDEO -->


    <!-- START PARTNER -->

    <div class="line1 bggrey">
        <div class="line2">

            <h2 class="icon_partner">Գործընկերներ</h2>

            <div class="partner">
                <a id="prev" href="#"></a>
                <div id="carousel">
                    <div><a href="https://www.gov.am/am/"><img src="/site/img/parliament_logo.png" width="280"
                                                               height="90"
                                                               alt="ՀՀ Ազգային ժողով"></a></div>
                    <div><a href="http://www.metrology.am/hy/" target="_blank"><img src="/site/img/partner_logo2.png"
                                                                                    width="225"
                                                                                    height="75"
                                                                                    alt="Ստանդարտացման և չափագիտության ազգային մարմին"></a>
                    </div>
                    <div><a href="index.html"><img src="/site/img/partner_logo1.png" width="319" height="91" alt=""></a>
                    </div>
                    <div><a href="http://www.armnab.am/" target="_blank"><img src="/site/img/partner_logo3.png"
                                                                              width="293"
                                                                              height="63"
                                                                              alt="Հավատարմագրման ազգային մարմին"></a>
                    </div>
                    <div><a href="http://www.competition.am/" target="_blank"><img src="/site/img/partner_logo5.png"
                                                                                   width="335"
                                                                                   height="70"
                                                                                   alt="ՀՀ տնտեսական մրցակցության պաշտպանության պետական հանձնաժողով"></a>
                    </div>
                </div>
                <a id="next" href="#"></a>
            </div>

        </div>
    </div>

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
