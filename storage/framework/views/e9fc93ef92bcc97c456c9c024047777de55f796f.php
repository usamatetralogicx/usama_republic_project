<?php $__env->startSection('title', 'My products'); ?>

<?php $__env->startSection('css'); ?>

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/file-uploaders/dropzone.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/tables/datatable/datatables.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/plugins/file-uploaders/dropzone.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/data-list-view.css')); ?>">
    <link href="<?php echo e(asset('dist/switchery/switchery.min.css')); ?>" rel="stylesheet"/>
    <!-- END: Page CSS-->

    <style>
        .sk-fading-circle {
            margin: 100px auto;
            width: 40px;
            height: 40px;
            position: relative;
        }

        .sk-fading-circle .sk-circle {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
        }

        .sk-fading-circle .sk-circle:before {
            content: '';
            display: block;
            margin: 0 auto;
            width: 15%;
            height: 15%;
            background-color: #2b3d51;
            border-radius: 100%;
            -webkit-animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
            animation: sk-circleFadeDelay 1.2s infinite ease-in-out both;
        }

        .sk-fading-circle .sk-circle2 {
            -webkit-transform: rotate(30deg);
            -ms-transform: rotate(30deg);
            transform: rotate(30deg);
        }

        .sk-fading-circle .sk-circle3 {
            -webkit-transform: rotate(60deg);
            -ms-transform: rotate(60deg);
            transform: rotate(60deg);
        }

        .sk-fading-circle .sk-circle4 {
            -webkit-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        .sk-fading-circle .sk-circle5 {
            -webkit-transform: rotate(120deg);
            -ms-transform: rotate(120deg);
            transform: rotate(120deg);
        }

        .sk-fading-circle .sk-circle6 {
            -webkit-transform: rotate(150deg);
            -ms-transform: rotate(150deg);
            transform: rotate(150deg);
        }

        .sk-fading-circle .sk-circle7 {
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .sk-fading-circle .sk-circle8 {
            -webkit-transform: rotate(210deg);
            -ms-transform: rotate(210deg);
            transform: rotate(210deg);
        }

        .sk-fading-circle .sk-circle9 {
            -webkit-transform: rotate(240deg);
            -ms-transform: rotate(240deg);
            transform: rotate(240deg);
        }

        .sk-fading-circle .sk-circle10 {
            -webkit-transform: rotate(270deg);
            -ms-transform: rotate(270deg);
            transform: rotate(270deg);
        }

        .sk-fading-circle .sk-circle11 {
            -webkit-transform: rotate(300deg);
            -ms-transform: rotate(300deg);
            transform: rotate(300deg);
        }

        .sk-fading-circle .sk-circle12 {
            -webkit-transform: rotate(330deg);
            -ms-transform: rotate(330deg);
            transform: rotate(330deg);
        }

        .sk-fading-circle .sk-circle2:before {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .sk-fading-circle .sk-circle3:before {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }

        .sk-fading-circle .sk-circle4:before {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .sk-fading-circle .sk-circle5:before {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        .sk-fading-circle .sk-circle6:before {
            -webkit-animation-delay: -0.7s;
            animation-delay: -0.7s;
        }

        .sk-fading-circle .sk-circle7:before {
            -webkit-animation-delay: -0.6s;
            animation-delay: -0.6s;
        }

        .sk-fading-circle .sk-circle8:before {
            -webkit-animation-delay: -0.5s;
            animation-delay: -0.5s;
        }

        .sk-fading-circle .sk-circle9:before {
            -webkit-animation-delay: -0.4s;
            animation-delay: -0.4s;
        }

        .sk-fading-circle .sk-circle10:before {
            -webkit-animation-delay: -0.3s;
            animation-delay: -0.3s;
        }

        .sk-fading-circle .sk-circle11:before {
            -webkit-animation-delay: -0.2s;
            animation-delay: -0.2s;
        }

        .sk-fading-circle .sk-circle12:before {
            -webkit-animation-delay: -0.1s;
            animation-delay: -0.1s;
        }
        select.form-control:not([multiple=multiple]) {
            background-image: url(https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/pages/arrow-down.png);
            background-position: calc(100% - 12px) 13px,calc(100% - 20px) 13px,100% 0;
            background-size: 12px 12px,10px 10px;
            background-repeat: no-repeat;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2rem;
        }

        @-webkit-keyframes sk-circleFadeDelay {
            0%, 39%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }

        @keyframes  sk-circleFadeDelay {
            0%, 39%, 100% {
                opacity: 0;
            }
            40% {
                opacity: 1;
            }
        }
    </style>
    <meta name="_token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div hidden id="page-type">my products</div>

    <div class="content-body">
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left pl-1">
                        <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                        <?php if(isset($pageType) && $pageType == 'disabled products'): ?>
                            Disabled Products
                        <?php else: ?>
                            Active Products
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                        My Products
                        <?php endif; ?>
                    </h4>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                    <fieldset class="filter pull-right d-flex">
                        <?php if(isset($pageType)): ?>
                            <form class=" d-flex" action="<?php echo e(url('/products')); ?>" method="get">
                                <fieldset class="form-group mr-1">
                                <input id="filter-by-name-id" type="search" value="<?php echo e($queryName); ?>" name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
                                </fieldset>
                                <fieldset class="form-group mr-1">
                                    <select name="filter-by-supplier" class="form-control d-inline-block">
                                        <option value=""> All </option>
                                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($querySupplier == $supplier->name): ?> selected <?php endif; ?> value="<?php echo e($supplier->name); ?>"><?php echo e($supplier->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </fieldset>
                                <fieldset class="form-group mr-1">
                                    <select name="filter-by-status" class="form-control d-inline-block">
                                        <option <?php if($queryStatus == 'all'): ?> selected <?php endif; ?>  value="all">All Products</option>
                                        <option  <?php if($queryStatus == 'active'): ?> selected <?php endif; ?> value="active" >Active Products</option>
                                        <option  <?php if($queryStatus == 'disabled'): ?> selected <?php endif; ?> value="disabled" >Disabled Products</option>
                                    </select>
                                </fieldset>
                                <div class="mr-1">
                                    <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="float-right">
                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#assign-category" id="open-assign-category-modal" class="btn btn-primary">Assign Category</a>
                    
                    <a class="btn btn-primary" href="<?php echo e(route('products.create')); ?>">Create New Product</a>
                    <?php endif; ?>

                    <div class="modal" id="assign-category">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Assign Category</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <form id="assign-category-form" action="<?php echo e(route('admin.assign.category')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-body">
                                        <div>
                                            <div class="form-group">
                                                <label for="select-category">Category</label>
                                                <select name="category" id="select-category" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php if(count($categories) > 0): ?>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <option value="">No category available</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div hidden id="show-sub-category" class="form-group">
                                                <label for="select-sub-category">Sub Category</label>
                                                <select name="sub_category" id="select-sub-category" class="form-control">
                                                </select>
                                            </div>
                                            <div class="text-danger" id="show-error-message"></div>
                                            <input type="text" hidden id="selected-products" name="products">
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <a class="btn btn-link" data-dismiss="modal">Close</a>
                                        <button id="assign-category-btn" disabled type="submit" class="btn btn-primary">Assign</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- dataTable starts -->
        <div class="row">
            <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
            <div class="col-md-3">
                <div class="sidebar-detached sidebar-left">
                    <div class="sidebar">
                        <!-- Ecommerce Sidebar Starts -->
                        <div class="sidebar-shop" id="ecommerce-sidebar-toggler">

                            <div class="row">
                                <div class="col-sm-12">
                                    <h6 class="filter-heading d-none d-lg-block">Filters</h6>
                                </div>
                            </div>
                            <span class="sidebar-close-icon d-block d-md-none">
                            <i class="feather icon-x"></i>
                        </span>
                            <div class="card">
                                <form id="filter-form-1" action="<?php echo e(url('/products')); ?>" method="GET">
                                    <div class="card-body">

                                        <div class="multi-range-price">
                                            <div class="multi-range-title">
                                                <fieldset class="form-group position-relative">
                                                    <input type="text" class="form-control search-product pr-1"
                                                           name="search" <?php if(isset($search)): ?> value="<?php echo e($search); ?>" <?php endif; ?> id="iconLeft5" placeholder="Search here">
                                                </fieldset>
                                            </div>
                                        </div>


                                        <hr>
                                        <!-- Categories Starts -->
                                        <?php if(isset($categories)): ?>
                                            <div id="product-categories">
                                                <div class="product-category-title">
                                                    <h6 class="filter-title mb-1">Categories</h6>
                                                </div>
                                                <ul class="list-unstyled categories-list">
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($index < 10): ?>
                                                            <li>
                                                                <a data-category-name="<?php echo e($category->name); ?>">
                                                    <span class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="category-filter" value="<?php echo e($category->name); ?>"
                                                               <?php if(isset($selected_category)): ?> <?php if($selected_category != '' && $selected_category != null ): ?> <?php if($selected_category->id == $category->id): ?> checked <?php endif; ?> <?php endif; ?> <?php endif; ?>>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border" style="height: 19px; width: 19px;"></span>
                                                            <span class="vs-radio--circle" style="height: 19px; width: 19px;"></span>
                                                        </span>
                                                        <span class="ml-50">
                                                           <?php echo e($category->name); ?>

                                                        </span>
                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php elseif($index == 10): ?>
                                                            <li id="btn-see-more-categories">
                                                                <a href="javascript:void(0);">See More</a>
                                                            </li>
                                                        <?php else: ?>
                                                            <li class="see-more-categories" hidden>
                                            <span class="vs-radio-con vs-radio-primary py-25">
                                                <input type="radio" name="category-filter" value="<?php echo e($category->name); ?>">
                                                <span class="vs-radio">
                                                    <span class="vs-radio--border" style="height: 19px; width: 19px;"></span>
                                                    <span class="vs-radio--circle" style="height: 19px; width: 19px;"></span>
                                                </span>
                                                <span class="ml-50">
                                                    <a><?php echo e($category->name); ?></a>
                                                </span>
                                            </span>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <li id="btn-see-less-categories" hidden>
                                                        <a href="javascript:void(0);">See Less</a>
                                                    </li>
                                                </ul>
                                                <hr>

                                            </div>

                                        <?php endif; ?>
                                        <div id="product-categories">
                                            <div class="product-category-title">
                                                <h6 class="filter-title mb-1">Stores</h6>
                                            </div>
                                            <ul class="list-unstyled categories-list">
                                                <?php $__currentLoopData = auth()->user()->stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <li>
                                                        <a data-category-name="<?php echo e($store->shop_domain); ?>">
                                                    <span class="vs-radio-con vs-radio-primary py-25">
                                                        <input type="radio" name="store-filter" value="<?php echo e($store->shop_domain); ?>"
                                                               <?php if(isset($selected_store)): ?> <?php if($selected_store != '' && $selected_store != null ): ?> <?php if($selected_store == $store->shop_domain): ?> checked <?php endif; ?> <?php endif; ?> <?php endif; ?>>
                                                        <span class="vs-radio">
                                                            <span class="vs-radio--border" style="height: 19px; width: 19px;"></span>
                                                            <span class="vs-radio--circle" style="height: 19px; width: 19px;"></span>
                                                        </span>
                                                        <span class="ml-50">
                                                          <?php echo e(explode('.',$store->shop_domain)[0]); ?>

                                                        </span>
                                                    </span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <li id="btn-see-less-categories" hidden>
                                                    <a href="javascript:void(0);">See Less</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Categories Ends -->


                                        <!-- Clear Filters Starts -->
                                        <div id="clear-filters">
                                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-block btn-primary">CLEAR ALL</a>
                                        </div>
                                        <!-- Clear Filters Ends -->

                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Ecommerce Sidebar Ends -->
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
            <div class="col-md-9">
                <?php endif; ?>
                <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                <div class="col-md-12">
                    <?php endif; ?>
                    <div class="content-detached content-right">
                        <section id="data-thumb-view" class="data-thumb-view-header">
                            <div class="table-responsive">
                                <table id="dt-product" class="table data-thumb-view ">
                                    <thead>
                                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                    <th>SELECT</th>
                                    <?php endif; ?>
                                    <th>IMAGE</th>
                                    <th>TITLE</th>

                                    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                                    <th>SUPPLIER</th>
                                    <th>FORM</th>
                                    <?php endif; ?>

                                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                    <th>FROM</th>
                                    <?php endif; ?>

                                    <th>STATUS</th>

                                    <th class="text-right" width="20%">ACTION</th>
                                    </thead>
                                    <tbody>
                                    <?php if(count($products) < 1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <strong>

                                                    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                                                    <?php if(isset($pageType) && $pageType == 'disabled products'): ?>
                                                        No disabled product found.
                                                    <?php else: ?>
                                                        No active product found.
                                                    <?php endif; ?>
                                                    <?php endif; ?>

                                                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                                    No product found.
                                                    <?php endif; ?>

                                                </strong>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                                <td class="text-center dt-checkboxes-cell">
                                                    <input name="products-<?php echo e($product->id); ?>" class="checkbox-add-to-cart products-checkboxes" id="<?php echo e($product->id); ?>" type="checkbox"
                                                           style="display: none !important;">
                                                </td>
                                                <?php endif; ?>
                                                <td class="product-img">
                                                    <a class="text-primary" href="<?php echo e(route('products.show',$product->id)); ?>">
                                                        <?php if($product->fromShopify): ?>
                                                            <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->title); ?>" height="60px" class="w-auto">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(env('APP_URL'). $product->image); ?>" alt="<?php echo e($product->title); ?>" height="60px" class="w-auto">
                                                        <?php endif; ?>
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <div>
                                                        <a  href="<?php echo e(route('products.show',$product->id)); ?>">
                                                            <?php echo e($product->title); ?>

                                                        </a>
                                                    </div>

                                                    <?php if($product->sub_categories != null): ?>
                                                        <?php $__currentLoopData = $product->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <a data-toggle="modal" data-target="#deAssignSubCategoryConfirmationModal<?php echo e($product_sub_category->id); ?>">
                                                                <div class="badge badge-primary">
                                                                    <?php echo e($product_sub_category->category->name . ' - ' . $product_sub_category->name); ?>

                                                                </div>
                                                            </a>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>

                                                </td>
                                                <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                                                <td class="product-name"><?php if($product->linked_supplier != null): ?>  <?php echo e($product->linked_supplier->name); ?> <?php else: ?> Manual <?php endif; ?></td>
                                                <td class="product-action">
                                                    <?php if($product->fromShopify): ?>
                                                        <span class="badge badge-primary">
                                                Shopify
                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">
                                                Manual
                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>
                                                <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                                <td class="product-action">
                                                    <?php if($product->fromShopify): ?>
                                                        <span class="badge badge-primary">
                                                Shopify
                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">
                                                Manual
                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <?php endif; ?>


                                                <td class="product-name">
                                                    <form id="form-change-product-status-<?php echo e($product->id); ?>" action="<?php echo e(route('admin.change.product.status', $product->id)); ?>">
                                        <span data-toggle="tooltip" title="Turn it on to active and off to disable this product">
                                            <input class="js-switch" <?php if($product->status == 1): ?> checked <?php endif; ?> type="checkbox" name="status" id="<?php echo e($product->id); ?>">
                                        </span>
                                                    </form>
                                                </td>

                                                <td class="text-right">
                                                    <a class="text-primary" href="<?php echo e(route('products.show',$product->id)); ?>">
                                                        <span data-toggle="tooltip" title="Click to view product details!"><i class="fa fa-eye" style="font-size: 18px"></i></span>
                                                    </a>
                                                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                                    <a class="text-primary" href="<?php echo e(route('products.edit',$product->id)); ?>">
                                                        <span data-toggle="tooltip" title="Click to edit product details!"><i class="fa fa-edit" style="font-size: 18px"></i></span>
                                                    </a>
                                                    <?php endif; ?>
                                                    <a class="text-primary" href="<?php echo e(route('product.delete', $product->id)); ?>">
                                                        <span data-toggle="tooltip" title="Click to delete product!"><i class="fa fa-trash" style="font-size: 18px"></i></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php if($product->sub_categories != null): ?>
                                                <?php $__currentLoopData = $product->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="modal fade" id="deAssignSubCategoryConfirmationModal<?php echo e($product_sub_category->id); ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">


                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">De Assign Confirmation</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <form action="<?php echo e(route('admin.de-assign.subcategory')); ?>" method="POST">
                                                                    <?php echo csrf_field(); ?>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to remove this subcategory from this product?
                                                                    </div>
                                                                    <input type="text" hidden name="product_id" value="<?php echo e($product->id); ?>">
                                                                    <input type="text" hidden name="sub_category_id" value="<?php echo e($product_sub_category->id); ?>">

                                                                    <div class="modal-footer">
                                                                        <a class="btn btn-link" data-dismiss="modal">Close</a>
                                                                        <button type="submit" class="btn btn-danger">Yes!</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <div class="d-flex justify-content-center">  <?php echo $products->links(); ?></div>
                    </div>
                </div>
            </div>



        </div>

    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('scripts'); ?>

        <!-- BEGIN: Page Vendor JS-->
            <script src="<?php echo e(asset('vendors/js/extensions/dropzone.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.buttons.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendors/js/tables/datatable/dataTables.select.min.js')); ?>"></script>
            <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')); ?>"></script>
            <!-- END: Page Vendor JS-->

            <!-- BEGIN: Page JS-->
            <script src="<?php echo e(asset('dist/switchery/switchery.min.js')); ?>"></script>
            <script src="<?php echo e(asset('js/scripts/ui/data-list-view.js')); ?>"></script>
            <!-- END: Page JS-->

            <script>
                //initialized switchery elements
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                elems.forEach(function (html) {
                    var switchery = new Switchery(html, {size: 'small'});
                });

                $('body').on('keyup','#filter-by-supplier-id',function () {
                    var compareWith = "laravel";
                    var compareWithLength = compareWith.length;
                    var compare = $(this).val();
                    var compareLength = compare.length;
                    if(compareLength <= compareWithLength){
                        if(compare[compareLength-1] === compareWith[compareLength-1]){
                            console.log(compareWith[compareLength-1]);
                        }
                        else{
                            console.log('Wrong Word');
                        }
                    }
                    else{
                        console.log('Wrong Word');
                    }

                });

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
                            url: '<?php echo e(env('APP_URL')); ?>' + '/retailer/add/products/to/draft',
                            type: 'POST',
                            data: {
                                'products': add_to_draft_products,
                                '_token': '<?php echo e(csrf_token()); ?>',
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
                            'url': '<?php echo e(env('APP_URL')); ?>' + '/admin/subcategories/' + category_id,
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

                    $('.js-switch').change(function () {
                        $(this).parent().parent().submit();
                    });

                });
            </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/products/index.blade.php ENDPATH**/ ?>