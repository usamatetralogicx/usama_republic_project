<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fa fa-inbox"></i>
                    <h2 class="brand-text mb-0" style="font-size: 1.37rem !important;padding-left: 0.5rem !important;">Dropship Republic</h2>
                </a></li>
{{--            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i--}}
{{--                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a>--}}
{{--            </li>--}}
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main " id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a href="{{ url('/') }}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            @role('admin')
            <li>
                <a href="#">
                    <i class="feather icon-list"></i>
                    <span class="menu-item">Products</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('admin.products') }}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">All Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products?products=active') }}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Active Products</span>
                        </a>
                    </li>
                    <li>
                        <a  href="{{ url('/products?products=disabled') }}">
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
                        <a href="{{ route('admin.orders') }}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">All Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}?filter-by-status=pending">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">New Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}?filter-by-status=ordered">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Ordered</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}?filter-by-status=shipped">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Shipped</span>
                        </a>
                    </li>
{{--                    <li>--}}
{{--                        <a href="{{ route('admin.orders') }}">--}}
{{--                            <i class="feather icon-circle"></i>--}}
{{--                            <span class="menu-item">Cancelled</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <a href="#">--}}
{{--                            <i class="feather icon-circle"></i>--}}
{{--                            <span class="menu-item">Shipments</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </li>
            <li class=" nav-item">
                <a href="{{ route('categories.index') }}">
                    <i class="feather icon-box"></i>
                    <span class="menu-title">Categories</span>
                </a>
            </li>
{{--            <li class=" nav-item">--}}
{{--                <a href="{{ route('admin.sales.reports') }}">--}}
{{--                    <i class="feather icon-dollar-sign"></i>--}}
{{--                    <span class="menu-item">Reports</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class=" nav-item">
                <a href="#">
                    <i class="feather icon-user"></i>
                    <span class="menu-title">Suppliers</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a href="{{ route('admin.suppliers') }}">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item"> All Suppliers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.suppliers') }}?status=active">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Active Suppliers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.suppliers') }}?status=disabled">
                            <i class="feather icon-circle"></i>
                            <span class="menu-item">Disabled Suppliers</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="{{ route('admin.retailers') }}">
                    <i class="feather icon-shopping-bag"></i>
                    <span class="menu-title">Stores</span>
                </a>
            </li>

            <li class=" nav-item">
                <a href="{{route('admin.payments')}}">
                    <i class="feather icon-package"></i>
                    <span class="menu-title">Payments</span>
                </a>
            </li>

{{--            <li class=" nav-item">--}}
{{--                <a href="{{route('admin.reset')}}">--}}
{{--                    <i class="feather icon-refresh-ccw"></i>--}}
{{--                    <span class="menu-title">Reset App</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            @endrole

            @role('retailer')
            <li class="nav-item">
                <a href="{{ route('search.products') }}">
                    <i class="feather icon-search"></i>
                    <span class="menu-title">Search Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('retailer.imported.products') }}">
                    <i class="feather icon-grid"></i>
                    <span class="menu-title">Import List</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('retailer.products') }}">
                    <i class="feather icon-box"></i>
                    <span class="menu-title">My Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('retailer.orders') }}">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title">My Orders</span>
                </a>
            </li>
            @endrole

            @role('supplier')
            <li class="nav-item">
                <a href="{{ route('supplier.products.index') }}">
                    <i class="feather icon-box"></i>
                    <span class="menu-title">My Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('supplier.stores') }}">
                    <i class="feather icon-database"></i>
                    <span class="menu-title">My Stores</span>
                </a>
            </li>
            <li class=" nav-item">
                <a href="{{ route('supplier.orders') }}">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title">My Orders</span>
                </a>
            </li>
            @endrole
{{--            @role('retailer|supplier')--}}

            <li class="nav-item position-absolute position-bottom-0 position-left-0 w-100">
                <a href="{{ route('settings') }}">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>
{{--           @endrole--}}
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
