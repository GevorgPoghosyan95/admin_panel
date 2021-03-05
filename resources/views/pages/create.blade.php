@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
{{--<script src="/js/tiny.js"></script>--}}
<style>
    textarea {
        height: 400px;
    }

    input.btn {
        margin-top: 10px;
        float: right;
    }

    .image-uploader .uploaded .uploaded-image {
        width: calc(100% - 1rem);
        padding-bottom: calc(100% - 1rem);
    }

    .image-uploader .uploaded .uploaded-image img {
        object-fit: contain
    }
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')

<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div id="lang-switch">
            <img src="/images/armenia.png" class="hy">
            <img src="/images/english.png" class="en">
            <img src="/images/russia.png" class="ru">
        </div>
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            {!! Form::open( ['method' => 'POST','route' => 'pages.store', 'files' => true]) !!}
            <label for="title" style="font-size: 26px">Title</label>
            <input type="hidden" name="lang" value="hy">
            <input type="text" class="form-control" name="title" id="title"><br>
            <label for="path" style="font-size: 26px">Path</label>
            <input type="text" class="form-control" name="path" id="path"><br>
            <label for="path" style="font-size: 26px">Page Type</label>
            <select class="form-control form-control-lg" name="page_type">
                <option value="" selected disabled>Choose here</option>
                @foreach($pageTypes as  $type)
                    <option value="{{$type}}">{{$type}}</option>
                @endforeach
            </select><br>
            <div class="content" style="display: none">
                @include('pages.type.content')
            </div>
            <div class="news" style="display: none">
                @include('pages.type.news',['categories'=>$categories])
            </div>

            <input type="submit" value="Save" class="btn btn-success"/>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</body>
@include('layout.footer')
<script src="/js/pages/create.js"></script>
