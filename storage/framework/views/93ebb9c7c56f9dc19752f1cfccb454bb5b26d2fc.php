<?php if(isset($retailers)): ?>
    <?php $__env->startSection('title', 'Retailers' ); ?>
<?php else: ?>
    <?php $__env->startSection('title', 'Suppliers' ); ?>
<?php endif; ?>


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


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <style>
        select.form-control:not([multiple=multiple]) {
            background-image: url(https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/app-assets/images/pages/arrow-down.png);
            background-position: calc(100% - 12px) 13px,calc(100% - 20px) 13px,100% 0;
            background-size: 12px 12px,10px 10px;
            background-repeat: no-repeat;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2rem;
        }
    </style>
    <?php
        $count =1;
    ?>
    <div hidden id="page-type">my products</div>

    <div class="content-body">
        <div class="row mt-2">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">
                        <?php if(isset($retailers)): ?>
                            Retailers
                        <?php else: ?>
                            Suppliers
                        <?php endif; ?>

                    </h4>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                    <?php if(isset($pageType) && $pageType == 'supplier-page'): ?>
                        <div class="filter pull-right d-flex">
                            <form class=" d-flex" action="<?php echo e(route('admin.suppliers')); ?>" method="get">
                                <div class="mr-1">
                                    <input id="filter-by-supplier-id" type="search" value="<?php echo e($querySupplier); ?>" name="filter-by-supplier" class="form-control d-inline-block" placeholder="Search by Name">
                                </div>
                                <fieldset class="form-group mr-1">
                                    <select name="status" class="form-control d-inline-block">
                                        <option <?php if($queryStatus == 'all'): ?> selected <?php endif; ?>  value="all">All </option>
                                        <option  <?php if($queryStatus == 'active'): ?> selected <?php endif; ?> value="active" >Active </option>
                                        <option  <?php if($queryStatus == 'disabled'): ?> selected <?php endif; ?> value="disabled" >Disabled </option>
                                    </select>
                                </fieldset>
                                <div class="mr-1">
                                    <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                                </div>
                            </form>

                        </div>
                    <?php endif; ?>
                    <?php if(isset($pageType) && $pageType == 'retailer-page'): ?>
                        <div class="filter pull-right d-flex">
                            <form class=" d-flex" action="<?php echo e(route('admin.retailers')); ?>" method="get">
                                <div class="mr-1">
                                    <input  type="search" value="<?php echo e($queryName); ?>" name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
                                </div>
                                <div class="mr-1">
                                    <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                                </div>
                            </form>

                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6"></div>
        </div>


        <?php if(isset($retailers)): ?>
            <section id="data-thumb-view" class="data-thumb-view-header">
                <div class="table-responsive">
                    <table id="dt-product" class="table data-thumb-view p-0">
                        <thead>
                        <th class="pl-1">#</th>
                        <th>NAME</th>
                        <th>PRODUCTS</th>
                        <th>ORDERS</th>
                        <th>IMPORT LIST</th>
                        <th class="text-right">ACTION</th>
                        </thead>
                        <tbody>
                        <?php if(count($retailers) < 1): ?>
                            <tr>
                                <td colspan="3" class="text-center"><strong>No retailer found.</strong></td>
                            </tr>
                        <?php else: ?>
                            <?php $__currentLoopData = $retailers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retailer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($count++); ?></td>
                                    <td class="product-name text-capitalize py-2"><a href="<?php echo e(route('admin.retailer', $retailer->id)); ?>"><?php echo e($retailer->name); ?></a></td>
                                    <td class="product-name"><?php echo e(count($retailer->retailer_products()->where('toShopify', true)->get() )); ?></td>
                                    <td class="product-name"><?php echo e(count($retailer->retailer_orders)); ?></td>
                                    <td class="product-name"><?php echo e(count($retailer->retailer_products()->where('toShopify', false)->get())); ?></td>
                                    <td class="text-right product-action">
                                        <a class="text-primary" href="<?php echo e(route('admin.retailer', $retailer->id)); ?>"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                        <a  class="text-primary" data-toggle="modal" data-target="#deleteRetailerConfirmationModal<?php echo e($retailer->id); ?>"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                                    </td>
                                    <div class="modal" id="deleteRetailerConfirmationModal<?php echo e($retailer->id); ?>">
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
                                                    <a href="<?php echo e(route('supplier.store.delete', $retailer->id)); ?>" class="btn btn-danger">Yes, I am</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="d-flex justify-content-center">  <?php echo $retailers->links(); ?></div>

        <?php else: ?>
            <section id="data-thumb-view" class="data-thumb-view-header">
                <div class="table-responsive">
                    <table id="dt-product" class="table data-thumb-view p-0">
                        <thead>
                        <th class="pl-1">#</th>
                        <th>NAME</th>
                        <th>PRODUCTS</th>
                        <th>ORDERS</th>
                        <th>Payment Plan</th>
                        <th>Expiry Date</th>
                        <th>Free User</th>
                        <th>STATUS</th>
                        <th class="text-right">ACTION</th>
                        </thead>
                        <tbody>
                        <?php if(count($suppliers) < 1): ?>
                            <tr>
                                <td colspan="3" class="text-center"><strong>No supplier found.</strong></td>
                            </tr>
                        <?php else: ?>
                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($count++); ?></td>
                                    <td class="product-name text-capitalize py-2">
                                        <a href="<?php echo e(route('admin.supplier', $supplier->id)); ?>"><?php echo e($supplier->name); ?></a></td>
                                    <td class="product-name"><?php echo e(count($supplier->products)); ?></td>
                                    <td class="product-name"><?php echo e(count($supplier->supplier_orders)); ?></td>
                                    <td>
                                        <?php if($supplier->subscribed('Supplier Monthly Plan - SmokeDrop')): ?>
                                            
                                            <?php if(!$supplier->subscription('Supplier Monthly Plan - SmokeDrop')->cancelled()): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Cancelled</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if($supplier->onGenericTrial()): ?>
                                                <span class="badge badge-info">Trial</span>
                                                <?php else: ?>
                                                <?php if($supplier->free_user == 1): ?>
                                                    <span class="badge badge-primary">Free User</span>
                                                    <?php else: ?>
                                            <span class="badge badge-warning">No Subscription</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($supplier->subscribed('Supplier Monthly Plan - SmokeDrop')): ?>
                                            <?php echo e(date_create($supplier->subscription('Supplier Monthly Plan - SmokeDrop')->created_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')); ?>

                                            <?php else: ?>
                                            <?php if($supplier->onGenericTrial()): ?>
                                                <?php echo e(date_create($supplier->trial_ends_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')); ?>

                                                <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="product-name">
                                        <form  action="<?php echo e(route('admin.change.supplier.free.status', $supplier->id)); ?>">
                                            <span data-toggle="tooltip" title="Turn it on to active and off for free-user-subscription of this supplier">
                                            <input class="js-switch" <?php if($supplier->free_user == 1): ?> checked <?php endif; ?> type="checkbox" name="free_user">
                                            </span>
                                        </form>
                                    </td>

                                    <td class="product-name">
                                        <form id="form-change-supplier-status-<?php echo e($supplier->id); ?>" action="<?php echo e(route('admin.change.supplier.status', $supplier->id)); ?>">
                                            <span data-toggle="tooltip" title="Turn it on to active and off to disable this supplier">
                                            <input class="js-switch" <?php if($supplier->status == 1): ?> checked <?php endif; ?> type="checkbox" name="status" id="<?php echo e($supplier->id); ?>">
                                            </span>
                                        </form>
                                    </td>
                                    <td class="text-right">
                                        <a href="<?php echo e(route('admin.supplier', $supplier->id)); ?>" class="text-primary"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                        <a  class="text-primary" data-toggle="modal" data-target="#deleteRetailerConfirmationModal<?php echo e($supplier->id); ?>"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                                    </td>
                                    <div class="modal" id="deleteRetailerConfirmationModal<?php echo e($supplier->id); ?>">
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
                                                    <a href="<?php echo e(route('supplier.store.delete', $supplier->id)); ?>" class="btn btn-danger">Yes, I am</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="d-flex justify-content-center">  <?php echo $suppliers->links(); ?></div>
        <?php endif; ?>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    < <!-- BEGIN: Page Vendor JS-->
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
        $('.js-switch').change(function () {
            $(this).parent().parent().submit();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Dropship-Republic\resources\views/users/index.blade.php ENDPATH**/ ?>