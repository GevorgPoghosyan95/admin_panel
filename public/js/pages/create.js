$(document).ready(function () {
    $(".chosen-select").chosen({no_results_text: "Oops, nothing found!", width: '100%'});

    $('select[name = "folders[]"]').change(function () {
        let galleryType = $(this).val()
        showGalleryTypes(galleryType)
    })

    let galleryType = $('select[name = "folders[]"]').val()
    showGalleryTypes(galleryType)

    function showGalleryTypes(val) {
        if (val !== null) {
            $('.galleryType').html('                                       <button type="button" class="btn blue">Select Gallery Type</button>\n' +
                '                    <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">\n' +
                '                        <i class="fa fa-angle-down"></i>\n' +
                '                    </button>' +
                ' <div class="dropdown-menu hold-on-click dropdown-radiobuttons" role="menu">\n' +
                '                        <label>\n' +
                '                            <input type="radio" name="galleryType" value="video">VideoGallery</label>\n' +
                '                        <label>\n' +
                '                            <input type="radio" name="galleryType" value="photo">PhotoGallery</label>\n' +
                '                        <label>\n' +
                '                            <input type="radio" name="galleryType" value="file">FileGallery</label>\n' +
                '                    </div>\n' +
                '                </div>')
        } else {
            $('.galleryType').html('');
        }
    }

    let type = $('select[name = "page_type"]').val()
    showType(type)
    tinymce.init({
        selector: 'textarea.tiny_area',
        height: "480",
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

    $('.input-images').imageUploader({
        imagesInputName: 'photos',
        maxFiles: 1,
    });

    $('#lang-switch .hy').addClass("active-flag");
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

    //select page type
    $('select[name = "type"]').on('change', function () {
        type = this.value;
        if(type == 'Home Page'){
            window.location = '/home_page';
        } else{
            showType(type)
        }

    });

    function showType(type) {
        switch (type) {
            case "Content":
                $('.content').show();
                $('.news').hide();
                $('#videoLinks').hide();
                break;
            case "News":
                $('.news').show();
                $('.content').hide();
                $('#videoLinks').hide();
                break;
            case "VideoGallery":
                $('.news').hide();
                $('.content').show();
                $('#videoLinks').show();
                break;
            default:
            // code block
        }
    }


});
