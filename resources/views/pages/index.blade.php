@include('layout.app')
@include('layout.page_styles')
<style>
    .btn-group {position: relative!important;}
    table img{height: 100px;width:100px;object-fit: cover}
    tbody tr {height: 100px!important;}
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
                            <i class="fa fa-globe"></i>Posts
                        </div>
                        <div class="tools"></div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="pages">
                            <thead>
                            <tr >
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

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
<script>
    $(document).ready(function () {

        $('#pages').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "order": [[ 0, 'desc' ]],
            "ajax": {
                "url": "{{ url('pages_foreach') }}",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}"},
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {"data": "body"},
                {"data": "image"},
                {"data": "created_at"},
                {"data": "options"},
            ]

        });
    });

</script>