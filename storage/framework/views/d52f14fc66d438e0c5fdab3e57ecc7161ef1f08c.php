<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
    <section class="users-edit">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                       <span class="nav-link mr-5">
                           <span class="font-weight-bolder">Payments</span>
                       </span>
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item " style="margin-right: 10px">
                            <a class="nav-link d-flex align-items-center active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-selected="true">
                                
                                <span class="d-none d-sm-block">Suppliers Payments</span>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-right: 10px">
                            <a class="nav-link d-flex align-items-center" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-selected="false">
                                
                                <span class="d-none d-sm-block">Retailers Payments</span>
                            </a>
                        </li>
                        
                        
                        
                        
                        
                        
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="products" aria-labelledby="products-tab" role="tabpanel">
                            <!-- Data list view starts -->
                            <section id="data-thumb-view" class="data-thumb-view-header">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table data-thumb-view p-0">
                                            <thead>
                                            <th>Name</th>
                                            <th class="pl-1">Plan</th>
                                            <th>Status</th>
                                            <th>Price</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th></th>
                                            </thead>
                                            <tbody>
                                            <?php if(count($suppliers) > 0): ?>
                                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(count($supplier->subscriptions) > 0): ?>
                                                        <?php $__currentLoopData = $supplier->subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td> <a href="<?php echo e(route('admin.supplier', $supplier->id)); ?>"><?php echo e($supplier->name); ?></a></td>
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
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center"><strong>No Suppliers Subscription History Found.</strong></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <!-- Data list view end -->
                        </div>

                        <div class="tab-pane" id="orders" aria-labelledby="orders-tab" role="tabpanel">
                            <!-- Data list view starts -->
                            <section id="data-thumb-view" class="data-thumb-view-header">
                                <!-- dataTable starts -->
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table data-thumb-view p-0">
                                            <thead>
                                            <th>Store</th>
                                            <th class="pl-1">Order</th>
                                            <th>Amount</th>
                                            <th>Receipt</th>
                                            <th>Transaction Date</th>
                                            <tbody>
                                            <?php if(count($retailers) > 0): ?>
                                                <?php $__currentLoopData = $retailers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retailer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(count($retailer->retailer_orders) > 0): ?>
                                                    <?php $__currentLoopData = $retailer->retailer_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($order->transaction != null): ?>
                                                            <tr>
                                                                <td><a href="<?php echo e(route('admin.retailer', $retailer->id)); ?>"><?php echo e($retailer->name); ?></a></td>
                                                                <td><?php echo e($order->transaction->order->name); ?></td>
                                                                <td>
                                                                    $<?php echo e(number_format($order->transaction->transaction_amount,2)); ?>

                                                                </td>
                                                                <td><a target="_blank" href="<?php echo e($order->transaction->receipt_url); ?>"> View Receipt</a></td>
                                                                <td><?php echo e(date_create($order->transaction->created_at)->format('M d Y - H:i a')); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center"><strong>No Retailers Transaction History Found.</strong></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </section>
                            <!-- Data list view end -->
                        </div>
                        
                        

                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        


                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Dropship-Republic\resources\views/payments/admin/index.blade.php ENDPATH**/ ?>