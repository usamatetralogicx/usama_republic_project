@extends('layouts.ecommerce')

@section('title', 'Order Details')

@section('content')

    <div class="mt-2">

        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box">
                    @if(isset($supplier_orders[0]))
                        <h4 class="page-title float-left">Order <a href="#">{{ $supplier_orders[0]->retailer_order->name }}</a></h4>
                    @else
                        <h4 class="page-title float-left">Order</h4>
                    @endif
                    <div class="float-right"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        @if(count($supplier_orders) > 0)
            <div class="row mt-2">
                <div class="col-sm-12 col-md-9 ">
                    <form id="fulfill-form" action="{{ url('supplier/fulfillment/fulfill', $supplier_orders[0]->retailer_order->id) }}" method="POST">
                        @csrf

                        @foreach($supplier_orders as $order)
                            <div class="bg-white p-2">
                                <div class="text-black-50">
                                    <span class="" style="font-size: 12px;">
                                   {{ Carbon\Carbon::parse($order->retailer_order->shopify_created_at)->format('Y M d') }}
                            </span>
                                    <span class="ml-2" style="font-size: 12px;">
                                        Status:
                                        <span>
                                            @if($order->fulfillment_status == 'pending' || $order->fulfillment_status == '' || $order->fulfillment_status == null)
                                                <div class="badge badge-warning text-capitalize " style="font-size: 10px">
                                                  {{ $order->fulfillment_status ? $order->fulfillment_status : 'pending' }}
                                                </div>
                                            @else
                                                <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                   {{ $order->fulfillment_status ? $order->fulfillment_status : 'fulfilled' }}
                                                </div>
                                            @endif
                                        </span>
                                    </span>
                                    <span class="ml-2" style="font-size: 12px;">
                                        Retailer:
                                        <span>
                                            @if($order->retailer_order->retailer != null)
                                                <div class="badge badge-light-primary text-capitalize " style="font-size: 12px">
                                                    {{ $order->retailer_order->retailer->name }}
                                                </div>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                                @foreach($order->hasLineItems as $line_item)
                                    <div class="dropdown-divider"></div>
                                    @if($line_item->fulfillable_quantity > 0)
                                        <div class="my-2">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-1 text-center">

                                                    @if($line_item->retailer_product_variant->src != null)
                                                        <img src="{{  $line_item->retailer_product_variant->retailer_product->image }}" alt="{{ $line_item->retailer_product_variant->name }}"
                                                             height="50px" width="50px">
                                                    @else
                                                        <img src="{{  $line_item->retailer_product_variant->src }}" alt="{{ $line_item->retailer_product_variant->name }}" height="50px" width="50px">
                                                    @endif
                                                </div>
                                                <div class="col-sm-12 col-md-7 d-flex align-items-center w-100">
                                                    <div class="row w-100 ml-2">
                                                        <div class="text-capitalize">
                                                            <div>
                                                                {{ $line_item->title }}
                                                            </div>
                                                            <div class="text-black-50">
                                                                {{ $line_item->variant_title }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 align-items-center text-right pr-2">
                                                    @role('retailer')
                                                    {{ number_format($line_item->retailer_product_variant->price, 2) . ' ' . $order->retailer_order->currency  }}
                                                    @endrole

                                                    @role('supplier')
                                                    {{ number_format(\App\ProductVariants::where('shopify_variant_id', $line_item->retailer_product_variant->local_shopify_variant_id)->first()->price, 2) . ' ' . $order->retailer_order->currency  }}
                                                    @endrole
                                                    <span class="text-black-50">&nbsp;&nbsp;&nbsp;&nbsp;x</span>
                                                    <span>
                                                      <input type="number" value="{{ $line_item->fulfillable_quantity }}" name="quantity[]" class="fulfillment-quantity mx-2 pl-1" min="0"
                                                             max="{{ $line_item->fulfillable_quantity }}">
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="my-2">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-1 text-center">
                                                    @if($line_item->retailer_product_variant->src != null)
                                                        <img src="{{  $line_item->retailer_product_variant->retailer_product->image }}"
                                                             alt="{{ $line_item->retailer_product_variant->name }}" height="50px"
                                                             width="50px">
                                                    @else
                                                        <img src="{{  $line_item->retailer_product_variant->src }}" alt="{{ $line_item->retailer_product_variant->name }}"
                                                             height="50px"
                                                             width="50px">
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 col-md-6 d-flex align-items-center w-100">
                                                    <div class="row w-100 ml-2">
                                                        <div class="text-capitalize">
                                                            <div>
                                                                {{ $line_item->title }}
                                                            </div>
                                                            <div class="text-black-50">
                                                                {{ $line_item->variant_title }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-5 align-items-center text-right pr-2">
                                                    @role('retailer')
                                                    {{ number_format($line_item->retailer_product_variant->price,2) . ' ' . $order->retailer_order->currency  }}
                                                    @endrole

                                                    @role('supplier')
                                                    {{ number_format(\App\ProductVariants::where('shopify_variant_id', $line_item->retailer_product_variant->local_shopify_variant_id)->first()->price, 2) . ' ' . $order->retailer_order->currency  }}
                                                    @endrole
                                                    <span class="text-black-50">&nbsp;&nbsp;&nbsp;&nbsp;x</span>
                                                    <span>
                                                        <input type="number" value="{{$line_item->quantity}}" name="quantity[]" class="d-none">
                                                        <span class="mx-2 pl-1">{{ $line_item->fulfilled_quantity }}</span>
                                                        <span style="font-size: 14px;" class="text-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                        @if($supplier_orders[0]->order_status == 0)
                            <button disabled type="button" id="fulfil-order-submit-btn" class="btn btn-primary mt-1 text-white">Fulfill Order</button>
                        @endif

                    </form>

                    @if(count($supplier_orders[0]->fulfillments) > 0)
                        <div class="row mt-2">
                            <div class="col-12">
                                <h3 class="pt-1">Fulfillments</h3>
                                <div class="text-justify">
                                    @foreach($supplier_orders[0]->fulfillments()->where('supplier_id', \Illuminate\Support\Facades\Auth::id())->get() as $fulfillment)
                                        <div class="bg-white mt-1 p-1">
                                            <div >
                                                <span class="font-weight-bolder"> {{ strtok($fulfillment->name, '.')  . ' - F'. explode('.', $fulfillment->name, 2)[1]  }}</span>
                                                <span class="float-right pr-1">
                                                    @if($fulfillment->tracking_number != null)
                                                        <div class="col-md-12 text-right">
                                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#editTrackingModal{{ $fulfillment->id }}"
                                                                       target="_blank">{{ $fulfillment->tracking_number }}</a>
                                                                </div>
                                                    @endif
                                               </span>
                                            </div>
                                            @foreach(json_decode($fulfillment->line_items, true) as $get_item)
                                                @php
                                                    $item = new \App\SupplierOrderLineItem();
                                                    $old_fulfillment_count = $get_item['fulfillable_quantity'] - $get_item['fulfilled_quantity'];
                                                    $item->fill($get_item);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-1 py-1 text-center">
                                                        <img src="{{ $item->retailer_product_variant->retailer_product->image }}" alt="{{ $item['title'] }}" height="50px" width="50px">
                                                    </div>
                                                    <div class="col-md-7 d-flex align-items-center w-100">
                                                        <div class="row w-100">
                                                            <div class="col-md-8 ml-2">
                                                                <div class="">
                                                                    {{ $item['title'] }}
                                                                </div>
                                                                <div class="text-black-50">
                                                                    {{ $item['variant_title'] }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-center w-100">
                                                        <div class="row d-flex align-items-center justify-content-center w-100">
                                                            <div class="col-md-12 text-right">
                                                                <div>
                                                                    Fulfilled quantity: {{ $item->fulfilled_quantity   }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($fulfillment->tracking_number == null || $fulfillment->tracking_number == '')
                                            <div class="bg-white py-2 px-1">
                                                <a data-toggle="modal" data-target="#editTrackingModal{{ $fulfillment->id }}" class="btn btn-primary text-white">Add
                                                    tracking</a>
                                            </div>
                                            {{--                                        @else--}}
                                            {{--                                            <a class="btn btn-primary">Cancel tracking</a>--}}
                                        @endif
                                        <div class="modal fade" id="editTrackingModal{{ $fulfillment->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Tracking</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form action="{{ route('supplier.add.fulfillment.tracking', $fulfillment->id) }}" method="POST">
                                                    @csrf
                                                    <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div class="form-group" id="default_carrier">
                                                                <label for="">Tracking number</label>
                                                                <input type="text" placeholder="Enter tracking number" value="{{$fulfillment->tracking_number}}" name="tracking_number"
                                                                       class="form-control">
                                                            </div>
                                                            <div hidden class="form-group">
                                                                <label for="">Carrier</label>
                                                                <select name="carrier" id="carrier_dropdown" class="form-control">
                                                                    <option value="none">None</option>
                                                                    <option value="other">Other</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Tracking URL</label>
                                                                <input name="tracking_url" placeholder="Enter tracking URL" value="{{$fulfillment->tracking_url}}" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Notes</label>
                                                                <textarea name="tracking_notes" class="form-control" placeholder="Enter tracking notes"
                                                                          rows="10">{{$fulfillment->tracking_notes}}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-sm-12 col-md-3 h-100">
                    {{--                    <div class="bg-white form-group p-2">--}}
                    {{--                        <label for="">Note</label>--}}
                    {{--                        <textarea readonly rows="8" class="form-control ">{{ $supplier_orders[0]->note }}</textarea>--}}
                    {{--                    </div>--}}
                    @php
                        $customer = json_decode($supplier_orders[0]->retailer_order->customer, true);
                        $customer_shipping_address = json_decode($supplier_orders[0]->retailer_order->shipping_address, true);
                        $customer_billing_address = json_decode($supplier_orders[0]->retailer_order->billing_address, true);
                    @endphp
                    <div class="p-2 bg-white">
                        <h4 class="">Customer</h4>
                        <h6 class="text-capitalize">Shipping Address</h6>
                        <div>
                            @if($supplier_orders[0]->retailer_order->shipping_address == null)
                                <a class="text-black-50">No shipping address</a>
                            @else
                                <div>
                                    <a>{{$customer_shipping_address['name'] }}</a>
                                </div>
                                <div>
                                    <a>{{$customer_shipping_address['address1'] }}</a>
                                </div>
                                <div>
                                    <a>{{$customer_shipping_address['city']. ' ' . $customer_shipping_address['zip'] }}</a>
                                </div>
                                <div>
                                    <a>{{$customer_shipping_address['country'] }}</a>
                                </div>
                                <div>
                                    <a>{{$customer_shipping_address['phone'] }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-black-50 mt-2">No order found.</div>
        @endif

    </div>
@endsection
