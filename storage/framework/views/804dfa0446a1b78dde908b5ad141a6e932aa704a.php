<?php $__env->startSection('title', 'Settings'); ?>

<?php $__env->startSection('css'); ?>
    <style>
        body {
            margin-top: 20px;
            background: #F0F8FF;
        }

        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, .08);
        }

        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #e5e9f2;
            border-radius: .2rem;
        }

        .card-header:first-child {
            border-radius: calc(.2rem - 1px) calc(.2rem - 1px) 0 0;
        }

        .card-header {
            border-bottom-width: 1px;
        }

        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            color: inherit;
            background-color: #fff;
            border-bottom: 1px solid #e5e9f2;
        }

        body {
            background-color: #eee;
        }

        .content {
            margin-top: 40px;
        }

        .plan-one {
            margin: 0 0 20px 0;
            width: 100%;
            position: relative;
        }

        .plan-card {
            background: #fff;
            margin-bottom: 30px;
            transition: .5s;
            border: 0;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.5);
        }

        .plan-one .pricing-header {
            padding: 0;
            margin-bottom: 0;
            text-align: center;
        }

        .plan-one .pricing-header .plan-title {
            -webkit-border-radius: 10px 10px 0px 0px;
            -moz-border-radius: 10px 10px 0px 0px;
            border-radius: 10px 10px 0px 0px;
            font-size: 1.2rem;
            color: #ffffff;
            padding: 10px 0;
            font-weight: 600;
            background: #5a99ee;
            margin: 0;
        }

        .plan-one .pricing-header .plan-cost {
            color: #ffffff;
            background: #71a7f0;
            padding: 15px 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .plan-one .pricing-header .plan-save {
            color: #ffffff;
            background: #84b3f2;
            padding: 10px 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .plan-one .pricing-header.green .plan-title {
            background: #47BCC7;
        }

        .plan-one .pricing-header.green .plan-cost {
            background: #5bc3cd;
        }

        .plan-one .pricing-header.green .plan-save {
            background: #6ac9d2;
        }

        .plan-one .pricing-header.orange .plan-title {
            background: #fc8165;
        }

        .plan-one .pricing-header.orange .plan-cost {
            background: #fd967e;
        }

        .plan-one .pricing-header.orange .plan-save {
            background: #fdaa97;
        }

        .plan-one .plan-features {
            border: 1px solid #e6ecf3;
            border-top: 0;
            border-bottom: 0;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        .plan-one .plan-features li {
            padding: 10px 15px 10px 40px;
            margin: 5px 0;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            position: relative;
            border-bottom: 1px solid #e6ecf3;
            line-height: 100%;
        }

        .plan-one .plan-footer {
            border: 1px solid #e6ecf3;
            border-top: 0;
            background: #ffffff;
            -webkit-border-radius: 0 0 10px 10px;
            -moz-border-radius: 0 0 10px 10px;
            border-radius: 0 0 10px 10px;
            text-align: center;
            padding: 10px 0 30px 0;
        }

        @media (max-width: 575.98px){
            .header-navbar.floating-nav{
                width: 100%;
            }
        }

        @media (max-width: 767px) {
            .plan-one .pricing-header {
                text-align: center;
            }

            .plan-one .pricing-header i {
                display: block;
                float: none;
                margin-bottom: 20px;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


    <div class="mt-2">
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Settings</h4>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-5 col-xl-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-1">Account Settings</h5>
                    </div>


                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#accounts-info-tab" role="tab">
                            Account
                        </a>
                        <?php if($user->subscribed('Supplier Monthly Plan - SmokeDrop') || $user->onGenericTrial()): ?>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#shipping-tab" role="tab">
                                Shipping
                            </a>
                            <a class="list-group-item list-group-item-action " data-toggle="list" href="#global-pricing-tab" role="tab">
                                Global Pricing Rules
                            </a>
                        <?php endif; ?>

                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#subscription-tab" role="tab">
                            Plans
                        </a>
                        <?php if($user->subscribed('Supplier Monthly Plan - SmokeDrop')): ?>
                            <a class="list-group-item list-group-item-action " data-toggle="list" href="#history-tab" role="tab">
                                Subscription History
                            </a>
                        <?php endif; ?>
                        <a class="list-group-item list-group-item-action " data-toggle="list" href="#store-prefer-tab" role="tab">
                            Referral Stores
                        </a>
                    </div>
                    <?php endif; ?>

                    <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#accounts-tab" role="tab">
                            My Account
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#global-pricing-tab" role="tab">
                            Global Pricing Rules
                        </a>
                        <a class="list-group-item list-group-item-action " data-toggle="list" href="#payments-tab" role="tab">
                            Payments
                        </a>
                        <a class="list-group-item list-group-item-action " data-toggle="list" href="#transactions-tab" role="tab">
                            Transactions History
                        </a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#reffer-supplier-tab" role="tab">
                            Referral Suppliers
                        </a>

                    </div>
                    <?php endif; ?>
                    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#accounts-tab" role="tab">
                            My Account
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-7 col-xl-8">
                <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                <div class="tab-content">
                    <div class="tab-pane fade" id="history-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Subscription History</h5>
                            </div>
                        </div>
                        <?php if($user->subscriptions != null): ?>
                            <?php if(count($user->subscriptions) > 0): ?>
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
                                            <?php $__currentLoopData = $user->subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                    <td><?php echo e(date_create($s->created_at)->format('M d')); ?></td>
                                                    <td><?php if($s->ends_at != null): ?><?php echo e(date_create($s->ends_at)->format('M d')); ?> <?php else: ?> <?php echo e(date_create($s->created_at)->add(new DateInterval('P30D'))->format('M d')); ?> <?php endif; ?></td>
                                                    
                                                    <td><a target="_blank" href="<?php echo e($user->invoices()[$index]->hosted_invoice_url); ?>">View Invoice</a></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5> No Subscription History Found</h5>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="store-prefer-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Refferal Stores</h5>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                

                                
                                
                                
                                
                                
                                
                                

                                <div class="row">
                                    <div class="col-md-4">
                                        Referral Code
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" readonly value="<?php echo e($user->referral_code); ?>">
                                    </div>
                                </div>
                                <hr>
                                <h6 class="mt-1">Referral Stores List</h6>
                                <?php if(count($user->restricted_stores) > 0): ?>
                                    <table class="table data-thumb-view p-0">
                                        <tbody>
                                        <?php $__currentLoopData = $user->restricted_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($s->shopify_domain); ?></td>
                                                <td class="text-right"><i onclick="window.location.href='<?php echo e(route('settings.detach.supplier.store',['supplier_id'=>$user->id,'store_id'=>$s->id])); ?>'" title="Detach Store" class="fa fa-trash font-medium-3" style="cursor: pointer"></i></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p>No Referral Stores Attached</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="shipping-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <span style="color: #2c2c2c;"><a class="card-title">Shipping &nbsp;</a><i class="fa fa-info-circle" data-toggle="tooltip"
                                                                                                          title="You can set shipping prices and estimated shipping time"></i></span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo e(route('supplier.shipping.settings')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputMarkupValue">Shipping Price</label>
                                            <input type="text" class="form-control" required name="shipping_price" <?php if(isset($supplier_settings)): ?> value="<?php echo e($supplier_settings->shipping_price); ?>"
                                                   <?php endif; ?> id="inputMarkupValue" placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputMarkupValue">Shipping Estimate  <!-- &nbsp;&nbsp;<span class="text-black-50">in days </span> --> <i class="fa fa-info-circle"
                                                                                                                                                                 data-toggle="tooltip"
                                                                                                                                                                 title="You can set estimated shipping time e.g. if you choose 2 days then retailer will see 1 - 3 days estimated shipping time"></i></label>
                                            <input type="text" class="form-control" required name="shipping_estimate"
                                                   <?php if(isset($supplier_settings)): ?> value="<?php echo e($supplier_settings->shipping_estimate); ?>"
                                                   <?php endif; ?> id="inputMarkupValue" placeholder="">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="global-pricing-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <span style="color: #2c2c2c;"><a class="card-title">Global Pricing Rules &nbsp;</a><i class="fa fa-info-circle" data-toggle="tooltip"
                                                                                                                      title="You can assign a fixed markup or multiplier that will apply to all of your products"></i></span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo e(route('markup.settings')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputMarkupValue">Markup</label>
                                            <input type="text" class="form-control" required name="markup_value" <?php if(isset($markup_settings)): ?> value="<?php echo e($markup_settings->value); ?>"
                                                   <?php endif; ?> id="inputMarkupValue" placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputMarkupType">Markup Type</label>
                                            <select required class="form-control" name="markup_type"  id="inputMarkupType">
                                                <option value="0">-- Select One --</option>
                                                <option value="percentage" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->type == 'percentage'): ?> selected <?php endif; ?> <?php endif; ?>>Percent</option>
                                                <option value="fixed" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->type == 'fixed'): ?> selected <?php endif; ?> <?php endif; ?>>Fixed</option>
                                                <option value="multiplier" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->type == 'multiplier'): ?> selected <?php endif; ?> <?php endif; ?>>Multiplier</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="checkbox" name="ask_every_time" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->ask_every_time): ?> checked
                                                   <?php endif; ?> <?php endif; ?> id="inputAskEveryTime">
                                            <label for="inputAskEveryTime">Ask for profit margin every time importing product</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade  " id="accounts-info-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Account Information</h5>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo e(route('settings.supplier.info.update')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="supplier_id" value="<?php echo e($user->id); ?>">
                                    <input type="hidden" name="type" value="user">
                                    <div class="form-group">
                                        <label for="email-account">Email</label>
                                        <input id="email-account" type="email" class="form-control" readonly value="<?php echo e($user->email); ?>">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="username-account">User Name</label>
                                        <input id="username-account" name="name" type="text" class="form-control" value="<?php echo e($user->name); ?>">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="username-account">Company Name</label>
                                        <input id="username-account" name="company_name" type="text" class="form-control" value="<?php echo e($user->company_name); ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-2">Update Password</h6>
                                <form action="<?php echo e(route('settings.supplier.password.update')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="supplier_id" value="<?php echo e($user->id); ?>">
                                    <input type="hidden" name="email" value="<?php echo e($user->email); ?>">

                                    <div class="form-group">
                                        <label>Current Password</label>
                                        <input  name="password" type="password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input name="new-pw" type="password" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Repeat New Password</label>
                                        <input  name="new-pwr" type="password" class="form-control" required>
                                    </div>
                                    <a class="btn btn-primary text-white change-password-button">Save</a>

                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-2">Update Billing Address</h6>
                                <form action="<?php echo e(route('settings.supplier.info.update')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="supplier_id" value="<?php echo e($user->id); ?>">
                                    <input type="hidden" name="type" value="billing">
                                    <div class="form-group">
                                        <label>Address 1</label>
                                        <input  name="address1" type="text" class="form-control" required value="<?php echo e($user->address); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <input name="address2" type="text" class="form-control" required value="<?php echo e($user->address2); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >City</label>
                                                <input  name="city" type="text" class="form-control" required value="<?php echo e($user->city); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >State</label>
                                                <input  name="state" type="text" class="form-control" required value="<?php echo e($user->state); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Country</label>
                                                <input  name="country" type="text" class="form-control" required value="<?php echo e($user->country); ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <button class="btn btn-primary">Save</button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="subscription-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Subscription Plan</h5>
                            </div>
                        </div>
                        <?php if(!$user->subscribed('Supplier Monthly Plan - SmokeDrop')): ?>
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="mb-2">Monthly Supplier Subscription - $49.00</h6>
                                    <input type="hidden" id="monthly_subscribption_key" value="<?php echo e($monthly_subscribption_key); ?>">
                                    <label for="inputAddress">Card Name <span style="color: red">*</span></label>
                                    <input id="card-holder-name" class="form-control" type="text" placeholder="Enter Card Name" style="margin-bottom: 10px">
                                    <!-- Stripe Elements Placeholder -->
                                    <label for="inputAddress">Card Information <span style="color: red">*</span></label>
                                    <div id="card-element" class="form-control" style="margin-bottom: 10px"></div>

                                    <div class="form-group">
                                        <label for="inputAddress">Address <span style="color: red">*</span></label>
                                        <input type="text" required class="form-control" id="cardAddress" placeholder="1234 Main St" name="address1"  value="<?php echo e($user->address); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress2">Address 2</label>
                                        <input type="text" class="form-control" id="cardAddress2" name="address2" placeholder="Apartment, studio, or floor"  value="<?php echo e($user->address2); ?>">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputCity">City <span style="color: red">*</span></label>
                                            <input type="text" name="city" class="form-control"  value="<?php echo e($user->city); ?>" id="cardCity">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputState">State <span style="color: red">*</span></label>
                                            <input type="text" required name="state" class="form-control" id="cardState"  value="<?php echo e($user->state); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputCountry">Country <span style="color: red">*</span></label>
                                            <input type="text" required value="<?php echo e($user->country); ?>" name="country" class="form-control" id="cardCountry">
                                        </div>

                                        <button id="card-button" class="btn btn-primary" data-token="<?php echo e(csrf_token()); ?>" data-method="post" data-route="<?php echo e(route('settings.supplier.subscribe')); ?>" data-secret="<?php echo e($intent->client_secret); ?>">
                                            Subscribe
                                        </button>
                                    </div>
                                </div>
                                <?php else: ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <?php if($user->subscription('Supplier Monthly Plan - SmokeDrop')->cancelled()): ?>
                                                <p class="mb-2">You Cancelled Monthly Supplier Subscription - $49.00 on card <span style="color: green">******<?php echo e($user->card_last_four); ?> </span> <br> you current subscription ends at <?php echo e(date_create($user->subscription('Supplier Monthly Plan - SmokeDrop')->ends_at)->format('d M Y-H:i a')); ?></p>
                                            <?php else: ?>
                                                <p class="mb-2">
                                                    You Subscribed Monthly Supplier Subscription - $49.00 on card <span style="color: green"> ******<?php echo e($user->card_last_four); ?> </span> <br>  <?php echo e(date_create($user->subscription('Supplier Monthly Plan - SmokeDrop')->created_at)->format('d M Y-H:i a')); ?>

                                                    <br>

                                                    <span style="color: darkgrey;font-weight: 500">Next Transaction for Monthly Supplier Subscription - $49.00 on  <?php echo e(date_create($user->subscription('Supplier Monthly Plan - SmokeDrop')->created_at)->add(new DateInterval('P30D'))->format('d M Y-H:i a')); ?> </span>
                                                    <br>
                                                </p>

                                            <?php endif; ?>
                                            <?php if(!$user->subscription('Supplier Monthly Plan - SmokeDrop')->cancelled()): ?>
                                                <button id="cancel-subscription" data-token="<?php echo e(csrf_token()); ?>" data-action="cancel" data-route="<?php echo e(route('settings.supplier.set.subscription')); ?>" class="btn btn-danger">
                                                    Cancel Subscription
                                                </button>
                                            <?php else: ?>
                                                <button id="resume-subscription" data-token="<?php echo e(csrf_token()); ?>" data-action="resume" data-route="<?php echo e(route('settings.supplier.set.subscription')); ?>"  class="btn btn-success">
                                                    Resume Subscription
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                    </div>

                </div>
                <?php endif; ?>

                <?php if(auth()->check() && auth()->user()->hasRole('retailer')): ?>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="accounts-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <a class="card-title">My Account</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Private info</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo e(route('retailer.account.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="inputName">Company Name</label>
                                        <input type="text" class="form-control" id="inputName" name="user_name" placeholder="Enter company name"
                                               value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->user_name); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail4">Email</label>
                                        <input type="email" class="form-control" id="inputEmail4" name="user_email" placeholder="Enter email"
                                               value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->user_email); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDomain">Connected Shopify Store</label>
                                        <input type="text" class="form-control" readonly value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->myshopify_domain); ?>" id="inputDomain" placeholder="Store">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStoreName">Store Name</label>
                                        <input type="text" class="form-control" id="inputStoreName" readonly name="name" placeholder="Enter store name"
                                               value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->name); ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="plans-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Plans</h5>

                                <div class="row gutters">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="plan-card plan-one">
                                            <div class="pricing-header">
                                                <h4 class="plan-title">Basic</h4>
                                                <div class="plan-cost">$129.00</div>
                                                <div class="plan-save">Save $29.00</div>
                                            </div>
                                            <ul class="plan-features">

                                                <li class="text-muted">
                                                    <del>24/7 Tech Support</del>
                                                </li>
                                                <li class="text-muted">
                                                    <del>Daily Backups</del>
                                                </li>
                                            </ul>
                                            <div class="plan-footer">
                                                <a href="#" class="btn btn-info btn-lg btn-rounded">Select Plan</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="plan-card plan-one">
                                            <div class="pricing-header orange">
                                                <h4 class="plan-title">Standard</h4>
                                                <div class="plan-cost">$189.00</div>
                                                <div class="plan-save">Save $49.00</div>
                                            </div>
                                            <ul class="plan-features">

                                                <li>24/7 Tech Support</li>
                                                <li class="text-muted">
                                                    <del>Daily Backups</del>
                                                </li>
                                            </ul>
                                            <div class="plan-footer">
                                                <a href="#" class="btn btn-danger btn-lg btn-rounded">Select Plan</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="plan-card plan-one">
                                            <div class="pricing-header green">
                                                <h4 class="plan-title">Premium</h4>
                                                <div class="plan-cost">$219.00</div>
                                                <div class="plan-save">Save $99.00</div>
                                            </div>
                                            <ul class="plan-features">

                                                <li>24/7 Tech Support</li>
                                                <li>Daily Backups</li>
                                            </ul>
                                            <div class="plan-footer">
                                                <a href="#" class="btn btn-info btn-lg btn-rounded">Select Plan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="brand-invoicing-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Brand Invoicing</h5>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="billing-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Billing</h5>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="global-pricing-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <span style="color: #2c2c2c;"><a class="card-title">Global Pricing Rules &nbsp;</a><i class="fa fa-info-circle" data-toggle="tooltip"
                                                                                                                      title="You can assign a fixed markup or multiplier that will apply to all of your products"></i></span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo e(route('markup.settings')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputMarkupValue">Markup</label>
                                            <input type="text" class="form-control" required name="markup_value" <?php if(isset($markup_settings)): ?> value="<?php echo e($markup_settings->value); ?>"
                                                   <?php endif; ?> id="inputMarkupValue" placeholder="">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputMarkupType">Markup Type</label>
                                            <select required class="form-control" name="markup_type" value id="inputMarkupType">
                                                <option value="0">-- Select One --</option>
                                                <option value="percentage" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->type == 'percentage'): ?> selected <?php endif; ?> <?php endif; ?>>Percent</option>
                                                <option value="fixed" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->type == 'fixed'): ?> selected <?php endif; ?> <?php endif; ?>>Fixed</option>
                                                <option value="multiplier" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->type == 'multiplier'): ?> selected <?php endif; ?> <?php endif; ?>>Multiplier</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="checkbox" name="ask_every_time" <?php if(isset($markup_settings)): ?> <?php if($markup_settings->ask_every_time): ?> checked
                                                   <?php endif; ?> <?php endif; ?> id="inputAskEveryTime">
                                            <label for="inputAskEveryTime">Ask for profit margin every time importing product</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="payments-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Payments</h5>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Payment Method</h5>
                            </div>
                            <div class="card-body">
                                <a data-toggle="modal" data-target="#addPaymentMethodModal" href="">Add new payment method</a>
                                <!-- The Modal -->
                                <div class="modal" id="addPaymentMethodModal">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">Add new card</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <form accept-charset="UTF-8" action="<?php echo e(route('payment.store')); ?>" class="require-validation"
                                                  data-cc-on-file="false"
                                                  data-stripe-publishable-key="<?php echo e(env('PUBLISHABLE_KEY')); ?>"
                                                  id="payment-form" method="POST">
                                                <div class="modal-body">
                                                    <?php echo e(csrf_field()); ?>


                                                    <div class='col-xs-12 form-group required'>
                                                        <label class='control-label'>Name on Card</label>
                                                        <input class='form-control' type='text'>
                                                    </div>
                                                    <div class='col-xs-12 form-group card required mb-1'>
                                                        <label class='control-label'>Card Number</label>
                                                        <input autocomplete='off' class='form-control card-number' size='20' maxlength="20" type='text'>
                                                    </div>
                                                    <div class="row">
                                                        <div class='col-4 col-xs-12 form-group cvc required'>
                                                            <label class='control-label'>CVC</label>
                                                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' maxlength="4" type='text'>
                                                        </div>
                                                        <div class='col-4 col-xs-12 form-group expiration required'>
                                                            <label class='control-label'>Expiration</label>
                                                            <input class='form-control card-expiry-month' placeholder='MM' size='2' maxlength="2" type='text'>
                                                        </div>
                                                        <div class='col-4 col-xs-12 form-group expiration required'>
                                                            <label class='control-label'></label>
                                                            <input class='form-control card-expiry-year' placeholder='YYYY' size='4' maxlength="4" type='text'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    
                                                    <button class='btn btn-primary submit-button' type='submit'>Add payment method</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <?php if(isset($payment_method)): ?>
                                    <?php $__currentLoopData = $payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row py-1" style="font-size: 20px">
                                        <div class="col-8">
                                            <?php if($m->brand == 'Visa'): ?>
                                                <i class="fa fa-cc-visa  text-primary"></i>
                                            <?php elseif($m->brand == 'MasterCard'): ?>
                                                <i class="fa fa-cc-mastercard  text-primary"></i>
                                            <?php else: ?>
                                                <i class="fa fa-credit-card  text-primary"></i>
                                            <?php endif; ?>
                                            &nbsp;&nbsp; **** **** **** <?php echo e($m->last4); ?>

                                        </div>
                                        <div class="col-4 text-right text-primary">
                                            <a data-toggle="modal" data-target="#deletePaymentMethodConfirmationModal<?php echo e($index); ?>" class="text-primary"><i class="fa fa-trash"></i></a>
                                            <!-- The Modal -->

                                        </div>
                                    </div>
                                    <div class="modal" id="deletePaymentMethodConfirmationModal<?php echo e($index); ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Remove Payment Method</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Are you sure you want to remove this payment method?
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a href="<?php echo e(route('remove.payment.method',$m->id)); ?>" class="btn btn-danger">Yes! Remove Payment Method</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>




                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reffer-supplier-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Referral Suppliers</h5>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal" action="<?php echo e(route('settings.supplier.set.restrictions')); ?>" method="post">
                                    <div class="row">

                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="shop_id" value="<?php echo e($shop->id); ?>">
                                        <div class="col-md-10">
                                            <input type="text" name="code" required class="form-control" placeholder="Enter Supplier Referral Code">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary"> Attach  </button>
                                        </div>

                                    </div>
                                </form>
                                <hr>
                                <h6>Attached Suppliers List</h6>
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
                    </div>
                    <div class="tab-pane fade" id="transactions-tab" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Transactions History</h5>
                            </div>
                        </div>
                        <div class="card">
                            <table class="table data-thumb-view p-0">
                                <thead>
                                <th>#</th>
                                <th class="pl-1">Order</th>
                                <th>Amount</th>
                                <th>Receipt</th>
                                <th>Transaction Date</th>
                                <tbody>
                                <?php
                                $i = 0;
                                ?>
                                <?php if(count(auth()->user()->retailer_orders) > 0): ?>
                                    <?php $__currentLoopData = auth()->user()->retailer_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($order->transaction != null): ?>
                                            <tr>
                                                <?php
                                                    $i = $i+1;
                                                ?>
                                                <td><?php echo e($i); ?></td>
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
                    </div>

                <?php endif; ?>
            <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="accounts-tab" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Account Information</h5>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo e(route('settings.admin.info.update')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="admin_id" value="<?php echo e($user->id); ?>">
                                <div class="profile-img-container text-center">
                                    <img <?php if(auth()->user()->gender == null): ?> src="<?php echo e(asset('images/portrait/small/avatar-s-11.jpg')); ?>" <?php else: ?> src="<?php echo e(asset(auth()->user()->gender)); ?>" <?php endif; ?> class="d-block rounded-circle img-border box-shadow-1" style="width: 100%;max-width: 150px; margin: 10px auto;" alt="Card image">
                                    <a class="text-white input-file-button btn btn-primary">Upload Photo</a>
                                </div>

                                <div class="form-group">
                                    <label for="email-account">Email</label>
                                    <input id="email-account" type="email" class="form-control" name="email" value="<?php echo e($user->email); ?>">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="username-account">User Name</label>
                                    <input id="username-account" name="name" type="text" class="form-control" value="<?php echo e($user->name); ?>">
                                </div>
                                <div class="form-group mt-2">
                                    <input id="admin-image" onchange="readURL(this);" style="display: none" name="profile" type="file" accept="image/*" class="form-control" value="<?php echo e($user->gender); ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-2">Update Password</h6>
                            <form action="<?php echo e(route('settings.supplier.password.update')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="supplier_id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="email" value="<?php echo e($user->email); ?>">

                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input  name="password" type="password" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input name="new-pw" type="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label >Repeat New Password</label>
                                    <input  name="new-pwr" type="password" class="form-control" required>
                                </div>
                                <a class="btn btn-primary text-white change-password-button">Save</a>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="overlay" class="overlay" style="display: none">
        <img class="loading-image" src="<?php echo e(asset('images/830.gif')); ?>" alt="loading">
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        function set_subscription($this){
            $('.overlay').show();
            $.ajax({
                url:$this.data('route'),
                method : 'POST',
                data:{
                    action: $this.data('action'),
                    _token:$this.data('token'),
                },
                success:function (data) {
                    if(data.status === 'success'){
                        toastr.success(data.message);
                        setTimeout(function () {
                            location.reload();
                        },1000);
                    }
                    else{
                        toastr.error('Your Request Failed!');
                    }
                }
            });
        }
        $('#cancel-subscription').click(function () {
            set_subscription($(this));
        });
        $('#resume-subscription').click(function () {
            set_subscription($(this));
        });
        $('.change-password-button').click(function () {
            var current = $('input[name=password]').val();
            var newp = $('input[name=new-pw]').val();
            var newpr = $('input[name=new-pwr]').val();
            if(current !== "" && newp !== "" && newpr !== ""){
                if(newp === newpr){
                    $(this).parent('form').submit();
                }
                else{
                    toastr.error('Password Didnot Match');
                }
            }
            else{
                toastr.info('Please fill the fields first');
            }
        });
    </script>
    <script>
        $('.input-file-button').click(function () {
                $('#admin-image').trigger('click');
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.input-file-button').prev()
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }

        }
        $('.button-store-save').click(function (e) {
            e.preventDefault();
            // toastr.error($('.prefer-radio:checked').val());
            if($('.prefer-radio:checked').val() === 'all'){
                $('#restricted_store_form').submit();
            }
            else{
                var store_checked = $('.selected-stores').find('.restricted_store:checked').length;
                // toastr.error(store_checked);
                if(store_checked === 0){
                    toastr.error('Please check one of the checkboxes!');
                }
                else{
                    $('#restricted_store_form').submit();
                }
            }
        });
        if($('.prefer-radio:checked').val() === 'all'){
            $('.selected-stores').hide();
        }
        else{
            $('.selected-stores').show();
        }
        $('.prefer-radio').change(function () {
            if($(this).val() === 'all'){
                $('.selected-stores').hide();
            }
            else{
                $('.selected-stores').show();
            }
        });
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('pk_test_Ej2y40IbbKwJ99sCBhIPRaxv');

        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = $(cardButton).data('secret');
        const plan = document.getElementById('monthly_subscribption_key').value;
        cardButton.addEventListener('click', async (e) => {
            var address1 = $('#cardAddress').val();
            var address2 =$('#cardAddress2').val();
            var city = $('#cardCity').val();
            var state = $('#cardState').val();
            var country = $('#cardCountry').val();
            console.log(address1,city,state,country);
            if(address1 !== '' && city !== '' && state !== '' && country !== ''){
                const { setupIntent, error } = await stripe.handleCardSetup(
                    clientSecret, cardElement, {
                        payment_method_data: {
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                if (error) {
                    toastr.error('Subscription Failed!');
                    location.reload();
                } else {
                    // The card has been verified successfully...
                    console.log('handling success', setupIntent.payment_method);
                    $('.overlay').show();
                    $.ajax({
                        url : $('#card-button').data('route'),
                        method: $('#card-button').data('method'),
                        data:{
                            payment_method: setupIntent.payment_method,
                            plan : plan,
                            _token:$('#card-button').data('token'),
                            address1: address1,
                            address2: address2,
                            city: city,
                            state: state,
                            country: country,
                        },
                        success:function (data) {
                            if(data.message === 'success'){
                                toastr.success('You Subscribed Supplier Monthly Plan - $49.00 Successfully');
                                setTimeout(function () {
                                    location.reload();
                                },1000);
                            }
                        },
                        error:function (data) {
                            toastr.error('server error!');
                            location.reload();
                        }
                    });
                }
            }
            else{
                toastr.info('Please fill all fields of billing address');
            }



        });
    </script>
    <script src="https://js.stripe.com/v2/"></script>
    <script>
        // var stripe = Stripe('pk_test_Ej2y40IbbKwJ99sCBhIPRaxv');

        $(function () {
            var $form = $("#payment-form");

            $form.on('submit', function (e) {
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                console.log(response);
                if (response.error) {
                    toastr.error(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    console.log(token);
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='reservation[stripe_token]' value='" + token + "'/>");
                    $form.append("<input type='hidden' name='last4' value='" + response['card']['last4'] + "'/>");
                    $form.append("<input type='hidden' name='object' value='" + response['card']['object'] + "'/>");
                    $form.append("<input type='hidden' name='brand' value='" + response['card']['brand'] + "'/>");
                    $form.get(0).submit();
                }
            }

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.new_theme', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/settings/index.blade.php ENDPATH**/ ?>