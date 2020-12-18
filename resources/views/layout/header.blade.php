<!-- BEGIN HEADER -->
<style>
    #lang-switch {
        float: left;
    }
    #lang-switch img {
        width: 50px;
        height: 50px;
        opacity: 0.5;
        transition: all .5s;
        margin: auto 3px;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    #lang-switch img:hover {
        cursor: pointer;
        opacity: 1;

    }

    /* Language */
    .active-lang {
        display: flex !important;
        transition: display .5s;
    }

    .active-flag {
        transition: all .5s;
        opacity: 1 !important;
    }
</style>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/personal">
                <img src="/assets/pages/img/logos/ekeng_logo.gif" alt="logo" class="logo-default"
                     style="width:130px;margin-top:15px"/> </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <div id="lang-switch">
                <img src="/images/armenia.jpg" class="hy">
                <img src="/images/english.jpg" class="en">
                <img src="/images/russia.jpg" class="ru">
            </div>
            <!-- END HEADER SEARCH BOX -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class below "dropdown-extended" to change the dropdown styte -->
                    <!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
                    <!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">

                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="/assets/pages/media/profile/user-account-icon-19.png"/>
                            <span class="username username-hide-on-mobile"> {{Auth::user()->first_name}} </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="/profile/{{Auth::user()->id}}" )>
                                    <i class="icon-user"></i> My Profile </a>
                            </li>

                            <li>
                                <a href="/logout">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->

    @if ($errors->any())
        <script>
            $(document).ready(function () {
                $('#error_modal').modal('show');
            })
        </script>
        <div class="modal fade" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #db4444">
                        <h4 class="modal-title" id="myModalLabel">ERROR </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($errors->all() as $error)
                        <h3>{!! $error !!}</h3>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

<script>
    $(document).ready(function(){

        $('#lang-switch .hy').addClass("active-flag");

        // Function switch
        $(function() {

            $("#lang-switch .hy").click(function() {
                $('input[name="lang"]').val('hy')
                $('#lang-switch .hy').addClass("active-flag");
                $('#lang-switch .en').removeClass("active-flag");
                $('#lang-switch .ru').removeClass("active-flag");
            });

            // English button
            $("#lang-switch .en").click(function() {
                $('input[name="lang"]').val('en')
                $('#lang-switch .en').addClass("active-flag");
                $('#lang-switch .hy').removeClass("active-flag");
                $('#lang-switch .ru').removeClass("active-flag");
            });

            $("#lang-switch .ru").click(function() {
                $('input[name="lang"]').val('ru')
                $('#lang-switch .ru').addClass("active-flag");
                $('#lang-switch .hy').removeClass("active-flag");
                $('#lang-switch .en').removeClass("active-flag");
            });
        });
    });
</script>
