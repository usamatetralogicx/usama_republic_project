@extends('layouts.new_theme')

@section('title', 'All Categories')

@section('content')


    <div class="row mt-2">
        <div class="col-6">
            <div class="page-title-box">
                <h4 class="page-title float-left">All Categories</h4>
            </div>
        </div>
        <div class="col-6">
            <div class="float-right">
                <a class="btn btn-primary" data-toggle="modal" href="javascript:void(0);" data-target="#createCategoryModal">Add Category</a>
                <a class="btn btn-primary"data-toggle="modal" href="javascript:void(0);" data-target="#createSubCategoryModal">Add Sub-category</a>
            </div>
            <div class="modal fade" id="createCategoryModal">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create Category</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="{{ route('categories.store') }}" method="POST">
                            <div class="modal-body">

                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="name" required class="form-control" placeholder="Enter category title">
                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <a class="btn btn-link" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade " id="createSubCategoryModal">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create sub category</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form action="{{ route('sub_categories.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category_id" required class="form-control">
                                        <option value="">Select Category</option>
                                        @if(count($categories) < 1)
                                            <option value="">No category available</option>
                                        @else
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="name" required autofocus class="form-control" placeholder="Enter sub-category title">
                                </div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <a class="btn btn-link" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="mt-1 bg-white">

        <ul class="list-group">
            @if(count($categories) < 1)
                <li class="text-center">No category found</li>
            @else
                @foreach($categories as $category)
                    <li class="list-group-item">
                        <a style="color: black" data-toggle="collapse" href="#collapse{{ $category->id }}">
                            {{ $category->name }}
                        </a>

                        <div class="float-right">
                            <a class="text-primary" data-toggle="modal" data-target="#editCategoryModal{{ $category->id }}"><i  style="font-size: 18px;" class="fa fa-edit"></i></a>
                            <a class="text-primary" data-toggle="modal" data-target="#deleteCategoryConfirmationModal{{ $category->id }}"><i  style="font-size: 18px;" class="fa fa-trash-o"></i></a>
                        </div>
                    </li>
                    <div id="collapse{{ $category->id }}" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if(count($sub_category_array[$category->id]) > 0)
                                            <ul class="list-group">
                                                @foreach($sub_category_array[$category->id] as $sub_category)
                                                    <li class="list-group-item">
                                                        <a style="color:#676a6d;">
                                                            {{ $sub_category->name }}
                                                            <div class="float-right">
                                                                <div class="float-right">
                                                                    <a class="text-primary" data-toggle="modal" data-target="#editSubCategoryModal{{ $sub_category->id }}"><i  style="font-size: 18px;" class="fa fa-edit"></i></a>
                                                                    <a class="text-primary" data-toggle="modal" data-target="#deleteSubCategoryConfirmationModal{{ $sub_category->id }}"><i  style="font-size: 18px;" class="fa fa-trash-o"></i></a>
                                                                </div>
                                                                <div class="modal" id="editSubCategoryModal{{$sub_category->id }}">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">

                                                                            <!-- Modal Header -->
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Edit SubCategory</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>

                                                                            <form action="{{ route('sub_categories.update', $sub_category->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <!-- Modal body -->
                                                                                <div class="modal-body">
                                                                                    <div class="form-group">
                                                                                        <label for="">Category</label>
                                                                                        <select name="category_id"  required class="form-control">
                                                                                            <option value="">Select Category</option>
                                                                                            @if(count($categories) < 1)
                                                                                                <option value="">No category available</option>
                                                                                            @else
                                                                                                @foreach($categories as $cat)
                                                                                                    <option @if($category->id == $cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                                                                @endforeach
                                                                                            @endif
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="">Title</label>
                                                                                        <input type="text" name="name" required autofocus value="{{ $sub_category->name }}" class="form-control" placeholder="Enter sub-category title">
                                                                                    </div>

                                                                                </div>

                                                                                <!-- Modal footer -->
                                                                                <div class="modal-footer">
                                                                                    <a class="btn btn-link" data-dismiss="modal">Close</a>
                                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal" id="deleteSubCategoryConfirmationModal{{ $sub_category->id }}">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">

                                                                            <!-- Modal Header -->
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Delete Category Confirmation</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>

                                                                            <!-- Modal body -->
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete this sub category?
                                                                            </div>

                                                                            <!-- Modal footer -->
                                                                            <div class="modal-footer">
                                                                                <a class="btn btn-link" data-dismiss="modal">Close</a>
                                                                                <form action="{{ route('sub_categories.destroy', $sub_category->id) }}" method="POST" style="display: inline">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                                                </form>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-black-50"> No sub category</div>
                                        @endif

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="modal" id="editCategoryModal{{ $category->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Category</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="">Title</label>
                                            <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="modal" id="deleteCategoryConfirmationModal{{ $category->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Category Confirmation</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Are you sure you want to delete this category?
                                    <div>
                                        <small class="text-danger">All sub-categories will also be deleted</small>
                                    </div>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <a class="btn btn-link" data-dismiss="modal">Close</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </ul>
    </div>

@endsection
