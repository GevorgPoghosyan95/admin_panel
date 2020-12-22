$(document).ready(function(){
    $('#lang-switch .hy').addClass("active-flag");
    let lang = 'hy';
    let token = $('meta[name="csrf-token"]').attr('content')
    showPosts(lang)
    $(function() {
        $("#lang-switch .hy").click(function() {
            lang = 'hy'
            showPosts(lang)
           // $('input[name="lang"]').val('hy')
            $('#lang-switch .hy').addClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        // English button
        $("#lang-switch .en").click(function() {
            lang = 'en'
            showPosts(lang)
           // $('input[name="lang"]').val('en')
            $('#lang-switch .en').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .ru').removeClass("active-flag");
        });

        $("#lang-switch .ru").click(function() {
            lang = 'ru'
            showPosts(lang)
            // $('input[name="lang"]').val('ru')
            $('#lang-switch .ru').addClass("active-flag");
            $('#lang-switch .hy').removeClass("active-flag");
            $('#lang-switch .en').removeClass("active-flag");
        });
    });
// posts search
    $(document).on('click','#search_res',function () {
        let params = $('.form-group').serializeArray();
        $('#posts').DataTable().destroy();
        let table = $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 0, 'desc' ]],
            // "pagingType": "full_numbers",
            "ajax": {
                "url": "/posts_search",
                "dataType": "json",
                "type": "POST",
                "data": {_token: token, params,lang:lang},
                "error": function (request, status, error) {
                    console.log(request.responseText);
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {"data": "content"},
                {"data": "image"},
                {"data": "created_at"},
                {"data": "options"},
            ]
        });

    });
//posts show
    function showPosts(lang) {
        $('#posts').DataTable().destroy();
        $('#posts').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 0, 'desc' ]],
            "ajax": {
                "url": "/posts_foreach",
                "dataType": "json",
                "type": "POST",
                "data": {_token: token,lang:lang},
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {"data": "content"},
                {"data": "image"},
                {"data": "created_at"},
                {"data": "options"},
            ]

        });
    }
});
