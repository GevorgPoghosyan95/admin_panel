@include('layout.app')
@include('layout.page_styles')
<style>
    .btn-group {position: relative!important;}
    table img{height: 100px;width:100px;object-fit: cover}
    tbody tr {height: 100px!important;}
    .dropdown-menu.pull-left {
        position: relative;
        z-index: 1000;
    }
</style>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
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
        <div id="lang-switch">
            <img src="/images/armenia.png" class="hy">
            <img src="/images/english.png" class="en">
            <img src="/images/russia.png" class="ru">
        </div>
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
                                <th>Path</th>
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
<script src="/js/pages/index.js"></script>