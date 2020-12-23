$(document).ready(function(){
    $('#lang-switch .hy').addClass("active-flag");
    let lang = 'hy';
    let token = $('meta[name="csrf-token"]').attr('content')
    showcategories(lang)
    $(function() {
        $("#lang-switch .hy").click(function() {
            lang = 'hy'
            showcategories(lang)
           // $('input[name="lang"]').val('hy')
            $('#lang-switch .hy').addClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        // English button
        $("#lang-switch .en").click(function() {
            lang = 'en'
            showcategories(lang)
           // $('input[name="lang"]').val('en')
            $('#lang-switch .en').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        $("#lang-switch .ru").click(function() {
            lang = 'ru'
            showcategories(lang)
            // $('input[name="lang"]').val('ru')
            $('#lang-switch .ru').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
        });
    });

//categories show
    function showcategories(lang) {
        $('#categories').DataTable().destroy();
        $('#categories').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 0, 'desc' ]],
            "ajax": {
                "url": "/categories_foreach",
                "dataType": "json",
                "type": "POST",
                "data": {_token: token,lang:lang},
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "created_at"},
                {"data": "options"},
            ]

        });
    }
});
