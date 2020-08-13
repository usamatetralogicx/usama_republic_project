@extends('layouts.ecommerce')

@section('title', 'Product Details')


@section('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-ecommerce-details.css') }}">
    <!-- END: Page CSS-->
@endsection

@section('content')

    <!-- app ecommerce details start -->
    <section class="app-ecommerce-details">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">

                    </div>
                    @role('supplier')
                    <div class="col-md-3 text-right">
                        <a class="btn btn-primary" href="{{route('products.edit',$product->id)}}"> Edit Product</a>
                    </div>
                    @endrole
                </div>
                <div class="row mb-5 mt-2">
                    <div class="col-12 col-md-5 <!--d-flex align-items-start justify-content-center mb-2 mb-md-0-->">
                        <div class="row">
                            <img src="{{ $product->image }}" class="img-fluid" alt="product image">
                        </div>

                        <div class="row mt-1">
                            @foreach($product->images as $image)
                                <div class="col-md-4" style="margin-bottom: 5px;margin-top: 5px">
                                    <img src="{{ $image->src }}" class="img-fluid" alt="product image">
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="col-12 col-md-6">
                        <h5>{{ $product->title }}</h5>
                        @php
                            $minPrice = (float) $product_variants->min('price');
                        @endphp

                        @php
                          $maxPrice = (float) $product_variants->max('price');
                            @endphp

{{--                        @dd($maxPrice,$minPrice)--}}
                        <h4 class="pull-right text-primary">@if($minPrice > 0 && $maxPrice > 0)  @if($minPrice == $maxPrice) ${{number_format($minPrice,2)}}  @else ${{number_format($minPrice,2)}} - ${{number_format($maxPrice,2)}} @endif @else ${{number_format($product->price,2)}} @endif</h4>
                        <p class="text-muted mb-0">by <span class="text-primary">{{ $product->vendor }}</span></p>
                        <p class="text-muted">@if($product->sold_count > 0 ) Added to import list {{ $product->sold_count }} times @endif</p>
                        <hr>
                        <p>{!! html_entity_decode($product->body_html) !!}</p>
                        @if($product->option1 != 'Title')
                            <p class="font-weight-bold"><i class="feather icon-box mr-50 font-medium-2"></i>Options available
                            </p>
                            <hr>
                            {{--                            @dd($product)--}}

                            @if($product->option1 != null)

                                <div class="form-group">
                                    <label class="font-weight-bold">{{ $product->option1 }}</label>
                                    <ul class="list-unstyled mb-0 product-color-options">
                                        @if($product->value1 != null)
                                            @foreach(json_decode($product->value1, true) as $value1)
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem">
                                                    {{ $value1 }}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <hr>
                                </div>
                            @endif
                            @if($product->option2 != null)
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ $product->option2 }}</label>
                                    <ul class="list-unstyled mb-0 product-color-options">
                                        @if($product->value2 != null)
                                            @foreach(json_decode($product->value2, true) as $value2)
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem">
                                                    {{ $value2 }}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <hr>
                                </div>
                            @endif
                            @if($product->option3 != null)
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ $product->option3 }}</label>
                                    <ul class="list-unstyled mb-0 product-color-options">
                                        @if( $product->value3 != null)
                                            @foreach(json_decode($product->value3, true) as $value3)
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem">
                                                    {{ $value3 }}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <hr>
                                </div>
                            @endif
                        @endif

                        @if($product->sub_categories != null)
                            <p class="font-weight-bold"><i class=" feather icon-tag  mr-50 font-medium-2"></i>Categories</p>
                            <hr>
                                <div class="form-group">
                                    <ul class="list-unstyled mb-0 product-color-options">
                                            @foreach($product->sub_categories as $product_sub_category)
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem;">
                                                    {{ $product_sub_category->category->name . ' - ' . $product_sub_category->name }}
                                                </li>
                                            @endforeach
                                    </ul>
                                    <hr>
                                </div>
                        @endif
                        @if($product->tags != null)
                            <p class="font-weight-bold"><i class=" fa fa-tags mr-50 font-medium-2"></i>Tags</p>
                            <hr>
                            <div class="form-group">
                                <ul class="list-unstyled mb-0 product-color-options">
                                    @foreach(explode(',',$product->tags) as $tag)
                                        <li class="d-inline-block border-primary px-2" style="padding: 0.2rem;margin-bottom: 5px">
                                            {{ $tag }}
                                        </li>
                                    @endforeach
                                </ul>
                                <hr>
                            </div>

                        @endif
                        @php
                        $quantityTotal = $product_variants->sum('quantity');
                        @endphp
                        @if($quantityTotal > 0)
                            <p>Available - <span class="text-success">In stock</span> ({{$quantityTotal}} items in {{count($product_variants)}} variants) </p>
                            @else
                            <p>Unavailable - <span class="text-danger">Not In stock</span> (0 items in {{count($product_variants)}} variants)</p>
                            @endif



                    </div>
                    @if(count($product_variants) > 0)
                        <div class="col-12">
                            <table class="table">
                                <thead class="font-weight-bolder">
                                <td>IMAGE</td>
                                <td>OPTION</td>
                                <td>PRICE</td>
                                <td>QTY</td>
                                </thead>
                                <tbody>
                                @foreach($product_variants as $variant)
                                    <tr>
                                        <td>
                                            @if($variant->src != null)
                                                <img src="{{ $variant->src }}" alt="{{ $variant->title }}" height="80px" width="80px">
                                            @else
                                                <img src="https://image.shutterstock.com/image-vector/no-image-available-icon-vector-260nw-1323742826.jpg" alt="{{ $variant->title }}" height="80px" width="80px">
                                            @endif
                                        </td>
                                        <td>{{ $variant->title }}</td>
                                        <td>${{ number_format($variant->price, 2)  }}</td>
                                        <td>{{ $variant->quantity  }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-12">
                            <p>This product has no variants</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- app ecommerce details end -->

@endsection

@section('scripts')
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('js/scripts/pages/app-ecommerce-details.js') }}"></script>
    <script src="{{ asset('js/scripts/forms/number-input.js') }}"></script>
    <!-- END: Page JS-->
@endsection
