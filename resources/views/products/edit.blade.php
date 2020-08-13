@extends('layouts.ecommerce')

@section('title', 'Edit Product')

@section('css')
    <link href="{{ asset('dist/fileuploads/css/dropify.css') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/summernote-bs4.css') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    <style>
        .note-popover .popover-content>.btn-group, .card-header.note-toolbar>.btn-group {
            margin-top: 5px;
            margin-right: 0 !important;
            margin-left: 0 !important;
        }
        .note-btn-group .btn-light {
            background-color: #7367f0 !important;
        }
        .categories-div{
            height: 400px;
            overflow: auto;
        }
        .sub-div {
            margin-left: 28px;
            display: none;
        }
    </style>

    @php
        $count = 0 ;
    @endphp

    <div class="row">
        <div class="col-lg-12 mt-2 pl-1">
            <div class="page-title-box">
                <h4 class="page-title float-left">Edit Product</h4>
            </div>
        </div>
    </div>

    <form id="images-form" action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @method('PUT')
        @csrf

        <div class="row">
            <div class=" col-md-8">
                <div class="p-1 bg-white">
                    <div class="form-group">
                        <div class="mb-1"><strong>Title</strong></div>
                        <input type="text" placeholder="Title" name="title" value="{{ $product->title }}" required id="title" class="form-control">
                    </div>
                </div>
                <div class="mt-2 p-1 bg-white">
                    <div style="width: 100%;">
                        <div class="mb-1"><strong>Description</strong></div>
                        <textarea style="display: none;" name="body_html" id="summernote">{!!  html_entity_decode($product->body_html) !!}</textarea>
                    </div>
                </div>
                <div id="for-image-upload" class="mt-2 p-1 bg-white">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <div class="mb-1"><strong>Product Image</strong></div>
                                <input type="file" name="images[]" class="dropify bg-transparent" multiple data-height="300"/>
                            </div>
                        </div><!-- end col -->
                    </div>

                    <div id="images-container" class=" pt-2 bg-white">
                        <div class="row m-0 p-0">
                            @foreach($images as $image)

                                <div class="col-sm-3 col-md-2 m-0 p-0">
                                    @if(substr($image->src, 0, 7) != '/images/')
                                        <img src="{{ $image->src }}" alt="{{ $image->alt }}" height="120px" width="120px">
                                    @else
                                        <img src="{{ env('APP_URL'). $image->src }}" alt="{{ $image->alt }}" height="120px" width="120px">
                                    @endif
                                    <p id="{{$image->id}}" style="color: #ffffff;width: 120px;" class="rounded-bottom bg-danger delete-previous-image text-center">Remove</p>
                                    <div class="modal" id="deleteProductImageConfirmationModal{{ $image->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation!</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Are you sure you want to delete this image?
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <a class="btn btn-link" data-dismiss="modal">Close</a>
                                                    <button type="button" id="{{ $image->id }}" class="btn btn-danger confirm-delete">Yes, delete</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="p-1 mt-2 bg-white">
                    <div class="mb-1"><strong>Pricing</strong></div>
                    <div class="row pl-1">
                        <div class="col-12 form-check-inline">
                            <div class="col-6 form-group pl-0">
                                <div class="mb-1"><strong>Price</strong></div>
                                <input type="text" name="price" value="{{ $product->price }}" id="product-price" placeholder="US$ 0.00" class="form-control">
                            </div>
                            <div class="col-6 form-group pr-0">
                                <div class="mb-1"><strong>Cost</strong></div>
                                <input type="text" name="cost" value="{{$product->cost }}" placeholder="US$ 0.00" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1 mt-2 bg-white">
                    <div class="mb-1"><strong>Inventory</strong></div>
                    <div class="row pl-1">
                        <div class="col-12 form-check-inline">
                            <div class="col-6 form-group pl-0">
                                <div class="mb-1"><strong>SKU (Stock Keeping Unit)</strong></div>
                                <input type="text" name="sku" value="{{ $product->sku }}" id="product-sku" class="form-control">
                            </div>
                            <div class="col-6 form-group pr-0">
                                <div class="mb-1"><strong>Barcode</strong></div>
                                <input type="text" name="barcode" value="{{ $product->barcode }}" id="product-barcode" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1 mt-2 bg-white">
                    <div class="mb-1"><strong>Shipping</strong></div>
                    <div class="checkbox checkbox-primary">
                        <input id="checkbox" type="checkbox" checked>
                        <label for="checkbox">This is a physical product</label>
                    </div>
                    <hr>
                    <div id="if-physical-product" class="form-group col-3 pl-0">
                        <div class="mb-1"><strong>Weight </strong> (grams)</div>
                        <input type="number" name="grams" value="{{ $product->grams }}" class="form-control">
                    </div>
                </div>
                <div class="p-1 mt-2 bg-white col-12">
                    <div class="mb-1"><strong>Variants</strong></div>
                    <hr class="p-0 m-0" id="variant-hr">
                    <div id="variants-pair-container">
                        <div class="mt-2">
                            <div><strong>Preview</strong></div>
                            <table class="table table-borderless table-responsive-sm">
                                <thead>
                                <th>Variant</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>SKU</th>
                                <th>Barcode</th>
                                <th></th>
                                </thead>
                                <tbody id="tbody">
                                @foreach($variants as $variant)
                                    <tr>
                                        <td>
                                            {{ $variant->title }}
                                            <input type="hidden" name="variant_title[]" value="{{ $variant->title }}">
                                        </td>
                                        <td height="50px" width="50px">
                                            @if($variant->src != null)
                                                @if(substr($variant->src, 0, 7) != '/images/')
                                                    <img src="{{ $variant->src }}" data-toggle="modal" data-target="#select_image_modal{{$variant->id}}" class="product-image" alt="{{ $variant->title }}" height="50px" width="50px">
                                                @else
                                                    <img src="{{ env('APP_URL') . $variant->src }}" data-toggle="modal" data-target="#select_image_modal{{$variant->id}}" class="product-image" alt="{{ $variant->title }}" height="50px" width="50px">
                                                @endif
                                            @else
                                                <img href="" data-toggle="modal" data-target="#select_image_modal{{$variant->id}}" class="product-image" height="50px" width="50px">
                                            @endif


                                            <div class="modal" id="select_image_modal{{ $variant->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Select Image for this variant</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                @foreach($images as $image)
                                                                    <div class="col-md-4">
                                                                        @if(substr($image->src, 0, 7) != '/images/')
                                                                            <img src="{{ $image->src }}" alt="{{ $image->alt }}" height="120px" width="120px">
                                                                        @else
                                                                            <img src="{{ env('APP_URL'). $image->src }}" alt="{{ $image->alt }}" height="120px" width="120px">
                                                                        @endif
                                                                        <p style="color: #ffffff;width: 120px;cursor: pointer" data-image="{{$image->id}}" data-variant="{{$variant->id}}" class="rounded-bottom bg-info choose-variant-image text-center">Choose</p>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <p class="text-center font-weight-bold">OR</p>
                                                            <hr>
                                                            <img href=""  height="50px" width="50px" style="margin-right: 10px">
                                                            <input type="file" onchange="readURL(this);" id="input-image-field-{{$variant->id}}" class="form-group" name="image[]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><input class="pl-1 form-control" name="variant_price[]" type="text" value="{{ $variant->price }}"></td>
                                        <td><input class="pl-1 form-control" name="variant_quantity[]" type="text" value="{{ $variant->quantity }}"></td>
                                        <td><input class="pl-1 form-control" name="variant_sku[]" type="text" value="{{ $variant->sku }}"></td>
                                        <td><input class="pl-1 form-control" name="variant_barcode[]" type="text" value="{{ $variant->barcode }}"></td>

                                        <td>
                                            <i class="fa fa-trash remove-variant text-primary" id="{{$variant->id}}"></i>
                                            <input type="hidden" name=variant_id[]" value="{{ $variant->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-1  bg-white ">
                    <div class="mb-1"><strong>Status</strong></div>
                    <ul id="reset-list" class="list-unstyled mb-0">
                        <li class="">
                            <fieldset>
                                <div class="vs-radio-con">
                                    <input type="radio" name="status" @if($product->status == 1) checked @endif required value="1">
                                    <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                    <span class="">Active</span>
                                </div>
                            </fieldset>
                        </li>
                        <li class="">
                            <fieldset>
                                <div class="vs-radio-con">
                                    <input type="radio" name="status" @if($product->status == 0) checked @endif value="0">
                                    <span class="vs-radio">
                                                            <span class="vs-radio--border"></span>
                                                            <span class="vs-radio--circle"></span>
                                                        </span>
                                    <span class="">Disabled</span>
                                </div>
                            </fieldset>
                        </li>
                    </ul>
                </div>
                <div class="p-1 mt-2 bg-white">
                    <div class="mb-1"><strong>Organization</strong></div>
                    <div class="form-group">
                        <div class="mb-1"><strong>Vendor</strong></div>
                        <input type="text" name="vendor" class="form-control" value="{{ $product->vendor }}" placeholder="Enter vendor name">
                    </div>
                    <div class="form-group">
                        <div class="mb-1"><strong>Type</strong></div>
                        <input type="text" name="type" class="form-control" value="{{ $product->type }}" placeholder="Enter product type">
                    </div>
                    <div class="form-group">
                        <div class="mb-1"><strong>Tags</strong></div>
                        <input id="variant-tags" data-role="tagsinput" value="{{ $product->tags }}" name="tags" class="form-control">
                    </div>
                </div>
                <div class="p-1 mt-2 bg-white ">
                    <div class="mb-1"><strong>Category</strong></div>
                    <div class="form-group categories-div">
                        @foreach($categories as $category)
                            <div class="cat-div">
                                <fieldset >
                                    <i class="fa fa-chevron-right opener" style="vertical-align: super;font-size: 10px;color: #7367f0;"></i>
                                    <div class="vs-checkbox-con vs-checkbox-primary d-inline-flex">
                                        <input type="checkbox" class="category_checkbox"
                                               name="category[]" value="{{$category->id}}">
                                        <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                        <span class="">@if($category->name == 'Electronic Components & Supplies') Electronic Components @else {{$category->name}}@endif</span>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="sub-div">
                                @foreach($category->sub_categories as $sub)
                                    <fieldset>
                                        <div class="vs-checkbox-con vs-checkbox-primary">
                                            <input type="checkbox" class="sub_cat_checkbox"
                                                   @if(in_array($sub->id,$product->sub_categories->pluck('id')->toArray())) checked @endif
                                                   name="subcategory[]" value="{{$sub->id}}">
                                            <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                            <span class="">{{$sub->name}}</span>
                                        </div>
                                    </fieldset>
                                @endforeach
                            </div>

                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-1 ml-1">
            <button type="submit" id="update-button"  class="btn btn-primary">Update product</button>
        </div>

    </form>
@endsection

@section('scripts')
    <script src="{{ asset('dist/fileuploads/js/dropify.js') }}"></script>
    <script src="{{ asset('dist/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('dist/summernote-bs4.js') }}"></script>

    <script>
        var selectedImages = [];
        var options = 1;
        var allValues = [];

        $(document).ready(function () {

            $('.sub-div').each(function () {
                if($(this).find('input[type=checkbox]:checked').length > 0){
                    $(this).prev().find('input[type=checkbox]').prop('checked','true');
                }
            });

            $('body').on('change','.category_checkbox',function () {
                if($(this).is(':checked')){
                    // $(this).parents('.cat-div').next().find('input[type=checkbox]').prop('checked','true');
                    $(this).parents('.cat-div').next().show();
                }
                else{
                    // $(this).parents('.cat-div').next().find('input[type=checkbox]').prop('checked',false);
                    $(this).parents('.cat-div').next().hide();
                }
            });

            $('body').on('change','.sub_cat_checkbox',function () {
                if($(this).is(':checked')){
                    $(this).parents('.sub-div').prev().find('.category_checkbox').prop('checked','true');
                }
                else{
                    var checked = $(this).parents('.sub-div').find('input[type=checkbox]:checked').length;
                    if(checked === 0){
                        $(this).parents('.sub-div').prev().find('.category_checkbox').prop('checked',false);
                    }
                }
            });

            $('.opener').click(function () {

                if($(this).hasClass('fa-chevron-right')){
                    $(this).removeClass('fa-chevron-right');
                    $(this).addClass('fa-chevron-down');
                }
                else{
                    $(this).removeClass('fa-chevron-down');
                    $(this).addClass('fa-chevron-right');
                }
                $(this).parents('.cat-div').next().toggle();
            });


            $('#summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                ],
                fontNames: ['Roboto', 'Calibri', 'Times New Roman', 'Arial'],
                fontNamesIgnoreCheck: ['Roboto', 'Calibri'],

                tabsize: 2,
                popover: false,
                height: 250,
            });

            // $('.product-image').click(function () {
            //     $(this).next().click();
            // });

            $('.remove-variant').click(function () {
                $(this).parent().parent().remove();
                var id = $(this).attr('id');

                console.log(id);

                $.ajax({
                    url: '{{env('APP_URL')}}' + '/supplier/variant/delete/' + id,
                    type: 'get',
                    success: function (success) {
                        console.log(success);
                    },
                    error: function (error) {
                        console.log(error);
                    },
                })

            });

            $("body").delegate(".variant-remove", "click", function () {
                console.log('clicked');
                $(this).parent().remove();
            });

            $('#checkbox').on('change', function () {
                if ($(this).prop('checked') === true) {
                    $('#if-physical-product').attr('hidden', false);
                } else {
                    $('#if-physical-product').attr('hidden', true);
                }
            });

            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Oops!! Something wrong.'
                },
                error: {
                    'fileSize': 'The file size is too big (1M max).'
                }
            });

        });

        // $("input ").change(function () {
        //     $('#update-button').attr('disabled', false);
        // });

        // $("input[type='text']").on('focus', function () {
        //     $('#update-button').attr('disabled', false);
        // });

        $('.delete-previous-image').click(function () {
            var image_id = this.id;
            console.log(image_id);
            $('#deleteProductImageConfirmationModal' + image_id).modal('show');


        });

        $('.confirm-delete').click(function () {
            var image_id = this.id;
            console.log(image_id);
            $('#' + image_id).parent().hide();
            $('#deleteProductImageConfirmationModal' + image_id).modal('hide');

            $.ajax({
                url: '{{ env('APP_URL') }}' + '/supplier/product/image/delete/' + image_id,
                type: 'get',
                success: function (success) {
                    if (success['status'] == 200) {
                        if (success['message'] === 'deleted') {
                            console.log("deleted");
                        }
                    } else {
                        console.log("some issue: " + success['message']);
                    }
                },
                error: function (error) {
                    console.log("error: " + error);
                },
            })
        });

        $('.choose-variant-image').click(function () {
            var current = $(this);
           $.ajax({
               url: '{{ env('APP_URL') }}' + '/supplier/product/variant/'+$(this).data('variant')+'/change/image/'+$(this).data('image'),
               type: 'GET',
               success:function (response) {
                   if(response.message == 'success'){
                       current.removeClass('bg-info');
                       current.addClass('bg-success');
                       current.text('Updated');
                       toastr.success('Variant image has been updated!');

                   }
                   else{
                       toastr.error('Something went wrong!');
                   }
               }
           })
            $(this).parents('.modal').prev()
                .attr('src', $(this).prev().attr('src'))
                .width(50)
                .height(50);
        });

        function readURL(input) {
            var id = input.id;
            var variant_id = id.substring(18);
            console.log(variant_id);

            var formData = new FormData();
            formData.append('variant_image', input.files[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ env('APP_URL') }}' + '/supplier/product/variant/add/image/' + variant_id,
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,
                success: function (success) {
                    console.log(success);
                    toastr.success('Image Uploaded Successfully!');
                },
                error: function (error) {
                    console.log(error);
                },
            });

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#' + id).prev()
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50);
                    $('#' + id).parents('.modal').prev()
                        .attr('src', $(this).prev().attr('src'))
                        .width(50)
                        .height(50);
                };


                reader.readAsDataURL(input.files[0]);
            }

        }

    </script>
@endsection
