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

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-8 col-10 d-flex justify-content-center">
                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="row m-0">
                            <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                                <img src="<?php echo e(asset('images/pages/register.jpg')); ?>" alt="branding logo">
                            </div>
                            <div class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 p-2">
                                    <div class="card-header pt-50 pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Create Account</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Fill the below form to create a new account.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">
                                            <form action="<?php echo e(route('register')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-label-group">
                                                    <input type="text" id="inputName" name="name" class="form-control <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" placeholder="Name" value="<?php echo e(old('name')); ?>" required autofocus>
                                                    <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                    <label for="inputName">Name</label>
                                                </div>
                                                <div class="form-label-group">
                                                    <input type="email" id="inputEmail" name="email" class="form-control <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" value="<?php echo e(old('email')); ?>" placeholder="Email" required>
                                                    <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                    <label for="inputEmail">Email</label>

                                                </div>
                                                <div class="form-label-group">
                                                    <input type="text" id="inputCompany" name="company_name" class="form-control" placeholder="Company Name" required>
                                                    <label for="inputEmail">Company Name</label>

                                                </div>
                                                <div class="form-label-group">
                                                    <input type="text" id="inputTel" name="phone" class="form-control" placeholder="Phone Number" required>
                                                    <label for="inputEmail">Phone Number</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="padding-right: 5px">
                                                        <div class="form-label-group">
                                                            <input type="text"  name="address" class="form-control" placeholder="Address" >
                                                            <label for="inputEmail">Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left: 5px">
                                                        <div class="form-label-group">
                                                            <input type="text"  name="zip" class="form-control" placeholder="Postal Code">
                                                            <label for="inputEmail">Zip</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4" style="padding-right: 5px">
                                                        <div class="form-label-group">
                                                            <input type="text"  name="city" class="form-control" placeholder="City">
                                                            <label for="inputEmail">City</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" style="padding-left: 5px;padding-right: 5px">
                                                        <div class="form-label-group">
                                                            <input type="text"  name="state" class="form-control" placeholder="State">
                                                            <label for="inputEmail">State</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" style="padding-left: 5px">
                                                        <div class="form-label-group">
                                                            <input type="text"  name="country" class="form-control" placeholder="Country">
                                                            <label for="inputEmail">Country</label>
                                                        </div>
                                                    </div>
                                                </div>





                                                <div class="form-label-group">
                                                    <input type="password" id="inputPassword" name="password" autocomplete="current-password" class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" placeholder="Password" required>
                                                    <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                                <div class="form-label-group">
                                                    <input type="password" id="inputConfPassword" name="password_confirmation" autocomplete="new-password" class="form-control  <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" placeholder="Confirm Password" required>
                                                    <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                                    <label for="inputConfPassword">Confirm Password</label>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" required>
                                                                <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                <span class=""> I accept the terms & conditions.</span>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary float-left btn-inline mb-50">Login</a>
                                                <button type="submit" class="btn btn-primary float-right btn-inline mb-50">Register</button>
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
<?php /**PATH C:\xampp\htdocs\Dropship-Republic\resources\views/auth/register.blade.php ENDPATH**/ ?>