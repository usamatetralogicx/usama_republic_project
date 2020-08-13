@extends('layouts.ecommerce')
@extends('layouts.ecommerce')

@section('title', 'Product')


@section('content')


    <!--Main layout-->
    <main class="mt-3 pt-4">
        <div class="dark-grey-text mt-2">

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <img src="{{ env('APP_URL') . $product_images->src }}" class="img-fluid" alt="">

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <!--Content-->
                    <div class="p-4">
                        <h3 class="">{{ $product->title }}</h3>
                        <p class="lead font-weight-bold">Price</p>
                        <p class="lead">
                            <span class="mr-1"><del>{{ number_format($product->price,2) }}$</del></span>
                            <span>{{ number_format($product->cost, 2) }}$</span>
                        </p>

                        <p class="lead font-weight-bold">Description</p>
                        {!! html_entity_decode($product->body_html) !!}
                        <form class="d-flex justify-content-left">
                            <!-- Default input -->
                            {{--                            <input type="number" value="1" aria-label="Search" class="form-control" style="width: 100px"> &nbsp;&nbsp;&nbsp;--}}
                            <button class="btn btn-primary btn-md my-0 p" type="submit">Add to draft
                                <i class="fa fa-edit ml-1"></i>
                            </button>

                        </form>

                    </div>
                    <!--Content-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

        </div>
    </main>
    <!--Main layout-->
@endsection
