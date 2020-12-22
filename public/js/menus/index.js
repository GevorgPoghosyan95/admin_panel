$(document).ready(function(){
    $('#lang-switch .hy').addClass("active-flag");
    let lang = 'hy';
    let token = $('meta[name="csrf-token"]').attr('content')
    showmenus(lang)
    $(function() {
        $("#lang-switch .hy").click(function() {
            $('input[name="lang"]').val('hy')
            lang = 'hy'
            showmenus(lang)
            $('#lang-switch .hy').addClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        // English button
        $("#lang-switch .en").click(function() {
            $('input[name="lang"]').val('en')
            lang = 'en'
            showmenus(lang)
            $('#lang-switch .en').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        $("#lang-switch .ru").click(function() {
            $('input[name="lang"]').val('ru')
            lang = 'ru'
            showmenus(lang)
            $('#lang-switch .ru').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
        });
    });

//menus show
    function showmenus(lang) {
        $('#menus').DataTable().destroy();
        $('#menus').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 0, 'desc' ]],
            "ajax": {
                "url": "/menus_foreach",
                "dataType": "json",
                "type": "POST",
                "data": {_token: token,lang:lang},
            },
            "columns": [
                {"data": "name"},
                {"data": "options"},
            ]

        });
    }
});
