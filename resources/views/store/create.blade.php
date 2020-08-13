@extends('layouts.new_theme')


@section('content')


    <div class="row mt-2 p-1">
        <div class="col-6">
            <div class="page-title-box">
                <h4 class="page-title float-left">Connect your store</h4>

            </div>
        </div>
        <div class="col-6">

            <div class="float-right">
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="mt-2 p-1 bg-white">

        <form action="{{ route('supplier.store.create') }}" method="POST">
            @csrf
            <div class="mb-1"><strong>Enter your app details</strong></div>
            <div class="form-group">
                <div class="mb-1">Store Domain</div>
                <input type="text" name="shop_domain" placeholder="Enter your store domain" required class="form-control">
            </div>
            <div class="form-group">
                <div class="mb-1">API Key</div>
                <input type="text" name="api_key" placeholder="Enter your api key" required class="form-control">
            </div>
            <div class="form-group">
                <div class="mb-1">Password</div>
                <input type="password" name="password" placeholder="Enter your app's password" required class="form-control">
            </div>
            <div class="form-group">
                <div class="mb-1">Shared Secret Key</div>
                <input type="text" name="shared_secret" placeholder="Enter your shared secret key" required class="form-control">
            </div>


            <button type="submit" class="btn btn-primary mt-1">Save</button>
        </form>
    </div>

@endsection
