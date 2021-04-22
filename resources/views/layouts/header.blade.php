@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
<link href="/css/home/index.css" rel="stylesheet" type="text/css"/>
<script src="/js/tinymce.min.js"></script>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<style>
    #header_f #imagePreview,#header_f #imagePreview1  {border-radius: 5px!important;}
    #header_f .rem_pl {top:0;font-size: 20px}
    #header_f #slogan {height: 57px;border-radius: 5px!important;}
    #header_f .slogan-preview {padding: 15px;font-size: 18px}
</style>
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
            <form action="{{route('header_store')}}" id="header_f" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="lang" value="hy">
                <input type="hidden" name="name" value="header">
                @csrf
                <div class="row">
                    <div class="col-lg-3 part_l ">
                        <h3>Add/change header logo</h3>
                        <label for="p_logo">Add site logo<i class="fa fa-cloud-upload" aria-hidden="true"></i> </label>
                        <input type="file" name="site_logo" id="p_logo" style="display: none">
                        <input type="hidden" name="old_pic" value="1">
                          @if(isset($data->image) && $data->image != '')
                                <div id="imagePreview1" style="background-repeat: no-repeat;position: relative;
                                        border: 1px solid grey;padding: 15px;height: auto">
                                <span aria-hidden="true" class="rem_pl"><i class="fa fa-close img_del"></i></span>
                                <img src='data:image/png;base64,{{$data->image}}' style='display: block;margin: 0 auto;width: 100%;'>

                                </div>
                        @endif
                            <div id="imagePreview" style="background-repeat: no-repeat;position: relative ">
                            </div>

                    </div>
                    <div class="col-lg-9">
                        <h3 style="text-align: center">Add/change header slogan</h3>
                        <textarea class="tiny_area" name="body" ></textarea><br>
                        <div class="slogan-preview"></div>
                    </div>
                </div>
                <div class="row">
                    @if(isset($data->menu_id))
                    {!! Form::select('menu_id', $menus,$data->menu_id ,['class' => 'form-control form-control-lg']); !!}
                     @else
                        {!! Form::select('menu_id',$menus, null,['class' => 'form-control form-control-lg']); !!}
                     @endif
                </div>
                <br>
                <input type="submit" value="Save" class="btn btn-success pull-right"/>
            </form>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        $('input[name="old_pic"]').val(1)
    })
    $('#p_logo').change(function () {
        $('#imagePreview1').hide()
        readURL(this, '#imagePreview');
        $('input[name="old_pic"]').val(2)
        $('#imagePreview').css({'border': '1px solid grey','padding': '15px','height':'auto' }).append('<span aria-hidden="true" class="rem_pl"><i class="fa fa-close img_del"></i></span>')
    });

    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).append('<img src="'+e.target.result +'" style="display: block;margin: 0 auto;width: 100%;">')
                // $(previewId).css({'background-image' : 'url('+e.target.result +')'});
                $(previewId).hide();
                $(previewId).fadeIn(650);
                $('label[for="p_logo"]').hide()
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).on('click','#imagePreview .rem_pl',function () {
        $('input[type="file"]').val('');
        $('#imagePreview').css('background-image' , '');
        $('#imagePreview').html('').css({'height':'0','padding' : '0','border':'none'});
        $('label[for="p_logo"]').show()
        $('#imagePreview1').show();
        $('input[name="old_pic"]').val(1)
    })

    $('#imagePreview1 .rem_pl').click(function () {
        $('#imagePreview1').hide();
        $('input[name="old_pic"]').val(0)
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

    $('#lang-switch .{!! $lang !!}').addClass("active-flag");
    $(function () {
        $("#lang-switch .hy").click(function () {
            $('input[name="lang"]').val('hy')
            $('#lang-switch .hy').addClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        // English button
        $("#lang-switch .en").click(function () {
            $('input[name="lang"]').val('en')
            $('#lang-switch .en').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        $("#lang-switch .ru").click(function () {
            $('input[name="lang"]').val('ru')
            $('#lang-switch .ru').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
        });
    });
</script>
@include('layout.footer')
