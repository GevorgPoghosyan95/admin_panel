@include('layout.app')
@include('layout.page_styles')
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .btn-group {
        position: relative !important;
    }

    table img {
        height: 100px;
        width: 100px;
        object-fit: cover
    }
    .dropdown-menu.pull-left {
        position: relative;
        z-index: 1000;
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
            <a target="_self" type="button" class="btn btn-primary" href="posts/create">Create New Post</a>
            <br><br>
                <div class="row">
                    <div class="col-md-12 srch_form">
                        <a id="search" href="#" style=";padding-top: 0;text-align: center;text-decoration: none;font-size: 20px;
                    display: block;width: 10%;margin: 0 auto">Search
                            <i class="fa fa-angle-down" style="transition: 1s"></i>
                        </a>
                        <div class="search container" style="display:none">
                            <form action="#" method="POST" class="form-group">
                                <div class="col-md-4">
                                    <div style="width: 80%">
                                        <div class="form-group">
                                            <label class="control-label">Title</label>
                                            <input type="text" class="form-control" name="posts.title">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Category</label>
                                            {!! Form::select('categories.name', $categories, null,['multiple class' => 'chosen-select form-control']); !!}<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div style="width: 80%">
                                        <div class="form-group">
                                            <label class="control-label">Created At Begin</label>
                                            <input type="date" class="form-control" name="posts.created_at">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Created At End</label>
                                            <input type="date" class="form-control" name="posts.created_at">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div style="width: 80%">
                                        <div class="form-group">
                                            <label class="control-label">Updated At Begin</label>
                                            <input type="date" class="form-control" name="posts.updated_at">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Updated At End</label>
                                            <input type="date" class="form-control" name="posts.updated_at">
                                        </div>

                                        <div class="form-group srch_buttons">
                                            <button type="button" class="btn btn icon-magnifier" id="search_res" style="float:right;margin-right: 0;color:#fff;background-color: #ff721e">
                                                &nbsp;Search
                                            </button>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Posts
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="posts">
                        <thead>
                        <tr>
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
<script type="text/javascript">
    $(document).ready(function () {
        $(".chosen-select").chosen({no_results_text: "Oops, nothing found!",width: '100%'});
        $('#search').click(function () {
            $(this).find('i').toggleClass('rotate_i')
            let container = $('.search.container')
            container.slideToggle(1000)
        });

    });
</script>
<script src="/js/posts/index.js"></script>
