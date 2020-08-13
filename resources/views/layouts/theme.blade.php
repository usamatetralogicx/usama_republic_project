<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- App title -->
    <title>@yield('title')</title>



    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">

    <!-- Switchery css -->
    <link href="{{ asset('plugins/switchery/switchery.min.css') }}" rel="stylesheet"/>

    <!-- File drop css -->
    <link href="{{ asset('plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet"/>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- App CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Modernizr js -->
    <script src="{{ asset('js/modernizr.min.js') }}"></script>

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">

</head>


<body>


<div id="wrapper">
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index.html" class="logo">
                <i class="zmdi zmdi-group-work icon-c-logo"></i>
                <span>SmokeDrop</span></a>
        </div>

        <nav class="navbar-custom">

            <ul class="list-inline float-right mb-0">
                <li class="list-inline-item dropdown notification-list">
                    <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}&nbsp;&nbsp;&nbsp;
                        <img src="{{ asset('images/users/avatar-1.jpg') }}" alt="user" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="zmdi zmdi-account-circle"></i> <span>Profile</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="zmdi zmdi-settings"></i> <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="{{ url('logout') }}" class="dropdown-item notify-item">
                            <i class="zmdi zmdi-power"></i> <span>Logout</span>
                        </a>

                    </div>
                </li>
            </ul>

            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-light waves-effect">
                        <i class="zmdi zmdi-menu"></i>
                    </button>
                </li>
            </ul>

        </nav>

    </div>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <ul>
                    <li class="text-muted menu-title">Navigation</li>

                    <li class="has_sub">
                        <a href="{{ url('/') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Dashboard </span> </a>
                    </li>

                    <li class="has_sub">
                        @role('admin')
                        <a href="{{ url('admin/products') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Products </span> </a>
                        @endrole

                        @role('supplier')
                        <a href="{{ url('supplier/products') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Products </span> </a>
                        @endrole

                        @role('retailer')
                        <a href="{{ url('retailer/products') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Products </span> </a>
                        @endrole
                    </li>

                    @hasanyrole('retailer|admin')
                    <li class="has_sub">
                        <a href="#" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Drafts </span> </a>
                    </li>
                    @endhasanyrole



                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>

    </div>


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content pl-0 pr-0">

            <div class="container-fluid m-0" >

                @yield('content')

            </div>
        </div>
    </div>


    <footer class="footer">
        2016 - 2019 © Smoke Drop.
    </footer>

</div>
<!-- END wrapper -->


<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/detect.js') }}"></script>
<script src="{{ asset('js/fastclick.js') }}"></script>
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/switchery/switchery.min.js') }}"></script>

<!--Morris Chart-->'
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>


<!-- Counter Up  -->
<script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('plugins/counterup/jquery.counterup.js') }}"></script>

<!-- Page specific js -->
<script src="{{ asset('pages/jquery.dashboard.js') }}"></script>

<!-- App js -->
<script src="{{ asset('js/jquery.core.js') }}"></script>
<script src="{{ asset('js/jquery.app.js') }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js" defer></script>


{{--custom scripts--}}
@section('scripts')
@show
</body>
</html>
