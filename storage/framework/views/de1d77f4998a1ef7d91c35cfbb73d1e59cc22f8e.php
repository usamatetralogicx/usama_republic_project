<?php $__env->startSection('title', 'Dashboard'); ?>



<?php $__env->startSection('content'); ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?php echo e(asset('js/equalizer.js')); ?>"></script>

    <div class="">
        <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?php echo e($productsCount); ?></h2>
                        <p>Products</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?php echo e($ordersCount); ?></h2>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">0%</h2>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">$0</h2>
                        <p>Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 ">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="mb-0">Suppliers</h4>
                    </div>
                    <div class="card-content pb-2">
                        <div class="table-responsive my-1 custom-align">
                            <table class="table table-hover-animation mb-0">
                                <thead>
                                <tr>
                                    <th width="20%">NAME</th>
                                    <th>STATUS</th>
                                    <th>ORDERS</th>
                                    <th>PRODUCTS</th>
                                    <th>START DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($supplier->name); ?></td>
                                        <td>
                                            <?php if($supplier->status == 1): ?>
                                                <i class="fa fa-circle font-small-3 text-success mr-50"></i>Active
                                            <?php else: ?>
                                                <i class="fa fa-circle font-small-3 text-danger mr-50"></i>Disabled
                                            <?php endif; ?>
                                        </td>
                                        <td class="pl-2"><?php echo e(count($supplier->supplier_orders)); ?></td>
                                        <td class="pl-2"><?php echo e(count($supplier->products)); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($supplier->created_at)->diffForHumans()); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <a class="pl-1 pb-1 position-absolute position-bottom-0" href="<?php echo e(route('admin.suppliers')); ?>">See more suppliers</a>
                    </div>
                </div>
            </div>
            <div class="col-6 ">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Retailers</h4>
                    </div>
                    <div class="card-content  pb-2">
                        <div class="table-responsive my-1  custom-align">
                            <table class="table table-hover-animation mb-0">
                                <thead>
                                <tr>
                                    <th width="20%">NAME</th>

                                    <th>ORDERS</th>
                                    <th>PRODUCTS</th>
                                    <th>START DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $retailers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retailer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($retailer->name); ?></td>







                                        <td class="pl-2"><?php echo e(count($retailer->retailer_orders)); ?></td>
                                        <td class="pl-2"><?php echo e(count($retailer->products)); ?></td>
                                        <td><?php echo e(\Carbon\Carbon::parse($retailer->created_at)->diffForHumans()); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <a class="pl-1 pb-1 position-absolute position-bottom-0" href="<?php echo e(route('admin.retailers')); ?>">See more retailers</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?php echo e($productsCount); ?></h2>
                        <p>Products</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?php echo e($ordersCount); ?></h2>
                        <p>Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">$<?php echo e(number_format($total_revenue,2)); ?></h2>

                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-package text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">$<?php echo e(number_format($total_profit, 2)); ?></h2>
                        <p>Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">



















































































        </div>
        <?php endif; ?>

        <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-primary p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-users text-primary font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?php echo e($productsCount); ?></h2>
                        <p>Products</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-warning p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-database text-warning font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1"><?php echo e($storesCount); ?></h2>
                        <p>Stores</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-danger p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-shopping-cart text-danger font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">$<?php echo e(number_format($total_revenue,2)); ?></h2>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header d-flex flex-column align-items-start pb-0">
                        <div class="avatar bg-rgba-success p-50 m-0">
                            <div class="avatar-content">
                                <i class="feather icon-credit-card text-success font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="text-bold-700 mt-1">$<?php echo e(number_format($total_profit,2)); ?></h2>
                        <p>Total Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">


















































































        </div>
        <?php endif; ?>
    </div>

    <script>

        var options = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'orders',
                data: [0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script>
        Equalizer('.custom-align').align();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.new_theme', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>