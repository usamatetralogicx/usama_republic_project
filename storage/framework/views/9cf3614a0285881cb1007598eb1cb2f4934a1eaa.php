<?php $__env->startSection('title', 'My Stores'); ?>

<?php $__env->startSection('css'); ?>

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/file-uploaders/dropzone.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/tables/datatable/datatables.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/plugins/file-uploaders/dropzone.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/data-list-view.css')); ?>">
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

    <?php
        $count =1;
    ?>
    <div class="row mt-2">
        <div class="col-6">
            <div class="page-title-box">
                <h4 class="page-title float-left">My Stores</h4>
            </div>
        </div>
        <div class="col-6">

            <div class="float-right">

                <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                <a class="btn btn-primary" href="<?php echo e(route('supplier.store.create')); ?>">Add Store</a>
                <?php endif; ?>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table data-thumb-view ">
            <thead>
            <tr>
                <th>&nbsp;&nbsp;#</th>
                <th>SHOP DOMAIN</th>
                <th class="text-right">ACTION</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($supplier_stores) < 1): ?>
                <tr>
                    <td colspan="3" class="text-center"><strong>No store found.</strong></td>
                </tr>
            <?php else: ?>
                <?php $__currentLoopData = $supplier_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($count++); ?></td>
                        <td class="py-3"><?php echo e($store->shop_domain); ?></td>
                        <td>
                            <a class="pull-right" href data-toggle="modal" data-target="#deleteShopConfirmationModal<?php echo e($store->id); ?>">
                                <span data-toggle="tooltip" title="Click to delete store"><i class="fa fa-trash" style="font-size: 18px"></i></span>
                            </a>
                            <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                            <a class="pull-right mr-1" href="<?php echo e(route('supplier.store.edit', $store->id)); ?>">
                                <span data-toggle="tooltip" title="Click to edit store!"><i class="fa fa-edit" style="font-size: 18px"></i></span>
                            </a>


                            <?php if(isset(\Illuminate\Support\Facades\Auth::user()->markup_setting) && \Illuminate\Support\Facades\Auth::user()->markup_setting->ask_every_time == 0): ?>
                                <a class="pull-right mr-1" href="<?php echo e(route('supplier.store.sync.products', $store->id)); ?>" id="sync-products-with-global-price-settings" >
                                    <span data-toggle="tooltip" title="Click to fetch all products from your shopify store!"><i class="fa phpdebugbar-fa-refresh" style="font-size: 18px"></i></span>
                                </a>
                            <?php else: ?>
                                <a class="pull-right mr-1 text-primary" data-toggle="modal" data-target="#setProfitMarginModal<?php echo e($store->id); ?>" >
                                    <span data-toggle="tooltip" title="Click to fetch all products from your shopify store!"><i class="fa phpdebugbar-fa-refresh" style="font-size: 18px"></i></span>
                                </a>
                            <?php endif; ?>

                            <?php endif; ?>
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
                        <div class="modal" id="setProfitMarginModal<?php echo e($store->id); ?>">
                            <div class="modal-dialog">
                                <div class="modal-content modal-lg">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Set profit margin for products' price</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="">
                                            <label for="">Select Profit margin type</label>
                                            <select class="form-control profit-margin-type" name="" id="<?php echo e($store->id); ?>">
                                                <option value="-1">Select profit margin type</option>
                                                <option value="1">Percentage profit</option>
                                                <option value="2">Fixed profit</option>
                                            </select>
                                            <div hidden id="percentage-profit-<?php echo e($store->id); ?>" class="form-group mt-1">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">%</div>
                                                    </div>
                                                    <input type="number" id="input-percentage-value-<?php echo e($store->id); ?>" class="form-control" placeholder="Percentage value">
                                                </div>
                                                <?php if( $store->profit_margin_percentage != null): ?>
                                                    <span>Previously selected profit percentage is: <?php echo e($store->profit_margin_percentage); ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <div hidden id="fixed-profit-<?php echo e($store->id); ?>" class="form-group mt-1">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">$</div>
                                                    </div>
                                                    <input type="number" id="input-fixed-value-<?php echo e($store->id); ?>" class="form-control" placeholder="Fixed value">
                                                </div>
                                                <?php if( $store->profit_margin_fixed != null): ?>
                                                    <span>Previously selected fixed profit amount is: <?php echo e($store->profit_margin_fixed); ?></span>
                                                <?php endif; ?>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <a id="<?php echo e($store->id); ?>" style="color: white" class="btn btn-primary sync-products">Sync</a>
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
    <?php echo e($supplier_stores->links()); ?>


    <div class="modal fade" id="loading-animation-modal" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title">Please wait while your products are being synced</h6>
                </div>

                <div class="modal-body">

                    <div class="sk-fading-circle" id="loader-animation" hidden>
                        <div class="sk-circle1 sk-circle"></div>
                        <div class="sk-circle2 sk-circle"></div>
                        <div class="sk-circle3 sk-circle"></div>
                        <div class="sk-circle4 sk-circle"></div>
                        <div class="sk-circle5 sk-circle"></div>
                        <div class="sk-circle6 sk-circle"></div>
                        <div class="sk-circle7 sk-circle"></div>
                        <div class="sk-circle8 sk-circle"></div>
                        <div class="sk-circle9 sk-circle"></div>
                        <div class="sk-circle10 sk-circle"></div>
                        <div class="sk-circle11 sk-circle"></div>
                        <div class="sk-circle12 sk-circle"></div>
                    </div>
                    <div id="show-message"></div>
                </div>

                <div class="modal-footer" hidden id="modal-close-button">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    <script src="<?php echo e(asset('js/scripts/ui/data-list-view.js')); ?>"></script>
    <!-- END: Page JS-->

    <script>
        $(function () {

            $('.sync-products').click(function () {
                var id = this.id;
                console.log('store id:' + id);
                $('#show-message').text('');
                $('#show-message').attr('hidden', true);

                $('#loading-animation-modal').modal('show');
                $('#loader-animation').attr('hidden', false);
                $('#setProfitMarginModal' + id).modal('hide');


                var percentage = $('#input-percentage-value-' + id).val();
                var fixed = $('#input-fixed-value-' + id).val();

                $.ajax({
                    url: '<?php echo e(env('APP_URL')); ?>' + '/supplier/store/set/profit/margin/' + id,
                    type: 'post',
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                        'percentage': percentage,
                        'fixed': fixed
                    },
                    success: function (success) {
                        if (success['status'] == 200) {
                            if (success['message'] === 'saved') {
                                $.ajax({
                                    url: '<?php echo e(env('APP_URL')); ?>' + '/supplier/store/sync/products/' + id,
                                    type: 'get',
                                    success: function (success) {

                                        if (success['status'] == 200) {
                                            $('#loader-animation').attr('hidden', true);
                                            $('#show-message').attr('hidden', false);
                                            $('#show-message').text(success['message']);

                                            console.log('Products added: ' + success['count']);
                                            $('#modal-close-button').attr('hidden', false);
                                            $('#input-percentage-value-' + id).val('');
                                            $('#input-percentage-value-' + id).parent().next().attr('hidden', true);
                                            $('#input-fixed-value-' + id).val('');
                                            $('#input-fixed-value-' + id).parent().next().attr('hidden', true);

                                        } else {
                                            $('#loader-animation').attr('hidden', true);
                                            $('#show-message').text('Your products are not synced. check log');
                                            $('#modal-close-button').attr('hidden', false);
                                        }

                                        console.log(success);
                                    },
                                    error: function (error) {
                                        $('#loader-animation').attr('hidden', true);
                                        $('#show-message').text('Your products are not synced.');
                                        $('#modal-close-button').attr('hidden', false);
                                        console.log(error);
                                    },
                                });
                            }
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });

            });

            $('#sync-products-with-global-price-settings').click(function () {
                $('#loading-animation-modal').modal('show');
                $('#loader-animation').attr('hidden', false);
            });


            $('.profit-margin-type').change(function () {
                var selectedValue = $(this).val();
                var store_id = this.id;
                console.log(selectedValue);

                if (selectedValue == -1) {
                    $('#fixed-profit-' + store_id).attr('hidden', true);
                    $('#fixed-profit-' + store_id).val('');
                    $('#percentage-profit-' + store_id).attr('hidden', true);
                    $('#percentage-profit-' + store_id).val('');

                } else if (selectedValue == 1) {
                    $('#fixed-profit-' + store_id).val('');
                    $('#fixed-profit-' + store_id).attr('hidden', true);
                    $('#percentage-profit-' + store_id).attr('hidden', false);
                } else if (selectedValue == 2) {
                    $('#percentage-profit-' + store_id).val('');
                    $('#fixed-profit-' + store_id).attr('hidden', false);
                    $('#percentage-profit-' + store_id).attr('hidden', true);

                }
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Dropship-Republic\resources\views/store/index.blade.php ENDPATH**/ ?>