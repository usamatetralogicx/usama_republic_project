<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <!-- App title -->
    <title>@yield('title')</title>

    <!-- File drop css -->
    <link href="{{ asset('plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet"/>

    <link href="{{ asset('plugins/toastr/toastr.css') }}" rel="stylesheet"/>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <!-- App CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>

    <!-- Modernizr js -->
    <script src="{{ asset('js/modernizr.min.js') }}"></script>

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">

</head>

<body>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="#" class="logo">
                    <i class="zmdi zmdi-group-work icon-c-logo"></i>
                    <span>Smoke Drop</span>
                </a>
            </div>
            <!-- End Logo container-->


            <div class="menu-extras navbar-topbar">

                <ul class="list-inline float-right mb-0">
                    <li class="list-inline-item dropdown notification-list">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
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

            </div> <!-- end menu-extras -->
            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
    <div class="navbar-custom">
        <div class="container">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has_sub">
                        <a href="{{ url('/') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Dashboard </span> </a>
                    </li>

                    @role('admin')
                    <li class="has-submenu">
                        <a><i class="zmdi zmdi-shopping-cart"></i> <span> Products </span> </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('admin.products') }}">All Products</a></li>
{{--                                    <li><a href="{{ route('admin.manage.products') }}">Manage Products</a></li>--}}


                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a><i class="zmdi zmdi-shopping-cart"></i> <span> Categories </span> </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('categories.index') }}">Manage Categories</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a><i class="zmdi zmdi-shopping-cart"></i> <span> View </span> </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('admin.stores') }}">Stores</a></li>
                                    <li><a href="{{ route('admin.orders') }}">Orders</a></li>
                                    <li><a href="{{ route('admin.retailers') }}">Retailers</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endrole


                    @role('supplier')
                    <li class="has-submenu">
                        <a><i class="zmdi zmdi-shopping-cart"></i> <span> Products </span> </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ url('supplier/products') }}">All Products</a></li>
{{--                                    <li><a href="{{ route('supplier.manage.products') }}">Manage Products</a></li>--}}
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="{{ route('supplier.orders') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Orders </span> </a>
                    </li>
                    <li class="has_sub">
                        <a href="{{ route('supplier.stores') }}" class="waves-effect"><i class="zmdi zmdi-view-dashboard"></i><span> Stores </span> </a>
                    </li>
                    @endrole

                    @role('retailer')
                    <li class="has-submenu">
                        <a><i class="zmdi zmdi-shopping-cart"></i> <span> Products </span> </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('retailer.all.available.products') }}">All Products</a></li>
                                    {{--                                    <li><a href="{{ route('supplier.manage.products') }}">Manage Products</a></li>--}}
{{--                                    <li><a href="{{ route('retailer.manage.products') }}">Manage Products</a></li>--}}
                                    <li><a href="{{ route('retailer.imported.products') }}">Imported Products </a></li>

                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a><i class="zmdi zmdi-shopping-cart"></i> <span> Orders </span> </a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('retailer.orders') }}">All Orders</a></li>
{{--                                    <li><a href="{{ route('retailer.orders.with.details') }}">Orders with details</a></li>--}}
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endrole

                </ul>
                <!-- End navigation menu  -->
            </div>
        </div>
    </div>


</header>

<!-- End Navigation Bar-->


<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="wrapper">
    {{--    <div class="container">--}}
    <div class="container-fluid">

        @yield('content')

    </div> <!-- container -->


    <!-- Footer -->
    <footer class="footer">
        2019 - 2020 © SmokeDrop.
    </footer>
    <!-- End Footer -->

</div> <!-- End wrapper -->


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
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>

<!-- Counter Up  -->
<script src="{{ asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('plugins/counterup/jquery.counterup.js') }}"></script>

<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('js/jquery.core.js') }}"></script>
<script src="{{ asset('js/jquery.app.js') }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js" defer></script>


{{--custom scripts--}}
@section('scripts')
@show
</body>
</html>

