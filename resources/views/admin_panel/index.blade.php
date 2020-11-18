@include('layout.app')

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        @include('layout.header')
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            @include('layout.sidebar')
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->

                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                    </div>
                </div>
            </div>

    </body>
    @include('layout.footer')
