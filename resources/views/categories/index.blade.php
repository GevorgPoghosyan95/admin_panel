@include('layout.app')

@include('layout.page_styles')
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
            <button type="button" class="btn btn-primary" onclick="window.open('categories/create')">Create New category</button>
            <br><br>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>categories
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key=>$category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->created_at}}</td>
                                <td>{{$category->updated_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button"
                                                data-toggle="dropdown"
                                                aria-expanded="false"> Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-left" category="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="icon-docs"></i>
                                                    {!! Form::open(['method' => 'DELETE','route' => ['categories.destroy', $category->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Delete',array('class' => 'btn btn-danger btn-xs')) !!}
                                                    {!! Form::close() !!} </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="icon-tag"></i>
                                                    {!! Form::open(['method' => 'GET','route' => ['categories.edit', $category->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Edit',array('class' => 'btn btn-primary btn-xs')) !!}
                                                    {!! Form::close() !!} </a>
                                            </li>
                                        </ul>
                                    </div>
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
@include('layout.footer')
<script src="/js/sweetAlert.js"></script>
