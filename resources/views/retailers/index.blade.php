@extends('layouts.new_theme')


@section('content')

    @php
        $count =1;
    @endphp

    <div class="mt-2">
        @include('flash-message')
    </div>

    <div class="bg-white p-2">

        @if(isset($retailers))
            <div class=" ">
                <h4 class=" float-left mb-3">Retailers</h4>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>NAME</th>
                    <th class="text-right">ACTION</th>
                </tr>
                </thead>
                <tbody>
                @if(count($retailers) < 1)
                    <tr>
                        <td colspan="3" class="text-center"><strong>No retailer found.</strong></td>
                    </tr>
                @else
                    @foreach($retailers as $retailer)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $retailer->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.retailer', $retailer->id) }}"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                <a class="text-primary" data-toggle="modal" data-target="#deleteRetailerConfirmationModal{{$retailer->id}}"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                            </td>
                            <div class="modal" id="deleteRetailerConfirmationModal{{$retailer->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete Shop</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Are you sure you want to delete this shop?
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <a href style="color: darkgrey" data-dismiss="modal">Close</a>
                                            <a href="{{ route('supplier.store.delete', $retailer->id) }}" class="btn btn-danger">Yes, I am</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{ $retailers->links() }}
        @else
            <div class=" ">
                <h4 class=" float-left mb-3">Suppliers</h4>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>NAME</th>
                    <th class="text-right">ACTION</th>
                </tr>
                </thead>
                <tbody>
                @if(count($suppliers) < 1)
                    <tr>
                        <td colspan="3" class="text-center"><strong>No supplier found.</strong></td>
                    </tr>
                @else
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td class="text-capitalize">{{ $supplier->name }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.supplier', $supplier->id) }}"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                <a  class="text-primary" data-toggle="modal" data-target="#deleteRetailerConfirmationModal{{$supplier->id}}"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                            </td>
                            <div class="modal" id="deleteRetailerConfirmationModal{{$supplier->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete Shop</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Are you sure you want to delete this shop?
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <a href style="color: darkgrey" data-dismiss="modal">Close</a>
                                            <a href="{{ route('supplier.store.delete', $supplier->id) }}" class="btn btn-danger">Yes, I am</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{ $suppliers->links() }}
        @endif

    </div>

@endsection
