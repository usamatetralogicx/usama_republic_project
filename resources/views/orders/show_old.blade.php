@extends('layouts.ecommerce')

@section('title', 'View Order')

@section('css')
    <style>

        .tracking-detail {
            padding:3rem 0
        }
        #tracking {
            margin-bottom:1rem
        }
        [class*=tracking-status-] p {
            margin:0;
            font-size:1.1rem;
            color:#fff;
            text-transform:uppercase;
            text-align:center
        }
        [class*=tracking-status-] {
            padding:1.6rem 0
        }
        .tracking-status-intransit {
            background-color:#65aee0
        }
        .tracking-status-outfordelivery {
            background-color:#f5a551
        }
        .tracking-status-deliveryoffice {
            background-color:#f7dc6f
        }
        .tracking-status-delivered {
            background-color:#4cbb87
        }
        .tracking-status-attemptfail {
            background-color:#b789c7
        }
        .tracking-status-error,.tracking-status-exception {
            background-color:#d26759
        }
        .tracking-status-expired {
            background-color:#616e7d
        }
        .tracking-status-pending {
            background-color:#ccc
        }
        .tracking-status-inforeceived {
            background-color:#214977
        }
        .tracking-list {
            border:1px solid #e5e5e5
        }
        .tracking-item {
            border-left:1px solid #e5e5e5;
            position:relative;
            padding:2rem 1.5rem .5rem 2.5rem;
            font-size:.9rem;
            margin-left:3rem;
            min-height:5rem
        }
        .tracking-item:last-child {
            padding-bottom:4rem
        }
        .tracking-item .tracking-date {
            margin-bottom:.5rem
        }
        .tracking-item .tracking-date span {
            color:#888;
            font-size:85%;
            padding-left:.4rem
        }
        .tracking-item .tracking-content {
            padding:.5rem .8rem;
            background-color:#f4f4f4;
            border-radius:.5rem
        }
        .tracking-item .tracking-content span {
            display:block;
            color:#888;
            font-size:85%
        }
        .tracking-item .tracking-icon {
            /*line-height:2.6rem;*/
            position:absolute;
            left:-1.3rem;
            width:2.6rem;
            height:2.6rem;
            text-align:center;
            border-radius:50%;
            font-size:1.1rem;
            background-color:#fff;
            color:#fff
        }
        .tracking-item .tracking-icon.status-sponsored {
            background-color:#f68
        }
        .tracking-item .tracking-icon.status-delivered {
            background-color:#4cbb87
        }
        .tracking-item .tracking-icon.status-outfordelivery {
            background-color:#f5a551
        }
        .tracking-item .tracking-icon.status-deliveryoffice {
            background-color:#f7dc6f
        }
        .tracking-item .tracking-icon.status-attemptfail {
            background-color:#b789c7
        }
        .tracking-item .tracking-icon.status-exception {
            background-color:#d26759
        }
        .tracking-item .tracking-icon.status-inforeceived {
            background-color:#214977
        }
        .tracking-item .tracking-icon.status-intransit {
            color:#e5e5e5;
            border:1px solid #e5e5e5;
            font-size:.6rem
        }
        @media(min-width:992px) {
            .tracking-item {
                margin-left:10rem
            }
            .tracking-item .tracking-date {
                position:absolute;
                left:-10rem;
                width:7.5rem;
                text-align:right
            }
            .tracking-item .tracking-date span {
                display:block
            }
            .tracking-item .tracking-content {
                padding:0;
                background-color:transparent
            }
        }
    </style>
@endsection

@section('content')

    @php $payable_amount = 0; $supplier_array = [];$total_shipping= 0; @endphp

    <div class="row">
        <div class="col-md-8">
            <div class="py-1 text-justify">
                <b style="font-size: 28px;">{{ $order_with_details[0]['order']->name }} </b> {{ \Carbon\Carbon::parse($order_with_details[0]['order']->shopify_created_at)->format('M d, Y') .' at '. \Carbon\Carbon::parse($order_with_details[0]['order']->shopify_created_at)->format('h:i a')  }}
                <div class="badge badge-primary text-capitalize ml-2">
                    {{ $order_with_details[0]['order']->financial_status }}
                </div>

                @if($order_with_details[0]['order']->fulfillment_status == 'partial')
                    <div class="badge badge-secondary text-capitalize">
                        Partially fulfilled
                    </div>
                @elseif($order_with_details[0]['order']->fulfillment_status == null)
                    <div class="badge badge-warning text-capitalize">
                        Not fulfilled
                    </div>
                @else
                    <div class="badge badge-success text-capitalize">
                        {{ $order_with_details[0]['order']->fulfillment_status }}
                    </div>
                @endif

            </div>
        </div>
        <div class="col-md-4 text-right d-block align-self-center">
            @if($order_with_details[0]['order']->send_to_supplier == 1)
                <div class="badge badge-success text-capitalize">
                    Ordered
                </div>
            @elseif($order_with_details[0]['order']->send_to_supplier == 0)
                <div class='text-muted'>Not assigned to supplier</div>
            @else
                <div class="badge badge-secondary text-capitalize">
                    Completed
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <!-- Unfulfilled items section -->
            @if($order_with_details['unfulfilledItemsCount'] > 0)
                <div class="pt-1 bg-white">
                    <h4 class="ml-1 font-weight-bold">Total Items ({{ $order_with_details['unfulfilledItemsCount'] }})</h4>

                    @foreach($order_with_details[0]['order_details'] as $item)
                        @if(($item['line_item']->quantity - $item['line_item']->fulfillable_quantity) >= 0)
                            @if($item['line_item']->fulfillable_quantity != 0)
                                <div class="ml-1 row">
                                    <div class="col-md-1 py-1 text-center">
                                        <img src="{{ $item['variant_image'] }}" alt="{{ $item['line_item']->name }}" height="60px" width="60px">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center w-100">
                                        <div class="row w-100">
                                            <div class="col-md-8">
                                                <div class="pl-2">
                                                    {{ $item['line_item']->title }}
                                                </div>
                                                <div class="pl-2 text-black-50">
                                                    {{ $item['line_item']->variant_title }}
                                                </div>
                                                <div class="pl-2 text-black-50">
                                                    {{ $item['line_item']->sku }}
                                                </div>
                                            </div>
                                            @if($item['supplier'] != '' || $item['supplier'] != null )
                                                <?php
                                                if (!in_array($item['supplier'], $supplier_array)) {
                                                    array_push($supplier_array, $item['supplier']);
                                                }
                                                ?>
                                                <div class="col-md-4">
                                                    @if(isset($item['supplier']))
                                                        <div class="badge badge-primary">
                                                            {{ $item['supplier'] }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-5 d-flex align-items-center w-100">
                                        <div class="row d-flex align-items-center justify-content-center w-100">
                                            <div class="pl-3 col-md-6 text-right p-0">
                                                <div>
                                                    @if( $order_with_details[0]['order']->currency == 'USD')
                                                        @if($item['line_item']->linked_retailer_product_variant != null)
                                                            ${{ number_format($item['line_item']->linked_retailer_product_variant->cost, 2) }} <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> {{ $item['line_item']->fulfillable_quantity  }}
                                                        @else
                                                            ${{ number_format($item['line_item']->price, 2) }} <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> {{ $item['line_item']->fulfillable_quantity  }}
                                                        @endif
                                                    @endif
                                                    @else
                                                        @if($item['line_item']->linked_retailer_product_variant != null)
                                                            {{ $order_with_details[0]['order']->currency .' '. $item['line_item']->linked_retailer_product_variant->cost }} <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> {{ $item['line_item']->fulfillable_quantity  }}
                                                        @else
                                                                ${{ number_format($item['line_item']->price, 2) }} <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> {{ $item['line_item']->fulfillable_quantity  }}
                                                        @endif
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-md-6 text-right">
                                                @php
                                                    if($item['line_item']->linked_retailer_product_variant != null){
    $payable_amount = $payable_amount + ($item['line_item']->linked_retailer_product_variant->cost * $item['line_item']->fulfillable_quantity);
}
else{

}  $payable_amount = $payable_amount + ($item['line_item']->price * $item['line_item']->fulfillable_quantity);
                                                @endphp
                                                @if( $order_with_details[0]['order']->currency == 'USD')
                                                    @if($item['line_item']->linked_retailer_product_variant != null)
                                                    ${{ number_format($item['line_item']->linked_retailer_product_variant->cost * $item['line_item']->fulfillable_quantity, 2) }}
                                                    @else
                                                        ${{ number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2) }}
                                                    @endif
                                                @else
                                                    @if($item['line_item']->linked_retailer_product_variant != null)
                                                    {{ $order_with_details[0]['order']->currency .' '. number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2) }}
                                                    @else
                                                        ${{ number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2) }}
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            @endif

                    @endforeach
                </div>
                <div>
                    @if($order_with_details[0]['order']->send_to_supplier != 1)
                        <a data-toggle="modal" data-target="#makePaymentModal" class="btn btn-primary text-white">Make Payment</a>
                        <!-- The Modal -->
                        <div class="modal" id="makePaymentModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Select Payment Method</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <form action="{{ route('payment', $order_with_details[0]['order']->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            @if(count(\Illuminate\Support\Facades\Auth::user()->payment_method) > 0)
                                                <label for="">Select your payment method</label>
                                                <select name="payment_method" id="" class="form-control" required>
                                                    <option value="">Select Payment Method</option>
                                                    @foreach(\Illuminate\Support\Facades\Auth::user()->payment_method as $method)
                                                    <option value="{{ $method->id }}">
                                                        @if($method->brand == 'Visa')
                                                            <i class="fa fa-cc-visa"></i>
                                                        @elseif($method->brand == 'MasterCard')
                                                            <i class="fa fa-cc-mastercard"></i>
                                                        @else
                                                            <i class="fa fa-credit-card"></i>
                                                        @endif
                                                        &nbsp;&nbsp; **** **** **** {{ $method->last4 }}
                                                    </option>
                                                        @endforeach
                                                </select>
                                                <?php
                                                foreach ($supplier_array as $supplier) {
                                                    $total_shipping = $total_shipping + \App\User::whereName($supplier)->first()->supplier_setting->shipping_price;
                                                }
                                                ?>
                                                <label class=" mt-1">Your payable amount (includes shipping)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" class="form-control" readonly value="{{ number_format(($payable_amount + $total_shipping), 2)  }}" name="payable_amount">
                                                </div>
                                            @else
                                                <div><strong>Your do not have payment method setup</strong></div>
                                                <div><strong> <a href="{{ route('settings') }}">Click Here</a> to add you payment method</strong></div>

                                            @endif
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            @if(\Illuminate\Support\Facades\Auth::user()->payment_method != null)
                                                <button type="submit" class="btn btn-primary">Confirm Payment</button>
                                            @else
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif


        <!-- Fulfilled items section -->
            @if(count($order_with_details[0]['order']->supplier_orders) > 0)
                <h3 class="mt-2">Fulfillments History</h3>
            @endif

            @foreach($order_with_details[0]['order']->supplier_orders as $supplier_order)
                @if(isset($supplier_order) && count($supplier_order->fulfillments) > 0)
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="text-justify">
                                @foreach($supplier_order->fulfillments as $fulfillment)
                                    <div class="bg-white mt-1 p-1">
                                        <div class="font-weight-bolder d-inline">
                                            {{ strtok($fulfillment->name, '.')  . ' - F'. explode('.', $fulfillment->name, 2)[1]  }}

                                        </div>
                                        <span class="text-primary  text-capitalize">&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp; {{ \App\User::find($fulfillment->supplier_id)->name }}  </span>
                                        <span class="text-primary  pull-right">&nbsp;&nbsp; {{ date_create($fulfillment->created_at)->format('Y-m-d h:i a') }}  </span>
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
                                                        <div class="col-md-8">
                                                            <div class="pl-3">
                                                                {{ $item['title'] }}
                                                            </div>
                                                            <div class="pl-3 text-black-50">
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
                                                        @if($fulfillment->tracking_number != null)
                                                            <div class="col-md-12 text-right">
                                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#editTrackingModal{{ $fulfillment->id }}"
                                                                   target="_blank">  {{ $fulfillment->tracking_number }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @role('supplier')
                                    @if($fulfillment->tracking_number == null || $fulfillment->tracking_number == '')
                                        <div class="bg-white py-2 px-1">
                                            <a data-toggle="modal" data-target="#editTrackingModal{{ $fulfillment->id }}" class="btn btn-primary text-white">Add tracking</a>
                                        </div>
                                    @endif
                                    @endrole
                                    <div class="modal fade" id="editTrackingModal{{ $fulfillment->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    @role('supplier')
                                                    <h4 class="modal-title">Edit Tracking</h4>
                                                    @endrole
                                                    @role('retailer')
                                                    <h4 class="modal-title">Tracking Details</h4>
                                                    @endrole
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form action="{{ route('supplier.add.fulfillment.tracking', $fulfillment->id) }}" method="POST">
                                                @csrf
                                                <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="form-group" id="default_carrier">
                                                            <label for="">Tracking number</label>
                                                            <input type="text" @role('retailer') readonly @endrole placeholder="Enter tracking number" value="{{$fulfillment->tracking_number}}"
                                                            name="tracking_number"
                                                            class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Tracking URL</label>
                                                            <input name="tracking_url" @role('retailer') readonly @endrole placeholder="Enter tracking URL" value="{{$fulfillment->tracking_url}}"
                                                            class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Notes</label>
                                                            <textarea name="tracking_notes" @role('retailer') readonly @endrole class="form-control" placeholder="Enter tracking notes"
                                                            rows="10">{{$fulfillment->tracking_notes}}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                        @role('supplier')
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        @endrole
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
            @endforeach


        <!-- Payment History section -->
            @if(count($order_with_details[0]['order']->transactions) > 0)
                <h3 class="mt-2">Payment History</h3>
            @endif

            @foreach($order_with_details[0]['order']->transactions as $transaction)
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div id="tracking">
                            <div class="tracking-list bg-white">
                                <div class="tracking-item">
                                    <div class="tracking-icon status-intransit">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                        </svg>
                                        <!-- <i class="fas fa-circle"></i> -->
                                    </div>
                                    <div class="tracking-date">{{ \Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString() }}
                                        <span>{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i A') }}</span>
                                    </div>
                                    <div class="tracking-content">${{ $transaction->transaction_amount }}
                                        <span style="overflow: hidden;">
                                    		<a href="{{ $transaction->receipt_url }}" target="_blank">View receipt</a>
                                    		{{-- USD --}}
                                    	</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="col-md-3 text-justify">

            <!--Notes section -->
            <div class="bg-white p-1">
                <h4>Notes</h4>
                @if($order_with_details[0]['order']->note == null)
                    <p class="text-black-50">No notes from customer</p>
                @else
                    <p>{{ $order_with_details[0]['order']->note }}</p>
                @endif

            </div>
            <!--Customers section -->
            @php
                $customer = json_decode($order_with_details[0]['order']->customer, true);
                $customer_shipping_address = json_decode($order_with_details[0]['order']->shipping_address, true);
                $customer_billing_address = json_decode($order_with_details[0]['order']->billing_address, true);
            @endphp
            <div class="mt-1 p-1 bg-white">
                <h4 class="">Customer</h4>
                @if($customer == null)
                    <a class="text-black-50">No customer</a>
                @else
                    <div>
                        <a>{{$customer['first_name'] .' '. $customer['last_name']}}</a>
                    </div>
                    <div>
                        @if($customer['orders_count'] == 1)
                            <a>{{$customer['orders_count'] .' order'}}</a>
                        @else
                            <a>{{$customer['orders_count'] .' orders'}}</a>
                        @endif
                    </div>
                @endif

                <div class="dropdown-divider"></div>
                <h6 class="text-capitalize">Customer Information</h6>
                <div class="">
                    @if($order_with_details[0]['order']->email == null)
                        <a class="text-black-50">No email address</a>
                    @else
                        <a>{{$order_with_details[0]['order']->email}}</a>
                    @endif
                </div>
                <div class="">
                    @if($order_with_details[0]['order']->phone == null)
                        <a class="text-black-50">No phone number</a>
                    @else
                        <a>{{$order_with_details[0]['order']->phone}}</a>
                    @endif
                </div>
                <div class="dropdown-divider"></div>
                <h6 class="text-capitalize">Shipping Address</h6>
                <div>
                    @if($order_with_details[0]['order']->shipping_address == null)
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
                <div class="dropdown-divider"></div>
                <h6 class="text-capitalize">Billing Address</h6>
                <div>
                    @if($order_with_details[0]['order']->billing_address == null)
                        <a class="text-black-50">No billing address</a>
                    @elseif($customer_billing_address == $customer_shipping_address)
                        <a class="text-black-50">Same as shipping address</a>
                    @else
                        <div>
                            <a>{{$customer_billing_address['name'] }}</a>
                        </div>
                        <div>
                            <a>{{$customer_billing_address['address1'] }}</a>
                        </div>
                        <div>
                            <a>{{$customer_billing_address['city']. ' ' . $customer_billing_address['zip'] }}</a>
                        </div>
                        <div>
                            <a>{{$customer_billing_address['country'] }}</a>
                        </div>
                        <div>
                            <a>{{$customer_billing_address['phone'] }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
