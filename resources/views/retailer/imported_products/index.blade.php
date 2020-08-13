@extends('layouts.ecommerce')

@section('title', 'My products')

@section('css')

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-list-view.css') }}">
    <!-- END: Page CSS-->

    <link href="{{ asset('dist/switchery/switchery.min.css') }}" rel="stylesheet"/>
    <style>
        .sk-fading-circle {
            margin: 100px auto;
            width: 40px;
            height: 40px;
            position: relative;
        }

        .sk-fading-circle .sk-circle {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
        }

        .sk-fading-circle .sk-circle:before {
            content: '';
            display: block;
            margin: 0 auto;
            width: 15%;
            height: 15%;
            background-color: #2b3d51;
            border-radius: 100%;
            -webkit-animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
            animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
        }

        .sk-fading-circle .sk-circle2 {
            -webkit-transform: rotate(30deg);
            -ms-transform: rotate(30deg);
            transform: rotate(30deg);
        }

        .sk-fading-circle .sk-circle3 {
            -webkit-transform: rotate(60deg);
            -ms-transform: rotate(60deg);
            transform: rotate(60deg);
        }

        .sk-fading-circle .sk-circle4 {
            -webkit-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .sk-fading-circle .sk-circle5 {
            -webkit-transform: rotate(120deg);
            -ms-transform: rotate(120deg);
            transform: rotate(120deg);
        }

        .sk-fading-circle .sk-circle6 {
            -webkit-transform: rotate(150deg);
            -ms-transform: rotate(150deg);
            transform: rotate(150deg);
        }

        .sk-fading-circle .sk-circle7 {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .sk-fading-circle .sk-circle8 {
            -webkit-transform: rotate(210deg);
            -ms-transform: rotate(210deg);
            transform: rotate(210deg);
        }

        .sk-fading-circle .sk-circle9 {
            -webkit-transform: rotate(240deg);
            -ms-transform: rotate(240deg);
            transform: rotate(240deg);
        }

        .sk-fading-circle .sk-circle10 {
            -webkit-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
            transform: rotate(270deg);
        }

        .sk-fading-circle .sk-circle11 {
            -webkit-transform: rotate(300deg);
            -ms-transform: rotate(300deg);
            transform: rotate(300deg);
        }

        .sk-fading-circle .sk-circle12 {
            -webkit-transform: rotate(330deg);
            -ms-transform: rotate(330deg);
            transform: rotate(330deg);
        }

        .sk-fading-circle .sk-circle2:before {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .sk-fading-circle .sk-circle3:before {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }

        .sk-fading-circle .sk-circle4:before {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .sk-fading-circle .sk-circle5:before {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        .sk-fading-circle .sk-circle6:before {
            -webkit-animation-delay: -0.7s;
            animation-delay: -0.7s;
        }

        .sk-fading-circle .sk-circle7:before {
            -webkit-animation-delay: -0.6s;
            animation-delay: -0.6s;
        }

        .sk-fading-circle .sk-circle8:before {
            -webkit-animation-delay: -0.5s;
            animation-delay: -0.5s;
        }

        .sk-fading-circle .sk-circle9:before {
            -webkit-animation-delay: -0.4s;
            animation-delay: -0.4s;
        }

        .sk-fading-circle .sk-circle10:before {
            -webkit-animation-delay: -0.3s;
            animation-delay: -0.3s;
        }

        .sk-fading-circle .sk-circle11:before {
            -webkit-animation-delay: -0.2s;
            animation-delay: -0.2s;
        }

        .sk-fading-circle .sk-circle12:before {
            -webkit-animation-delay: -0.1s;
            animation-delay: -0.1s;
        }
        .action-filters{
            display: none;
        }

        @-webkit-keyframes sk-circleFadeDelay {
            0%, 39%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }

        @keyframes sk-circleFadeDelay {
            0%, 39%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }
    </style>
    <meta name="_token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <div hidden id="page-type">{{$pageType}}</div>
    <div class="content-body">
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="page-title-box">
                    @if($pageType == 'my products')
                        <h4 class="page-title float-left pl-1">My Products</h4>
                    @else
                        <h4 class="page-title float-left pl-1">Import List</h4>

                    @endif
                    <fieldset class="filter pull-right d-flex">
                        <form class=" d-flex" @if($pageType == 'my products') action="{{route('retailer.products')}}" @else action="{{route('retailer.imported.products')}}" @endif method="get">
                            <fieldset class="form-group mr-1">
                                <input id="filter-by-name-id" type="search" @if(isset($queryName)) value="{{$queryName}}"  @endif name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
                            </fieldset>
                            <div class="mr-1">
                                <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                            </div>
                        </form>
                    </fieldset>
                </div>

            </div>
        </div>
        <!-- Data list view starts -->
        <section id="data-thumb-view" class="data-thumb-view-header">
            <!-- dataTable starts -->
            <div class="table-responsive">
                <table id="dt-product" class="table data-thumb-view">
                    <thead>
                    <tr>
                        @if($pageType != 'my products')
                            <th></th>
                        @endif
                        <th>Image</th>
                        <th>NAME</th>
                        <th>COST</th>
                        <th>PRICE</th>
                        <th width="20%" class="text-right">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($retailer_drafts) < 1)
                        <tr>
                            @if($pageType == 'my products')
                                <td colspan="6" class="text-center"><strong>No product imported to your shopify store</strong></td>
                            @else
                                <td colspan="6" class="text-center"><strong>No product found in your import list</strong></td>
                            @endif
                        </tr>
                    @else
                        @foreach($retailer_drafts as $product)
                            <tr data-selected-product-id="{{ $product->id }}">
                                @if($pageType != 'my products')
                                    <td>
                                    </td>
                                @endif

                                <td class="product-img"><a href="{{route('retailer.products.edit', $product->id)}}"><img src="{{ $product->image }}" alt="{{ $product->title }}" height="70px" width="100px"></a></td>
                                <td class="product-name"><a href="{{route('retailer.products.edit', $product->id)}}">{{ $product->title }}</a></td>
                                <td class="product-price">${{ number_format($product->cost, 2) }}</td>
                                <td class="product-price">${{ number_format($product->price, 2) }}</td>
                                <td class="product-action">
                                    @if($product->product_id == null)
                                        <span class="badge badge-danger text-left">
                                            Removed By Admin
                                        </span>
                                    @else
                                        @if($pageType == 'my products')
                                            <span data-toggle="tooltip" title="Turn it on to import and off to set published status of product from your shopify account!">
                                               <input class="js-switch set-shopify-status"data-id="{{$product->id}}" @if($product->status == 1) data-type="disable" checked @else data-type="enable" @endif type="checkbox">
                                        </span>
                                        @else
                                            <span data-toggle="tooltip" title="Turn it on to import and off to delete product from your shopify account!">
                                               <input class="js-switch" data-type="export" @if($product->toShopify == 1) checked @endif type="checkbox" id="{{$product->id}}">
                                            </span>
                                        @endif
                                    @endif


                                        <a class="pull-right" data-toggle="modal" href data-target="#deleteConfirmationModal{{ $product->id }}">
                                            <span data-toggle="tooltip"
                                                  @if($product->toShopify == 1)
                                                  title="Clicking here will delete product from import list and shopify!"
                                                  @else
                                                  title="Click here to delete product from import list!"
                                                  @endif
                                            ><i class="fa fa-trash" style="font-size: 18px"></i>
                                            </span>
                                        </a>

                                        @if($product->toShopify == 1)
                                            <a class="pull-right pr-1 text-primary" target="_blank"
                                               href="{{ 'https://'. \Illuminate\Support\Facades\Auth::user()->myshopify_domain  . '/collections/frontpage/products/' . $product->handle }}">
                                            <span data-toggle="tooltip" title="Clicking here to view product in shopify store!">
                                                <span class="fa fa-shopping-bag" style="font-size: 18px;"></span>
                                            </span>
                                            </a>
                                            <a class="pull-right pr-1 text-primary" target="_blank"
                                               href="{{  'https://'. \Illuminate\Support\Facades\Auth::user()->myshopify_domain . '/admin/products/' . $product->shopify_product_id }}">
                                            <span data-toggle="tooltip" title="Clicking here to view product in shopify admin!"><i class="fa fa-eye" style="font-size: 18px"></i>
                                            </span>
                                            </a>
                                        @endif

                                        @if($product->product_id != null)
                                            @if($product->toShopify != 1)
                                                <a class="pull-right mr-1" href="{{ route('retailer.products.edit', $product->id) }}">
                                                    <span data-toggle="tooltip" title="Click to edit product details!"><i class="fa fa-edit" style="font-size: 18px"></i></span>
                                                </a>
                                            @endif
                                        @endif

                                </td>
                            </tr>
                            <div class="modal" id="deleteConfirmationModal{{ $product->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content modal-lg">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete Product Confirmation</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            @if($product->toShopify == 1)
                                                Are you sure you want to delete this product?
                                                <small class="danger">It will also be deleted from shopify</small>
                                            @else
                                                Are you sure you want to delete this product?
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-link" data-dismiss="modal">Close</a>
                                            <a class="btn btn-danger" id="add-to-store" href="{{ route('retailer.product.destroy', $product->id) }}">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    </tbody>
                </table>
                <!-- dataTable ends -->
            </div>

        </section>
        <!-- Data list view end -->
        <div class="modal fade" id="loading-animation-modal" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h6 class="modal-title">Please wait while we are processing action on products to your shopify account</h6>
                    </div>

                    <div class="modal-body">
                        <div class="sk-fading-circle" id="loader-animation" hidden>
                            <div class="sk-circle1 sk-circle"></div>
                            <div class="sk-circle2 sk-circle"></div>
                            <div class="sk-circle3 sk-circle"></div>
                            <div class="sk-circle4 sk-circle"></div>
                            <div class="sk-circle5 sk-circle"></div>
                            <div class="sk-circle6 sk-circle"></div>
                            <div class="sk-circle7 sk-circle"></div>
                            <div class="sk-circle8 sk-circle"></div>
                            <div class="sk-circle9 sk-circle"></div>
                            <div class="sk-circle10 sk-circle"></div>
                            <div class="sk-circle11 sk-circle"></div>
                            <div class="sk-circle12 sk-circle"></div>
                        </div>
                        <div id="show-message"></div>
                    </div>

                    <div class="modal-footer" hidden id="modal-close-button">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
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
    <script src="{{ asset('dist/switchery/switchery.min.js')  }}"></script>

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('js/scripts/ui/data-list-view.js') }}"></script>
    <!-- END: Page JS-->

    <script>
        var checkBoxClicked;
        var add_to_store_products_global = [];
        var url = 'https://dropshipping.shopifyapplications.com';

        //initialized switchery elements
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });


        $(function () {
            $('.js-switch').change(function () {
                var value = $(this).prop('checked');

                var retailer_product_id = this.id;
                if($(this).data('type') === 'export'){
                    // toastr.info('Import Export Works');
                    if (value) {

                        console.log('retailer product id:' + retailer_product_id);

                        var loading_animation_modal = $('#loading-animation-modal');
                        var loading_animation = $('#loader-animation');
                        var show_message = $('#show-message');
                        show_message.text('');
                        var modal_close_button = $('#modal-close-button');

                        loading_animation.attr('hidden', false);
                        loading_animation_modal.modal('show');
                        // loading_animation_modal_message.attr('hidden', false);

                        $.ajax({
                            url: url + '/retailer/product/push/to/shopify/' + retailer_product_id,
                            type: 'post',
                            data: {
                                _token: "{{csrf_token()}}",
                            },
                            success: function (success) {
                                if (success['status'] == 200) {
                                    if (success['message'] === 'saved') {
                                        var response_json = JSON.parse(success['response']);
                                        var after_push_price = response_json.body.product.variants[0].price;
                                        var price = $('#price-' + retailer_product_id);
                                        price.text('$' + after_push_price);

                                        toastr.success('Product has been imported successfully.');
                                        // loading_animation_modal.modal('hide');
                                        loading_animation.attr('hidden', true);
                                        modal_close_button.attr('hidden', false);
                                        show_message.text('Product has been imported successfully.');
                                    }
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            },
                        });

                    } else {

                        toastr.info('Please wait this product is being deleted');
                        $.ajax({
                            url: url + '/retailer/product/delete/from/shopify/' + retailer_product_id,
                            type: 'GET',
                            success: function (success) {
                                console.log(success);
                                if (success['status'] == 200) {
                                    toastr.success(success['message']);
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        })

                    }
                }
                console.log(value);
            });
            $('.set-shopify-status').change(function () {
                var value = $(this).prop('checked');
                var retailer_product_id = $(this).data('id');
                if(value){
                    var published = true;
                }
                else{
                    var published = false;
                }
                if($(this).data('type') === 'enable' || $(this).data('type') === 'disable'){
                    toastr.info('Please Wait Setting Your Product Status in Shopify Store');
                    $.ajax({
                        url: url + '/retailer/product/status/from/shopify/' + retailer_product_id,
                        type: 'GET',
                        data:{
                            published : published
                        },
                        success: function (success) {
                            console.log(success);
                            if (success['status'] == 200) {
                                toastr.success(success['message']);
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    })
                }
            })
        });
    </script>
@endsection
