@extends('layouts.new_theme')

@section('title', 'Manage Products')

@section('content')
    <style>
        .card {
            border:1px solid #c9d0d878
        }
        .card-body ul li {
            line-height:1.8;
            font-size:14px
        }
        .color-dots span {
            width:10px;
            height:10px;
        }

    </style>

    <div class="mx-3">
        <div class="row py-3">
            <div class="col-2 p-0">
              <div class="">
                  <ul class="list-group">
                  <li class="list-group-item text-black-50">Categories & Tags </li>
                      @foreach($all_categories as $category)
                          <li class="list-group-item">{{ $category->name }}</li>
                      @endforeach
                  </ul>

              </div>
            </div>
            <div class="col-10">
             <div class="pl-2">
                 <div class="row">
                     @foreach($products as $product)
                         <div class="col-lg-3 p-0 col-md-3 mb-4">
                             <div class="card m-1 h-100">
                                 <!--Card image-->
                                 <div class="product-image">
                                     <img src="{{ $product->image }}" class="card-img-top" alt="photo">
                                 </div>
                                 <!--Card content-->
                                 <div class="card-body">
                                     <!--Title-->
                                     <div class="card-title font-weight-bold mb-2" style="min-height: 65px; overflow: hidden">{{ $product->title }}</div>
                                     @role('retailer')
                                     <div class="text-right">
                                         <button class="btn btn-block btn-primary">Add to draft<i class="fa fa-chevron-right pl-2"></i></button>
                                     </div>
                                     @endrole
                                 </div>
                                 <div class="card-footer bg-transparent d-flex justify-content-between">
                                     <span><strong class="font-weight-bold">Price</strong></span>
                                     <div>
                                         <del class="text-muted mr-2"></del>
                                         <strong class="font-weight-bold">${{ $product->price }}</strong>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </div>
             </div>
            </div>
        </div>

    </div>
@endsection
