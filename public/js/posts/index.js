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

    $('#selectAll').click(function(){
        var $this = $(this);
        if($this.hasClass('checked')){
            $('input:checkbox').prop('checked',true);
            $this.toggleClass('checked');
            $this.text('Unselect');
        } else {
            $('input:checkbox').prop('checked',false);
            $this.toggleClass('checked');
            $this.text('Select All');
        }
    });

    $('#deleteSelected').click(function (e) {
        let params = [];
        $("input:checkbox[name=postCheckbox]:checked").each(function(){
            params.push($(this).val());
        });
        if(params.length !== 0){
            e.preventDefault()
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    confirmed = true
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:'POST',
                        url:'/posts/deleteChecked',
                        data:{'params':params},
                        success:function(result) {
                            if(result.status == 'OK'){
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                setTimeout(function(){
                                    window.location.reload()
                                },1000)
                            }else{
                                alert(result.error.message)
                            }
                        }
                    });
                }
            })
        }
    })
});
