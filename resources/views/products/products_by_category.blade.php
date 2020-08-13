@extends('layouts.themeH')

@section('title', 'Products')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">
<div class="container">

    <div class="mt-3">  @include('flash-message')</div>


    <div class="mt-3 pb-1">

        <div class="row">
            <div class="col-md-12  bg-white">
                <div class="row">
                    <div class="col-6">
                        <div class="page-title-box">
                            <h4 class="page-title float-left">Products by {{ $category->name }}</h4>

                        </div>
                    </div>
                    <div class="col-6  mt-3 mb-2 ">

                        <div class="float-right">



                            @role('retailer')
                            @if(count($products) > 0)
                            <a class="btn btn-success" id="add-to-draft" href="#">Add to draft</a>
                            @endif
                            @endrole

                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="">
                            <ul class="list-group">
                                <li class="list-group-item text-black-50">Categories & Tags</li>
                                @foreach($sub_categories as $category)
                                    <li style="color: #16181b" class="list-group-item">{{ $category->name }}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                    <div class="col-md-10">
                        <table class="table @if(count($products) > 0) table-responsive-md @endif table-bordered">
                            <thead>
                            @role('retailer|admin')
                            <th width="5%">Select</th>
                            @endrole

                            <th width="5%">Image</th>
                            <th width="50%">Title</th>
                            @role('supplier|admin')
                            <th width="5%">From</th>
                            @endrole
                            <th width="8%">Action</th>
                            </thead>
                            @if(count($products) < 1)
                            <tr>
                                <td colspan="5" class="text-center"><strong>No product found in {{ $category->name }}.</strong></td>
                            </tr>
                            @else
                            @foreach ($products as $product)
                            <tr>
                                @role('admin')
                                <td class="text-center"><input name="products-{{ $product->id }}" class="checkbox-add-to-cart" id="{{ $product->id }}" type="checkbox"></td>
                                @endrole
                                @role('retailer')
                                <td class="text-center"><input name="products-{{ $product->id }}" class="checkbox-add-to-draft" id="{{ $product->id }}" type="checkbox"></td>
                                @endrole
                                <td>
                                    @if($product->fromShopify)
                                    <img src="{{ $product->image }}" alt="{{ $product->title }}" height="80" width="80">
                                    @else
                                    <img src="{{ env('APP_URL'). $product->image }}" alt="{{ $product->title }}" height="80" width="80">
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        {{ $product->title }}

                                    </div>

                                    @if($product->sub_categories != null)
                                    @foreach($product->sub_categories as $product_sub_category)

                                    <a data-toggle="modal" data-target="#deAssignSubCategoryConfirmationModal{{ $product_sub_category->id }}">
                                        <div class="badge badge-info">
                                            {{ $product_sub_category->name }}
                                        </div>
                                    </a>
                                    <div class="modal fade" id="deAssignSubCategoryConfirmationModal{{ $product_sub_category->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">


                                                <div class="modal-header">
                                                    <h4 class="modal-title">De Assign Confirmation</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form action="{{ route('admin.de-assign.subcategory') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        Are you sure you want to remove this subcategory from this product?
                                                    </div>
                                                    <input type="text" hidden name="product_id" value="{{ $product->id }}">
                                                    <input type="text" hidden name="sub_category_id" value="{{ $product_sub_category->id }}">

                                                    <div class="modal-footer">
                                                        <a class="btn btn-link" data-dismiss="modal">Close</a>
                                                        <button type="submit" class="btn btn-danger">Yes!</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif

                                </td>
                                @role('supplier|admin')
                                <td>
                                    @if($product->fromShopify)
                                    <span class="badge badge-primary">
                                                    Shopify
                                            </span>

                                    @else
                                    <span class="badge badge-success">
                                                    Manual
                                            </span>
                                    @endif
                                </td>
                                @endrole
                                <td class="text-right">
                                    <a href="{{ route('products.show',$product->id) }}"><i class="fa fa-eye"></i></a>

                                    @can('product-edit')
                                    <a href="{{ route('products.edit',$product->id) }}"><i class="fa fa-edit"></i></a>
                                    @endcan

                                    @can('product-delete')
                                    <a href="{{ route('product.delete', $product->id) }}"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script>
    toastr.options = {
        // "progressBar": true,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": true,
        "onclick": null,
        "closeButton": true,
        // "showDuration": "500",
        // "hideDuration": "1000",
        "timeOut": "5500",
        // "extendedTimeOut": "1000",
        // "showEasing": "swing",
        // "hideEasing": "linear",
        // "showMethod": "fadeIn",
        // "hideMethod": "fadeOut"
    };

    $('#add-to-draft').click(function () {
        var add_to_draft_products = [];
        $.each($(".checkbox-add-to-draft:checked"), function () {
            // add_to_cart_products.push($(this).val());
            add_to_draft_products.push(this.id);
        });


        console.log(add_to_draft_products);

        if (add_to_draft_products.length > 0) {
            toastr.info('Selected products are being added to your drafts in background');
            $.ajax({
                url: '{{ env('APP_URL') }}' + '/retailer/add/products/to/draft',
                type: 'POST',
                data: {
                    'products': add_to_draft_products,
                    '_token': '{{csrf_token()}}',
                },
                success: function (success) {
                    if (success['status'] == 200) {


                        setTimeout(() => {
                            toastr.clear();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: success['message'],
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }, 2000);


                    }
                    console.log('success: ' + success);
                },
                error: function (error) {
                    console.log('error: ' + error);

                }
            });
        } else {
            toastr.info('No product is selected. Please select product(s) to add them into drafts.');
        }


    });

    $(function () {

        var global_products = [];
        var count = 0;


        $('.checkbox-add-to-cart').change(function () {
            var add_to_store_products = [];
            $.each($(".checkbox-add-to-cart:checked"), function () {
                // add_to_cart_products.push($(this).val());
                add_to_store_products.push(this.id);

            });

            global_products = add_to_store_products;

        });

        $('#select-category').change(function () {
            var category_id = $(this).val();
            var select_sub_category = $('#select-sub-category');
            var show_sub_category = $('#show-sub-category');

            $.ajax({
                'type': 'GET',
                'url': '{{env('APP_URL')}}' + '/admin/subcategories/' + category_id,
                success: function (success) {
                    if (success['status'] === 200) {
                        var subcategories = success['data'];
                        show_sub_category.attr('hidden', false);
                        select_sub_category.empty();

                        if (subcategories.length < 1) {
                            select_sub_category.append('<option>No sub category available</option>');

                        } else {
                            for (var i = 0; i < subcategories.length; i++) {
                                select_sub_category.append('<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>');
                            }
                        }

                        console.log(subcategories);
                    } else {
                        show_sub_category.attr('hidden', false);

                    }

                    console.log(success);
                },
                error: function (error) {
                    console.log(error);
                    show_sub_category.attr('hidden', true);
                }

            });

        });

        $("#assign-category-form").one("submit", function (e) {
            e.preventDefault();


            $('#selected-products').val(global_products);

            $(this).submit();


        });

        $('#open-assign-category-modal').click(function () {
            if (global_products.length < 1) {
                $('#show-error-message').text('Please select product to assign category.');
                $('#assign-category-btn').attr('disabled', true);
            } else {
                $('#show-error-message').text('');
                $('#assign-category-btn').attr('disabled', false);
            }
        });


    });
</script>
@endsection
