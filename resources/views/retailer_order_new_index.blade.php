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
    <div hidden id="page-type">my products</div>


    <div class="content-body">
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Orders</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <!-- dataTable starts -->
        <section id="data-thumb-view" class="data-thumb-view-header">
            <div class="table-responsive">
                <table id="dt-product" class="table data-thumb-view p-0">
                    <thead>
                    <th class="pl-1">ORDER</th>
                    <th>FULFILLMENT</th>
                    <th>SUPPLIER</th>
                    <th>TOTAL (incl. Tax)</th>
                    <th>CREATED</th>
                    <th class="text-right" width="15%">ACTION</th>
                    </thead>
                    <tbody>
                    @if(count($orders) > 0)
                        @foreach($orders as $order)
                            <tr>
                                <td class="py-2">
                                    @if($order->retailer_order != null)
                                        {{ $order->retailer_order->name }}
                                    @endif
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
                                    {{ $order->supplier->name }}
                                </td>
                                <td>${{ $order->retailer_order->total_price_usd }}</td>
                                <td>
                                    @if(Carbon\Carbon::parse($order->created_at)->isToday())
                                        {{ Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                    @else
                                        {{ Carbon\Carbon::parse($order->created_at)->isoFormat('MMM Do YYYY, h:mm a') }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a class="text-primary" href="{{ route('admin.orders.with.details', $order->id) }}"><i class="fa fa-eye" style="font-size: 18px"></i></a>
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
