<?php $__env->startSection('title', 'View Order'); ?>

<?php $__env->startSection('css'); ?>
    <style>

        .tracking-detail {
            padding:3rem 0
        }
        #tracking {
            margin-bottom:1rem
        }
        [class*=tracking-status-] p {
            margin:0;
            font-size:1.1rem;
            color:#fff;
            text-transform:uppercase;
            text-align:center
        }
        [class*=tracking-status-] {
            padding:1.6rem 0
        }
        .tracking-status-intransit {
            background-color:#65aee0
        }
        .tracking-status-outfordelivery {
            background-color:#f5a551
        }
        .tracking-status-deliveryoffice {
            background-color:#f7dc6f
        }
        .tracking-status-delivered {
            background-color:#4cbb87
        }
        .tracking-status-attemptfail {
            background-color:#b789c7
        }
        .tracking-status-error,.tracking-status-exception {
            background-color:#d26759
        }
        .tracking-status-expired {
            background-color:#616e7d
        }
        .tracking-status-pending {
            background-color:#ccc
        }
        .tracking-status-inforeceived {
            background-color:#214977
        }
        .tracking-list {
            border:1px solid #e5e5e5
        }
        .tracking-item {
            border-left:1px solid #e5e5e5;
            position:relative;
            padding:2rem 1.5rem .5rem 2.5rem;
            font-size:.9rem;
            margin-left:3rem;
            min-height:5rem
        }
        .tracking-item:last-child {
            padding-bottom:4rem
        }
        .tracking-item .tracking-date {
            margin-bottom:.5rem
        }
        .tracking-item .tracking-date span {
            color:#888;
            font-size:85%;
            padding-left:.4rem
        }
        .tracking-item .tracking-content {
            padding:.5rem .8rem;
            background-color:#f4f4f4;
            border-radius:.5rem
        }
        .tracking-item .tracking-content span {
            display:block;
            color:#888;
            font-size:85%
        }
        .tracking-item .tracking-icon {
            /*line-height:2.6rem;*/
            position:absolute;
            left:-1.3rem;
            width:2.6rem;
            height:2.6rem;
            text-align:center;
            border-radius:50%;
            font-size:1.1rem;
            background-color:#fff;
            color:#fff
        }
        .tracking-item .tracking-icon.status-sponsored {
            background-color:#f68
        }
        .tracking-item .tracking-icon.status-delivered {
            background-color:#4cbb87
        }
        .tracking-item .tracking-icon.status-outfordelivery {
            background-color:#f5a551
        }
        .tracking-item .tracking-icon.status-deliveryoffice {
            background-color:#f7dc6f
        }
        .tracking-item .tracking-icon.status-attemptfail {
            background-color:#b789c7
        }
        .tracking-item .tracking-icon.status-exception {
            background-color:#d26759
        }
        .tracking-item .tracking-icon.status-inforeceived {
            background-color:#214977
        }
        .tracking-item .tracking-icon.status-intransit {
            color:#e5e5e5;
            border:1px solid #e5e5e5;
            font-size:.6rem
        }
        @media(min-width:992px) {
            .tracking-item {
                margin-left:10rem
            }
            .tracking-item .tracking-date {
                position:absolute;
                left:-10rem;
                width:7.5rem;
                text-align:right
            }
            .tracking-item .tracking-date span {
                display:block
            }
            .tracking-item .tracking-content {
                padding:0;
                background-color:transparent
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $payable_amount = 0; $supplier_array = [];$total_shipping= 0; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="py-1 text-justify">
                <b style="font-size: 28px;"><?php echo e($order_with_details[0]['order']->name); ?> </b> <?php echo e(\Carbon\Carbon::parse($order_with_details[0]['order']->shopify_created_at)->format('M d, Y') .' at '. \Carbon\Carbon::parse($order_with_details[0]['order']->shopify_created_at)->format('h:i a')); ?>

                <div class="badge badge-primary text-capitalize ml-2">
                    <?php echo e($order_with_details[0]['order']->financial_status); ?>

                </div>

                <?php if($order_with_details[0]['order']->fulfillment_status == 'partial'): ?>
                    <div class="badge badge-secondary text-capitalize">
                        Partially fulfilled
                    </div>
                <?php elseif($order_with_details[0]['order']->fulfillment_status == null): ?>
                    <div class="badge badge-warning text-capitalize">
                        Not fulfilled
                    </div>
                <?php else: ?>
                    <div class="badge badge-success text-capitalize">
                        <?php echo e($order_with_details[0]['order']->fulfillment_status); ?>

                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="col-md-4 text-right d-block align-self-center">
            <?php if($order_with_details[0]['order']->send_to_supplier == 1): ?>
                <div class="badge badge-success text-capitalize">
                    Ordered
                </div>
            <?php elseif($order_with_details[0]['order']->send_to_supplier == 0): ?>
                <div class='text-muted'>Not assigned to supplier</div>
            <?php else: ?>
                <div class="badge badge-secondary text-capitalize">
                    Completed
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <!-- Unfulfilled items section -->
            <?php if($order_with_details['unfulfilledItemsCount'] > 0): ?>
                <div class="pt-1 bg-white">
                    <h4 class="ml-1 font-weight-bold">Total Items (<?php echo e($order_with_details['unfulfilledItemsCount']); ?>)</h4>

                    <?php $__currentLoopData = $order_with_details[0]['order_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(($item['line_item']->quantity - $item['line_item']->fulfillable_quantity) >= 0): ?>
                            <?php if($item['line_item']->fulfillable_quantity != 0): ?>
                                <div class="ml-1 row">
                                    <div class="col-md-1 py-1 text-center">
                                        <img src="<?php echo e($item['variant_image']); ?>" alt="<?php echo e($item['line_item']->name); ?>" height="60px" width="60px">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center w-100">
                                        <div class="row w-100">
                                            <div class="col-md-8">
                                                <div class="pl-2">
                                                    <?php echo e($item['line_item']->title); ?>

                                                </div>
                                                <div class="pl-2 text-black-50">
                                                    <?php echo e($item['line_item']->variant_title); ?>

                                                </div>
                                                <div class="pl-2 text-black-50">
                                                    <?php echo e($item['line_item']->sku); ?>

                                                </div>
                                            </div>
                                            <?php if($item['supplier'] != '' || $item['supplier'] != null ): ?>
                                                <?php
                                                if (!in_array($item['supplier'], $supplier_array)) {
                                                    array_push($supplier_array, $item['supplier']);
                                                }
                                                ?>
                                                <div class="col-md-4">
                                                    <?php if(isset($item['supplier'])): ?>
                                                        <div class="badge badge-primary">
                                                            <?php echo e($item['supplier']); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-5 d-flex align-items-center w-100">
                                        <div class="row d-flex align-items-center justify-content-center w-100">
                                            <div class="pl-3 col-md-6 text-right p-0">
                                                <div>
                                                    <?php if( $order_with_details[0]['order']->currency == 'USD'): ?>
                                                        <?php if($item['line_item']->linked_retailer_product_variant != null): ?>
                                                            $<?php echo e(number_format($item['line_item']->linked_retailer_product_variant->cost, 2)); ?> <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> <?php echo e($item['line_item']->fulfillable_quantity); ?>

                                                        <?php else: ?>
                                                            $<?php echo e(number_format($item['line_item']->price, 2)); ?> <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> <?php echo e($item['line_item']->fulfillable_quantity); ?>

                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($item['line_item']->linked_retailer_product_variant != null): ?>
                                                            <?php echo e($order_with_details[0]['order']->currency .' '. $item['line_item']->linked_retailer_product_variant->cost); ?> <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> <?php echo e($item['line_item']->fulfillable_quantity); ?>

                                                        <?php else: ?>
                                                                $<?php echo e(number_format($item['line_item']->price, 2)); ?> <a
                                                                class="text-black-50">&nbsp;&nbsp;X&nbsp;&nbsp;</a> <?php echo e($item['line_item']->fulfillable_quantity); ?>

                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                            <div class="col-md-6 text-right">
                                                <?php
                                                    if($item['line_item']->linked_retailer_product_variant != null){
    $payable_amount = $payable_amount + ($item['line_item']->linked_retailer_product_variant->cost * $item['line_item']->fulfillable_quantity);
}
else{

}  $payable_amount = $payable_amount + ($item['line_item']->price * $item['line_item']->fulfillable_quantity);
                                                ?>
                                                <?php if( $order_with_details[0]['order']->currency == 'USD'): ?>
                                                    <?php if($item['line_item']->linked_retailer_product_variant != null): ?>
                                                    $<?php echo e(number_format($item['line_item']->linked_retailer_product_variant->cost * $item['line_item']->fulfillable_quantity, 2)); ?>

                                                    <?php else: ?>
                                                        $<?php echo e(number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2)); ?>

                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if($item['line_item']->linked_retailer_product_variant != null): ?>
                                                    <?php echo e($order_with_details[0]['order']->currency .' '. number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2)); ?>

                                                    <?php else: ?>
                                                        $<?php echo e(number_format($item['line_item']->price * $item['line_item']->fulfillable_quantity, 2)); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div>
                    <?php if($order_with_details[0]['order']->send_to_supplier != 1): ?>
                        <a data-toggle="modal" data-target="#makePaymentModal" class="btn btn-primary text-white">Make Payment</a>
                        <!-- The Modal -->
                        <div class="modal" id="makePaymentModal">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Select Payment Method</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <form action="<?php echo e(route('payment', $order_with_details[0]['order']->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body">
                                            <?php if(count(\Illuminate\Support\Facades\Auth::user()->payment_method) > 0): ?>
                                                <label for="">Select your payment method</label>
                                                <select name="payment_method" id="" class="form-control" required>
                                                    <option value="">Select Payment Method</option>
                                                    <?php $__currentLoopData = \Illuminate\Support\Facades\Auth::user()->payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($method->id); ?>">
                                                        <?php if($method->brand == 'Visa'): ?>
                                                            <i class="fa fa-cc-visa"></i>
                                                        <?php elseif($method->brand == 'MasterCard'): ?>
                                                            <i class="fa fa-cc-mastercard"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-credit-card"></i>
                                                        <?php endif; ?>
                                                        &nbsp;&nbsp; **** **** **** <?php echo e($method->last4); ?>

                                                    </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php
                                                foreach ($supplier_array as $supplier) {
                                                    $total_shipping = $total_shipping + \App\User::whereName($supplier)->first()->supplier_setting->shipping_price;
                                                }
                                                ?>
                                                <label class=" mt-1">Your payable amount (includes shipping)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" class="form-control" readonly value="<?php echo e(number_format(($payable_amount + $total_shipping), 2)); ?>" name="payable_amount">
                                                </div>
                                            <?php else: ?>
                                                <div><strong>Your do not have payment method setup</strong></div>
                                                <div><strong> <a href="<?php echo e(route('settings')); ?>">Click Here</a> to add you payment method</strong></div>

                                            <?php endif; ?>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <?php if(\Illuminate\Support\Facades\Auth::user()->payment_method != null): ?>
                                                <button type="submit" class="btn btn-primary">Confirm Payment</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


        <!-- Fulfilled items section -->
            <?php if(count($order_with_details[0]['order']->supplier_orders) > 0): ?>
                <h3 class="mt-2">Fulfillments History</h3>
            <?php endif; ?>

            <?php $__currentLoopData = $order_with_details[0]['order']->supplier_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($supplier_order) && count($supplier_order->fulfillments) > 0): ?>
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="text-justify">
                                <?php $__currentLoopData = $supplier_order->fulfillments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fulfillment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white mt-1 p-1">
                                        <div class="font-weight-bolder d-inline">
                                            <?php echo e(strtok($fulfillment->name, '.')  . ' - F'. explode('.', $fulfillment->name, 2)[1]); ?>


                                        </div>
                                        <span class="text-primary  text-capitalize">&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;&nbsp; <?php echo e(\App\User::find($fulfillment->supplier_id)->name); ?>  </span>
                                        <span class="text-primary  pull-right">&nbsp;&nbsp; <?php echo e(date_create($fulfillment->created_at)->format('Y-m-d h:i a')); ?>  </span>
                                        <?php $__currentLoopData = json_decode($fulfillment->line_items, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $get_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $item = new \App\SupplierOrderLineItem();
                                                $old_fulfillment_count = $get_item['fulfillable_quantity'] - $get_item['fulfilled_quantity'];
                                                $item->fill($get_item);
                                            ?>
                                            <div class="row">
                                                <div class="col-md-1 py-1 text-center">
                                                    <img src="<?php echo e($item->retailer_product_variant->retailer_product->image); ?>" alt="<?php echo e($item['title']); ?>" height="50px" width="50px">
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center w-100">
                                                    <div class="row w-100">
                                                        <div class="col-md-8">
                                                            <div class="pl-3">
                                                                <?php echo e($item['title']); ?>

                                                            </div>
                                                            <div class="pl-3 text-black-50">
                                                                <?php echo e($item['variant_title']); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-flex align-items-center w-100">
                                                    <div class="row d-flex align-items-center justify-content-center w-100">
                                                        <div class="col-md-12 text-right">
                                                            <div>
                                                                Fulfilled quantity: <?php echo e($item->fulfilled_quantity); ?>

                                                            </div>
                                                        </div>
                                                        <?php if($fulfillment->tracking_number != null): ?>
                                                            <div class="col-md-12 text-right">
                                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#editTrackingModal<?php echo e($fulfillment->id); ?>"
                                                                   target="_blank">  <?php echo e($fulfillment->tracking_number); ?></a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                    <?php if($fulfillment->tracking_number == null || $fulfillment->tracking_number == ''): ?>
                                        <div class="bg-white py-2 px-1">
                                            <a data-toggle="modal" data-target="#editTrackingModal<?php echo e($fulfillment->id); ?>" class="btn btn-primary text-white">Add tracking</a>
                                        </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="modal fade" id="editTrackingModal<?php echo e($fulfillment->id); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                                    <h4 class="modal-title">Edit Tracking</h4>
                                                    <?php endif; ?>
                                                    <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?>
                                                    <h4 class="modal-title">Tracking Details</h4>
                                                    <?php endif; ?>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form action="<?php echo e(route('supplier.add.fulfillment.tracking', $fulfillment->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="form-group" id="default_carrier">
                                                            <label for="">Tracking number</label>
                                                            <input type="text" <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?> readonly <?php endif; ?> placeholder="Enter tracking number" value="<?php echo e($fulfillment->tracking_number); ?>"
                                                            name="tracking_number"
                                                            class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Tracking URL</label>
                                                            <input name="tracking_url" <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?> readonly <?php endif; ?> placeholder="Enter tracking URL" value="<?php echo e($fulfillment->tracking_url); ?>"
                                                            class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Notes</label>
                                                            <textarea name="tracking_notes" <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?> readonly <?php endif; ?> class="form-control" placeholder="Enter tracking notes"
                                                            rows="10"><?php echo e($fulfillment->tracking_notes); ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                        <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        <!-- Payment History section -->
            <?php if(count($order_with_details[0]['order']->transactions) > 0): ?>
                <h3 class="mt-2">Payment History</h3>
            <?php endif; ?>

            <?php $__currentLoopData = $order_with_details[0]['order']->transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div id="tracking">
                            <div class="tracking-list bg-white">
                                <div class="tracking-item">
                                    <div class="tracking-icon status-intransit">
                                        <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 512 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                        </svg>
                                        <!-- <i class="fas fa-circle"></i> -->
                                    </div>
                                    <div class="tracking-date"><?php echo e(\Carbon\Carbon::parse($transaction->created_at)->toFormattedDateString()); ?>

                                        <span><?php echo e(\Carbon\Carbon::parse($transaction->created_at)->format('H:i A')); ?></span>
                                    </div>
                                    <div class="tracking-content">$<?php echo e($transaction->transaction_amount); ?>

                                        <span style="overflow: hidden;">
                                    		<a href="<?php echo e($transaction->receipt_url); ?>" target="_blank">View receipt</a>
                                    		
                                    	</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
        <div class="col-md-3 text-justify">

            <!--Notes section -->
            <div class="bg-white p-1">
                <h4>Notes</h4>
                <?php if($order_with_details[0]['order']->note == null): ?>
                    <p class="text-black-50">No notes from customer</p>
                <?php else: ?>
                    <p><?php echo e($order_with_details[0]['order']->note); ?></p>
                <?php endif; ?>

            </div>
            <!--Customers section -->
            <?php
                $customer = json_decode($order_with_details[0]['order']->customer, true);
                $customer_shipping_address = json_decode($order_with_details[0]['order']->shipping_address, true);
                $customer_billing_address = json_decode($order_with_details[0]['order']->billing_address, true);
            ?>
            <div class="mt-1 p-1 bg-white">
                <h4 class="">Customer</h4>
                <?php if($customer == null): ?>
                    <a class="text-black-50">No customer</a>
                <?php else: ?>
                    <div>
                        <a><?php echo e($customer['first_name'] .' '. $customer['last_name']); ?></a>
                    </div>
                    <div>
                        <?php if($customer['orders_count'] == 1): ?>
                            <a><?php echo e($customer['orders_count'] .' order'); ?></a>
                        <?php else: ?>
                            <a><?php echo e($customer['orders_count'] .' orders'); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="dropdown-divider"></div>
                <h6 class="text-capitalize">Customer Information</h6>
                <div class="">
                    <?php if($order_with_details[0]['order']->email == null): ?>
                        <a class="text-black-50">No email address</a>
                    <?php else: ?>
                        <a><?php echo e($order_with_details[0]['order']->email); ?></a>
                    <?php endif; ?>
                </div>
                <div class="">
                    <?php if($order_with_details[0]['order']->phone == null): ?>
                        <a class="text-black-50">No phone number</a>
                    <?php else: ?>
                        <a><?php echo e($order_with_details[0]['order']->phone); ?></a>
                    <?php endif; ?>
                </div>
                <div class="dropdown-divider"></div>
                <h6 class="text-capitalize">Shipping Address</h6>
                <div>
                    <?php if($order_with_details[0]['order']->shipping_address == null): ?>
                        <a class="text-black-50">No shipping address</a>
                    <?php else: ?>
                        <div>
                            <a><?php echo e($customer_shipping_address['name']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_shipping_address['address1']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_shipping_address['city']. ' ' . $customer_shipping_address['zip']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_shipping_address['country']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_shipping_address['phone']); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="dropdown-divider"></div>
                <h6 class="text-capitalize">Billing Address</h6>
                <div>
                    <?php if($order_with_details[0]['order']->billing_address == null): ?>
                        <a class="text-black-50">No billing address</a>
                    <?php elseif($customer_billing_address == $customer_shipping_address): ?>
                        <a class="text-black-50">Same as shipping address</a>
                    <?php else: ?>
                        <div>
                            <a><?php echo e($customer_billing_address['name']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_billing_address['address1']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_billing_address['city']. ' ' . $customer_billing_address['zip']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_billing_address['country']); ?></a>
                        </div>
                        <div>
                            <a><?php echo e($customer_billing_address['phone']); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/orders/show_old.blade.php ENDPATH**/ ?>