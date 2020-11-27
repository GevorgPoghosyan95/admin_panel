@include('layout.app')
@include('layout.page_styles')
<style>
    .btn-group {position: relative!important;}
    table img{height: 100px;width:100px;object-fit: cover}
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
                    <table class="table table-striped table-bordered table-hover" >
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
                                    <td>
                                        <div class="btn btn-sm btn-danger pull-right delete" style="margin-left: 0!important;" data-id="{{$menu->id}}">
                                            <i class="voyager-trash"></i> Delete
                                        </div>
                                        <a href="/menus/1/edit" class="btn btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> Edit
                                        </a>
                                        <a href="/menu/builder/{{$menu->id}}" class="btn btn-sm btn-success pull-right">
                                            <i class="voyager-list"></i> Builder
                                        </a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('menu_item')}}" method="post">
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
@include('layout.footer')