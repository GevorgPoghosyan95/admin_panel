@include('layout.app')
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="/assets/pages/css/profile.min.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="/assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css"/>
<!-- END THEME LAYOUT STYLES -->
<!-- BEGIN HEADER -->
@include('layout.header')
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false"
                data-auto-scroll="true" data-slide-speed="200">
                <li class="nav-link">
                    <a href="#" onclick="goBack()" class="nav-link nav-toggle">
                        <i class="icon-logout"></i>
                        <span class="title">Հետ</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN THEME PANEL -->
            <div class="theme-panel">

            </div>
            <!-- END THEME PANEL -->
            <h1 class="page-title"> New User Profile | Account
            </h1>
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <div class="profile-sidebar">
                        <!-- PORTLET MAIN -->
                        <div class="portlet light profile-sidebar-portlet ">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                <img src="/assets/pages/media/profile/user-account-icon-19.png" class="img-responsive"
                                     alt=""></div>
                            <!-- END SIDEBAR USERPIC -->
                            <!-- SIDEBAR USER TITLE -->
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">{{$user->first_name}}
                                    &nbsp;{{$user->last_name}}</div>
                                <div class="profile-usertitle-job"> Developer</div>
                            </div>
                            <div class="profile-usermenu">
                                <ul class="nav">

                                    <li class="active">
                                        <a href="page_user_profile_1_account.html">
                                            <i class="icon-settings"></i> Account Settings </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END MENU -->
                        </div>

                    </div>
                    <!-- END BEGIN PROFILE SIDEBAR -->
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                {!! Form::model($user, ['method' => 'PATCH','route' => ['update_personal', $user->id]]) !!}
                                                <div class="form-group">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" class="form-control"
                                                           value="{{$user->first_name}}"
                                                           name="first_name"/></div>
                                                <div class="form-group">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" class="form-control"
                                                           value="{{$user->last_name}}"
                                                           name="last_name"/></div>
                                                <div class="form-group">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" class="form-control" value="{{$user->email}}"
                                                           readonly/></div>
                                                <br>
                                                <div class="margiv-top-10">
                                                    <input type="submit" class="btn green" value="Save Changes">
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                            <div class="tab-pane" id="tab_1_3">
                                                {!! Form::model($user, ['method' => 'PATCH','route' => ['change_password', $user->id]]) !!}
                                                    <div class="form-group">
                                                        <label class="control-label">Current Password</label>
                                                        <input type="password" class="form-control"
                                                               name="current_password"/></div>
                                                    <div class="form-group">
                                                        <label class="control-label">New Password</label>
                                                        <input type="password" class="form-control" name="password"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Re-type New Password</label>
                                                        <input type="password" class="form-control"
                                                               name="password_confirmation"/></div>
                                                    <div class="margiv-top-10">
                                                        <input type="submit" class="btn green" value="Change Password">
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>
                                            <br>
                                            <br>
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
@include('layout.footer')


<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

</html>
