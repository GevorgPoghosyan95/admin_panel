<!doctype html>

<html lang="hy">

<head>

    <title>{!! __('translations.title') !!}</title>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta content="telephone=no" name="format-detection">

    <meta name="keywords" content="Շուկայի վերահսկողության տեսչական մարմին">
    <meta name="description" content="Շուկայի վերահսկողության տեսչական մարմին">

    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="/site/css/style.css" type="text/css">
    <link rel="stylesheet" href="/site/css/paginate.css" type="text/css">
    <link rel="stylesheet" href="/site/css/phone.css" type="text/css">
    <link rel="stylesheet" href="/site/css/ico.css" type="text/css">

    <script src="/site/js/jquery.min.js"></script>
    <script src="/site/js/menu.js"></script>
    <link rel='stylesheet' href='/site/css/gallery.css' type='text/css'>
    <script src="/site/js/gallery.js"></script>

    <link rel="stylesheet" href="/site/slider/css/slider.css" type="text/css">
    <script src="/site/slider/js/jquery.nivo.slider.js"></script>

    <link rel="stylesheet" href="/site/css/skin.css" type="text/css">
    <script src="/site/js/partner.js"></script>
    <script>$(function () {
            $('#carousel').carouFredSel({width: '93%', auto: {items: 1}, prev: '#prev', next: '#next'});
        });</script>

    <style type="text/css">body {
            top: 0px !important;
        }

        .skiptranslate {
            display: none !important;
        }</style>

    <script>window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-177383913-1');</script>

</head>

<body>
<!-- header yield-->
@yield('header')
<!-- page type yield-->
@yield('type')
<!-- footer yield-->
@yield('footer')
</body>
</html>
