@include('layout.app')
@include('layout.page_styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            <button type="button" class="btn btn-primary" onclick="window.open('permissions/create')">Create New
                Permission
            </button>
            <br><br>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Permissions
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="permissions">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#permissions').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": true,
            "ajax": {
                "url": "{{ url('permissions_foreach') }}",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}"},
            },
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "created_at"},
                {"data": "updated_at"},
                {"data": "options"},
            ]

        });
    });
</script>
