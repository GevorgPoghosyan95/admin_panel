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
            <a target="_self" type="button" class="btn btn-primary" href="pages/create">Create New Page</a>
            <br><br>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Pages
                    </div>
{{--                    <div class="tools"></div>--}}
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_2">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Image</th>
                            <th>Document</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($pages)
                        @foreach($pages as $key=>$page)
                            <tr>
                                <td>{{$page->id}}</td>
                                <td>{{$page->title}}</td>
                                <td>{!!  substr($page->body,0,50) !!}</td>
                                <td >{!! $page->image ? "<img src='data:image/png;base64,$page->image' alt=''>" : '' !!}</td>
                                <td>{{$page->document}}</td>
                                <td>{{$page->created_at}}</td>
                                <td width="10%">
                                        {!! Form::open(['method' => 'DELETE','route' => ['pages.destroy', $page->id]]) !!}
                                        {!! Form::submit('Delete',array('class' => 'btn btn-sm btn-danger pull-right')) !!}
                                        {!! Form::close() !!}

                                        {!! Form::open(['method' => 'GET','route' => ['pages.edit', $page->id]]) !!}
                                        {!! Form::submit('Edit',array('class' => 'btn btn-sm btn-primary pull-right')) !!}
                                        {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@include('layout.footer')
<script>
    $(document).ready(function () {
        $('.alert').fadeOut('5000')
    })
</script>
<script src="/js/sweetAlert.js"></script>
