@include('layout.app')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
{{--<script src="/js/tinymce.min.js"></script>--}}
<script src="/js/tiny.js"></script>

<style>

    textarea {
        height: 400px;
    }

    input.btn {
        margin-top: 10px;
        float: right;
    }
    .image-uploader .uploaded .uploaded-image {width: calc(100% - 1rem);
        padding-bottom: calc(100% - 1rem);}
    .image-uploader .uploaded .uploaded-image img{object-fit: contain}
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')
<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            {!! Form::model($page, ['method' => 'PUT','route' => ['pages.update', $page->id], 'files' => true]) !!}
            <label for="title" style="font-size: 26px">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{!! !empty($page->title) ? $page->title : '' !!}"><br>
            <label for="" style="font-size: 26px">Page Content</label>
            <textarea class="tiny_area" name="content"></textarea> <br>
            <div class="input-images" style="width: 10%"></div>
            <div class="img-alert" style="color: red;padding-left: 5px;font-size: 12px"></div> <br>
            {{--                <input type="file" name="doc" >--}}
            <input type="hidden" name="img" value="{{$page->image}}" id="img">
            <input type="submit" value="Save" class="btn btn-success"/>
            <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>

    </div>
</div>

</body>
<script>
    $(document).ready(function () {
        let myImg = '{{($page->image)}}' ? 'data:image/png;base64,{{($page->image)}}' : '',
            pre = myImg !== '' ? [{id: 1, src: myImg}] : [];
        tinymce.init({
            selector: 'textarea.tiny_area',
            setup: function (editor) {
                editor.on('init', function (e) {
                    editor.setContent(`{!! !empty($page->body) ? $page->body : '' !!}`);
                });
            }
        });
        $('.input-images').imageUploader({
            imagesInputName: 'photos',
            maxFiles: 1,
            preloaded: pre
        });
        $('.iui-close').click(function () {
            $('#img').val('')
        });
    });
</script>
@include('layout.footer')
