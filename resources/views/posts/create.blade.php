@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<script src="/js/tiny.js"></script>
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
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            {!! Form::open( ['method' => 'POST','route' => 'posts.store', 'files' => true]) !!}
            <label for="title" style="font-size: 18px">Title</label>
            <input type="hidden" name="lang" value="hy">
            <input type="text" class="form-control" name="title" id="title">
            <label for="title" style="font-size: 18px">Category</label><br>
            {!! Form::select('category', $categories, null,['multiple class' => 'chosen-select form-control','style'=>'width:20%']); !!}<br>
            <label for="" style="font-size: 18px">Post Content</label>
            <textarea id="full-featured-non-premium" name="content"></textarea><br>
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
</script>
</body>
@include('layout.footer')
<script>
    $(document).ready(function () {
        $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    });
</script>
