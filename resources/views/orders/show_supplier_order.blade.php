@extends('layouts.new_theme')

@section('title', 'View Order')

@section('content')

    <div class="">

        <div class="row">
            <div class="col-md-12">
                <div class="p-1 text-justify">
                    <b style="font-size: 28px;">{{ $order_with_details[0]['order']->name }} </b> {{ \Carbon\Carbon::parse($order_with_details[0]['order']->shopify_created_at)->format('M d, Y') .' at '. \Carbon\Carbon::parse($order_with_details[0]['order']->shopify_created_at)->format('h:i a')  }}
                    <div class="badge badge-info text-capitalize ml-3" style="font-size: 14px">
                        {{ $order_with_details[0]['order']->financial_status }}
                    </div>

                    @if($order_with_details[0]['order']->fulfillment_status == 'partial')
                        <div class="badge badge-warning text-capitalize" style="font-size: 14px">
                            Partially fulfilled
                        </div>
                    @elseif($order_with_details[0]['order']->fulfillment_status == null)
                        <div class="badge badge-secondary text-capitalize" style="font-size: 14px">
                            Not fulfilled
                        </div>
                    @else
                        <div class="badge badge-success text-capitalize" style="font-size: 14px">
                            {{ $order_with_details[0]['order']->fulfillment_status }}
                        </div>
                    @endif

                    <div class=" mt-3 badge badge-success" style="font-size: 14px">
                        {{ $order_with_details[0]['retailer'] }}
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Unfulfilled items section -->
                @if($order_with_details['unfulfilledItemsCount'] > 0)
                    <div class="bg-white p-1">
                        <h4 class="font-weight-bold  py-2">Unfulfilled ({{ $order_with_details['unfulfilledItemsCount'] }})</h4>

                        @foreach($order_with_details[0]['order_details'] as $item)
                            @if(($item['line_item']->quantity - $item['line_item']->fulfillable_quantity) >= 0)
                                @if($item['line_item']->fulfillable_quantity != 0)
                                    <div class="row">
                                        <div class="col-md-1 py-2 text-center">
                                            <img src="{{ $item['variant_image'] }}" alt="{{ $item['line_item']->name }}" height="80px" width="80px">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center w-100">
                                            <div class="row w-100">
                                                <div class="col-md-9">
                                                    <div class="pl-3" style="font-size: 17px;">
                                                        {{ $item['line_item']->title }}
                                                    </div>
                                                    <div class="pl-3 text-black-50">
                                                        {{ $item['line_item']->variant_title }}
                                                    </div>
                                                    <div class="pl-3 text-black-50">
                                                        {{ $item['line_item']->sku }}
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    @if($item['deleted_product'])
                                                        <div class="badge badge-danger">
                                                            Deleted
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 d-flex align-items-center w-100">
                                            <div class="row d-flex align-items-center justify-content-center w-100">
                                                <div class="pl-3 col-md-6 text-right p-0" style="font-size: 18px;">
                                                    <div>
                                                        @if( $order_with_details[0]['order']->currency == 'USD')
                                                            ${{ $item['line_item']->price }} <a class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> {{ $item['line_item']->fulfillable_quantity  }}
                                                        @else
                                                            {{ $order_with_details[0]['order']->currency .' '. $item['line_item']->price }} <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> {{ $item['line_item']->fulfillable_quantity  }}
                                                        @endif

                                                    </div>

                                                </div>
                                                <div class="col-md-6 text-right" style="font-size: 18px;">
                                                    @if( $order_with_details[0]['order']->currency == 'USD')
                                                        ${{ number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2) }}
                                                    @else
                                                        {{ $order_with_details[0]['order']->currency .' '. number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2) }}
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                @endif
                            @endif
                        @endforeach
                        <div class="bg-white py-2">
                            <a href="javascript:void(0);" class="btn btn-primary ">Mark as fulfilled</a>
                        </div>
                    </div>
                @endif


            <!-- Fulfilled items section -->
                @foreach($order_with_details[0]['fulfillments'] as $fulfillment)
                    <div class="text-justify bg-white
                    @if($order_with_details['unfulfilledItemsCount'] > 0) mt-3 @endif
                        p-3">
                        <div style="font-size: 18px ">
                            <strong>Fulfilled ({{ $fulfillment['fulfillment_item_count']  }}) </strong>{{ $fulfillment['fulfillment_name']  }}
                        </div>
                        @foreach($fulfillment['fulfilled_items'] as $item)
                            <div class="row">
                                <div class="col-md-1 py-2 text-center">
                                    <img src="{{ $item['variant_image'] }}" alt="{{ $item['line_item']->name }}" height="80px" width="80px">
                                </div>
                                <div class="col-md-6 d-flex align-items-center w-100">
                                    <div class="row w-100">
                                        <div class="col-md-8">
                                            <div class="pl-3" style="font-size: 18px;">
                                                {{ $item['line_item']->title }}
                                            </div>
                                            <div class="pl-3 text-black-50">
                                                {{ $item['line_item']->variant_title }}
                                            </div>
                                            <div class="pl-3 text-black-50">
                                                {{ $item['line_item']->sku }}
                                            </div>
                                        </div>
                                        {{--                                        @if($item['supplier'] != '' || $item['supplier'] != null )--}}
                                        {{--                                            <div class="col-md-4">--}}
                                        {{--                                                <div class="badge badge-info">--}}
                                        {{--                                                    {{ $item['supplier'] }}--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                        @endif--}}
                                    </div>
                                </div>
                                <div class="col-md-5 d-flex align-items-center w-100">
                                    <div class="row d-flex align-items-center justify-content-center w-100">
                                        <div class="col-md-6 text-right" style="font-size: 18px;">
                                            <div>
                                                {{ $order_with_details[0]['order']->currency .' '. $item['fulfilled_price'] }} <a class="text-black-50"> X </a> {{ $item['fulfilled_quantity'] }}
                                            </div>

                                        </div>
                                        <div class="col-md-6 text-right" style="font-size: 18px;">
                                            {{ $order_with_details[0]['order']->currency .' '. number_format($item['fulfilled_price'] *  $item['fulfilled_quantity'],2) }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <div class="bg-white py-2">
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#editTrackingModal{{ $item['line_item_id'] }}" class="btn btn-primary">Add tracking</a>
                            <!-- The Modal -->
                            <div class="modal fade" id="editTrackingModal{{$item['line_item_id'] }}">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Tracking</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">

                                            <div class="row" hidden id="custom_carrier">
                                                <div class="col-md-6">
                                                    <label for="">Tracking number</label>
                                                    <input type="text" placeholder="Enter tracking number" name="custom_tracking_number" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Tracking URL</label>
                                                    <input type="text" placeholder="Enter tracking number" name="custom_tracking_url" class="form-control">
                                                    <span class="text-black-50">Enter tracking page link for this custom carrier</span>
                                                </div>
                                            </div>

                                            <div class="form-group" id="default_carrier">
                                                <label for="">Tracking number</label>
                                                <input type="text" placeholder="Enter tracking number" name="tracking_number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Carrier</label>
                                                <select name="carrier" id="carrier_dropdown" class="form-control">
                                                    <option value="none">None</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <a href="javascript:void(0);" class="btn btn-primary">Save</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="ml-2 btn btn-secondary">Cancel fulfillment</a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>


    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/project_custom.js') }}"></script>
@endsection
