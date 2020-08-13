@extends('layouts.ecommerce')

@section('title', 'Orders')

@section('content')

    <div class="mt-2">

        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Orders</h4>
                    <div class="float-right">
                        @role('retailer')
                        <a class="btn btn-primary" href="{{ route('retailer.orders.all.sync') }}">Sync Orders</a>
                        @endrole
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        @if(count($order_with_details) > 0)
            @if($noOfOrdersIncludesProductImportedFromOurSite != 0)
                @foreach($order_with_details as $order)
                    @if(count($order['order_details']) > 0)
                        <div class="my-1 p-1 bg-white border">
                            <div class="text-black-50">
                                Order <a href="#">{{ $order['order']->name }}</a> {{ Carbon\Carbon::parse($order['order']->shopify_created_at)->format('Y M d') }}

                            <!--     financial status     -->
                                @if($order['order']->financial_status != 'paid')
                                    <div class="badge badge-warning text-capitalize ml-1" style="font-size: 14px">
                                        {{ $order['order']->financial_status }}
                                    </div>
                                @elseif($order['order']->financial_status == null)
                                    <div class="badge badge-secondary text-capitalize ml-1" style="font-size: 14px">
                                        Not paid
                                    </div>
                                @else
                                    <div class="badge badge-success text-capitalize ml-1" style="font-size: 14px">
                                        {{ $order['order']->financial_status }}
                                    </div>
                                @endif

                            <!--     fulfillment status     -->
                                @if($order['order']->fulfillment_status == 'partial')
                                    <div class="badge badge-warning text-capitalize" style="font-size: 14px">
                                        Partially fulfilled
                                    </div>
                                @elseif($order['order']->fulfillment_status == null)
                                    <div class="badge badge-secondary text-capitalize" style="font-size: 14px">
                                        Not fulfilled
                                    </div>
                                @else
                                    <div class="badge badge-success text-capitalize" style="font-size: 14px">
                                        {{ $order['order']->fulfillment_status }}
                                    </div>
                                @endif

                                <div class=""><a data-toggle="modal" data-target="#sendOrderToSuppliersModal{{$order['order']->id}}" class="btn-sm btn-primary text-white">Send to supplier</a></div>
                                <div class="float-right"><a data-toggle="modal" data-target="#fulfillOrderModal{{$order['order']->id}}" class="btn-sm btn-primary text-white">Fulfill Order</a></div>
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
                                                <h4 class="modal-title">Send order to the supplier of products in this order</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                              <div class="form-group">
                                                  <label for="">Note:    <span><small>optional</small></span></label>

                                                  <textarea class="form-control" ></textarea>
                                              </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <a href class="btn btn-primary">Send</a>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            @foreach($order['order_details'] as  $detail)
                                <div class="row">
                                    <div class="col-2 text-center">
                                        <img class="my-1" src="{{ $detail['variant_image'] }}" alt="{{ $detail['line_item']->name }}" height="50px" width="50px">
                                    </div>
                                    <div class="col-6 d-flex align-items-center w-100">
                                        <div class="row w-100">
                                            <div class="col-md-8 text-capitalize">
                                                <div>
                                                    {{ $detail['line_item']->title }}
                                                </div>
                                                <div class="text-black-50">
                                                    {{ $detail['line_item']->variant_title }}
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                @if($detail['supplier'] != '')

                                                    <div class="">
                                                        {{--                                            Supplied By:--}}
                                                        <div class="badge badge-primary">{{ $detail['supplier']  }}</div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4  d-flex align-items-center">
                                        {{ $detail['line_item']->price . ' ' . $order['order']->currency  }}
                                        <div class="text-black-50">&nbsp;&nbsp;&nbsp; x &nbsp;&nbsp;&nbsp;</div> {{  $detail['line_item']->quantity }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="align-items-end">{{ number_format(($detail['line_item']->quantity * $detail['line_item']->price) , 2) . ' ' . $order['order']->currency   }}</div>
                                    </div>
                                </div>
                                {{--                    <div class="dropdown-divider"></div>--}}
                            @endforeach
                            {{--                <div class="row">--}}
                            {{--                    <div class="col-10"></div>--}}
                            {{--                    <div class="col-2 d-flex align-items-center  w-100">--}}
                            {{--                        <div class="dropdown-divider"></div>--}}
                            {{--                        <div class="my-3 text-right">--}}
                            {{--                            Tax: {{ $order['order']->total_tax .' '. $order['order']->currency  }}--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}
                            {{--                </div>--}}
                            {{--                <div class="row">--}}
                            {{--                    <div class="col-10"></div>--}}
                            {{--                    <div class="col-2 d-flex align-items-center float-right w-100">--}}
                            {{--                        <div class="dropdown-divider"></div>--}}
                            {{--                        <div class="font-weight-bold text">--}}
                            {{--                            Total: {{ $order['order']->total_price .' '. $order['order']->currency  }}--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}
                            {{--                </div>--}}
                        </div>
                    @endif
                @endforeach
            @else
                <div class="text-black-50 mt-2">No order found.</div>
            @endif
        @else
            <div class="text-black-50 mt-2">No order found.</div>
        @endif


    </div>
@endsection
