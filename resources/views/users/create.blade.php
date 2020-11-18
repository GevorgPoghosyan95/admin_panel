@include('layout.app')
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
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            <div class="portlet light " id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject font-red bold uppercase"> Form Wizard
                                        </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    {!! Form::open(['route' => 'users.store','method'=>'POST','class'=>"form-horizontal",'id'=>"submit_form"]) !!}
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                <li>
                                    <a href="#tab1" data-toggle="tab" class="step">
                                        <span class="number"> 1 </span>
                                        <span class="desc">
                                                                <i class="fa fa-check"></i> Register New User </span>
                                    </a>
                                </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-danger display-none">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                </div>
                                <div class="alert alert-success display-none">
                                    <button class="close" data-dismiss="alert"></button>
                                    Your form validation is successful!
                                </div>
                                <div class="tab-pane active" id="tab1">
                                    <h3 class="block">Provide users details</h3>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">First Name
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::text('first_name', $value = null, ['class' => 'form-control', 'placeholder' => 'First Name *','required']) !!}
                                            <span class="help-block"> Provide your first name </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Last Name
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::text('last_name', $value = null, ['class' => 'form-control', 'placeholder' => 'Last Name *','required']) !!}
                                            <span class="help-block"> Provide your last name </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Password
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password *', 'type' => 'password']) !!}
                                            <span class="help-block"> Provide your password. </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Confirm Password
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password','class' => 'form-control','type' => 'password','required']) !!}
                                            <span class="help-block"> Confirm your password </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Email
                                            <span class="required"> * </span>
                                        </label>
                                        <div class="col-md-4">
                                            {!! Form::email('email', null, ['placeholder' => 'Email *','class' => 'form-control','type'=>'email']) !!}
                                            <span class="help-block"> Provide your email address </span>
                                        </div>
                                    </div>
                                    <div class="form-group form-md-line-input">
                                        <label class="col-md-3 control-label" for="form_control_1">Roles</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="roles" required>
                                                <option value="" disabled selected>Check role</option>
                                                @foreach($roles as $id=>$role)
                                                    <option value="{{$id}}">{{$role}}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-focus"></div>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn btn-outline green button-next">Register
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>

</body>
@include('layout.footer')


<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
    })
</script>
