<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywordcs" content="">
    <meta name="author" content="Hamza">
    <title>Smokedrop - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/nouislider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/ui/prism.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/extensions/noui-slider.min.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Toaster CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/toastr.css') }}">
    <!-- END: Toaster CSS-->

@yield('css')

<!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    {{--    <style>--}}
    {{--        .overlay {--}}
    {{--            opacity: 1;--}}
    {{--            background-color: #f3f3f3;--}}
    {{--            position: fixed;--}}
    {{--            margin-left: auto;--}}
    {{--            width: 100%;--}}
    {{--            height: 100%;--}}
    {{--            top: 0px;--}}
    {{--            left: 105px;--}}
    {{--            z-index: 1000;--}}
    {{--        }--}}

    {{--        .loading-image {--}}
    {{--            margin: 0;--}}
    {{--            position: absolute;--}}
    {{--            top: 50%;--}}
    {{--            left: 50%;--}}
    {{--            -ms-transform: translate(-50%, -50%);--}}
    {{--            transform: translate(-50%, -50%);--}}
    {{--        }--}}
    {{--        @media (max-width: 575.98px){--}}
    {{--            .header-navbar.floating-nav{--}}
    {{--                width: 100%;--}}
    {{--            }--}}
    {{--        }--}}
    {{--    </style>--}}

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout content-detached-left-sidebar ecommerce-application navbar-floating footer-static menu-expanded" data-open="click"
      data-menu="vertical-menu-modern" data-col="content-detached-left-sidebar" data-layout="semi-dark-layout">

@include('layouts.top-nav-bar')
@include('layouts.side-nav-bar')

<!-- BEGIN: Overlay-->
{{--<div id="overlay" class="overlay">--}}
{{--    <img class="loading-image" src="{{ asset('images/loading.gif') }}" alt="loading">--}}
{{--</div>--}}
<div class="clearfix"></div>
<!-- END: Overlay-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    {{--    <div class="header-navbar-shadow"></div>--}}


    <div class="content-wrapper pb-0">
        @role('supplier')
        @if(auth()->user()->free_user == 0)
            @if(auth()->user()->onGenericTrial())
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <p class="mb-0">
                        Hey, You membership trial ends at {{date_create(auth()->user()->trial_ends_at)->format('d M Y')}}. please <a style="color: grey;border-bottom: 1px grey solid" href="{{route('settings')}}">click here to subscribe</a>
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                    </button>
                </div>
            @endif
        @endif
        @endrole
        @yield('content')
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('layouts.footer')

<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/components.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: toastr-->
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<!-- END: toastr-->

<!-- BEGIN: Custom JS-->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<!-- END: Custom JS-->

<script>
    var info = '{{ Session::get('info') }}';
    if (info) {
        toastr.info('{{ Session::get('info') }}');
    }
    var error = '{{ Session::get('error') }}';
    if (error) {
        toastr.error('{{ Session::get('error') }}');
    }
    var success = '{{ Session::get('success') }}';
    if (success) {
        toastr.success('{{ Session::get('success') }}');
    }
    // setTimeout(function () {
    //     if($('html').hasClass('loaded')){
    //         $('#overlay').hide();
    //     }
    // },2000);
    $('.brread-cum').click(function () {
        $('.drag-target').trigger('drag');
    });
</script>


@yield('scripts')

</body>
<!-- END: Body-->

</html>
