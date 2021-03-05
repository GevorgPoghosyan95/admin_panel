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
<script>
    $(document).ready(function () {
        $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
        let myImg = '{{($post->image)}}' ? 'data:image/png;base64,{{($post->image)}}' : '',
            pre = myImg !== '' ? [{id: 1, src: myImg}] : [];
        tinymce.init({
            selector: 'textarea.tiny_area',
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
            setup: function (editor) {
                editor.on('init', function (e) {
                    editor.setContent(`{!! !empty($post->content) ? $post->content : '' !!}`);
                });
            },
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
        });
        $('.input-images').imageUploader({
            imagesInputName: 'photos',
            maxFiles: 1,
            preloaded: pre
        });
        $('.iui-close').click(function () {
            $('#img').val('')
        })
    });
</script>
@include('layout.footer')

