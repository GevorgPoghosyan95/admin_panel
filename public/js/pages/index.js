$(document).ready(function(){
    $('#lang-switch .hy').addClass("active-flag");
    let lang = 'hy';
    let token = $('meta[name="csrf-token"]').attr('content')
    showpages(lang)
    $(function() {
        $("#lang-switch .hy").click(function() {
            lang = 'hy'
            showpages(lang)
           // $('input[name="lang"]').val('hy')
            $('#lang-switch .hy').addClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        // English button
        $("#lang-switch .en").click(function() {
            lang = 'en'
            showpages(lang)
           // $('input[name="lang"]').val('en')
            $('#lang-switch .en').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        $("#lang-switch .ru").click(function() {
            lang = 'ru'
            showpages(lang)
            // $('input[name="lang"]').val('ru')
            $('#lang-switch .ru').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
        });
    });

//pages show
    function showpages(lang) {
        $('#pages').DataTable().destroy();
        $('#pages').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 0, 'desc' ]],
            "ajax": {
                "url": "/pages_foreach",
                "dataType": "json",
                "type": "POST",
                "data": {_token: token,lang:lang},
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {"data": "body"},
                {"data": "image"},
                {"data": "path"},
                {"data": "created_at"},
                {"data": "options"},
            ]

        });
    }
});
