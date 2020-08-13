@extends('layouts.ecommerce')

@section('title', 'Orders')

@section('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-list-view.css') }}">
    <link href="{{ asset('dist/switchery/switchery.min.css') }}" rel="stylesheet"/>
    <!-- END: Page CSS-->
@endsection

@section('content')
    <style>
        select.form-control:not([multiple=multiple]) {
            background-image: url(https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/pages/arrow-down.png);
            background-position: calc(100% - 12px) 13px,calc(100% - 20px) 13px,100% 0;
            background-size: 12px 12px,10px 10px;
            background-repeat: no-repeat;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2rem;
        }
    </style>
    <div hidden id="page-type">my products</div>

    <div class="content-body">
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Orders</h4>
                    <div class="float-right">
                        @role('supplier')
                        <form action="{{ route('supplier.orders') }}" method="GET" class="d-inline-flex">
                            <div class="from-group mr-1">
                                <input type="text" placeholder="By Keyword" @if(isset($search)) value="{{ $search }}" @endif name="search" class="form-control" >
                            </div>
                            <div class="from-group mr-1">
                                <select  name="filter" class="form-control" id="">
                                    <option  value="">All Orders</option>
                                    <option @if($queryStatus == 'pending') selected @endif value="pending">New Orders</option>
                                    <option @if($queryStatus == 'ordered') selected @endif value="ordered" >Completed</option>
                                    {{--                            <option @if($queryStatus == 'pending') selected @endif value="cancelled" >Cancelled Only</option>--}}
                                    <option @if($queryStatus == 'shipped') selected @endif value="shipped" >Shipped</option>
                                </select>
                            </div>

                            <div class="from-group mr-1">
                                <button type="submit" class="btn btn-round btn-primary" style="padding: 11px 20px; !important;" >Search</button>

                            </div>

                        </form>
                        @endrole
                        @role('retailer')
                        <div class="row">


                            <div class="col-6 text-right p-0">
                                <form action="{{ route('retailer.orders') }}" method="GET">
{{--                                     <div class="from-group">--}}
{{--                                        <select name="filter" class="form-control" id="">--}}
{{--                                            <option>Status</option>--}}
{{--                                            <option value="1">Pending</option>--}}
{{--                                            <option value="2">Ordered</option>--}}
{{--                                            <option value="3">Completed</option>--}}
{{--                                            <option value="4">Cancelled</option>--}}
{{--                                        </select>--}}
{{--                                    </div> --}}
                                    <div class="from-group">
                                        <input type="text" placeholder="search" name="search" class="form-control" style="border-radius: 30px;">
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <a class="btn btn-primary" href="{{ route('retailer.orders.all.sync') }}">Sync Orders</a>
                            </div>

                        </div>
                        @endrole
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <!-- dataTable starts -->


        @if(isset($userType) && $userType == 'supplier')
            <section id="data-thumb-view" class="data-thumb-view-header">
                <div class="table-responsive">
                    <table id="dt-product" class="table data-thumb-view p-0">
                        <thead>
                        <th class="pl-1">ORDER</th>
                        <th>SHOPIFY STATUS</th>
                        <th>ORDER STATUS</th>
                        <th>TOTAL (incl. Tax)</th>
                        <th>CREATED</th>
                        <th class="text-right" width="15%">ACTION</th>
                        </thead>
                        <tbody>
                        @if(count($orders) > 0)
                            @foreach($orders as $order)
                                <tr>
                                    <td class="py-2">
                                        <a href="{{route('supplier.fulfillments', $order->retailer_order->id)}}">
                                        {{ $order->retailer_order->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($order->retailer_order->fulfillment_status == null)
                                            <div class="badge badge-warning">pending</div>
                                        @elseif($order->retailer_order->fulfillment_status == 'fulfilled')
                                            <div class="badge badge-success">{{ $order->retailer_order->fulfillment_status }}</div>
                                        @else
                                            <div class="badge badge-secondary">not fulfilled</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->order_status == 1 && $order->fulfillment_status == 'fulfilled')
                                            <div class='badge badge-secondary'>Completed</div>
                                        @elseif($order->order_status == 1 && $order->fulfillment_status != 'fulfilled')
                                            <div class='badge badge-success'>Ordered</div>
                                        @else
                                            <div class='badge badge-warning'>Pending</div>
                                        @endif
                                    </td>
                                    <td>${{ $order->retailer_order->total_price_usd }}</td>
                                    <td>
                                        {{ Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                    </td>
                                    <td class="text-right">
                                        <a class="text-primary" href="{{ route('supplier.fulfillments', $order->retailer_order->id) }}"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                        <a class="text-primary"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center"><strong>No order found.</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="d-flex justify-content-center">  {!! $orders->links() !!}</div>
        @else
            <section id="data-thumb-view" class="data-thumb-view-header">
                <div class="table-responsive">
                    <table id="dt-product" class="table data-thumb-view p-0">
                        <thead>
                        <th class="pl-1">ORDER</th>
                        <th>SHOPIFY STATUS</th>
                        <th>ORDER STATUS</th>
                        <th>TOTAL (incl. Tax)</th>
                        <th>TO PAY</th>
                        <th>CREATED</th>
                        <th class="text-right" width="15%">ACTION</th>
                        </thead>
                        <tbody>
                        @if(count($orders) > 0)
                            @foreach($orders as $order)
                                <tr>
                                    <td class="py-2">
                                        <a href="{{route('retailer.order', $order->id)}}">
                                        {{ $order->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($order->fulfillment_status == null)
                                            <div class="badge badge-warning">pending</div>
                                        @elseif($order->fulfillment_status == 'fulfilled')
                                            <div class="badge badge-success">{{ $order->fulfillment_status }}</div>
                                        @else
                                            <div class="badge badge-secondary">not fulfilled</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->supplier_orders != null)
                                            <?php

                                            $total_supplier_orders = count($order->supplier_orders);
                                            $fulfilled_orders = 0;
                                            foreach ($order->supplier_orders as $supplier_order) {
                                                if ($supplier_order->order_status == 1) {
                                                    $fulfilled_orders++;
                                                }
                                            }

                                            if ($total_supplier_orders == 0 && $total_supplier_orders == $fulfilled_orders) {
                                                echo "<div class='text-muted'>Not assigned to supplier</div>";
                                            } else if ($total_supplier_orders == $fulfilled_orders) {
                                                echo "<div class='badge badge-secondary'>Completed</div>";
                                            } else {
                                                echo "<div class='badge badge-success'>Ordered</div>";
                                            }
                                            ?>
                                        @else
                                            <div class="text-muted">Not assigned to supplier</div>
                                        @endif
                                    </td>
                                    <td>${{ $order->total_price_usd }}</td>
                                    <td>
                                        <?php
                                        $payable_amount = 0;
                                        $shipping_amount = 0;
                                        $supplier_array = [];
                                        foreach ($order->hasLineItems as $item) {
                                            if ($item->linked_retailer_product_variant !=  null){
                                                $payable_amount = $payable_amount + ($item->linked_retailer_product_variant->cost * $item->quantity);

                                                if (!in_array($item->linked_retailer_product_variant->retailer_product->linked_supplier_product->supplier->first()->name, $supplier_array)) {
                                                    array_push($supplier_array, $item->linked_retailer_product_variant->retailer_product->linked_supplier_product->supplier->first()->name);
                                                }
                                            }
                                            else{
                                                $payable_amount = $payable_amount + ($item->price * $item->quantity);
                                            }

                                        }
                                        foreach ($supplier_array as $supplier){

                                            $shipping_amount = $shipping_amount + \App\User::whereName($supplier)->first()->supplier_setting->shipping_price;
                                        }
                                        echo '$' . number_format($payable_amount, 2) . ' + $' . number_format($shipping_amount, 2) ;
                                        ?>
                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                    </td>
                                    <td class="text-right">
                                        <a class="text-primary" href="{{ route('retailer.order', $order->id) }}"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                        <a class="text-primary"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center"><strong>No order found.</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="d-flex justify-content-center">  {!! $orders->links() !!}</div>

        @endif

    </div>

@endsection


@section('scripts')

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('dist/switchery/switchery.min.js')  }}"></script>
    <script src="{{ asset('js/scripts/ui/data-list-view.js') }}"></script>
    <!-- END: Page JS-->
@endsection
