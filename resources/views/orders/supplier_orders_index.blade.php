@extends('layouts.new_theme')

@section('title', 'Supplier Orders')

@section('content')

    <div class="row mt-2 p-1">
        <div class="col-xl-12">
            <div class="page-title-box">
                <h4 class="page-title float-left">Your Orders</h4>
                <div class="float-right mt-3 mb-2 ">
                    {{--                            <a class="btn btn-success" href="{{ route('retailer.orders.all.sync') }}">Sync Orders</a>--}}
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

   <div class="p-1 bg-white">
       <table class="table table-bordered table-responsive-md ">
           <thead>
           <th>Order</th>
           <th>Date</th>
           <th>Retailer</th>
           <th>Payment</th>
           <th>Fulfillment</th>
           <th>Action</th>
           </thead>
           <tbody>
           @if(count($orders_array) > 0)
               @foreach($orders_array as $order)
                   <tr>
                       <td>{{ $order['order']->name }}</td>
                       <td>
                           @if(Carbon\Carbon::parse($order['order']->shopify_created_at)->isToday())
                               {{ Carbon\Carbon::parse($order['order']->shopify_created_at)->diffForHumans() }}
                           @else
                               {{ Carbon\Carbon::parse($order['order']->shopify_created_at)->isoFormat('MMM Do YYYY, h:mm a') }}
                           @endif
                       </td>
                       <td>
                           <div>{{  $order['retailer'] }}</div>
                       </td>
                       <td>
                           @if($order['order']->financial_status == 'paid')
                               <div class="badge badge-pill badge-info">{{ $order['order']->financial_status }}</div>
                           @elseif($order['order']->financial_status == 'pending')
                               <div class="badge badge-pill badge-warning">{{ $order['order']->financial_status }}</div>
                           @else
                               <div class="badge badge-pill badge-secondary">{{ $order['order']->financial_status }}</div>
                           @endif
                       </td>
                       <td>
                           @if($order['order']->fulfillment_status == null)
                               <div class="badge badge-danger">Not fulfilled</div>
                           @elseif($order['order']->fulfillment_status == 'partial')
                               <div class="badge badge-warning">Partially fulfilled</div>
                           @else
                               <div class="badge badge-secondary">{{ $order['order']->fulfillment_status }}</div>
                           @endif
                       </td>
                       {{--                            <td>${{ $order['order']->total_price_usd }}</td>--}}
                       <td class="text-center">
                           <a style="color: black" href="{{ route('supplier.order', $order['order']->id) }}"><i class="fa fa-eye"></i></a>

                       </td>
                   </tr>
               @endforeach
           @else
               <tr>
                   <td colspan="7" class="text-center"><strong>No order found.</strong></td>
               </tr>
           @endif
           </tbody>
       </table>
   </div>


@endsection
