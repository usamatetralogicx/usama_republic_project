@extends('layouts.ecommerce')

@section('title', 'Orders')

@section('content')

    <div class="mt-2">

        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">
                        @role('admin')
                        Order Details
                        @endrole

                        @role('supplier|retailer')
                        Orders
                        @endrole

                    </h4>
                    <div class="float-right">
                        @role('retailer')
                        <a class="btn btn-primary" href="{{ route('retailer.orders.all.sync') }}">Sync Orders</a>
                        @endrole
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        @if(isset($pageType) && $pageType == 'supplier')
            @if(count($order_with_details) > 0)
                @foreach($order_with_details as $order)
                    @if(count($order['order_details']) > 0)
                        <div class="my-1 p-1 bg-white border">
                            <div class="text-black-50">
                                Order <a href="#">{{ $order['order']->name }}</a> {{ Carbon\Carbon::parse($order['order']->shopify_created_at)->format('Y M d') }}
                                <div class="float-right"><a href="{{ url('supplier/fulfillment', $order['order']->id) }}" class="btn-sm btn-primary text-white">Fulfill Order</a></div>
                                <span class="ml-2" style="font-size: 12px;">
                                    Status:
                                    <span>
                                        <?php
                                        $noOfFulfilledOrders = 0;
                                        ?>
                                        @foreach($order['order']->supplier_orders as $supplier_order)
                                            @if ($supplier_order->fulfillment_status == 'fulfilled' || $supplier_order->order_status == 1)
                                                <?php
                                                $noOfFulfilledOrders++;
                                                ?>
                                            @endif
                                        @endforeach

                                        @if(count($order['order']->supplier_orders) != $noOfFulfilledOrders || count($order['order']->supplier_orders) < 1 )
                                            <div class="badge badge-warning text-capitalize " style="font-size: 10px">
                                                    Pending
                                            </div>
                                        @else
                                            <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                  Fulfilled
                                            </div>
                                        @endif
                                    </span>
                                </span>
                                @if( $order['order']->supplier_orders->first() != null)
                                    <span class="ml-2" style="font-size: 12px;">
                                    Retailer:
                                    <span>

                                            @if(  $order['order']->supplier_orders->first()->retailer_order->retailer != null)
                                            <div class="badge badge-light-primary text-capitalize my-sm-1 my-md-0" style="font-size: 12px">
                                                {{ $order['order']->supplier_orders->first()->retailer_order->retailer->name }}
                                            </div>
                                        @endif

                                    </span>
                                </span>
                                @endif
                                <div class="modal" id="fulfillOrderModal{{$order['order']->id}}">
                                    {{--                                    <div class="modal-dialog modal-lg">--}}
                                    {{--                                        <div class="modal-content">--}}

                                    {{--                                            <!-- Modal Header -->--}}
                                    {{--                                            <div class="modal-header">--}}
                                    {{--                                                <h4 class="modal-title">Order Fulfillment</h4>--}}
                                    {{--                                                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <!-- Modal body -->--}}
                                    {{--                                            <div class="modal-body">--}}
                                    {{--                                                Fulfillment details goes here--}}
                                    {{--                                            </div>--}}

                                    {{--                                            <!-- Modal footer -->--}}
                                    {{--                                            <div class="modal-footer">--}}
                                    {{--                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>--}}
                                    {{--                                            </div>--}}

                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}
                                </div>

                            </div>
                            @foreach($order['order_details'] as  $supplier_order_line_item)
                                <div class="dropdown-divider"></div>
                                <div class="row  px-1">
                                    <div class="col-md-1 text-center">
                                        @if($supplier_order_line_item->retailer_product_variant->src != null)
                                            <img src="{{  $supplier_order_line_item->retailer_product_variant->retailer_product->image }}"
                                                 alt="{{ $supplier_order_line_item->retailer_product_variant->name }}" height="50px"
                                                 width="50px">
                                        @else
                                            <img src="{{  $supplier_order_line_item->retailer_product_variant->src }}" alt="{{ $supplier_order_line_item->retailer_product_variant->name }}"
                                                 height="50px"
                                                 width="50px">
                                        @endif
                                    </div>
                                    <div class="col-md-7 d-flex align-items-center w-100">
                                        <div class="row w-100">
                                            <div class="text-capitalize">
                                                <div>
                                                    {{ $supplier_order_line_item->title }}
                                                </div>
                                                <div class="text-black-50">
                                                    {{ $supplier_order_line_item->variant_title }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 align-items-center">
                                        <div class="row">
                                            <div class="col-4 p-0 py-1 d-sm-inline">
                                                @role('retailer')
                                                {{ number_format($supplier_order_line_item->retailer_product_variant->price, 2) . ' ' . $order['order']->currency  }}
                                                @endrole

                                                @role('supplier')
                                                {{ number_format(\App\ProductVariants::where('title', $supplier_order_line_item->retailer_product_variant->title)->where('shopify_variant_id', $supplier_order_line_item->retailer_product_variant->local_shopify_variant_id)->first()->price, 2) . ' ' . $order['order']->currency  }}
                                                @endrole


                                            </div>
                                            <div class="col-1 p-0 py-1">
                                                <div class="text-black-50">x</div>
                                            </div>
                                            <div class="col-2 p-0 py-1">
                                                {{ $supplier_order_line_item->fulfillable_quantity ? $supplier_order_line_item->fulfillable_quantity : $supplier_order_line_item->quantity }}
                                            </div>
                                            <div class="col-5 p-0 py-1 text-right">
                                                @role('retailer')
                                                {{ number_format((($supplier_order_line_item->fulfillable_quantity ? $supplier_order_line_item->fulfillable_quantity : $supplier_order_line_item->quantity) * $supplier_order_line_item->retailer_product_variant->price) , 2) . ' ' . $order['order']->currency   }}
                                                @endrole

                                                @role('supplier')
                                                {{ number_format((($supplier_order_line_item->fulfillable_quantity ? $supplier_order_line_item->fulfillable_quantity : $supplier_order_line_item->quantity) * \App\ProductVariants::where('title', $supplier_order_line_item->retailer_product_variant->title)->where('shopify_variant_id', $supplier_order_line_item->retailer_product_variant->local_shopify_variant_id)->first()->price) , 2) . ' ' . $order['order']->currency   }}
                                                @endrole
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-black-50 mt-2">No order found.</div>
            @endif
        @elseif(isset($pageType) && $pageType == 'admin')
            @if(count($order_with_details) > 0)
                @foreach($order_with_details as $order)
                    @if(count($order['order_details']) > 0)
                        <div class="my-1 p-1 bg-white border">
                            <div class="text-black-50">
                                Order <a href="#">{{ $order['order']->name }}</a> {{ Carbon\Carbon::parse($order['order']->shopify_created_at)->format('Y M d') }}
                                <span class="ml-2" style="font-size: 12px;">
                                    Status:
                                    <span>
                                        <?php
                                        $noOfFulfilledOrders = 0;
                                        ?>
                                        @if($order['order']->supplier_orders != null)
                                            @foreach($order['order']->supplier_orders as $supplier_order)
                                                @if ($supplier_order->fulfillment_status == 'fulfilled' || $supplier_order->order_status == 1)
                                                    <?php
                                                    $noOfFulfilledOrders++;
                                                    ?>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if(count($order['order']->supplier_orders) != $noOfFulfilledOrders || count($order['order']->supplier_orders) < 1 )
                                            <div class="badge badge-warning text-capitalize " style="font-size: 10px">
                                                    Pending
                                            </div>
                                        @else
                                            <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                  Fulfilled
                                            </div>
                                        @endif
                                    </span>
                                </span>
                                @if($order['order']->supplier_orders->first() != null)
                                    <span class="ml-2" style="font-size: 12px;">
                                        Retailer:
                                        <span>
                                            @if(  $order['order']->supplier_orders->first()->retailer_order->retailer != null)
                                                <div class="badge badge-light-primary text-capitalize my-sm-1 my-md-0" style="font-size: 12px">
                                                    {{ $order['order']->supplier_orders->first()->retailer_order->retailer->name }}
                                                </div>
                                            @endif
                                        </span>
                                    </span>
                                @endif
                                <span class="ml-2" style="font-size: 12px;">
                                        Supplier:
                                        <span>
                                            @if($order['order']->supplier_orders->first()->supplier != null)
                                                <div class="badge badge-light-primary text-capitalize my-sm-1 my-md-0" style="font-size: 12px">
                                                    {{ $order['order']->supplier_orders->first()->supplier->name }}
                                                </div>
                                            @endif
                                        </span>
                                    </span>
                            </div>
                            @foreach($order['order_details'] as  $supplier_order_line_item)
                                <div class="dropdown-divider"></div>
                                <div class="row  px-1">
                                    <div class="col-md-1 text-center">
                                        @if($supplier_order_line_item->retailer_product_variant->src != null)
                                            <img src="{{  $supplier_order_line_item->retailer_product_variant->retailer_product->image }}"
                                                 alt="{{ $supplier_order_line_item->retailer_product_variant->name }}" height="50px"
                                                 width="50px">
                                        @else
                                            <img src="{{  $supplier_order_line_item->retailer_product_variant->src }}" alt="{{ $supplier_order_line_item->retailer_product_variant->name }}"
                                                 height="50px"
                                                 width="50px">
                                        @endif
                                    </div>
                                    <div class="col-md-7 d-flex align-items-center w-100">
                                        <div class="row w-100">
                                            <div class="text-capitalize">
                                                <div>
                                                    {{ $supplier_order_line_item->title }}
                                                </div>
                                                <div class="text-black-50">
                                                    {{ $supplier_order_line_item->variant_title }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 align-items-center">
                                        <div class="row">
                                            <div class="col-4 p-0 py-1 d-sm-inline">
                                                @role('retailer')
                                                {{ number_format($supplier_order_line_item->retailer_product_variant->price, 2) . ' ' . $order['order']->currency  }}
                                                @endrole

                                                @role('admin|supplier')
                                                {{ number_format(\App\ProductVariants::where('title', $supplier_order_line_item->retailer_product_variant->title)->first()->price, 2) . ' ' . $order['order']->currency  }}
                                                @endrole
                                            </div>
                                            <div class="col-1 p-0 py-1">
                                                <div class="text-black-50">x</div>
                                            </div>
                                            <div class="col-2 p-0 py-1">
                                                {{ $supplier_order_line_item->fulfillable_quantity ? $supplier_order_line_item->fulfillable_quantity : $supplier_order_line_item->quantity }}
                                            </div>
                                            <div class="col-5 p-0 py-1 text-right">
                                                @role('retailer')
                                                {{ number_format((($supplier_order_line_item->fulfillable_quantity ? $supplier_order_line_item->fulfillable_quantity : $supplier_order_line_item->quantity) * $supplier_order_line_item->retailer_product_variant->price) , 2) . ' ' . $order['order']->currency   }}
                                                @endrole

                                                @role('admin|supplier')
                                                {{ number_format((($supplier_order_line_item->fulfillable_quantity ? $supplier_order_line_item->fulfillable_quantity : $supplier_order_line_item->quantity) * \App\ProductVariants::where('title', $supplier_order_line_item->retailer_product_variant->title)->first()->price) , 2) . ' ' . $order['order']->currency   }}
                                                @endrole
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-black-50 mt-2">No order found.</div>
            @endif
        @else
            @if(count($order_with_details) > 0)
                @foreach($order_with_details as $order)
                    @if(count($order['order_details']) > 0)
                        <div class="my-1 p-1 bg-white border" style="font-size: 12px">
                            <div class="text-black-50">
                                Order <a href="#">{{ $order['order']->name }}</a> {{ Carbon\Carbon::parse($order['order']->shopify_created_at)->format('Y M d') }}

                                <span class="ml-2">Shopify Status:</span>
                                <!--     financial status     -->
                                @if($order['order']->financial_status != 'paid')
                                    <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                        {{ $order['order']->financial_status }}
                                    </div>
                                @elseif($order['order']->financial_status == null)
                                    <div class="badge badge-secondary text-capitalize" style="font-size: 10px">
                                        Not paid
                                    </div>
                                @else
                                    <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                        {{ $order['order']->financial_status }}
                                    </div>
                                @endif

                            <!--     fulfillment status     -->
                                @if($order['order']->fulfillment_status == 'partial')
                                    <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                        Partially fulfilled
                                    </div>
                                @elseif($order['order']->fulfillment_status == null)
                                    <div class="badge badge-secondary text-capitalize" style="font-size: 10px">
                                        Not fulfilled
                                    </div>
                                @else
                                    <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                        {{ $order['order']->fulfillment_status }}
                                    </div>
                                @endif

                                {{--                                <div class="float-right"><a data-toggle="modal" data-target="#fulfillOrderModal{{$order['order']->id}}" class="btn-sm btn-primary text-white">Fulfill Order</a></div>--}}
                                @if(!$order['order']->send_to_supplier)
                                    <div class="float-right mr-1"><a data-toggle="modal" data-target="#sendOrderToSuppliersModal{{$order['order']->id}}" class="btn-sm btn-primary text-white">Send to
                                            supplier</a></div>
                                @else
                                    <span class="ml-2" style="font-size: 12px;">
                                        Supplier Status:
                                        <span>

                <!--- Below code check whether all the supplier has fulfilled the products in the order or no -->
                                            <?php
                                            $noOfFulfilledOrders = 0;
                                            ?>
                                            @foreach($order['order']->supplier_orders as $supplier_order)
                                                @if ($supplier_order->fulfillment_status == 'fulfilled' || $supplier_order->order_status == 1)
                                                    <?php
                                                    $noOfFulfilledOrders++;
                                                    ?>
                                                @endif
                                            @endforeach

                                            @if((count($order['order']->supplier_orders) != $noOfFulfilledOrders) || count($order['order']->supplier_orders) < 1)
                                                <div class="badge badge-warning text-capitalize " style="font-size: 10px">
                                                    Pending
                                                </div>
                                            @else
                                                <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                  Fulfilled
                                                </div>

                                            @endif
                                        </span>
                                    </span>
                                @endif
                                <div class="modal" id="fulfillOrderModal{{$order['order']->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Order Fulfillment</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                Fulfillment details goes here
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal" id="sendOrderToSuppliersModal{{$order['order']->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Send order to the supplier(s)</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <form action="{{ route('retailer.assign.order.to.suppliers',  $order['order']->id) }}" method="POST">
                                            @csrf
                                            <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Note &nbsp;&nbsp;<span class="text-black-50"><small>optional</small></span></label>
                                                        <textarea class="form-control" name="note_to_supplier"></textarea>
                                                    </div>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @foreach($order['order_details'] as  $detail)
                                <div class="dropdown-divider"></div>
                                <div class="row">
                                    <div class="col-1 text-center">
                                        <img src="{{ $detail['variant_image'] }}" alt="{{ $detail['line_item']->name }}" height="50px" width="50px">
                                    </div>
                                    <div class="col-8 d-flex align-items-center w-100">
                                        <div class="row w-100">
                                            <div class="col-md-8 text-capitalize">
                                                <div>
                                                    {{ $detail['line_item']->title }}
                                                </div>
                                                <div class="text-black-50">
                                                    {{ $detail['line_item']->variant_title }}
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                @if($detail['supplier'] != '')
                                                    <div>
                                                        <div class="badge badge-primary">{{ $detail['supplier']  }}</div>
                                                        {{--                                                        &nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-truck"></i></a>--}}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3  d-flex align-items-center">
                                        {{ number_format($detail['line_item']->price, 2) . ' ' . $order['order']->currency  }}
                                        <div class="text-black-50">&nbsp;&nbsp;&nbsp; x &nbsp;&nbsp;&nbsp;</div> {{  $detail['line_item']->quantity }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="align-items-end">{{ number_format(($detail['line_item']->quantity * $detail['line_item']->price) , 2) . ' ' . $order['order']->currency   }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-black-50 mt-2">No order found.</div>
            @endif
        @endif

    </div>
@endsection
