<?php $__env->startSection('title', 'Orders'); ?>

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
    <div hidden id="page-type">my products</div>
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

    <div class="content-body">
        <div class="row mt-2">
            <div class="col-xl-12 d-inline-block">
                <div class="page-title-box d-inline-block">
                    <h4 class="page-title  float-left">Orders</h4>
                    <div class="clearfix"></div>
                </div>
                <form class="pull-right d-flex" action="<?php echo e(route('admin.orders')); ?>" method="get">
                    <fieldset class="form-group mr-1">
                        <select name="filter-by-supplier" class="form-control d-inline-block">
                            <option value=""> All Suppliers</option>
                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($querySupplier == $supplier->name): ?> selected <?php endif; ?> value="<?php echo e($supplier->name); ?>"><?php echo e($supplier->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                    </fieldset>
                    <fieldset class="form-group mr-1">
                        <select name="filter-by-store" class="form-control d-inline-block">
                            <option value=""> All Stores</option>
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($queryStore == $store->name): ?> selected <?php endif; ?> value="<?php echo e($store->name); ?>"><?php echo e($store->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        
                    </fieldset>
                    <fieldset class="form-group mr-1">
                        <select name="filter-by-status" class="form-control d-inline-block">
                            <option  value="">All Orders</option>
                            <option <?php if($queryStatus == 'pending'): ?> selected <?php endif; ?> value="pending">New Orders</option>
                            <option <?php if($queryStatus == 'ordered'): ?> selected <?php endif; ?> value="ordered" >Ordered</option>

                            <option <?php if($queryStatus == 'shipped'): ?> selected <?php endif; ?> value="shipped" >Shipped</option>
                        </select>
                    </fieldset>
                    <div class="mr-1">
                        <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- dataTable starts -->
        <section id="data-thumb-view" class="data-thumb-view-header">
            <div class="table-responsive">
                <table id="dt-product" class="table data-thumb-view p-0">
                    <thead>
                    <th class="pl-1">ORDER</th>
                    <th>FULFILLMENT</th>
                    <th>SUPPLIER</th>
                    <th>TOTAL (incl. Tax)</th>
                    <th>CREATED</th>
                    <th class="text-right" width="15%">ACTION</th>
                    </thead>
                    <tbody>
                    <?php if(count($orders) > 0): ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="py-2">
                                    <?php if($order->retailer_order != null): ?>
                                        <a href="<?php echo e(route('admin.orders.with.details', $order->id)); ?>">
                                        <?php echo e($order->retailer_order->name); ?>

                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>

                                    <?php if($order->fulfillment_status == null): ?>
                                        <div class="badge badge-warning">pending</div>
                                    <?php elseif($order->fulfillment_status == 'fulfilled'): ?>
                                        <div class="badge badge-success"><?php echo e($order->fulfillment_status); ?></div>
                                    <?php else: ?>
                                        <div class="badge badge-secondary">not fulfilled</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($order->supplier->name); ?>

                                </td>
                                <td>$<?php echo e($order->retailer_order->total_price_usd); ?></td>
                                <td>
                                    <?php if(Carbon\Carbon::parse($order->created_at)->isToday()): ?>
                                        <?php echo e(Carbon\Carbon::parse($order->created_at)->diffForHumans()); ?>

                                    <?php else: ?>
                                        <?php echo e(Carbon\Carbon::parse($order->created_at)->isoFormat('MMM Do YYYY, h:mm a')); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <a class="text-primary" href="<?php echo e(route('admin.orders.with.details', $order->id)); ?>"><i class="fa fa-eye" style="font-size: 18px"></i></a>
                                    <a class="text-primary"><i class="fa fa-trash" style="font-size: 18px"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center"><strong>No order found.</strong></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="d-flex justify-content-center">  <?php echo $orders->links(); ?></div>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Dropship-Republic\resources\views/orders/index.blade.php ENDPATH**/ ?>