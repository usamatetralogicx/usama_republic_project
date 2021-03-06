<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Hamza">
    <title>Login Page - SmokeDrop</title>
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/ico/apple-icon-120.png')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('images/ico/favicon.ico')); ?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/vendors.min.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-extended.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/colors.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/components.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/themes/dark-layout.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/themes/semi-dark-layout.css')); ?>">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/core/menu/menu-types/vertical-menu.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/core/colors/palette-gradient.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/authentication.css')); ?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click"
      data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-7 col-md-9 col-10 d-flex justify-content-center px-0">
                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="row m-0">
                            <div class="col-lg-6 d-lg-block d-none text-center align-self-center">
                                <img src="<?php echo e(asset('images/pages/forgot-password.png')); ?>" alt="branding logo">
                            </div>
                            <div class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2 py-1">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Recover your password</h4>
                                        </div>
                                    </div>

                                    <p class="px-2 mb-0">Please enter your email address and we'll send you instructions on how to reset your password.</p>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <?php if(session('status')): ?>
                                                <p class="text-success">
                                                    <?php echo e(session('status')); ?>

                                                </p>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('password.email')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-label-group">
                                                    <input type="email" id="inputEmail" name="email" class="form-control  <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" placeholder="Email"
                                                           value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                                                    <label for="inputEmail">Email</label>
                                                    <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                </div>

                                                <div class="float-md-left d-block mb-1">
                                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary btn-block px-75">Back to Login</a>
                                                </div>
                                                <div class="float-md-right d-block mb-1">
                                                    <button type="submit" class="btn btn-primary btn-block px-75">Recover Password</button>
                                                </div>
                                            </form>
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


<!-- BEGIN: Vendor JS-->
<script src="<?php echo e(asset('vendors/js/vendors.min.js')); ?>"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo e(asset('js/core/app-menu.js')); ?>"></script>
<script src="<?php echo e(asset('js/core/app.js')); ?>"></script>
<script src="<?php echo e(asset('js/scripts/components.js')); ?>"></script>
<!-- END: Theme JS-->


<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
<?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>