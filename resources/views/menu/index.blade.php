@include('layout.app')
@include('layout.page_styles')
<style>
    .btn-group {
        position: relative !important;
    }

    table img {
        height: 100px;
        width: 100px;
        object-fit: cover
    }
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')
<!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <p>{{ $error }}</p>
                    </div>
                @endforeach
            @endif
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Create new menu
            </button>
            <br><br>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Pages
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th style="text-align: center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td width="60%">{{$menu->name}}</td>
                                <td width="10%">
                                    <!-- Delete form begin -->
                                {!! Form::open(['method' => 'DELETE','route' => ['menu_delete', $menu->id]]) !!}
                                {!! Form::submit('Delete',array('class' => 'btn btn-sm btn-danger pull-right')) !!}
                                {!! Form::close() !!}
                                <!-- Delete form end -->
                                    <!-- Edit form begin -->
                                {!! Form::open(['method' => 'GET','route' => ['menu_edit', $menu->id]]) !!}
                                {!! Form::hidden('menu_name', $menu->name, array('class' => 'form-control')) !!}
                                {!! Form::submit('Edit',array('class' => 'btn btn-sm btn-primary pull-right edit')) !!}
                                {!! Form::submit('Save',array('class' => 'btn btn-sm btn-primary pull-right save','style'=>'display:none')) !!}
                                {!! Form::close() !!}
                                <!-- Edit form end -->
                                    <!-- Builder form begin -->
                                {!! Form::open(['method' => 'GET','route' => ['menu_builder', $menu->id]]) !!}
                                {!! Form::submit('Builder',array('class' => 'btn btn-sm btn-primary pull-right')) !!}
                                {!! Form::close() !!}
                                <!-- Builder form end -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('create_menu')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="url">Menu name</label>
                        <input type="text" class="form-control" id="name" placeholder="name" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/sweetAlert.js"></script>
<script>
    var lots_of_stuff_already_done = false;

    $('.edit').on('click', function(e) {
        e.preventDefault();
        let td = $(this).parents('td').siblings('td')
        let val = td.text()
        td.empty()
        td.append('<input type="text" name="menuName" class="form-control" value="'+ val +'"/>')
        $(this).siblings('.save').css('display','block')
        $(this).remove()
        $('input[name="menuName"]').keyup(function () {
            $('input[name="menu_name"]').val($(this).val())
        })
    });
</script>
@include('layout.footer')
