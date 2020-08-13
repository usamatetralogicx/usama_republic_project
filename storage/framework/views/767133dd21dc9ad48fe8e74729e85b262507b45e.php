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
    <title>Smokedrop - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/ico/apple-icon-120.png')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('images/ico/favicon.ico')); ?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/vendors.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/extensions/nouislider.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/ui/prism.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/forms/select/select2.min.css')); ?>">
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
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/plugins/extensions/noui-slider.min.css')); ?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Toaster CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/extensions/toastr.css')); ?>">
    <!-- END: Toaster CSS-->

<?php echo $__env->yieldContent('css'); ?>

<!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <!-- END: Custom CSS-->

    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout content-detached-left-sidebar ecommerce-application navbar-floating footer-static menu-expanded" data-open="click"
      data-menu="vertical-menu-modern" data-col="content-detached-left-sidebar" data-layout="semi-dark-layout">

<?php echo $__env->make('layouts.top-nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.side-nav-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- BEGIN: Overlay-->



<div class="clearfix"></div>
<!-- END: Overlay-->

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    


    <div class="content-wrapper pb-0">
        <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
        <?php if(auth()->user()->free_user == 0): ?>
            <?php if(auth()->user()->onGenericTrial()): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <p class="mb-0">
                        Hey, You membership trial ends at <?php echo e(date_create(auth()->user()->trial_ends_at)->format('d M Y')); ?>. please <a style="color: grey;border-bottom: 1px grey solid" href="<?php echo e(route('settings')); ?>">click here to subscribe</a>
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="feather icon-x-circle"></i></span>
                    </button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- BEGIN: Vendor JS-->
<script src="<?php echo e(asset('vendors/js/vendors.min.js')); ?>"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?php echo e(asset('js/core/app-menu.js')); ?>"></script>
<script src="<?php echo e(asset('js/core/app.js')); ?>"></script>
<script src="<?php echo e(asset('js/scripts/components.js')); ?>"></script>
<!-- END: Theme JS-->

<!-- BEGIN: toastr-->
<script src="<?php echo e(asset('vendors/js/extensions/toastr.min.js')); ?>"></script>
<!-- END: toastr-->

<!-- BEGIN: Custom JS-->
<script src="<?php echo e(asset('assets/js/scripts.js')); ?>"></script>
<!-- END: Custom JS-->

<script>
    var info = '<?php echo e(Session::get('info')); ?>';
    if (info) {
        toastr.info('<?php echo e(Session::get('info')); ?>');
    }
    var error = '<?php echo e(Session::get('error')); ?>';
    if (error) {
        toastr.error('<?php echo e(Session::get('error')); ?>');
    }
    var success = '<?php echo e(Session::get('success')); ?>';
    if (success) {
        toastr.success('<?php echo e(Session::get('success')); ?>');
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


<?php echo $__env->yieldContent('scripts'); ?>

</body>
<!-- END: Body-->

</html>
<?php /**PATH C:\xampp\htdocs\Dropship-Republic\resources\views/layouts/ecommerce.blade.php ENDPATH**/ ?>