@include('layout.app')
<script src="/js/tinymce.min.js"></script>
<link href="/css/lang.css" rel="stylesheet" type="text/css"/>
{{--<script src="/js/tiny.js"></script>--}}
<style>
    textarea {
        height: 400px;
    }

    input.btn {
        margin-top: 10px;
        float: right;
    }

    .image-uploader .uploaded .uploaded-image {
        width: calc(100% - 1rem);
        padding-bottom: calc(100% - 1rem);
    }

    .image-uploader .uploaded .uploaded-image img {
        object-fit: contain
    }
</style>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
@include('layout.header')
<!-- BEGIN CONTAINER -->
<div class="page-container">
@include('layout.sidebar')

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
            {!! Form::open( ['method' => 'POST','route' => 'pages.store', 'files' => true]) !!}
            <label for="title" style="font-size: 26px">Title</label>
            <input type="hidden" name="lang" value="hy">
            <input type="text" class="form-control" name="title" id="title"><br>
            <label for="path" style="font-size: 26px">Path</label>
            <input type="text" class="form-control" name="path" id="path"><br>
            <div class="clearfix">
                <label class="control-label">Add files</label>
                {!! Form::select('folders[]', $folders, null,['multiple class' => 'chosen-select form-control']); !!}
                <div class="btn-group" style="float:right">
                    <div class="galleryType">

                    </div>
                </div>
                <label for="path" style="font-size: 26px">Left Sidebar Menu</label>
                <select class="form-control form-control-lg" name="menuID">
                    <option value="" selected>Without menu</option>
                    @foreach($menus as  $menu)
                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endforeach
                </select><br>
                <label for="path" style="font-size: 26px">Page Type</label>
                <select class="form-control form-control-lg" name="type">
                    <option disabled selected hidden>Choose Type</option>
                    @foreach($pageTypes as  $type)

                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select><br>
                <div class="portlet-body"  id="videoLinks" style="display: none;margin-top: 50px">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button id="sample_editable_1_new" class="btn green"> Add New Video Links
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                        <thead>
                        <tr>
                            <th> Name</th>
                            <th> Url</th>
                            <th> Edit</th>
                            <th> Delete</th>
                            <th> Params</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="content" style="display: none">
                    @include('pages.type.content')
                </div>
                <div class="news" style="display: none">
                    @include('pages.type.news',['categories'=>$categories])
                </div>
                <input type="submit" value="Save" class="btn btn-success"/>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</body>
@include('layout.footer')
<script src="/js/pages/create.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="/assets/pages/scripts/table-datatables-editable.js" type="text/javascript"></script>
