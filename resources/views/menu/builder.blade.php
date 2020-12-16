@include('layout.app')
@include('layout.header')
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <style>
        .add_to:hover {
            cursor: pointer;
            color: red
        }

        .buttons {
            z-index: 9;
            position: relative;
            top: 4px;
            right: 10px;
            float: right;
        }

        .buttons .btn {
            padding: 6px 15px;
            margin: 5px 5px 5px 0;
            border-radius: 5px !important;
        }

        .delete {
            margin-left: 0 !important;
        }

        .dd {
            max-width: 100%
        }

        .dd-handle {
            display: block;
            height: 50px;
            margin: 10px 0;
            padding: 14px 20px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            background: #fafafa;
            border-radius: 5px !important;
            box-sizing: border-box;
            font-size: 15px;
            box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, .2);
            transition: all ease 0.3s;
        }

        .dd-handle:hover {
            cursor: pointer
        }

        .flash-modal {
            position: fixed;
            top: 75px;
            right: -250px;
            z-index: 1000;
            max-width: 25%;
            background-color: #ff6f36;
            border-radius: 4px !important;
        }

        .flash-modal p {
            padding: 10px 10px;
            margin: 0;
            color: #ffffff;
            font-size: 20px;
        }

        #menuItemModal, .close {
            float: left;
        }

        #menuItemModal {
            width: 98%
        }
    </style>
@include('layout.sidebar')
<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="row">
                <div class="col-lg-3 pull-left">
                    <span style="font-size: 24px;line-height: 26px"><i class="fa fa-bars" aria-hidden="true"></i> {{$menu->name}} (menu)</span>
                    <button type="button" class="btn btn-success"
                            style="margin-left: 15px;border-radius: 5px!important;" data-toggle="modal"
                            data-target="#menu_item_form">
                        add new menu Item
                    </button>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="dd">
                    <ol class="dd-list outer">
                        <div id="dd-empty-placeholder"></div>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="flash-modal">
    <p></p>
</div>


{{--------------------new item modal--}}
<div class="modal fade" id="menu_item_form" tabindex="-1" role="dialog" aria-labelledby="menuItemLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="menuItemModal">
                    Title of the Menu Item </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="0">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="url">URL for the Menu Item </label>
                    <input type="text" class="form-control" id="url" placeholder="url">
                </div>
                <div class="form-group">
                    <label for="page">Select page</label>
                    <select class="form-control" id="page">
{{--                        <option selected="selected">choose page</option>--}}
                        @foreach($pages as $page)
                            <option value="{{$page->id}}">{{$page->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="target">Open in </label>
                    <select class="form-control" id="target">
                        <option value="_self">Same window</option>
                        <option value="_blank">New window</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-top-0 d-flex justify-content-center">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                <button id="subm" type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $.get("/menu/builder/edit/{{$menu->id}}", function (data) {
            data = JSON.parse(data);
            let obj = {children: []};
            $.each(data, function (key, value) {
                // console.log(value);
                $('.dd').nestable('add', value);
            });
            $('.dd-item').each(function (i, v) {
                // console.log(v.attributes['data-id'].value);
                $(this).prepend('<div class="buttons">' +
                    '<div class="btn btn-sm btn-danger pull-right delete" data-id="' + v.attributes['data-id'].value + '"> Delete </div>' +
                    '<div class="btn btn-sm btn-primary pull-right edit" data-id="' + v.attributes['data-id'].value + '" > Edit </div>' +
                    '</div>')
            });
            if ($('.outer .dd-item').length === 0) {
                $('.dd-empty').show();
            } else {
                $('.dd-empty').hide();
            }
        });

        $('.dd').nestable({maxDepth: 3});
        $(document).on("click", ".delete", function () {
            var r = confirm("Delete item ?");
            if (r == true) {
                let id = $(this).data('id');
                if (!$(this).parent().parent().hasClass('outer')) {
                    $(this).parent().parent().remove()
                } else {
                    $(this).parent('.dd-item').remove();
                }
                $.post('{{ route('menu_item_delete') }}', {
                    item_id: id,
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    data = JSON.parse(data);
                    data.status === 'success' ? flashMessage(data.message) : flashMessage(data.message, 'red');
                });
                if ($('.outer .dd-item').length === 0) {
                    $('.dd-empty').show();
                }
            }
        });
        $(document).on("click", ".edit", function () {
            // console.log($(this).data('id'));
            $('input[name="id"]').val($(this).data('id'));
            $('#title').val($(this).closest(".dd-item").data('title'));
            // console.log($(this).closest(".dd-item").data('title'));
            $('input[name="id"]').val($(this).data('id'));
            $('#menu_item_form').modal('show')
        });
        $('#menu_item_form').on('hidden.bs.modal', function (e) {
            $(this).find('input[name="id"]').val(0);
        });
        $('#subm').click(function () {
            let page = $('#page').val(),
                title = $('#title').val(),
                url = $('#url').val(),
                target  = $('#target').val();
            if ($('#menu_item_form input[name="id"]').val() == 0) {

            }
            // let str = '<li class="dd-item" data-id="0" data-order="1" data-title="'+ title+'"><div class="buttons">' +
            //     '<div class="btn btn-sm btn-danger pull-right delete" data-id="0"> Delete </div>' +
            //     '<div class="btn btn-sm btn-primary pull-right edit" data-id="0" > Edit </div>' +
            //     '</div> <div class="dd-handle"> ' + title + '</div></li>';
            // $('.outer').append(str);
            // $('.dd-empty').hide();
            // console.log($('.outer .dd-item').length);
            $.post('{{ route('menu_item_add') }}', {
                // list: JSON.stringify($('.dd').nestable('serialize')),
                // id: 0,
                title: title,
                order: 1,
                menu_id: '{{$menu->id}}',
                page_id: page,
                target : target,
                _token: '{{ csrf_token() }}'
            }, function (data) {
                $('.dd-empty').hide();
                data = JSON.parse(data);
                $('.outer').append('<li class="dd-item" data-id="' + data.id + '" data-order="1" data-title="' + title + '"> <div class="buttons">' +
                    '<div class="btn btn-sm btn-danger pull-right delete" data-id="' + data.id + '"> Delete </div>' +
                    '<div class="btn btn-sm btn-primary pull-right edit" data-id="' + data.id + '" > Edit </div>' +
                    '</div><div class="dd-handle"> ' + title + '</div></li>');
                data.status === 'success' ? flashMessage(data.message) : flashMessage(data.message, 'red');
            });
        });
        $('.dd').on('change', function (e) {
            $('.flash-modal').css({'right': '-250px', 'transition': '1s'});
            $('.flash-modal p').html('')
            // console.log(JSON.stringify($('.dd').nestable('serialize')));
            $.post('{{ route('menu_create') }}', {
                list: JSON.stringify($('.dd').nestable('serialize')),
                menu_id: '{{$menu->id}}',
                _token: '{{ csrf_token() }}'
            }, function (data) {
                data = JSON.parse(data);
                data.status === 'success' ? flashMessage(data.message) : flashMessage(data.message, 'red');
            });
        });

        function flashMessage(message, color = '#ff6f36') {
            $('.flash-modal p').html(message)
            $('.flash-modal').css({'right': '35px', 'transition': '1s', 'background-color': color})
            setTimeout(function () {
                $('.flash-modal').css({'right': '-250px', 'transition': '1s'})
            }, 3000)
        }

        $('#page').change(function () {
            console.log($(this).val());
            $.get("/menu/builder/edit/get_page/"+$(this).val(),function (res) {
                res = JSON.parse(res);
                if(res.status === "success"){
                    $('#menu_item_form').find('input[id="title"]').val(res.data.title);
                    // console.log(res.data.title);
                }else{
                    alert("error")
                    $('#menu_item_form').modal('hide');
                }
            });
        })
    })

</script>
</body>
@include('layout.footer')
