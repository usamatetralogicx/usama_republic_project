<!-- BEGIN: Header-->

<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow w-100 m-0 rounded-0">

    <div class="navbar-wrapper">
        <div class="navbar-container content">

            <div class="navbar-collapse" id="navbar-mobile">

                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <span class="brread-cum sm:inline-flex xl:hidden cursor-pointer p-2 feather-icon select-none relative"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu "><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></span>

                </div>
                <ul class="nav navbar-nav float-right">
























                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name">
                                    <?php if(\Illuminate\Support\Facades\Auth::user() == null): ?>
                                        <?php echo e(\App\User::where('myshopify_domain', \OhMyBrew\ShopifyApp\Facades\ShopifyApp::shop()->shopify_domain)->first()->name); ?>

                                    <?php else: ?>
                                        <?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?>

                                    <?php endif; ?>
                                </span>
                            </div>
                            <span><img class="round" <?php if(auth()->user()->gender == null): ?> src="<?php echo e(asset('images/portrait/small/avatar-s-11.jpg')); ?>" <?php else: ?> src="<?php echo e(asset(auth()->user()->gender)); ?>" <?php endif; ?>  alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?>
                            <a class="dropdown-item" href="<?php echo e(url('settings#accounts-tab')); ?>">
                                <i class="feather icon-user"></i> My Account
                            </a>
                            <?php endif; ?>

                            <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                            <a class="dropdown-item" href="#">
                                <i class="feather icon-user"></i> My Account
                            </a>
                            <?php endif; ?>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><i class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->
<?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/layouts/top-nav-bar.blade.php ENDPATH**/ ?>