@extends('layouts.new_theme')


@if(isset($retailer))
    @section('title', $retailer->name)
@else
    @section('title', $supplier->name)
@endif

@section('style_sheets')

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-user.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/coming-soon.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-list-view.css') }}">
    <!-- END: Page CSS-->

    <link href="{{ asset('dist/switchery/switchery.min.css') }}" rel="stylesheet"/>

@endsection


@section('content')

    <style>
        .mr10 {
            margin-right: 10px;
        }
    </style>
    @if(isset($retailer))
        <!-- users edit start -->
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <span class="nav-link mr-5">
                           <span class="font-weight-bolder">Retailer: {{ $retailer->name }}</span>
                       </span>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item mr10">
                                <a class="nav-link  d-flex align-items-center active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-selected="true">
                                    {{--                                    <i class="feather icon-box mr-25"></i>--}}
                                    <span class="d-none d-sm-block">Products</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-selected="false">
                                    {{--                                    <i class="feather icon-shopping-cart mr-25"></i>--}}
                                    <span class="d-none d-sm-block">Orders</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-selected="false">
                                    {{--                                    <i class="feather icon-dollar-sign mr-25"></i>--}}
                                    <span class="d-none d-sm-block">Payments</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Settings</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#reffer_suppliers" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Referral Suppliers</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="products" aria-labelledby="products-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <fieldset class="filter pull-right d-flex">
                                    <form class=" d-flex" action="{{route('admin.retailer',$retailer->id)}}" method="get">
                                        <fieldset class="form-group mr-1">
                                            <input id="filter-by-name-id" type="search" value="{{$queryName}}" name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
                                        </fieldset>
                                        <div class="mr-1">
                                            <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                                        </div>
                                    </form>
                                </fieldset>
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view table-hover-animation">
                                            <thead>
                                            <tr>
                                                <th width="10%">Image</th>
                                                <th>NAME</th>
                                                <th>PRICE</th>
                                                <th>COST</th>
                                                <th>IMPORT TO SHOPIFY</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($retailer_products) < 1)
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>Retailer has no product.</strong></td>
                                                </tr>
                                            @else
                                                @foreach($retailer_products as $product)
                                                    <tr data-selected-product-id="{{ $product->id }}">
                                                        <td class="product-img">
                                                            @if($product->linked_supplier_product != null)
                                                                <a href="{{ route('product.show', $product->linked_supplier_product->id) }}" class="text-primary">
                                                                    <img src="{{ $product->image }}" alt="{{ $product->title }}" height="70px" width="auto">
                                                                    @else
                                                                        <img src="{{ $product->image }}" alt="{{ $product->title }}" height="70px" width="auto">
                                                            @endif
                                                        </td>
                                                        <td class="product-name">
                                                            @if($product->linked_supplier_product != null)
                                                                <a href="{{ route('product.show', $product->linked_supplier_product->id) }}" class="text-primary">
                                                                    {{ $product->title }}
                                                                </a>
                                                            @else
                                                                {{ $product->title }}
                                                            @endif
                                                        </td>
                                                        <td>${{number_format($product->price,2)}}</td>
                                                        <td>${{number_format($product->cost,2)}}</td>
                                                        <td>
                                                            @if($product->toShopify == 1)
                                                                <span class="badge badge-success">Yes</span>
                                                            @else
                                                                <span class="badge badge-warning">No</span>
                                                            @endif
                                                        </td>
                                                        @if($product->linked_supplier_product != null)
                                                            <td class="product-action text-right">
                                                                <a href="{{ route('product.show', $product->linked_supplier_product->id) }}" class="text-primary"><i class="fa fa-eye" style="font-size: 18px;"></i></a>

                                                            </td>
                                                        @else
                                                            <td class="text-right">Not Linked to Any Supplier</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <!-- dataTable ends -->
                                    </div>
                                </section>


                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view p-0">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>CREATED ON</th>
                                                <th>TOTAL (incl.Tax)</th>
                                                <th>STATUS</th>
                                                <th>SUPPLIER ORDER STATUS</th>
                                                <th>ASSIGNED TO SUPPLIER</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($retailer_orders) < 1)
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>Retailer has no order</strong></td>
                                                </tr>
                                            @else
                                                @foreach($retailer_orders as $retailer_order)
                                                    <tr data-selected-product-id="{{ $retailer_order->id }}">
                                                        <td class="product-name">{{ $retailer_order->name }}</td>
                                                        <td class="product-name">{{ \Illuminate\Support\Carbon::parse($retailer_order->shopify_created_at)->diffForHumans() }}</td>
                                                        <td class="product-name">${{ number_format($retailer_order->total_price, 2) }}</td>
                                                        <td class="product-name">
                                                            @if($retailer_order->financial_status != 'paid')
                                                                <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                    {{$retailer_order->financial_status }}
                                                                </div>
                                                            @elseif($retailer_order->financial_status == null)
                                                                <div class="badge badge-secondary text-capitalize" style="font-size: 10px">
                                                                    Not paid
                                                                </div>
                                                            @else
                                                                <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                                    {{ $retailer_order->financial_status }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="product-name">
                                                            @if(count($retailer_order->supplier_orders) == 0)
                                                                <div class="badge badge-info text-capitalize" style="font-size: 10px">
                                                                    New Order
                                                                </div>
                                                            @else

                                                                @if($retailer_order->supplier_orders->first()->financial_status != 'fulfilled')
                                                                    <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                        {{ $retailer_order->supplier_orders->first()->financial_status }}
                                                                    </div>
                                                                @elseif($retailer_order->supplier_orders->first()->fulfillment_status == null)
                                                                    <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                        Not Fulfilled
                                                                    </div>
                                                                @else
                                                                    <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                                        {{ $retailer_order->supplier_orders->first()->fulfillment_status }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="product-name">
                                                            @if($retailer_order->send_to_supplier == 1)
                                                                <div class="badge badge-success text-capitalize px-2" style="font-size: 10px">
                                                                    Yes
                                                                </div>
                                                            @else
                                                                <div class="badge badge-warning text-capitalize px-2" style="font-size: 10px">
                                                                    No
                                                                </div>
                                                            @endif
                                                        </td>

                                                        <td class="product-action text-right">
                                                            <a data-toggle="modal" data-target="#retailerOrderDetailsModal{{ $retailer_order->id }}" class="text-primary">
                                                                <i class="fa fa-eye" style="font-size: 18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                        @if(count($retailer_orders)  > 0)
                                            @foreach($retailer_orders as $retailer_order)
                                                <div class="modal" id="retailerOrderDetailsModal{{ $retailer_order->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Order {{ $retailer_order->name }}'s Details</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                    <th>ITEM</th>
                                                                    <th>QTY</th>
                                                                    <th>VENDOR</th>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($retailer_order->hasLineItems as $line_item)
                                                                        <tr>
                                                                            <td>{{ $line_item->name }}</td>
                                                                            <td>{{ $line_item->quantity }}</td>
                                                                            <td>{{ $line_item->vendor }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endif
                                    <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane" id="payments" aria-labelledby="payments-tab" role="tabpanel">
                                <!-- coming soon flat design -->

                                <div class="card">
                                    <div class="card-body">
                                        <table class="table data-thumb-view p-0">
                                            <thead>
                                            <th class="pl-1">Order</th>
                                            <th>Amount</th>
                                            <th>Receipt</th>
                                            <th>Transaction Date</th>
                                            <tbody>
                                            @if(count($retailer_orders) > 0)
                                                @foreach($retailer_orders as $index => $order)
                                                    @if($order->transaction != null)
                                                        <tr>
                                                            <td>{{$order->transaction->order->name}}</td>
                                                            <td>
                                                                ${{number_format($order->transaction->transaction_amount,2)}}
                                                            </td>
                                                            <td><a target="_blank" href="{{$order->transaction->receipt_url}}"> View Receipt</a></td>
                                                            <td>{{date_create($order->transaction->created_at)->format('M d Y - H:i a')}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center"><strong>No Transaction History Found.</strong></td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            {{--                                <section>--}}
                            {{--                                    <div class="row d-flex align-items-center justify-content-center">--}}
                            {{--                                        <div class="col-xl-5 col-md-8 col-sm-10 col-12 px-md-0 px-2">--}}
                            {{--                                            <div class="card text-center w-100 mb-0">--}}
                            {{--                                                <div class="card-content">--}}
                            {{--                                                    <div class="card-body pt-0 mt-2">--}}
                            {{--                                                        <img src="{{ asset('images/pages/rocket.png') }}" class="img-responsive block width-150 mx-auto" width="150" alt="bg-img">--}}
                            {{--                                                        <div class="card-header justify-content-center pb-0">--}}
                            {{--                                                            <div class="card-title">--}}
                            {{--                                                                <h2 class="mb-0">Payments are coming soon!</h2>--}}
                            {{--                                                            </div>--}}
                            {{--                                                        </div>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </div>--}}
                            {{--                                    </div>--}}
                            {{--                                </section>--}}
                            <!--/ coming soon flat design -->
                            </div>
                            <div class="tab-pane" id="settings" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Retailer markup settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Global Pricing Rules &nbsp;</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Supplier can assign a fixed markup or multiplier that will apply to all of the products"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <form action="{{ route('markup.settings') }}" method="POST">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Markup</label>
                                                        <input type="text" class="form-control" readonly required name="markup_value"
                                                               @if (isset($retailer_markup_settings)) value="{{ $retailer_markup_settings->value }}"
                                                               @endif id="inputMarkupValue" placeholder="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupType">Markup Type</label>
                                                        <select required class="form-control" readonly name="markup_type" id="inputMarkupType">
                                                            <option value="0">-- Select One --</option>
                                                            <option value="percentage"
                                                                    @if(isset($retailer_markup_settings)) @if($retailer_markup_settings->type == 'percentage') selected @endif @endif>Percent
                                                            </option>
                                                            <option value="fixed" @if(isset($retailer_markup_settings)) @if($retailer_markup_settings->type == 'fixed') selected @endif @endif>Fixed
                                                            </option>
                                                            <option value="multiplier"
                                                                    @if(isset($retailer_markup_settings)) @if($retailer_markup_settings->type == 'multiplier') selected @endif @endif>Multiplier
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="checkbox" name="ask_every_time" readonly
                                                               @if(isset($retailer_markup_settings)) @if($retailer_markup_settings->ask_every_time) checked
                                                               @endif @endif id="inputAskEveryTime">
                                                        <label for="inputAskEveryTime">Ask for profit margin every time importing product</label>
                                                    </div>
                                                </div>
                                                {{--                                                <button type="submit" class="btn btn-primary">Save changes</button>--}}
                                            </form>

                                        </div>
                                    </div>
                                </section>
                                <!-- Retailer markup settings: END -->
                            </div>
                            <div class="tab-pane" id="reffer_suppliers" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Retailer markup settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Referral Suppliers List</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Store attached suppliers list"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            @if(count($shop->attached_suppliers) > 0)

                                                <table class="table data-thumb-view p-0">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Supplier</th>
                                                    <th>Referral Code</th>
                                                    <th></th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($shop->attached_suppliers as $index => $supplier)
                                                        <tr>
                                                            <td>{{$index+1}}</td>
                                                            <td>{{$supplier->name}}</td>
                                                            <td>{{$supplier->referral_code}}</td>
                                                            <td class="text-right"><i onclick="window.location.href='{{route('settings.detach.supplier.store',['supplier_id'=>$supplier->id,'store_id'=>$shop->id])}}'" title="Detach Supplier" class="fa fa-trash font-medium-3" style="cursor: pointer"></i></td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>No Referral Suppliers Attached</p>
                                            @endif

                                        </div>
                                    </div>
                                </section>
                                <!-- Retailer markup settings: END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- users edit ends -->
    @else
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <span class="nav-link mr-5">
                           <span class="font-weight-bolder">Supplier: {{ $supplier->name }}</span>
                       </span>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center active" id="personal-tab" data-toggle="tab" href="#personal" aria-controls="account" role="tab" aria-selected="true">
                                    <span class="d-none d-sm-block">Personal Information</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center " id="products-tab" data-toggle="tab" href="#products" aria-controls="account" role="tab" aria-selected="true">
                                    <span class="d-none d-sm-block">Products</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="orders-tab" data-toggle="tab" href="#orders" aria-controls="information" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Orders</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="stores-tab" data-toggle="tab" href="#stores" aria-controls="stores" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Stores</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="payments-tab" data-toggle="tab" href="#payments" aria-controls="social" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Payments</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Settings</span>
                                </a>
                            </li>

                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#trail" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Trail Details</span>
                                </a>
                            </li>

                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#reffer_stores" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Referral Stores</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal" aria-labelledby="products-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
{{--                                    <p >Referral Code: <span class="text-info font-weight-bold">{{$supplier->referral_code}}</span></p>--}}
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>EMAIL</th>
                                                <th>COMPANY NAME</th>
                                                <th>PHONE</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Country</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td class="product-img">
                                                    {{ $supplier->name }}
                                                </td>
                                                <td class="product-name">
                                                    {{ $supplier->email }}
                                                </td>
                                                <td class="product-name">
                                                    {{ $supplier->company_name }}
                                                </td>
                                                <td class="product-name">
                                                    {{ $supplier->phone }}
                                                </td>
                                                <td> {{ $supplier->address }} {{$supplier->address2}} </td>
                                                <td> {{ $supplier->city }}  </td>
                                                <td> {{ $supplier->state }}  </td>
                                                <td> {{ $supplier->country }}  </td>
{{--                                                <td> @if($supplier->status == 0) <span class="badge badge-danger">Disabled</span> @else <span class="badge-success badge"> Active</span> @endif </td>--}}
{{--                                                <td>--}}
{{--                                                    @if($supplier->subscribed('Supplier Monthly Plan - SmokeDrop'))--}}
{{--                                                        --}}{{--                                           {{ dd($supplier->subscription('Supplier Monthly Plan - SmokeDrop'))}}--}}
{{--                                                        @if (!$supplier->subscription('Supplier Monthly Plan - SmokeDrop')->cancelled())--}}
{{--                                                            <span class="badge badge-success">Active</span>--}}
{{--                                                        @else--}}
{{--                                                            <span class="badge badge-danger">Cancelled</span>--}}
{{--                                                        @endif--}}
{{--                                                    @else--}}
{{--                                                        @if($supplier->onGenericTrial())--}}
{{--                                                            <span class="badge badge-info">Trial</span>--}}
{{--                                                        @else--}}
{{--                                                            @if($supplier->free_user == 1)--}}
{{--                                                                <span class="badge badge-primary">Free User</span>--}}
{{--                                                            @else--}}
{{--                                                                <span class="badge badge-warning">No Subscription</span>--}}
{{--                                                            @endif--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    @if($supplier->subscribed('Supplier Monthly Plan - SmokeDrop'))--}}
{{--                                                        {{date_create($supplier->subscription('Supplier Monthly Plan - SmokeDrop')->created_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')}}--}}
{{--                                                    @else--}}
{{--                                                        @if($supplier->onGenericTrial())--}}
{{--                                                            {{date_create($supplier->trial_ends_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')}}--}}
{{--                                                        @endif--}}
{{--                                                    @endif--}}
{{--                                                </td>--}}

{{--                                                <td>{{$supplier->referral_code}}</td>--}}
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane " id="products" aria-labelledby="products-tab" role="tabpanel">
                                <fieldset class="filter pull-right d-flex">
                                    <form class=" d-flex" action="{{route('admin.supplier',$supplier->id)}}" method="get">
                                        <fieldset class="form-group mr-1">
                                            <input id="filter-by-name-id" type="search" value="{{$queryName}}" name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
                                        </fieldset>
                                        <fieldset class="form-group mr-1">
                                            <select name="filter-by-status" class="form-control d-inline-block">
                                                <option @if($queryStatus == 'all') selected @endif  value="all">All Products</option>
                                                <option  @if($queryStatus == 'active') selected @endif value="active" >Active Products</option>
                                                <option  @if($queryStatus == 'disabled') selected @endif value="disabled" >Disabled Products</option>
                                            </select>
                                        </fieldset>
                                        <div class="mr-1">
                                            <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                                        </div>
                                    </form>
                                </fieldset>
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->

                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view">
                                            <thead>
                                            <tr>
                                                <th width="10%">Image</th>
                                                <th>NAME</th>
                                                <th>PRICE</th>
                                                <th>ADDED TO IMPORT LIST</th>
                                                <th>STATUS</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($supplier_products) < 1)
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>retailer has no product</strong></td>
                                                </tr>
                                            @else
                                                @foreach($supplier_products as $product)
                                                    <tr data-selected-product-id="{{ $product->id }}">
                                                        <td class="product-img"><a href="{{ route('products.show', $product->id) }}" class="text-primary">
                                                                <img src="{{ $product->image }}" alt="{{ $product->title }}" height="100px" width="auto">
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="{{ route('products.show', $product->id) }}" class="text-primary">
                                                                {{ $product->title }}
                                                            </a>
                                                        </td>
                                                        <td>${{number_format($product->price,2)}}</td>
                                                        <td class="product-name">{{ $product->sold_count }} times</td>
                                                        <td class="product-name">
                                                            <form id="form-change-product-status-{{$product->id}}" action="{{ route('admin.change.product.status', $product->id) }}">
                                                            <span data-toggle="tooltip" title="Turn it on to active and off to disable this product">
                                                                <input class="js-switch" @if($product->status == 1) checked @endif type="checkbox" name="status" id="{{$product->id}}">
                                                            </span>
                                                            </form>
                                                        </td>
                                                        <td class="product-action text-right">
                                                            <a href="{{ route('products.show', $product->id) }}" class="text-primary">
                                                                <i class="fa fa-eye" style="font-size: 18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->

                                <div class="d-flex justify-content-center">  {!! $supplier_products->links() !!}</div>
                            </div>
                            <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view table-hover-animation">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>CREATED ON</th>
                                                <th>TOTAL (excl. Tax)</th>
                                                <th>STATUS</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($supplier_orders) < 1)
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>Retailer has no order</strong></td>
                                                </tr>
                                            @else
                                                @foreach($supplier_orders as $supplier_order)
                                                    <tr data-selected-product-id="{{ $supplier_order->id }}">
                                                        <td class="product-name">{{ $supplier_order->retailer_order->name }}</td>
                                                        <td class="product-name">{{ \Illuminate\Support\Carbon::parse($supplier_order->created_at)->diffForHumans() }}</td>
                                                        <td class="product-name">
                                                            @php($order_total=0)
                                                            @foreach($supplier_order->hasLineItems as $item)
                                                                <?php
                                                                $order_total = $order_total + ($item->quantity * $item->price);
                                                                ?>
                                                            @endforeach
                                                            ${{ number_format($order_total, 2) }}
                                                        </td>
                                                        <td class="product-name">
                                                            @if($supplier_order->financial_status != 'fulfilled')
                                                                <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                    {{$supplier_order->financial_status }}
                                                                </div>
                                                            @elseif($supplier_order->fulfillment_status == null)
                                                                <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                    Not Fulfilled
                                                                </div>
                                                            @else
                                                                <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                                    {{ $retailer_order->fulfillment_status }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td class="product-action text-right">
                                                            <a data-toggle="modal" data-target="#supplierOrderDetailsModal{{ $supplier_order->id }}" class="text-primary"><i class="fa fa-eye" style="font-size: 18px;"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>

                                        @if(count($supplier_orders ) > 0)
                                            @foreach($supplier_orders as $supplier_order)
                                                <div class="modal" id="supplierOrderDetailsModal{{ $supplier_order->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Order {{ $supplier_order->retailer_order->name }}'s Details</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                    <th>ITEM</th>
                                                                    <th>QTY</th>
                                                                    <th>VENDOR</th>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($supplier_order->hasLineItems as $line_item)
                                                                        <tr>
                                                                            {{--   @dd($line_item) --}}
                                                                            <td>{{ $line_item->name }}</td>
                                                                            <td>{{ $line_item->quantity }}</td>
                                                                            <td>{{ $line_item->vendor }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>

                                                                </table>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endif
                                    <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane" id="stores" aria-labelledby="stores-tab" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table data-thumb-view table-hover-animation">
                                        <thead>
                                        <tr>
                                            <th>SHOP DOMAIN</th>
                                            <th>PRODUCTS FETCHED</th>
                                            <th class="text-right">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($supplier_stores) < 1)
                                            <tr>
                                                <td colspan="3" class="text-center"><strong>This supplier has no store.</strong></td>
                                            </tr>
                                        @else
                                            @foreach($supplier_stores as $store)
                                                <tr>
                                                    <td class="py-3">{{ $store->shop_domain }}</td>
                                                    <td class="py-3">{{ $store->fetch_count }} times</td>
                                                    <td>
                                                        <a class="pull-right" href data-toggle="modal" data-target="#deleteShopConfirmationModal{{$store->id}}" style="font-size: 18px">
                                                            <span data-toggle="tooltip" title="Click to delete store"><i class="fa fa-trash" style="font-size: 18px;"></i></span>
                                                        </a>
                                                    </td>
                                                    <div class="modal" id="deleteShopConfirmationModal{{$store->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Delete Shop</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this shop?
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <a href style="color: darkgrey" data-dismiss="modal">Close</a>
                                                                    <a href="{{ route('supplier.store.delete', $store->id) }}" class="btn btn-danger">Yes, I am</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="payments" aria-labelledby="payments-tab" role="tabpanel">
                                <!-- coming soon flat design -->
                                @if($supplier->subscriptions != null)

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table data-thumb-view p-0">
                                                <thead>
                                                <th class="pl-1">Plan</th>
                                                <th>Status</th>
                                                <th>Price</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                @if(count($supplier->subscriptions) > 0)
                                                    @foreach($supplier->subscriptions as $index => $s)
                                                        <tr>
                                                            <td>{{$s->name}}</td>
                                                            <td>
                                                                @if($s->stripe_status == 'canceled')
                                                                    <div class="badge badge-warning">cancelled</div>
                                                                @elseif($s->stripe_status == 'active')
                                                                    <div class="badge badge-success">active</div>
                                                                @endif
                                                            </td>
                                                            <td>$49.00</td>
                                                            <td>{{date_create($s->created_at)->format('M d Y')}}</td>
                                                            <td>@if($s->ends_at != null){{date_create($s->ends_at)->format('M d Y')}} @else {{date_create($s->created_at)->add(new DateInterval('P30D'))->format('M d Y')}} @endif</td>
                                                            {{--                                                    <td><a href="/user/invoice/{{ $invoices[$index]->id }}">Download</a></td>--}}
                                                            <td><a target="_blank" href="{{ $supplier->invoices()[$index]->hosted_invoice_url }}">View Invoice</a></td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center"><strong>No Subscription History Found.</strong></td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                            @endif

                            <!--/ coming soon flat design -->
                            </div>
                            <div class="tab-pane" id="settings" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Supplier shipping settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Shipping &nbsp;</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Supplier can set shipping prices and estimated shipping time"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <form action="{{ route('supplier.shipping.settings') }}" method="POST">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Shipping Price</label>
                                                        <input type="text" class="form-control" readonly="" required name="shipping_price"
                                                               @if (isset($supplier_settings)) value="{{ $supplier_settings->shipping_price }}"
                                                               @endif id="inputMarkupValue" placeholder="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Shipping Estimate  <!-- &nbsp;&nbsp;<span class="text-black-50">in days </span> --> <i
                                                                class="fa fa-info-circle" data-toggle="tooltip"
                                                                title="Estimated shipping time set by supplier e.g. if 2 days selected then retailer will see 1 - 3 days estimated shipping time"></i></label>
                                                        <input type="text" class="form-control" readonly="" required name="shipping_estimate"
                                                               @if (isset($supplier_settings)) value="{{ $supplier_settings->shipping_estimate }}"
                                                               @endif id="inputMarkupValue" placeholder="">
                                                    </div>
                                                </div>
                                                {{--                                                        <button type="submit" class="btn btn-primary">Save changes</button>--}}
                                            </form>

                                        </div>
                                    </div>
                                </section>
                                <!-- Supplier shipping settings: END -->


                                <!-- Supplier markup settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Global Pricing Rules &nbsp;</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Supplier can assign a fixed markup or multiplier that will apply to all of the products"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <form action="{{ route('markup.settings') }}" method="POST">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Markup</label>
                                                        <input type="text" class="form-control" readonly required name="markup_value"
                                                               @if (isset($supplier_markup_settings)) value="{{ $supplier_markup_settings->value }}"
                                                               @endif id="inputMarkupValue" placeholder="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupType">Markup Type</label>
                                                        <select required class="form-control" readonly name="markup_type" value id="inputMarkupType">
                                                            <option value="0">-- Select One --</option>
                                                            <option value="percentage"
                                                                    @if(isset($supplier_markup_settings)) @if($supplier_markup_settings->type == 'percentage') selected @endif @endif>Percent
                                                            </option>
                                                            <option value="fixed" @if(isset($supplier_markup_settings)) @if($supplier_markup_settings->type == 'fixed') selected @endif @endif>Fixed
                                                            </option>
                                                            <option value="multiplier"
                                                                    @if(isset($supplier_markup_settings)) @if($supplier_markup_settings->type == 'multiplier') selected @endif @endif>Multiplier
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="checkbox" name="ask_every_time" readonly @if(isset($markup_settings)) @if($markup_settings->ask_every_time) checked
                                                               @endif @endif id="inputAskEveryTime">
                                                        <label for="inputAskEveryTime">Ask for profit margin every time importing product</label>
                                                    </div>
                                                </div>
                                                {{--                                                <button type="submit" class="btn btn-primary">Save changes</button>--}}
                                            </form>

                                        </div>
                                    </div>
                                </section>
                                <!-- Supplier markup settings: END -->
                            </div>

                            <div class="tab-pane" id="trail" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Supplier shipping settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Trail Extension Setting</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Here You Can Extend The Trail Period Of Supplier"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            @if($supplier->onGenericTrial())
                                                <div class="table-responsive">
                                                    <table id="dt-product" class="table data-thumb-view p-0">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="badge badge-info">Trial</span>
                                                            </td>
                                                            <td>
                                                                Ends at  {{date_create($supplier->trial_ends_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                            <form action="{{route('admin.change.supplier.trail',$supplier->id)}}" method="post">
                                                @csrf
                                                <section class="mt-1 row">
                                                    <div class="form-group col-md-3">
                                                        <label for="Email Address">User Name</label>
                                                        <input type="text" class="form-control" readonly value="{{$supplier->name}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="Email Address">Email Address</label>
                                                        <input type="text" class="form-control" readonly value="{{$supplier->email}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="Email Address">Trail Ends at</label>
                                                        <input type="date" name="trial_ends_at" class="form-control" min="{{date_create($supplier->trial_ends_at)->format('Y-m-d')}}"  value="{{date_create($supplier->trial_ends_at)->format('Y-m-d')}}">
                                                    </div>
                                                </section>
                                                <div class="row">
                                                    <div class=" col-md-3">
                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="tab-pane" id="reffer_stores" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Supplier shipping settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Referral Stores List </a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="the stores who added supplier as referral"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">


                                            <p >Referral Code: <input type="text" class="form-control" readonly value="{{$supplier->referral_code}}" style="width: 50%"></p>
                                            <div class="table-responsive">
                                                <table id="dt-product" class="table data-thumb-view p-0">
                                                    @if(count($supplier->restricted_stores) > 0)
                                                        <table class="table data-thumb-view p-0">
                                                            <tbody>
                                                            @foreach($supplier->restricted_stores as $index => $s)
                                                                <tr>
                                                                    <td>{{$s->shopify_domain}}</td>
                                                                    <td class="text-right"><i onclick="window.location.href='{{route('settings.detach.supplier.store',['supplier_id'=>$supplier->id,'store_id'=>$s->id])}}'" title="Detach Store" class="fa fa-trash font-medium-3" style="cursor: pointer"></i></td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p>No Referral Stores Found</p>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection


@section('scripts')

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('vendors/js/coming-soon/jquery.countdown.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('js/scripts/pages/app-user.js') }}"></script>
    <script src="{{ asset('js/scripts/navs/navs.js') }}"></script>
    <script src="{{ asset('js/scripts/pages/coming-soon.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script src="{{ asset('dist/switchery/switchery.min.js')  }}"></script>

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('js/scripts/ui/data-list-view.js') }}"></script>
    <!-- END: Page JS-->

    <script>

        //initialized switchery elements
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        $(function () {
            var $a = $(".tabs li");
            $a.click(function () {
                $a.removeClass("active");
                $(this).addClass("active");
            });

            $('.js-switch').change(function () {
                $(this).parent().parent().submit();
            });
        });
    </script>

@endsection
