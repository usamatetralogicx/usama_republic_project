<?php if(isset($retailer)): ?>
    <?php $__env->startSection('title', $retailer->name); ?>
<?php else: ?>
    <?php $__env->startSection('title', $supplier->name); ?>
<?php endif; ?>

<?php $__env->startSection('style_sheets'); ?>

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/app-user.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/coming-soon.css')); ?>">
    <!-- END: Page CSS-->

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/tables/datatable/datatables.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/plugins/file-uploaders/dropzone.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/data-list-view.css')); ?>">
    <!-- END: Page CSS-->

    <link href="<?php echo e(asset('dist/switchery/switchery.min.css')); ?>" rel="stylesheet"/>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <style>
        .mr10 {
            margin-right: 10px;
        }
    </style>
    <?php if(isset($retailer)): ?>
        <!-- users edit start -->
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <span class="nav-link mr-5">
                           <span class="font-weight-bolder">Retailer: <?php echo e($retailer->name); ?></span>
                       </span>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item mr10">
                                <a class="nav-link  d-flex align-items-center active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-selected="true">
                                    
                                    <span class="d-none d-sm-block">Products</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-selected="false">
                                    
                                    <span class="d-none d-sm-block">Orders</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-selected="false">
                                    
                                    <span class="d-none d-sm-block">Payments</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Settings</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#reffer_suppliers" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Referral Suppliers</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="products" aria-labelledby="products-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <fieldset class="filter pull-right d-flex">
                                    <form class=" d-flex" action="<?php echo e(route('admin.retailer',$retailer->id)); ?>" method="get">
                                        <fieldset class="form-group mr-1">
                                            <input id="filter-by-name-id" type="search" value="<?php echo e($queryName); ?>" name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
                                        </fieldset>
                                        <div class="mr-1">
                                            <button class="btn btn-round btn-primary d-inline-block"> Filter </button>
                                        </div>
                                    </form>
                                </fieldset>
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view table-hover-animation">
                                            <thead>
                                            <tr>
                                                <th width="10%">Image</th>
                                                <th>NAME</th>
                                                <th>PRICE</th>
                                                <th>COST</th>
                                                <th>IMPORT TO SHOPIFY</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(count($retailer_products) < 1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>Retailer has no product.</strong></td>
                                                </tr>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $retailer_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr data-selected-product-id="<?php echo e($product->id); ?>">
                                                        <td class="product-img">
                                                            <?php if($product->linked_supplier_product != null): ?>
                                                                <a href="<?php echo e(route('product.show', $product->linked_supplier_product->id)); ?>" class="text-primary">
                                                                    <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->title); ?>" height="70px" width="auto">
                                                                    <?php else: ?>
                                                                        <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->title); ?>" height="70px" width="auto">
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="product-name">
                                                            <?php if($product->linked_supplier_product != null): ?>
                                                                <a href="<?php echo e(route('product.show', $product->linked_supplier_product->id)); ?>" class="text-primary">
                                                                    <?php echo e($product->title); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <?php echo e($product->title); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td>$<?php echo e(number_format($product->price,2)); ?></td>
                                                        <td>$<?php echo e(number_format($product->cost,2)); ?></td>
                                                        <td>
                                                            <?php if($product->toShopify == 1): ?>
                                                                <span class="badge badge-success">Yes</span>
                                                            <?php else: ?>
                                                                <span class="badge badge-warning">No</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <?php if($product->linked_supplier_product != null): ?>
                                                            <td class="product-action text-right">
                                                                <a href="<?php echo e(route('product.show', $product->linked_supplier_product->id)); ?>" class="text-primary"><i class="fa fa-eye" style="font-size: 18px;"></i></a>

                                                            </td>
                                                        <?php else: ?>
                                                            <td class="text-right">Not Linked to Any Supplier</td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <!-- dataTable ends -->
                                    </div>
                                </section>


                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view p-0">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>CREATED ON</th>
                                                <th>TOTAL (incl.Tax)</th>
                                                <th>STATUS</th>
                                                <th>SUPPLIER ORDER STATUS</th>
                                                <th>ASSIGNED TO SUPPLIER</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(count($retailer_orders) < 1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>Retailer has no order</strong></td>
                                                </tr>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $retailer_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retailer_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr data-selected-product-id="<?php echo e($retailer_order->id); ?>">
                                                        <td class="product-name"><?php echo e($retailer_order->name); ?></td>
                                                        <td class="product-name"><?php echo e(\Illuminate\Support\Carbon::parse($retailer_order->shopify_created_at)->diffForHumans()); ?></td>
                                                        <td class="product-name">$<?php echo e(number_format($retailer_order->total_price, 2)); ?></td>
                                                        <td class="product-name">
                                                            <?php if($retailer_order->financial_status != 'paid'): ?>
                                                                <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                    <?php echo e($retailer_order->financial_status); ?>

                                                                </div>
                                                            <?php elseif($retailer_order->financial_status == null): ?>
                                                                <div class="badge badge-secondary text-capitalize" style="font-size: 10px">
                                                                    Not paid
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                                    <?php echo e($retailer_order->financial_status); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="product-name">
                                                            <?php if(count($retailer_order->supplier_orders) == 0): ?>
                                                                <div class="badge badge-info text-capitalize" style="font-size: 10px">
                                                                    New Order
                                                                </div>
                                                            <?php else: ?>

                                                                <?php if($retailer_order->supplier_orders->first()->financial_status != 'fulfilled'): ?>
                                                                    <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                        <?php echo e($retailer_order->supplier_orders->first()->financial_status); ?>

                                                                    </div>
                                                                <?php elseif($retailer_order->supplier_orders->first()->fulfillment_status == null): ?>
                                                                    <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                        Not Fulfilled
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                                        <?php echo e($retailer_order->supplier_orders->first()->fulfillment_status); ?>

                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="product-name">
                                                            <?php if($retailer_order->send_to_supplier == 1): ?>
                                                                <div class="badge badge-success text-capitalize px-2" style="font-size: 10px">
                                                                    Yes
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="badge badge-warning text-capitalize px-2" style="font-size: 10px">
                                                                    No
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td class="product-action text-right">
                                                            <a data-toggle="modal" data-target="#retailerOrderDetailsModal<?php echo e($retailer_order->id); ?>" class="text-primary">
                                                                <i class="fa fa-eye" style="font-size: 18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <?php if(count($retailer_orders)  > 0): ?>
                                            <?php $__currentLoopData = $retailer_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retailer_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="modal" id="retailerOrderDetailsModal<?php echo e($retailer_order->id); ?>">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Order <?php echo e($retailer_order->name); ?>'s Details</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                    <th>ITEM</th>
                                                                    <th>QTY</th>
                                                                    <th>VENDOR</th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php $__currentLoopData = $retailer_order->hasLineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td><?php echo e($line_item->name); ?></td>
                                                                            <td><?php echo e($line_item->quantity); ?></td>
                                                                            <td><?php echo e($line_item->vendor); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane" id="payments" aria-labelledby="payments-tab" role="tabpanel">
                                <!-- coming soon flat design -->

                                <div class="card">
                                    <div class="card-body">
                                        <table class="table data-thumb-view p-0">
                                            <thead>
                                            <th class="pl-1">Order</th>
                                            <th>Amount</th>
                                            <th>Receipt</th>
                                            <th>Transaction Date</th>
                                            <tbody>
                                            <?php if(count($retailer_orders) > 0): ?>
                                                <?php $__currentLoopData = $retailer_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($order->transaction != null): ?>
                                                        <tr>
                                                            <td><?php echo e($order->transaction->order->name); ?></td>
                                                            <td>
                                                                $<?php echo e(number_format($order->transaction->transaction_amount,2)); ?>

                                                            </td>
                                                            <td><a target="_blank" href="<?php echo e($order->transaction->receipt_url); ?>"> View Receipt</a></td>
                                                            <td><?php echo e(date_create($order->transaction->created_at)->format('M d Y - H:i a')); ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center"><strong>No Transaction History Found.</strong></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            <!--/ coming soon flat design -->
                            </div>
                            <div class="tab-pane" id="settings" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Retailer markup settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Global Pricing Rules &nbsp;</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Supplier can assign a fixed markup or multiplier that will apply to all of the products"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <form action="<?php echo e(route('markup.settings')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Markup</label>
                                                        <input type="text" class="form-control" readonly required name="markup_value"
                                                               <?php if(isset($retailer_markup_settings)): ?> value="<?php echo e($retailer_markup_settings->value); ?>"
                                                               <?php endif; ?> id="inputMarkupValue" placeholder="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupType">Markup Type</label>
                                                        <select required class="form-control" readonly name="markup_type" id="inputMarkupType">
                                                            <option value="0">-- Select One --</option>
                                                            <option value="percentage"
                                                                    <?php if(isset($retailer_markup_settings)): ?> <?php if($retailer_markup_settings->type == 'percentage'): ?> selected <?php endif; ?> <?php endif; ?>>Percent
                                                            </option>
                                                            <option value="fixed" <?php if(isset($retailer_markup_settings)): ?> <?php if($retailer_markup_settings->type == 'fixed'): ?> selected <?php endif; ?> <?php endif; ?>>Fixed
                                                            </option>
                                                            <option value="multiplier"
                                                                    <?php if(isset($retailer_markup_settings)): ?> <?php if($retailer_markup_settings->type == 'multiplier'): ?> selected <?php endif; ?> <?php endif; ?>>Multiplier
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="checkbox" name="ask_every_time" readonly
                                                               <?php if(isset($retailer_markup_settings)): ?> <?php if($retailer_markup_settings->ask_every_time): ?> checked
                                                               <?php endif; ?> <?php endif; ?> id="inputAskEveryTime">
                                                        <label for="inputAskEveryTime">Ask for profit margin every time importing product</label>
                                                    </div>
                                                </div>
                                                
                                            </form>

                                        </div>
                                    </div>
                                </section>
                                <!-- Retailer markup settings: END -->
                            </div>
                            <div class="tab-pane" id="reffer_suppliers" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Retailer markup settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Referral Suppliers List</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Store attached suppliers list"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <?php if(count($shop->attached_suppliers) > 0): ?>

                                                <table class="table data-thumb-view p-0">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Supplier</th>
                                                    <th>Referral Code</th>
                                                    <th></th>
                                                    </thead>
                                                    <tbody>
                                                    <?php $__currentLoopData = $shop->attached_suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($index+1); ?></td>
                                                            <td><?php echo e($supplier->name); ?></td>
                                                            <td><?php echo e($supplier->referral_code); ?></td>
                                                            <td class="text-right"><i onclick="window.location.href='<?php echo e(route('settings.detach.supplier.store',['supplier_id'=>$supplier->id,'store_id'=>$shop->id])); ?>'" title="Detach Supplier" class="fa fa-trash font-medium-3" style="cursor: pointer"></i></td>

                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p>No Referral Suppliers Attached</p>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </section>
                                <!-- Retailer markup settings: END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- users edit ends -->
    <?php else: ?>
        <section class="users-edit">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                       <span class="nav-link mr-5">
                           <span class="font-weight-bolder">Supplier: <?php echo e($supplier->name); ?></span>
                       </span>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center active" id="personal-tab" data-toggle="tab" href="#personal" aria-controls="account" role="tab" aria-selected="true">
                                    <span class="d-none d-sm-block">Personal Information</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center " id="products-tab" data-toggle="tab" href="#products" aria-controls="account" role="tab" aria-selected="true">
                                    <span class="d-none d-sm-block">Products</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="orders-tab" data-toggle="tab" href="#orders" aria-controls="information" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Orders</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="stores-tab" data-toggle="tab" href="#stores" aria-controls="stores" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Stores</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="payments-tab" data-toggle="tab" href="#payments" aria-controls="social" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Payments</span>
                                </a>
                            </li>
                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Settings</span>
                                </a>
                            </li>

                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#trail" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Trail Details</span>
                                </a>
                            </li>

                            <li class="nav-item mr10">
                                <a class="nav-link d-flex align-items-center" id="settings-tab" data-toggle="tab" href="#reffer_stores" role="tab" aria-selected="false">
                                    <span class="d-none d-sm-block">Referral Stores</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="personal" aria-labelledby="products-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->

                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>EMAIL</th>
                                                <th>COMPANY NAME</th>
                                                <th>PHONE</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Country</th>

                                            </tr>
                                            </thead>
                                            <tbody>

                                            <tr>
                                                <td class="product-img">
                                                    <?php echo e($supplier->name); ?>

                                                </td>
                                                <td class="product-name">
                                                    <?php echo e($supplier->email); ?>

                                                </td>
                                                <td class="product-name">
                                                    <?php echo e($supplier->company_name); ?>

                                                </td>
                                                <td class="product-name">
                                                    <?php echo e($supplier->phone); ?>

                                                </td>
                                                <td> <?php echo e($supplier->address); ?> <?php echo e($supplier->address2); ?> </td>
                                                <td> <?php echo e($supplier->city); ?>  </td>
                                                <td> <?php echo e($supplier->state); ?>  </td>
                                                <td> <?php echo e($supplier->country); ?>  </td>
































                                            </tr>
                                            </tbody>
                                        </table>
                                        <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane " id="products" aria-labelledby="products-tab" role="tabpanel">
                                <fieldset class="filter pull-right d-flex">
                                    <form class=" d-flex" action="<?php echo e(route('admin.supplier',$supplier->id)); ?>" method="get">
                                        <fieldset class="form-group mr-1">
                                            <input id="filter-by-name-id" type="search" value="<?php echo e($queryName); ?>" name="filter-by-name" class="form-control d-inline-block" placeholder="Search by Name">
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
                                </fieldset>
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->

                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view">
                                            <thead>
                                            <tr>
                                                <th width="10%">Image</th>
                                                <th>NAME</th>
                                                <th>PRICE</th>
                                                <th>ADDED TO IMPORT LIST</th>
                                                <th>STATUS</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(count($supplier_products) < 1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>retailer has no product</strong></td>
                                                </tr>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $supplier_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr data-selected-product-id="<?php echo e($product->id); ?>">
                                                        <td class="product-img"><a href="<?php echo e(route('products.show', $product->id)); ?>" class="text-primary">
                                                                <img src="<?php echo e($product->image); ?>" alt="<?php echo e($product->title); ?>" height="100px" width="auto">
                                                            </a>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="text-primary">
                                                                <?php echo e($product->title); ?>

                                                            </a>
                                                        </td>
                                                        <td>$<?php echo e(number_format($product->price,2)); ?></td>
                                                        <td class="product-name"><?php echo e($product->sold_count); ?> times</td>
                                                        <td class="product-name">
                                                            <form id="form-change-product-status-<?php echo e($product->id); ?>" action="<?php echo e(route('admin.change.product.status', $product->id)); ?>">
                                                            <span data-toggle="tooltip" title="Turn it on to active and off to disable this product">
                                                                <input class="js-switch" <?php if($product->status == 1): ?> checked <?php endif; ?> type="checkbox" name="status" id="<?php echo e($product->id); ?>">
                                                            </span>
                                                            </form>
                                                        </td>
                                                        <td class="product-action text-right">
                                                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="text-primary">
                                                                <i class="fa fa-eye" style="font-size: 18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                        <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->

                                <div class="d-flex justify-content-center">  <?php echo $supplier_products->links(); ?></div>
                            </div>
                            <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                                <!-- Data list view starts -->
                                <section id="data-thumb-view" class="data-thumb-view-header">
                                    <!-- dataTable starts -->
                                    <div class="table-responsive">
                                        <table id="dt-product" class="table data-thumb-view table-hover-animation">
                                            <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>CREATED ON</th>
                                                <th>TOTAL (excl. Tax)</th>
                                                <th>STATUS</th>
                                                <th class="text-right">ACTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(count($supplier_orders) < 1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center"><strong>Retailer has no order</strong></td>
                                                </tr>
                                            <?php else: ?>
                                                <?php $__currentLoopData = $supplier_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr data-selected-product-id="<?php echo e($supplier_order->id); ?>">
                                                        <td class="product-name"><?php echo e($supplier_order->retailer_order->name); ?></td>
                                                        <td class="product-name"><?php echo e(\Illuminate\Support\Carbon::parse($supplier_order->created_at)->diffForHumans()); ?></td>
                                                        <td class="product-name">
                                                            <?php ($order_total=0); ?>
                                                            <?php $__currentLoopData = $supplier_order->hasLineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                $order_total = $order_total + ($item->quantity * $item->price);
                                                                ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            $<?php echo e(number_format($order_total, 2)); ?>

                                                        </td>
                                                        <td class="product-name">
                                                            <?php if($supplier_order->financial_status != 'fulfilled'): ?>
                                                                <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                    <?php echo e($supplier_order->financial_status); ?>

                                                                </div>
                                                            <?php elseif($supplier_order->fulfillment_status == null): ?>
                                                                <div class="badge badge-warning text-capitalize" style="font-size: 10px">
                                                                    Not Fulfilled
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="badge badge-success text-capitalize" style="font-size: 10px">
                                                                    <?php echo e($retailer_order->fulfillment_status); ?>

                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="product-action text-right">
                                                            <a data-toggle="modal" data-target="#supplierOrderDetailsModal<?php echo e($supplier_order->id); ?>" class="text-primary"><i class="fa fa-eye" style="font-size: 18px;"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>

                                        <?php if(count($supplier_orders ) > 0): ?>
                                            <?php $__currentLoopData = $supplier_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="modal" id="supplierOrderDetailsModal<?php echo e($supplier_order->id); ?>">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Order <?php echo e($supplier_order->retailer_order->name); ?>'s Details</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                    <th>ITEM</th>
                                                                    <th>QTY</th>
                                                                    <th>VENDOR</th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php $__currentLoopData = $supplier_order->hasLineItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            
                                                                            <td><?php echo e($line_item->name); ?></td>
                                                                            <td><?php echo e($line_item->quantity); ?></td>
                                                                            <td><?php echo e($line_item->vendor); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tbody>

                                                                </table>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <!-- dataTable ends -->
                                    </div>

                                </section>
                                <!-- Data list view end -->
                            </div>
                            <div class="tab-pane" id="stores" aria-labelledby="stores-tab" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table data-thumb-view table-hover-animation">
                                        <thead>
                                        <tr>
                                            <th>SHOP DOMAIN</th>
                                            <th>PRODUCTS FETCHED</th>
                                            <th class="text-right">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($supplier_stores) < 1): ?>
                                            <tr>
                                                <td colspan="3" class="text-center"><strong>This supplier has no store.</strong></td>
                                            </tr>
                                        <?php else: ?>
                                            <?php $__currentLoopData = $supplier_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="py-3"><?php echo e($store->shop_domain); ?></td>
                                                    <td class="py-3"><?php echo e($store->fetch_count); ?> times</td>
                                                    <td>
                                                        <a class="pull-right" href data-toggle="modal" data-target="#deleteShopConfirmationModal<?php echo e($store->id); ?>" style="font-size: 18px">
                                                            <span data-toggle="tooltip" title="Click to delete store"><i class="fa fa-trash" style="font-size: 18px;"></i></span>
                                                        </a>
                                                    </td>
                                                    <div class="modal" id="deleteShopConfirmationModal<?php echo e($store->id); ?>">
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
                                                                    <a href="<?php echo e(route('supplier.store.delete', $store->id)); ?>" class="btn btn-danger">Yes, I am</a>
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
                            </div>
                            <div class="tab-pane" id="payments" aria-labelledby="payments-tab" role="tabpanel">
                                <!-- coming soon flat design -->
                                <?php if($supplier->subscriptions != null): ?>

                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table data-thumb-view p-0">
                                                <thead>
                                                <th class="pl-1">Plan</th>
                                                <th>Status</th>
                                                <th>Price</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th></th>
                                                </thead>
                                                <tbody>
                                                <?php if(count($supplier->subscriptions) > 0): ?>
                                                    <?php $__currentLoopData = $supplier->subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($s->name); ?></td>
                                                            <td>
                                                                <?php if($s->stripe_status == 'canceled'): ?>
                                                                    <div class="badge badge-warning">cancelled</div>
                                                                <?php elseif($s->stripe_status == 'active'): ?>
                                                                    <div class="badge badge-success">active</div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>$49.00</td>
                                                            <td><?php echo e(date_create($s->created_at)->format('M d Y')); ?></td>
                                                            <td><?php if($s->ends_at != null): ?><?php echo e(date_create($s->ends_at)->format('M d Y')); ?> <?php else: ?> <?php echo e(date_create($s->created_at)->add(new DateInterval('P30D'))->format('M d Y')); ?> <?php endif; ?></td>
                                                            
                                                            <td><a target="_blank" href="<?php echo e($supplier->invoices()[$index]->hosted_invoice_url); ?>">View Invoice</a></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center"><strong>No Subscription History Found.</strong></td>
                                                    </tr>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                            <?php endif; ?>

                            <!--/ coming soon flat design -->
                            </div>
                            <div class="tab-pane" id="settings" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Supplier shipping settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Shipping &nbsp;</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Supplier can set shipping prices and estimated shipping time"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <form action="<?php echo e(route('supplier.shipping.settings')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Shipping Price</label>
                                                        <input type="text" class="form-control" readonly="" required name="shipping_price"
                                                               <?php if(isset($supplier_settings)): ?> value="<?php echo e($supplier_settings->shipping_price); ?>"
                                                               <?php endif; ?> id="inputMarkupValue" placeholder="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Shipping Estimate  <!-- &nbsp;&nbsp;<span class="text-black-50">in days </span> --> <i
                                                                class="fa fa-info-circle" data-toggle="tooltip"
                                                                title="Estimated shipping time set by supplier e.g. if 2 days selected then retailer will see 1 - 3 days estimated shipping time"></i></label>
                                                        <input type="text" class="form-control" readonly="" required name="shipping_estimate"
                                                               <?php if(isset($supplier_settings)): ?> value="<?php echo e($supplier_settings->shipping_estimate); ?>"
                                                               <?php endif; ?> id="inputMarkupValue" placeholder="">
                                                    </div>
                                                </div>
                                                
                                            </form>

                                        </div>
                                    </div>
                                </section>
                                <!-- Supplier shipping settings: END -->


                                <!-- Supplier markup settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Global Pricing Rules &nbsp;</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Supplier can assign a fixed markup or multiplier that will apply to all of the products"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <form action="<?php echo e(route('markup.settings')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupValue">Markup</label>
                                                        <input type="text" class="form-control" readonly required name="markup_value"
                                                               <?php if(isset($supplier_markup_settings)): ?> value="<?php echo e($supplier_markup_settings->value); ?>"
                                                               <?php endif; ?> id="inputMarkupValue" placeholder="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputMarkupType">Markup Type</label>
                                                        <select required class="form-control" readonly name="markup_type" value id="inputMarkupType">
                                                            <option value="0">-- Select One --</option>
                                                            <option value="percentage"
                                                                    <?php if(isset($supplier_markup_settings)): ?> <?php if($supplier_markup_settings->type == 'percentage'): ?> selected <?php endif; ?> <?php endif; ?>>Percent
                                                            </option>
                                                            <option value="fixed" <?php if(isset($supplier_markup_settings)): ?> <?php if($supplier_markup_settings->type == 'fixed'): ?> selected <?php endif; ?> <?php endif; ?>>Fixed
                                                            </option>
                                                            <option value="multiplier"
                                                                    <?php if(isset($supplier_markup_settings)): ?> <?php if($supplier_markup_settings->type == 'multiplier'): ?> selected <?php endif; ?> <?php endif; ?>>Multiplier
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="checkbox" name="ask_every_time" readonly <?php if(isset($markup_settings)): ?> <?php if($markup_settings->ask_every_time): ?> checked
                                                               <?php endif; ?> <?php endif; ?> id="inputAskEveryTime">
                                                        <label for="inputAskEveryTime">Ask for profit margin every time importing product</label>
                                                    </div>
                                                </div>
                                                
                                            </form>

                                        </div>
                                    </div>
                                </section>
                                <!-- Supplier markup settings: END -->
                            </div>

                            <div class="tab-pane" id="trail" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Supplier shipping settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Trail Extension Setting</a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="Here You Can Extend The Trail Period Of Supplier"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <?php if($supplier->onGenericTrial()): ?>
                                                <div class="table-responsive">
                                                    <table id="dt-product" class="table data-thumb-view p-0">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="badge badge-info">Trial</span>
                                                            </td>
                                                            <td>
                                                                Ends at  <?php echo e(date_create($supplier->trial_ends_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')); ?>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('admin.change.supplier.trail',$supplier->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <section class="mt-1 row">
                                                    <div class="form-group col-md-3">
                                                        <label for="Email Address">User Name</label>
                                                        <input type="text" class="form-control" readonly value="<?php echo e($supplier->name); ?>">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="Email Address">Email Address</label>
                                                        <input type="text" class="form-control" readonly value="<?php echo e($supplier->email); ?>">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="Email Address">Trail Ends at</label>
                                                        <input type="date" name="trial_ends_at" class="form-control" min="<?php echo e(date_create($supplier->trial_ends_at)->format('Y-m-d')); ?>"  value="<?php echo e(date_create($supplier->trial_ends_at)->format('Y-m-d')); ?>">
                                                    </div>
                                                </section>
                                                <div class="row">
                                                    <div class=" col-md-3">
                                                        <button class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <div class="tab-pane" id="reffer_stores" aria-labelledby="settings-tab" role="tabpanel">
                                <!-- Supplier shipping settings: START -->
                                <section>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">
                                            <span style="color: #2c2c2c;">
                                                <a class="card-title">Referral Stores List </a>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="the stores who added supplier as referral"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mb-1">
                                        <div class="card-body py-0">


                                            <p >Referral Code: <input type="text" class="form-control" readonly value="<?php echo e($supplier->referral_code); ?>" style="width: 50%"></p>
                                            <div class="table-responsive">
                                                <table id="dt-product" class="table data-thumb-view p-0">
                                                    <?php if(count($supplier->restricted_stores) > 0): ?>
                                                        <table class="table data-thumb-view p-0">
                                                            <tbody>
                                                            <?php $__currentLoopData = $supplier->restricted_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><?php echo e($s->shopify_domain); ?></td>
                                                                    <td class="text-right"><i onclick="window.location.href='<?php echo e(route('settings.detach.supplier.store',['supplier_id'=>$supplier->id,'store_id'=>$s->id])); ?>'" title="Detach Store" class="fa fa-trash font-medium-3" style="cursor: pointer"></i></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    <?php else: ?>
                                                        <p>No Referral Stores Found</p>
                                                    <?php endif; ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo e(asset('vendors/js/forms/select/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/forms/validation/jqBootstrapValidation.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/pickers/pickadate/picker.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/pickers/pickadate/picker.date.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/coming-soon/jquery.countdown.min.js')); ?>"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo e(asset('js/scripts/pages/app-user.js')); ?>"></script>
    <script src="<?php echo e(asset('js/scripts/navs/navs.js')); ?>"></script>
    <script src="<?php echo e(asset('js/scripts/pages/coming-soon.js')); ?>"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo e(asset('vendors/js/extensions/dropzone.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/tables/datatable/dataTables.select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/tables/datatable/datatables.checkboxes.min.js')); ?>"></script>
    <!-- END: Page Vendor JS-->
    <script src="<?php echo e(asset('dist/switchery/switchery.min.js')); ?>"></script>

    <!-- BEGIN: Page JS-->
    <script src="<?php echo e(asset('js/scripts/ui/data-list-view.js')); ?>"></script>
    <!-- END: Page JS-->

    <script>

        //initialized switchery elements
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        $(function () {
            var $a = $(".tabs li");
            $a.click(function () {
                $a.removeClass("active");
                $(this).addClass("active");
            });

            $('.js-switch').change(function () {
                $(this).parent().parent().submit();
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.new_theme', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/users/show.blade.php ENDPATH**/ ?>