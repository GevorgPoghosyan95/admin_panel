@include('layout.app')
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
      type="text/css"/>
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css"/>
<link href="/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css"/>
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="/assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css"/>
<!-- END THEME LAYOUT STYLES -->

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
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Edit Permission</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('permissions.index') }}"> Back</a>
                    </div>
                </div>
            </div>


            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::model($permission, ['method' => 'PATCH','route' => ['permissions.update', $permission->id]]) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', $value=$permission->name, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                </div>
                {!! Form::submit('Change Group',array('class' => 'btn-danger btn-sm','id'=>'change_group','style'=>'margin-left:14px')); !!}
                <div class="col-xs-12 col-sm-12 col-md-12" id="current_group">
                    <div class="form-group">
                        <strong>Group Name:</strong>
                        {!! Form::select('current_group', [$group->id=>$group->name],null, array('class' => 'form-control select2me')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12" id="selected_group" style="display:none">
                    <div class="form-group">
                        <strong>Group Name:</strong>
                        {!! Form::select('selected_group', [$all_groups],null, array('class' => 'form-control select2me')) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {!! Form::close() !!}


        </div>
    </div>
</div>
</body>
@include('layout.footer')

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $('#change_group').on('click', function (e) {
        e.preventDefault();
        $('#current_group').remove();
        $('#selected_group').css('display', '');
    });


</script>
