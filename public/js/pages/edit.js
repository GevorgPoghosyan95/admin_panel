$(document).ready(function () {
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
                editor.setContent(page_content);
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

//select page type
$('select[name = "type"]').on('change', function () {
    let type = this.value;
    showType(type)
});


function showType(type) {
    switch (type) {
        case "Content":
            $('.content').show();
            $('.news').hide();
            break;
        case "News":
            $('.news').show();
            $('.content').hide();
            break;
        case "Faq":
            $('.news').hide();
            $('.content').hide();
            break;
        default:
        // code block
    }
}
