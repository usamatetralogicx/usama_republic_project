@extends('layouts.new_theme')

@section('title', 'Dashboard')



@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('js/equalizer.js') }}"></script>

    <div class="">
        @role('admin')
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                        <p>Products</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $ordersCount }}</h2>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">0%</h2>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">$0</h2>
                        <p>Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 ">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="mb-0">Suppliers</h4>
                    </div>
                    <div class="card-content pb-2">
                        <div class="table-responsive my-1 custom-align">
                            <table class="table table-hover-animation mb-0">
                                <thead>
                                <tr>
                                    <th width="20%">NAME</th>
                                    <th>STATUS</th>
                                    <th>ORDERS</th>
                                    <th>PRODUCTS</th>
                                    <th>START DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>
                                            @if($supplier->status == 1)
                                                <i class="fa fa-circle font-small-3 text-success mr-50"></i>Active
                                            @else
                                                <i class="fa fa-circle font-small-3 text-danger mr-50"></i>Disabled
                                            @endif
                                        </td>
                                        <td class="pl-2">{{ count($supplier->supplier_orders) }}</td>
                                        <td class="pl-2">{{ count($supplier->products) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($supplier->created_at)->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a class="pl-1 pb-1 position-absolute position-bottom-0" href="{{ route('admin.suppliers') }}">See more suppliers</a>
                    </div>
                </div>
            </div>
            <div class="col-6 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Retailers</h4>
                    </div>
                    <div class="card-content  pb-2">
                        <div class="table-responsive my-1  custom-align">
                            <table class="table table-hover-animation mb-0">
                                <thead>
                                <tr>
                                    <th width="20%">NAME</th>
{{--                                    <th>STATUS</th>--}}
                                    <th>ORDERS</th>
                                    <th>PRODUCTS</th>
                                    <th>START DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($retailers as $retailer)
                                    <tr>
                                        <td>{{ $retailer->name }}</td>
{{--                                        <td>--}}
{{--                                            @if($retailer->status == 1)--}}
{{--                                                <i class="fa fa-circle font-small-3 text-success mr-50"></i>Active--}}
{{--                                            @else--}}
{{--                                                <i class="fa fa-circle font-small-3 text-danger mr-50"></i>Not Active--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                        <td class="pl-2">{{ count($retailer->retailer_orders) }}</td>
                                        <td class="pl-2">{{ count($retailer->products) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($retailer->created_at)->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a class="pl-1 pb-1 position-absolute position-bottom-0" href="{{ route('admin.retailers') }}">See more retailers</a>
                    </div>
                </div>
            </div>
        </div>
        @endrole

        @role('retailer')
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                        <p>Products</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $ordersCount }}</h2>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">${{ number_format($total_revenue,2) }}</h2>

                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">${{ number_format($total_profit, 2) }}</h2>
                        <p>Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
{{--            <div class="col-lg-6 col-md-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header d-flex justify-content-between align-items-end">--}}
{{--                        <h4 class="card-title">Revenue</h4>--}}
{{--                        <div class="dropdown">--}}
{{--                            <button class="btn-icon btn btn-round btn-sm" type="button" data-toggle="dropdown">--}}
{{--                                <i class="feather icon-settings"></i>--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"--}}
{{--                                 style="position: absolute; transform: translate3d(124px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">--}}
{{--                                <a class="dropdown-item" href="#">Today</a>--}}
{{--                                <a class="dropdown-item" href="#">This Week</a>--}}
{{--                                <a class="dropdown-item" href="#">This Month</a>--}}
{{--                                <a class="dropdown-item" href="#">Custom</a>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-content">--}}
{{--                        <div class="card-body pb-0" style="position: relative;">--}}
{{--                            <div id="chart" style="min-height: 285px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 col-md-6 col-12 row pr-0 h-100">--}}
{{--                <div class="col-sm-6 col-12 pr-0  mt-1">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">${{ number_format($current_month_revenue,2) }}</h2>--}}
{{--                            <p>This Month Revenue</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 col-12 pr-0  mt-1">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">${{ number_format($last_month_revenue,2) }}</h2>--}}
{{--                            <p>Last Month Revenue</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 col-12 pr-0 mt-2">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>--}}
{{--                            <p>Products</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 col-12 pr-0 mt-2">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>--}}
{{--                            <p>Products</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        @endrole

        @role('supplier')
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{ $productsCount }}</h2>
                        <p>Products</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-database text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">{{$storesCount }}</h2>
                        <p>Stores</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">${{ number_format($total_revenue,2) }}</h2>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">${{ number_format($total_profit,2) }}</h2>
                        <p>Total Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
{{--            <div class="col-lg-6 col-md-6 col-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header d-flex justify-content-between align-items-end">--}}
{{--                        <h4 class="card-title">Revenue</h4>--}}
{{--                        <div class="dropdown">--}}
{{--                            <button class="btn-icon btn btn-round btn-sm" type="button" data-toggle="dropdown">--}}
{{--                                <i class="feather icon-settings"></i>--}}
{{--                            </button>--}}
{{--                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"--}}
{{--                                 style="position: absolute; transform: translate3d(124px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">--}}
{{--                                <a class="dropdown-item" href="#">Today</a>--}}
{{--                                <a class="dropdown-item" href="#">This Week</a>--}}
{{--                                <a class="dropdown-item" href="#">This Month</a>--}}
{{--                                <a class="dropdown-item" href="#">Custom</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-content">--}}
{{--                        <div class="card-body pb-0" style="position: relative;">--}}
{{--                            <div id="chart" style="min-height: 285px;"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 col-md-6 col-12 row pr-0 h-100">--}}
{{--                <div class="col-sm-6 col-12 pr-0  mt-1">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">${{ number_format($current_month_revenue,2) }}</h2>--}}
{{--                            <p>This Month Revenue</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 col-12 pr-0  mt-1">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">${{ number_format($last_month_revenue,2) }}</h2>--}}
{{--                            <p>Last Month Revenue</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 col-12 pr-0 mt-2">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">${{ number_format($total_profit, 2)  }}</h2>--}}
{{--                            <p>Total Profit</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6 col-12 pr-0 mt-2">--}}
{{--                    <div class="card h-100">--}}
{{--                        <div class="card-header d-flex flex-column align-items-start pb-0 h-100">--}}
{{--                            <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                <div class="avatar-content">--}}
{{--                                    <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h2 class="text-bold-700 mt-1">${{ number_format($current_month_profit, 2) }}</h2>--}}
{{--                            <p>Current Month Profit</p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
        @endrole
    </div>

    <script>

        var options = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'orders',
                data: [0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>

@endsection

@section('scripts')

    <script>
        Equalizer('.custom-align').align();
    </script>
@endsection
