@include('layout.app')
<script src="/js/tinymce.min.js"></script>
{{--<script src="/js/tiny.js"></script>--}}
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
            {!! Form::model($post, ['method' => 'PUT','route' => ['posts.update', $post->id], 'files' => true]) !!}
                <label for="title" style="font-size: 18px">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="{!! !empty($post->title) ? $post->title : '' !!}"><br>
                <button class="btn btn-success" id="change_video">Change Video Link</button>
                <div class="video"></div>
                <label for="title" style="font-size: 18px">Category</label><br>
                {!! Form::select('category[]', $categories, $post->categories,['multiple class' => 'chosen-select form-control','style'=>'width:20%']); !!}<br>
                <label for="" style="font-size: 26px">Page Content</label>
                <textarea class="tiny_area" name="content"></textarea> <br>
                <div class="input-images" style="width: 10%"></div>
                <div class="img-alert" style="color: red;padding-left: 5px;font-size: 12px"></div> <br>
{{--                <input type="file" name="doc" >--}}
                <input type="hidden" name="img" value="{{$post->image}}" id="img">
                <input type="submit" value="Save" class="btn btn-success"/>
                <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>

    </div>
</div>

</body>
<script>  let myImg = '{{($post->image)}}' ? 'data:image/png;base64,{{($post->image)}}' : '',
        pre = myImg !== '' ? [{id: 1, src: myImg}] : [];
    let post_content = `{!! !empty($post->content) ? $post->content : '' !!}`
</script>
<script src="/js/posts/edit.js"></script>
@include('layout.footer')

