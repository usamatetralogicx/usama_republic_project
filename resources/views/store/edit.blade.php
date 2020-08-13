@extends('layouts.new_theme')


@section('content')

    <div class="">
        <h4 class="mt-2 page-title">Update your store details</h4>
        <div class="mt-2 p-1 bg-white">
            <form action="{{ route('supplier.store.update', $store->id )}}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="mb-1">Store Domain</div>
                    <input type="text" name="shop_domain" value="{{ $store->shop_domain }}" placeholder="Enter your store domain" required class="form-control">
                </div>
                <div class="form-group">
                    <div class="mb-1">API Key</div>
                    <input type="text" name="api_key" value="{{ $store->api_key }}" placeholder="Enter your api key" required class="form-control">
                </div>
                <div class="form-group">
                    <div class="mb-1">Password</div>
                    <input type="text" name="password" value="{{ $store->password }}" placeholder="Enter your app's password" required class="form-control">
                </div>
                <div class="form-group">
                    <div class="mb-1">Shared Secret Key</div>
                    <input type="text" name="shared_secret" value="{{ $store->shared_secret }}" placeholder="Enter your shared secret key" required class="form-control">
                </div>


                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>


@endsection
