@extends('layouts.themeH')

@section('title', 'Products')


@section('content')


    <div class="container">
        @include('flash-message')


        <div class="mt-3 p-3 bg-white">

            <div class="row">
                <div class="col-xl-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Assign Category</h4>
                        <div class="float-right mt-3 mb-2 ">
                            <div class="">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#assign-category" class="btn btn-success">Assign Category</a>

                                <div class="modal" id="assign-category">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">Assign Category</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form id="assign-category-form" action="{{ route('admin.assign.category') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div>
                                                        <div class="form-group">
                                                            <label for="select-category">Category</label>
                                                            <select name="category" id="select-category" class="form-control">
                                                                <option value="">Select Category</option>
                                                                @if(count($categories) > 0)
                                                                    @foreach($categories as $category)
                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No category available</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div hidden id="show-sub-category" class="form-group">
                                                            <label for="select-sub-category">Sub Category</label>
                                                            <select name="sub_category" id="select-sub-category" class="form-control">
                                                            </select>
                                                        </div>

                                                        <input type="text" hidden id="selected-products" name="products">
                                                    </div>
                                                </div>


                                                <div class="modal-footer">
                                                    <a class="btn btn-link" data-dismiss="modal">Close</a>
                                                    <button type="submit" class="btn btn-primary">Assign</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <table class="table table-responsive-sm table-bordered">
                <thead>
                <th width="10%">Select</th>
                <th width="10%">Image</th>
                <th width="70%">Product Title</th>
                <th width="10%">Assigned Categories</th>
                {{--                <th width="10%">Price</th>--}}

                </thead>
                <tbody>
                @if(count($products) < 1)
                    <tr>
                        <td colspan="5" class="text-center"><strong>No product found</strong></td>
                    </tr>
                @else
                    @foreach($products as $product)
                        <tr>
                            <td class="text-center"><input name="products-{{ $product->id }}" class="checkbox-add-to-cart" id="{{ $product->id }}" type="checkbox"></td>
                            <td><img src="{{ $product->image }}" alt="{{ $product->title }}" width="70px" height="70px"></td>
                            <td>{{ $product->title }}</td>
                            <td>
                                <a href=""><i class="fa fa-c"></i></a>
                            </td>
                            {{--                            <td>{{ $product->price }}</td>--}}

                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>
    </div>



@endsection

@section('scripts')

    <script>
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


        });
    </script>
@endsection
