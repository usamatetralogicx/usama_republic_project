<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="Hamza">
    <title>Login Page - SmokeDrop</title>
    <link rel="apple-touch-icon" href="{{ asset('images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/authentication.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- END: Custom CSS-->

    <style>
        .overlay {
            opacity: 1;
            background-color: #f3f3f3;
            position: fixed;
            margin-left: auto;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            z-index: 1000;
        }

        .loading-image{
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click"
      data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">

<!-- BEGIN: Overlay-->
<div id="overlay" class="overlay">
    <img class="loading-image" src="{{ asset('images/loading.gif') }}" alt="Please wait while you account is being logged in">
    <p hidden id="loading-message" class="loading-image mt-5">Please wait while you account is being logged in</p>
</div>
<div class="clearfix"></div>
<!-- END: Overlay-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-8 col-11 d-flex justify-content-center">
                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="row m-0">
                            <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
                                <img src="{{ asset('images/pages/login.png') }}" alt="branding logo">
                            </div>
                            <div class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Login</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Welcome back, please login to your account.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="user-name" name="email"
                                                           placeholder="Email" required autofocus>
                                                    <div class="form-control-position"><i class="feather icon-user"></i></div>
                                                    <label for="user-name">Email</label>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </fieldset>

                                                <fieldset class="form-label-group position-relative has-icon-left">
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="user-password" name="password" placeholder="Password"
                                                           required>
                                                    <div class="form-control-position"><i class="feather icon-lock"></i></div>
                                                    <label for="user-password">Password</label>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </fieldset>
                                                <div class="form-group d-flex justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox">
                                                                <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                <span class="">Remember me</span>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="text-right"><a href="{{ route('password.request') }}" class="card-link">Forgot Password?</a></div>
                                                </div>
                                                <a href="{{ route('register') }}" class="btn btn-outline-primary float-left btn-inline">Register</a>
                                                <button type="submit" class="btn btn-primary float-right btn-inline">Login</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="login-footer">
                                        <div class="divider">

                                        </div>
                                        <div class="footer-btn d-inline">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

<div hidden>
    @if(isset($retailer))
        <input type="hidden" id="re" value="{{ $retailer->email }}">
        <input type="hidden" id="rp" value="{{ $retailer->name }}">

    @else
        <input type="hidden" id="re" value="">
        <input type="hidden" id="rp" value="">
    @endif
</div>


<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script src="{{ asset('js/core/app.js') }}"></script>
<script src="{{ asset('js/scripts/components.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script>
    $(function () {
        var email = $('#re').val();
        var password = $('#rp').val();
        console.log(email);
        console.log(password);

        if (email != '' || password != '') {

            $('#loading-message').attr('hidden', false);
            $.ajax({
                url: '{{ env('APP_URL') }}' + '/user/login',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'email': email,
                    'password': password,

                },
                success: function (success) {
                    window.location.replace('{{env('APP_URL')}}/');
                    $('#overlay').attr('hidden', false);

                },
                error: function (error) {
                    console.log(error);
                    $('#overlay').attr('hidden', false);
                }
            });
        } else if (email == '') {
            $('#overlay').attr('hidden', true);
            $('#loading-message').attr('hidden', true);

        }
    });
</script>
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
