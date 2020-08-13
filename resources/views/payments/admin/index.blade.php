@extends('layouts.ecommerce')

@section('title', 'Payments')

@section('content')
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                       <span class="nav-link mr-5">
                           <span class="font-weight-bolder">Payments</span>
                       </span>
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item " style="margin-right: 10px">
                            <a class="nav-link d-flex align-items-center active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-selected="true">
                                {{--                                    <i class="feather icon-box mr-25"></i>--}}
                                <span class="d-none d-sm-block">Suppliers Payments</span>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px">
                            <a class="nav-link d-flex align-items-center" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-selected="false">
                                {{--                                    <i class="feather icon-shopping-cart mr-25"></i>--}}
                                <span class="d-none d-sm-block">Retailers Payments</span>
                            </a>
                        </li>
                        {{--                        <li class="nav-item">--}}
                        {{--                            <a class="nav-link d-flex align-items-center" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-selected="false">--}}
                        {{--                                --}}{{--                                    <i class="feather icon-dollar-sign mr-25"></i>--}}
                        {{--                                <span class="d-none d-sm-block">Payments</span>--}}
                        {{--                            </a>--}}
                        {{--                        </li>--}}
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="products" aria-labelledby="products-tab" role="tabpanel">
                            <!-- Data list view starts -->
                            <section id="data-thumb-view" class="data-thumb-view-header">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table data-thumb-view p-0">
                                            <thead>
                                            <th>Name</th>
                                            <th class="pl-1">Plan</th>
                                            <th>Status</th>
                                            <th>Price</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th></th>
                                            </thead>
                                            <tbody>
                                            @if(count($suppliers) > 0)
                                                @foreach($suppliers as $supplier)
                                                    @if(count($supplier->subscriptions) > 0)
                                                        @foreach($supplier->subscriptions as $index => $s)
                                                            <tr>
                                                                <td> <a href="{{route('admin.supplier', $supplier->id)}}">{{ $supplier->name }}</a></td>
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
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center"><strong>No Suppliers Subscription History Found.</strong></td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <!-- Data list view end -->
                        </div>

                        <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                            <!-- Data list view starts -->
                            <section id="data-thumb-view" class="data-thumb-view-header">
                                <!-- dataTable starts -->
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table data-thumb-view p-0">
                                            <thead>
                                            <th>Store</th>
                                            <th class="pl-1">Order</th>
                                            <th>Amount</th>
                                            <th>Receipt</th>
                                            <th>Transaction Date</th>
                                            <tbody>
                                            @if(count($retailers) > 0)
                                                @foreach($retailers as $retailer)
                                                @if(count($retailer->retailer_orders) > 0)
                                                    @foreach($retailer->retailer_orders as $index => $order)
                                                        @if($order->transaction != null)
                                                            <tr>
                                                                <td><a href="{{route('admin.retailer', $retailer->id)}}">{{$retailer->name}}</a></td>
                                                                <td>{{$order->transaction->order->name}}</td>
                                                                <td>
                                                                    ${{number_format($order->transaction->transaction_amount,2)}}
                                                                </td>
                                                                <td><a target="_blank" href="{{$order->transaction->receipt_url}}"> View Receipt</a></td>
                                                                <td>{{date_create($order->transaction->created_at)->format('M d Y - H:i a')}}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center"><strong>No Retailers Transaction History Found.</strong></td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </section>
                            <!-- Data list view end -->
                        </div>
                        {{--                        <div class="tab-pane" id="payments" aria-labelledby="payments-tab" role="tabpanel">--}}
                        {{--                            <!-- coming soon flat design -->--}}

                        {{--                            <div class="card">--}}
                        {{--                                <div class="card-body">--}}
                        {{--                                    <table class="table data-thumb-view p-0">--}}
                        {{--                                        <thead>--}}
                        {{--                                        <th class="pl-1">Order</th>--}}
                        {{--                                        <th>Amount</th>--}}
                        {{--                                        <th>Receipt</th>--}}
                        {{--                                        <th>Transaction Date</th>--}}
                        {{--                                        <tbody>--}}
                        {{--                                        @if(count($retailer_orders) > 0)--}}
                        {{--                                            @foreach($retailer_orders as $index => $order)--}}
                        {{--                                                @if($order->transaction != null)--}}
                        {{--                                                    <tr>--}}
                        {{--                                                        <td>{{$order->transaction->order->name}}</td>--}}
                        {{--                                                        <td>--}}
                        {{--                                                            ${{number_format($order->transaction->transaction_amount,2)}}--}}
                        {{--                                                        </td>--}}
                        {{--                                                        <td><a target="_blank" href="{{$order->transaction->receipt_url}}"> View Receipt</a></td>--}}
                        {{--                                                        <td>{{date_create($order->transaction->created_at)->format('M d Y - H:i a')}}</td>--}}
                        {{--                                                    </tr>--}}
                        {{--                                                @endif--}}
                        {{--                                            @endforeach--}}
                        {{--                                        @else--}}
                        {{--                                            <tr>--}}
                        {{--                                                <td colspan="4" class="text-center"><strong>No Transaction History Found.</strong></td>--}}
                        {{--                                            </tr>--}}
                        {{--                                        @endif--}}
                        {{--                                        </tbody>--}}
                        {{--                                    </table>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}


                        {{--                        --}}{{--                                <section>--}}
                        {{--                        --}}{{--                                    <div class="row d-flex align-items-center justify-content-center">--}}
                        {{--                        --}}{{--                                        <div class="col-xl-5 col-md-8 col-sm-10 col-12 px-md-0 px-2">--}}
                        {{--                        --}}{{--                                            <div class="card text-center w-100 mb-0">--}}
                        {{--                        --}}{{--                                                <div class="card-content">--}}
                        {{--                        --}}{{--                                                    <div class="card-body pt-0 mt-2">--}}
                        {{--                        --}}{{--                                                        <img src="{{ asset('images/pages/rocket.png') }}" class="img-responsive block width-150 mx-auto" width="150" alt="bg-img">--}}
                        {{--                        --}}{{--                                                        <div class="card-header justify-content-center pb-0">--}}
                        {{--                        --}}{{--                                                            <div class="card-title">--}}
                        {{--                        --}}{{--                                                                <h2 class="mb-0">Payments are coming soon!</h2>--}}
                        {{--                        --}}{{--                                                            </div>--}}
                        {{--                        --}}{{--                                                        </div>--}}
                        {{--                        --}}{{--                                                    </div>--}}
                        {{--                        --}}{{--                                                </div>--}}
                        {{--                        --}}{{--                                            </div>--}}
                        {{--                        --}}{{--                                        </div>--}}
                        {{--                        --}}{{--                                    </div>--}}
                        {{--                        --}}{{--                                </section>--}}
                        {{--                        <!--/ coming soon flat design -->--}}
                        {{--                        </div>--}}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
