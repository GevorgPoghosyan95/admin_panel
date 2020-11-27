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

        .delete {
            width: 15%;
            margin: 0;
            position: absolute;
            right: 5px;
            top: 3px;
            text-align: center
        }

        .delete:hover {
            cursor: pointer
        }

        .dd {
            max-width: 100%
        }

        .pull-right {
            text-align: right;
            margin-right: 15px;
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
            border-radius: 3px !important;
            box-sizing: border-box;
            font-size: 15px;
            box-shadow: 0px 0px 1px 1px rgba(0, 0, 0, .2);
            transition: all ease 0.3s;
        }

        .dd-handle:hover {
            cursor: pointer
        }
    </style>
@include('layout.sidebar')
<!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <div class="row">
                <div class="col-lg-3 pull-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form">
                        New Item
                    </button>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="dd">
                    <ol class="dd-list outer">
                        <div id="dd-empty-placeholder"></div>
                        {{--                        @foreach($items as $item)--}}
                        {{--                            <li class="dd-item" data-id=" {{$item->id}}">--}}
                        {{--                                <div class="dd-handle"> {{$item->title}}</div>--}}
                        {{--                                <p class="delete">delete</p>--}}
                        {{--                            </li>--}}
                        {{--                        @endforeach--}}
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">
                    Title of the Menu Item </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                        @foreach($pages as $page)
                            <option value="{{$page->id}}">{{$page->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="page">Open in </label>
                    <select class="form-control" id="page">
                        <option value="1">Same window</option>
                        <option value="2">New window</option>
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
        $.get("/menu/builder/edit/{{basename(Request::path())}}", function (data) {
            let data1 = JSON.parse(data);
            let obj = {children: []};
            let rrt = '[{"id":1,"order":1,"children":[{"id":7,"parent_id":1,"order":1,"children":[{"id":9,"parent_id":7,"order":1,"children":[]},{"id":8,"parent_id":7,"order":2,"children":[]}]}]},{"id":10,"order":2,"children":[]}]';

            // console.log(obj);
            //console.log(data);
            $.each(JSON.parse(data),function (key,value) {
                $('.dd').nestable('add', value);
            })

            // $('.dd').nestable('add', {"id":7,"order":1,"title":"users","parent_id":null,"children":[{"id":1,"title":"Admin","parent_id":7,"order":3,"children":[]}]},{"id":9,"order":1,"title":"groups","parent_id":null,"children":[]},{"id":10,"order":1,"title":"test","parent_id":null,"children":[]},{"id":8,"order":2,"title":"permissions","parent_id":null,"children":[]});
            // $('.dd').nestable('add', {"id":1,"order":1,"children":[{"id":7,"parent_id":1,"order":1,"children":[{"id":9,"parent_id":7,"order":1,"children":[]},{"id":8,"parent_id":7,"order":2,"children":[]}]}]},{"id":10,"order":2,"children":[]});
            // $('.dd').nestable('add', {"id":1,"order":1  ,"children":[{"id":7,"parent_id":1,"order":1,"children":[{"id":9,"parent_id":7,"order":1,"children":[]},{"id":8,"parent_id":7,"order":2,"children":[]}]}]},{"id":10,"order":2,"children":[]});

        });

        $('.dd').nestable({maxDepth: 3});
        $(document).on("click", ".add_to", function () {
            $('.dd-empty').hide();
            $(this).removeClass('add_to');
            $(this).append('<button class="btn btn-alert delete" style="width: 15%;margin: 0;position: absolute;right: 5px;top: 3px;text-align: center">delete</button>');
            $(this).appendTo('.dd-list');
        });
        $(document).on("click", ".delete", function () {
            if (!$(this).parent().parent().hasClass('outer')) {
                $(this).parent().parent().remove()
            } else {
                $(this).parent('.dd-item').remove();
            }
            if ($('.outer .dd-item').length === 0) {
                $('.dd-empty').show();
            }
        });
        $('#subm').click(function () {
            let page = $('#page').val(),
                title = $('#title').val(),
                url = $('#url').val();
            $('.outer').append('<li class="dd-item" data-id="' + page + '" data-order="1" data-title="'+ title+'"> <div class="dd-handle"> ' + title + '</div><p class="delete">delete</p> </li>');
            $('.dd-empty').hide();
            // console.log(JSON.stringify($('.dd').nestable('serialize')));
            $.post('{{ route('menu_create') }}', {
                list: JSON.stringify($('.dd').nestable('serialize')),
                menu_id : '{{basename(Request::path())}}',
                _token: '{{ csrf_token() }}'
            }, function (data) {
                // console.log(data);
                ;
            });

        });
        $('.dd').on('change', function (e) {
            console.log($('.dd').nestable('serialize'));
            $.post('{{ route('menu_create') }}', {
                list: JSON.stringify($('.dd').nestable('serialize')),
                menu_id : '{{basename(Request::path())}}',
                _token: '{{ csrf_token() }}'
            }, function (data) {
                console.log(data);
            });
        });
    })
</script>
</body>
@include('layout.footer')