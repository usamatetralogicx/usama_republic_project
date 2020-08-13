<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <i class="fa fa-inbox"></i>
                    <h2 class="brand-text mb-0" style="font-size: 1.37rem !important;padding-left: 0.5rem !important;">Dropship Republic</h2>
                </a></li>



        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main " id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a href="<?php echo e(url('/')); ?>">
                    <i class="feather icon-home"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
            <li>
                <a href="#">
                    <i class="feather icon-list"></i>
                    <span class="menu-item">Products</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="<?php echo e(route('admin.products')); ?>">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">All Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('/products?products=active')); ?>">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Active Products</span>
                        </a>
                    </li>
                    <li>
                        <a  href="<?php echo e(url('/products?products=disabled')); ?>">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Disable Products</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title">Orders</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="<?php echo e(route('admin.orders')); ?>">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">All Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.orders')); ?>?filter-by-status=pending">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">New Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.orders')); ?>?filter-by-status=ordered">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Ordered</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.orders')); ?>?filter-by-status=shipped">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Shipped</span>
                        </a>
                    </li>













                </ul>
            </li>
            <li class=" nav-item">
                <a href="<?php echo e(route('categories.index')); ?>">
                    <i class="feather icon-box"></i>
                    <span class="menu-title">Categories</span>
                </a>
            </li>






            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-user"></i>
                    <span class="menu-title">Suppliers</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="<?php echo e(route('admin.suppliers')); ?>">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item"> All Suppliers</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.suppliers')); ?>?status=active">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Active Suppliers</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.suppliers')); ?>?status=disabled">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Disabled Suppliers</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="<?php echo e(route('admin.retailers')); ?>">
                    <i class="feather icon-shopping-bag"></i>
                    <span class="menu-title">Stores</span>
                </a>
            </li>

            <li class=" nav-item">
                <a href="<?php echo e(route('admin.payments')); ?>">
                    <i class="feather icon-package"></i>
                    <span class="menu-title">Payments</span>
                </a>
            </li>








            <?php endif; ?>

            <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('search.products')); ?>">
                    <i class="feather icon-search"></i>
                    <span class="menu-title">Search Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('retailer.imported.products')); ?>">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title">Import List</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('retailer.products')); ?>">
                    <i class="feather icon-box"></i>
                    <span class="menu-title">My Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('retailer.orders')); ?>">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title">My Orders</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
            <li class="nav-item">
                <a href="<?php echo e(route('supplier.products.index')); ?>">
                    <i class="feather icon-box"></i>
                    <span class="menu-title">My Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('supplier.stores')); ?>">
                    <i class="feather icon-database"></i>
                    <span class="menu-title">My Stores</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="<?php echo e(route('supplier.orders')); ?>">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title">My Orders</span>
                </a>
            </li>
            <?php endif; ?>


            <li class="nav-item position-absolute position-bottom-0 position-left-0 w-100">
                <a href="<?php echo e(route('settings')); ?>">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
<?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/layouts/side-nav-bar.blade.php ENDPATH**/ ?>