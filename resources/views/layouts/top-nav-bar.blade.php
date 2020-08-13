<!-- BEGIN: Header-->

<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow w-100 m-0 rounded-0">

    <div class="navbar-wrapper">
        <div class="navbar-container content">

            <div class="navbar-collapse" id="navbar-mobile">

                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <span class="brread-cum sm:inline-flex xl:hidden cursor-pointer p-2 feather-icon select-none relative"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu "><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></span>

                </div>
                <ul class="nav navbar-nav float-right">
{{--                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span--}}
{{--                                class="badge badge-pill badge-primary badge-up">5</span></a>--}}
{{--                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">--}}
{{--                            <li class="dropdown-menu-header">--}}
{{--                                <div class="dropdown-header m-0 p-2">--}}
{{--                                    <h3 class="white">5 New</h3><span class="notification-title">App Notifications</span>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="scrollable-container media-list">--}}
{{--                                <a class="d-flex justify-content-between" href="javascript:void(0)">--}}
{{--                                    <div class="media d-flex align-items-start">--}}
{{--                                        <div class="media-left"><i class="feather icon-plus-square font-medium-5 primary"></i></div>--}}
{{--                                        <div class="media-body">--}}
{{--                                            <h6 class="primary media-heading">You have new order!</h6><small class="notification-text"> Are your going to meet me tonight?</small>--}}
{{--                                        </div>--}}
{{--                                        <small>--}}
{{--                                            <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">9 hours ago</time>--}}
{{--                                        </small>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="javascript:void(0)">Read all notifications</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name">
                                    @if(\Illuminate\Support\Facades\Auth::user() == null)
                                        {{ \App\User::where('myshopify_domain', \OhMyBrew\ShopifyApp\Facades\ShopifyApp::shop()->shopify_domain)->first()->name }}
                                    @else
                                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                    @endif
                                </span>
                            </div>
                            <span><img class="round" @if(auth()->user()->gender == null) src="{{ asset('images/portrait/small/avatar-s-11.jpg') }}" @else src="{{ asset(auth()->user()->gender) }}" @endif  alt="avatar" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            @role('retailer')
                            <a class="dropdown-item" href="{{ url('settings#accounts-tab') }}">
                                <i class="feather icon-user"></i> My Account
                            </a>
                            @endrole

                            @role('supplier')
                            <a class="dropdown-item" href="#">
                                <i class="feather icon-user"></i> My Account
                            </a>
                            @endrole

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->
