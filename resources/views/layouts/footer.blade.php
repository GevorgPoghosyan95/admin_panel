@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
<link href="/css/home/index.css" rel="stylesheet" type="text/css"/>
<script src="/js/tinymce.min.js"></script>
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
        <div class="page-content">
            <form action="{{route('footer_store')}}" id="header_f" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="lang" value="hy">
                <input type="hidden" name="name" value="footer">
            @csrf

                <div class="row">
                    <div class="col-lg-5 ">
                        <h3>Add footer menu </h3>
                        @if(isset($data->menu_id))
                            {!! Form::select('menu_id', $menus,$data->menu_id ,['class' => 'form-control form-control-lg']); !!}
                        @else
                            <select name="menu_id" class="form-control form-control-lg">
                                <option disabled selected hidden>Choose Menu</option>
                                @foreach($menus as  $key=>$menu)
                                <option value="{{$key}}">{{$menu}}</option>
                                @endforeach
                            </select>
{{--                            {!! Form::select('menu_id',$menus, null,['class' => 'form-control form-control-lg']); !!}--}}
                        @endif
                    </div>
                    <div class="col-lg-7">
                        <h3 style="text-align: center">Add footer content</h3>
                        <textarea class="tiny_area" name="body" ></textarea><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h3 style="text-align: center">Add footer bottom content</h3>
                        <textarea class="tiny_area1" name="bottom_content" ></textarea><br>
                    </div>
                </div>
                <br>
                <input type="submit" value="Save" class="btn btn-success pull-right"/>
            </form>
        </div>
    </div>
</div>
<script>
    tinymce.init({
        selector: 'textarea.tiny_area1',
        height: "200",
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        /* enable title field in the Image dialog*/
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        file_picker_types: 'image',
        setup : function(ed)
        {
            ed.on('init', function(evt)
            {
                ed.setContent(`{!! !is_null($data->bottom_content) ? $data->bottom_content : ''!!}`);
            });
        },
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {title: file.name});
                };
                reader.readAsDataURL(file);
            };
            input.click();
        },

        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'

    })
    tinymce.init({
        selector: 'textarea.tiny_area',
        height: "200",
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        toolbar_sticky: true,
        /* enable title field in the Image dialog*/
        image_title: true,
        /* enable automatic uploads of images represented by blob or data URIs*/
        automatic_uploads: true,
        file_picker_types: 'image',
        setup : function(ed)
        {
            ed.on('init', function(evt)
            {
                ed.setContent(`{!! !is_null($data->body) ? $data->body : ''!!}`);
            });
        },
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {title: file.name});
                };
                reader.readAsDataURL(file);
            };
            input.click();
        },

        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'

    });
</script>
</body>