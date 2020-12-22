@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
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
            {!! Form::open( ['method' => 'POST','route' => 'posts.store', 'files' => true]) !!}
            <label for="title" style="font-size: 18px">Title</label>
            <input type="hidden" name="lang" value="hy">
            <input type="text" class="form-control" name="title" id="title">
            <label for="title" style="font-size: 18px">Category</label><br>
            {!! Form::select('category', $categories, null,['multiple class' => 'chosen-select form-control','style'=>'width:20%']); !!}<br>
            <label for="" style="font-size: 18px">Post Content</label>
            <textarea class="tiny_area" name="content"></textarea><br>
            <div class="input-images" style="width: 10%"></div>
            <input type="submit" value="Save" class="btn btn-success"/>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    $('.input-images').imageUploader({
        imagesInputName: 'photos',
        maxFiles: 1,
    });
    $(document).ready(function () {
        tinymce.init({
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            selector: 'textarea.tiny_area',
        });
    })
</script>
</body>
@include('layout.footer')
<script>
    $(document).ready(function () {
        $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    });
</script>
<script src="/js/posts/create.js"></script>
