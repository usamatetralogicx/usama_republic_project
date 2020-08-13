@extends('layouts.ecommerce')

@section('title', 'Search Products')

@section('css')
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-ecommerce-shop.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: CSRF Token-->
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- END: CSRF Token-->

    <style>
        .sk-fading-circle {
            margin: 100px auto;
            width: 40px;
            height: 40px;
            position: relative;
        }

        .sk-fading-circle .sk-circle {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
        }

        .sk-fading-circle .sk-circle:before {
            content: '';
            display: block;
            margin: 0 auto;
            width: 15%;
            height: 15%;
            background-color: #2b3d51;
            border-radius: 100%;
            -webkit-animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
            animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
        }

        .sk-fading-circle .sk-circle2 {
            -webkit-transform: rotate(30deg);
            -ms-transform: rotate(30deg);
            transform: rotate(30deg);
        }

        .sk-fading-circle .sk-circle3 {
            -webkit-transform: rotate(60deg);
            -ms-transform: rotate(60deg);
            transform: rotate(60deg);
        }

        .sk-fading-circle .sk-circle4 {
            -webkit-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .sk-fading-circle .sk-circle5 {
            -webkit-transform: rotate(120deg);
            -ms-transform: rotate(120deg);
            transform: rotate(120deg);
        }

        .sk-fading-circle .sk-circle6 {
            -webkit-transform: rotate(150deg);
            -ms-transform: rotate(150deg);
            transform: rotate(150deg);
        }

        .sk-fading-circle .sk-circle7 {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .sk-fading-circle .sk-circle8 {
            -webkit-transform: rotate(210deg);
            -ms-transform: rotate(210deg);
            transform: rotate(210deg);
        }

        .sk-fading-circle .sk-circle9 {
            -webkit-transform: rotate(240deg);
            -ms-transform: rotate(240deg);
            transform: rotate(240deg);
        }

        .sk-fading-circle .sk-circle10 {
            -webkit-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
            transform: rotate(270deg);
        }

        .sk-fading-circle .sk-circle11 {
            -webkit-transform: rotate(300deg);
            -ms-transform: rotate(300deg);
            transform: rotate(300deg);
        }

        .sk-fading-circle .sk-circle12 {
            -webkit-transform: rotate(330deg);
            -ms-transform: rotate(330deg);
            transform: rotate(330deg);
        }

        .sk-fading-circle .sk-circle2:before {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .sk-fading-circle .sk-circle3:before {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }

        .sk-fading-circle .sk-circle4:before {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .sk-fading-circle .sk-circle5:before {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        .sk-fading-circle .sk-circle6:before {
            -webkit-animation-delay: -0.7s;
            animation-delay: -0.7s;
        }

        .sk-fading-circle .sk-circle7:before {
            -webkit-animation-delay: -0.6s;
            animation-delay: -0.6s;
        }

        .sk-fading-circle .sk-circle8:before {
            -webkit-animation-delay: -0.5s;
            animation-delay: -0.5s;
        }

        .sk-fading-circle .sk-circle9:before {
            -webkit-animation-delay: -0.4s;
            animation-delay: -0.4s;
        }

        .sk-fading-circle .sk-circle10:before {
            -webkit-animation-delay: -0.3s;
            animation-delay: -0.3s;
        }

        .sk-fading-circle .sk-circle11:before {
            -webkit-animation-delay: -0.2s;
            animation-delay: -0.2s;
        }

        .sk-fading-circle .sk-circle12:before {
            -webkit-animation-delay: -0.1s;
            animation-delay: -0.1s;
        }

        @-webkit-keyframes sk-circleFadeDelay {
            0%, 39%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }

        @keyframes sk-circleFadeDelay {
            0%, 39%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }
    </style>

@endsection

@section('content')

    <div class="content-detached content-right">
        <div class="content-body">
            <!-- Ecommerce Content Section Starts -->
            <section id="ecommerce-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ecommerce-header-items">
                            <div class="result-toggler">
                                <button class="navbar-toggler shop-sidebar-toggler" type="button" data-toggle="collapse">
                                    <span class="navbar-toggler-icon d-block d-lg-none"><i class="feather icon-menu"></i></span>
                                </button>
                                <div class="search-results">
                                    {{--                                    @if(!isset($productsCount))--}}
                                    {{--                                        {{ \App\Product::all()->count() }} results found--}}
                                    {{--                                    @else--}}
                                    {{--                                        @dd($productsCount)--}}
                                    {{--                                        {{ $productsCount }} results found--}}
                                    {{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="view-options">
                                <button id="button-add-products-to-import-list" class="btn btn-primary mr-1">Add to import list</button>
                                <div class="hidden">{{ \Illuminate\Support\Facades\Auth::user()->markup_setting->ask_every_time }}</div>
                                <div class="view-btn-option">
                                    <button class="btn btn-white view-btn grid-view-btn active">
                                        <i class="feather icon-grid"></i>
                                    </button>
                                    <button type="button" class="btn btn-white list-view-btn view-btn">
                                        <i class="feather icon-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Ecommerce Content Section Starts -->
            <!-- background Overlay when sidebar is shown  starts-->
            <div class="shop-content-overlay"></div>
            <!-- background Overlay when sidebar is shown  ends-->

            <!-- Ecommerce Products Starts -->

            @if(count($products) > 0)
                <section id="ecommerce-products" class="grid-view">
                @foreach($products as $product)

                        <div class="card ecommerce-card">
                            <div class="card-content">
                                <div class="item-img text-center pt-0">
                                    <a href="{{ route('product.show', $product->id) }}">
                                        <img class="img-fluid" src="{{ $product->image }}" style="min-height: 250px;max-height: 250px;" alt="img-placeholder">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="item-wrapper">
                                    </div>
                                    <div class="item-name">
                                        <a href="#">{{ $product->title }}</a>
                                        <p class="item-company">By <span class="company-name">{{ $product->vendor }}</span></p>

                                        <div class="text-black-50" style="font-size: 12px;"> In Stock:
                                            &nbsp;&nbsp;{{ $product->variants->sum('quantity') .' left in ' . count($product->variants) . ' variants' }}</div>

                                        @if(isset($product->supplier->first()->supplier_setting) && $product->supplier->first()->supplier_setting->shipping_estimate != null && ($product->supplier->first()->supplier_setting->shipping_estimate - 1) > 0)
                                            <div class="text-black-50" style="font-size: 12px;">Estimated
                                                Shipping {{ ($product->supplier->first()->supplier_setting->shipping_estimate - 1) . ' - '  . ($product->supplier->first()->supplier_setting->shipping_estimate + 1)  }}
                                                days
                                            </div>
                                        @else
                                            <div class="text-white" style="font-size: 12px;"><span>&nbsp;</span></div>
                                        @endif

                                        @if(isset($product->supplier->first()->supplier_setting) && $product->supplier->first()->supplier_setting->shipping_price != null)
                                            <div class="text-black-50" style="font-size: 12px;"> Shipping Cost
                                                &nbsp;&nbsp;${{ number_format($product->supplier->first()->supplier_setting->shipping_price, 2) }}</div>
                                        @else
                                            <div class="text-white" style="font-size: 12px;"><span>&nbsp;</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-options text-center align-self-center">
                                    <div class="block my-2">
                                        <div class="p-0 m-0 row text-center">
                                            @if(isset($markup_settings) && ($markup_settings->value != null || $markup_settings->value != ''))
                                                @if($markup_settings->type == 'percentage')
                                                    @if($product->price > 0)
                                                        <div class="col-4 p-0">${{number_format( $product->price, 2) }}</div>
                                                        <div class="col-4 p-0">{{ number_format(((($product->price + (($product->price / 100) * $markup_settings->value)) - $product->price ) / $product->price) * 100, 2) }}
                                                            %
                                                        </div>
                                                        <div class="col-4 p-0">${{ number_format($product->price + (($product->price / 100) * $markup_settings->value),2) }}</div>
                                                    @else
                                                        <div class="col-4 p-0">$0.00</div>
                                                        <div class="col-4 p-0">0.00
                                                            %
                                                        </div>
                                                        <div class="col-4 p-0">$0.00</div>
                                                    @endif
                                                @elseif($markup_settings->type == 'fixed')
                                                    @if($product->price > 0)
                                                        <div class="col-4 p-0">${{number_format( $product->price, 2) }}</div>
                                                        <div class="col-4 p-0">{{ number_format(((($product->price + $markup_settings->value) - $product->price ) / $product->price) * 100, 2) }}%</div>
                                                        <div class="col-4 p-0">${{ number_format($product->price +  $markup_settings->value,2) }}</div>
                                                    @else
                                                        <div class="col-4 p-0">$0.00</div>
                                                        <div class="col-4 p-0">0.00%</div>
                                                        <div class="col-4 p-0">$0.00</div>
                                                    @endif
                                                @elseif($markup_settings->type == 'multiplier')
                                                    @if($product->price > 0)
                                                        <div class="col-4 p-0">${{number_format( $product->price, 2) }}</div>
                                                        <div class="col-4 p-0">{{ number_format(((($product->price * $markup_settings->value) - $product->price ) / $product->price) * 100, 2) }}%</div>
                                                        <div class="col-4 p-0">${{ number_format($product->price * $markup_settings->value,2) }}</div>
                                                    @else
                                                        <div class="col-4 p-0">$0.00</div>
                                                        <div class="col-4 p-0">0.00%</div>
                                                        <div class="col-4 p-0">$0.00</div>
                                                    @endif
                                                @endif
                                            @else
                                                @if($product->price > 0)
                                                    <div class="col-4 p-0">${{number_format( $product->price, 2) }}</div>
                                                    <div class="col-4 p-0">{{ number_format(((($product->price + 20) - $product->price ) / $product->price) * 100, 2) }}%</div>
                                                    <div class="col-4 p-0">${{ number_format($product->price + 20,2) }}</div>
                                                @else
                                                    <div class="col-4 p-0">$0.00</div>
                                                    <div class="col-4 p-0">0.00%</div>
                                                    <div class="col-4 p-0">$0.00</div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="p-0 m-0 row text-center">
                                            <div class="col-4 text-black-50 p-0"><small>cost</small></div>
                                            <div class="col-4 text-black-50 p-0"><small>margin</small></div>
                                            <div class="col-4 text-black-50 p-0"><small>retail</small></div>
                                        </div>
                                    </div>

                                    @if(isset($retailer_products))
                                        @if(in_array($product->id, $retailer_products))
                                            <div class="cart" style="background-color: #38c172" data-product-id="{{ $product->id }}">
                                                @if(\App\RetailerProduct::where('product_id', $product->id)->first()->toShopify == 1)
                                                    <i class="feather icon-shopping-bag"></i>Added to your store
                                                @else
                                                    <i class="feather icon-check-square"></i>Added to import list
                                                @endif
                                            </div>
                                        @else
                                            <div class="cart" data-product-id="{{ $product->id }}">
                                                <i class="feather icon-shopping-cart"></i>Add to import list
                                            </div>
                                        @endif
                                    @else
                                        <div class="cart" data-product-id="{{ $product->id }}">
                                            <i class="feather icon-shopping-cart"></i>Add to import list
                                        </div>
                                    @endif

                                </div>
                            </div>
                            @if(isset($retailer_products))
                                @if(!in_array($product->id, $retailer_products))
                                    <div class="position-absolute p-2">
                                        <input type="checkbox" class="dt-checkboxes position-relative products-add-to-import-list" data-id="{{ $product->id }}" style="width: 0;"
                                               name="products_selected" id="">
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="modal" id="setProfitMarginModal{{$product->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content modal-lg">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Set profit margin for products' price</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="">Select Profit margin type</label>
                                        <select class="form-control profit-margin-type" data-product-id="{{ $product->id }}">
                                            <option value="1">Percentage profit</option>
                                            <option value="2">Fixed profit</option>
                                        </select>
                                        <div id="percentage-profit-{{$product->id}}" class="form-group mt-1">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">%</div>
                                                </div>
                                                <input type="number" id="input-percentage-value-{{$product->id}}" class="form-control" placeholder="Percentage value">
                                            </div>
                                        </div>
                                        <div hidden id="fixed-profit-{{$product->id}}" class="form-group mt-1">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">$</div>
                                                </div>
                                                <input type="number" id="input-fixed-value-{{$product->id}}" class="form-control" placeholder="Fixed value">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-link" data-dismiss="modal">Close</a>
                                        <a class="btn btn-primary import-product" id="modal-btn-import-product-{{ $product->id }}" data-product-id="{{$product->id}}"
                                           href="javascript:void(0);">Import</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                @endforeach
                </section>
            @else
                <div class="card mt-1">
                    <div class="card-body">
                        <p class="text-black-50">Sorry there is no product for you at this time please come back later.</p>
                    </div>
                </div>
        @endif

        <!-- Ecommerce Products Ends -->

            <!-- Ecommerce Pagination Starts -->
            <section id="ecommerce-pagination">
                <div class="row mt-1">
                    <div class="col-sm-12 d-flex justify-content-center">
                        <nav aria-label="Page navigation example">
                            {{ $products->links() }}
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Ecommerce Pagination Ends -->

        </div>
    </div>
    <div class="sidebar-detached sidebar-left">
        <div class="sidebar">
            <!-- Ecommerce Sidebar Starts -->
            <div class="sidebar-shop" id="ecommerce-sidebar-toggler">

                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="filter-heading d-none d-lg-block">Filters</h6>
                    </div>
                </div>
                <span class="sidebar-close-icon d-block d-md-none">
                            <i class="feather icon-x"></i>
                        </span>
                <div class="card">
                    <form id="filter-form-1" action="{{ url('search/products') }}" method="GET">
                        <div class="card-body">

                            <div class="multi-range-price">
                                <div class="multi-range-title">
                                    <fieldset class="form-group position-relative">
                                        <input type="text" class="form-control search-product pr-1"
                                               @if(isset($search_term))
                                               value="{{ $search_term }}"
                                               @endif
                                               name="search" id="iconLeft5" placeholder="Search here">
                                    </fieldset>
                                </div>
                            </div>

                            <div class="multi-range-price">
                                <div class="multi-range-title pb-75">
                                    <h6 class="filter-title mb-0">Multi Range</h6>
                                </div>
                                <ul class="list-unstyled price-range" id="price-range">
                                    <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="price-filter" @if (isset($selected_price_filter)) @if($selected_price_filter == 0) checked @endif @endif value="0">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50">All</span>
                                    </span>
                                    </li>
                                    <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="price-filter" @if (isset($selected_price_filter)) @if($selected_price_filter == 1) checked @endif @endif value="1">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50"> &lt;=$10</span>
                                    </span>
                                    </li>
                                    <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="price-filter" @if (isset($selected_price_filter)) @if($selected_price_filter == 2) checked @endif @endif value="2">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50">$10 - $100</span>
                                    </span>
                                    </li>
                                    <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="price-filter" @if (isset($selected_price_filter)) @if($selected_price_filter == 3) checked @endif @endif value="3">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50">$100 - $500</span>
                                    </span>
                                    </li>
                                    <li>
                                    <span class="vs-radio-con vs-radio-primary py-25">
                                        <input type="radio" name="price-filter" @if (isset($selected_price_filter)) @if($selected_price_filter == 4) checked @endif @endif value="4">
                                        <span class="vs-radio">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="ml-50">&gt;= $500</span>
                                    </span>
                                    </li>

                                </ul>
                            </div>

                            <hr>

                            <!-- Categories Starts -->
                            @if(isset($categories))
                                <div id="product-categories">
                                    <div class="product-category-title">
                                        <h6 class="filter-title mb-1">Categories</h6>
                                    </div>
                                    <ul class="list-unstyled categories-list">
                                        @foreach($categories as $index => $category)
                                            @if($index < 10)
                                                <li>
                                                    <a data-category-name="{{ $category->name }}">
                                                    <span class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="category-filter" value="{{ $category->name }}"
                                                               @if(isset($selected_category)) @if($selected_category != '' && $selected_category != null ) @if($selected_category->id == $category->id) checked @endif @endif @endif>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border" style="height: 19px; width: 19px;"></span>
                                                            <span class="vs-radio--circle" style="height: 19px; width: 19px;"></span>
                                                        </span>
                                                        <span class="ml-50">
                                                           {{ $category->name }}
                                                        </span>
                                                    </span>
                                                    </a>
                                                </li>
                                            @elseif($index == 10)
                                                <li id="btn-see-more-categories">
                                                    <a href="javascript:void(0);">See More</a>
                                                </li>
                                            @else
                                                <li class="see-more-categories" hidden>
                                            <span class="vs-radio-con vs-radio-primary py-25">
                                                <input type="radio" name="category-filter" value="{{ $category->name }}">
                                                <span class="vs-radio">
                                                    <span class="vs-radio--border" style="height: 19px; width: 19px;"></span>
                                                    <span class="vs-radio--circle" style="height: 19px; width: 19px;"></span>
                                                </span>
                                                <span class="ml-50">
                                                    <a>{{ $category->name }}</a>
                                                </span>
                                            </span>
                                                </li>
                                            @endif
                                        @endforeach
                                        <li id="btn-see-less-categories" hidden>
                                            <a href="javascript:void(0);">See Less</a>
                                        </li>
                                    </ul>
                                </div>

                                <hr>
                            @endif
                        <!-- Categories Ends -->

                            <!-- Vendors Starts -->
                            @if(isset($vendors))
                                <div class="brands">
                                    <div class="brand-title mt-1 pb-1">
                                        <h6 class="filter-title mb-0">Vendors</h6>
                                    </div>
                                    <div class="brand-list" id="brands">
                                        <ul class="list-unstyled">

                                            @foreach($vendors as $index => $vendor)
                                                @if($index < 10)
                                                    <li class="d-flex justify-content-between align-items-center py-50">
                                                <span class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="vendor-filter[]"
                                                           @if(isset($selected_vendor_filter)) @if(is_array($selected_vendor_filter) && in_array($vendor['vendor'], $selected_vendor_filter)) checked
                                                           @endif @endif   value="{{ $vendor['vendor'] }}">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{ $vendor['vendor'] }}</span>
                                                </span>
                                                        <span>{{ $vendor['product_count'] }}</span>
                                                    </li>
                                                @elseif($index == 10)
                                                    <li id="btn-see-more-vendors">
                                                        <a href="javascript:void(0);">See More</a>
                                                    </li>
                                                @else
                                                    <li class="see-more-vendors d-flex justify-content-between align-items-center py-25" hidden>
                                                <span class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" name="vendor-filter[]" value="{{ $vendor['vendor'] }}">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                    <span class="">{{ $vendor['vendor'] }}</span>
                                                </span>
                                                        <span>{{ $vendor['product_count'] }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                            <li id="btn-see-less-vendors" hidden>
                                                <a href="javascript:void(0);">See Less</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                        @endif
                        <!-- /Vendors Ends -->

                            <!-- Clear Filters Starts -->
                            <div id="clear-filters">
                                <a href="{{ route('search.products') }}" class="btn btn-block btn-primary">CLEAR ALL FILTERS</a>
                            </div>
                            <!-- Clear Filters Ends -->

                        </div>
                    </form>
                </div>
            </div>
            <!-- Ecommerce Sidebar Ends -->
        </div>
    </div>

    <div class="modal" id="setProfitMarginModal">
        <div class="modal-dialog">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title">Set profit margin for products' price</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label for="">Select Profit margin type</label>
                    <select class="form-control" id="profit-margin-type">
                        <option value="1">Percentage profit</option>
                        <option value="2">Fixed profit</option>
                    </select>
                    <div id="percentage-profit" class="form-group mt-1">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">%</div>
                            </div>
                            <input type="number" id="input-percentage-value" class="form-control" placeholder="Percentage value">
                        </div>
                    </div>
                    <div hidden id="fixed-profit" class="form-group mt-1">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="number" id="input-fixed-value" class="form-control" placeholder="Fixed value">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-link" data-dismiss="modal">Close</a>
                    <a class="btn btn-primary" id="modal-btn-import-products" href="javascript:void(0);">Import</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loading-animation-modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title">Please wait while we are importing products to your account</h6>
                </div>

                <div class="modal-body">
                    <div class="sk-fading-circle" id="loader-animation" hidden>
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                    <div id="show-message"></div>
                </div>

                <div class="modal-footer" hidden id="modal-close-button">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    @if(isset($markup_settings))
        <div hidden id="ask-every-time">{{ $markup_settings->ask_every_time }}</div>
    @endif


@endsection

@section('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/wNumb.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/nouislider.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('js/scripts/pages/app-ecommerce-shop.js') }}"></script>
    <!-- END: Page JS-->

@endsection


