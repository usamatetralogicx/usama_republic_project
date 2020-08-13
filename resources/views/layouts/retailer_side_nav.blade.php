<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fa fa-inbox"></i>
                    <h2 class="brand-text mb-0">Smokedrop</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main " id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{ url('/') }}"><i class="feather icon-home"></i><span class="menu-title">Dashboard</span></a>
            </li>
            {{--            <li class=" navigation-header"><span></span></li>--}}
            <li class=" nav-item"><a href="{{ route('search.products') }}"><i class="feather icon-search"></i><span class="menu-title">Search Products</span></a></li>
            <li class=" nav-item"><a href="{{ route('retailer.imported.products') }}"><i class="feather icon-grid"></i><span class="menu-title">Import List</span></a></li>
            <li class=" nav-item"><a href="{{ route('retailer.products') }}"><i class="feather icon-box"></i><span class="menu-title">My Products</span></a>
            <li class=" nav-item"><a href="{{ route('retailer.orders.with.details') }}"><i class="feather icon-shopping-cart"></i><span class="menu-title">My Orders</span></a></li>


            <li class="nav-item position-absolute position-bottom-0 position-left-0 w-100"><a href="{{ route('settings') }}"><i class="feather icon-settings"></i><span class="menu-title">Settings</span></a></li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
