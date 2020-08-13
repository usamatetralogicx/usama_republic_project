<?php $__env->startSection('title', 'Product Details'); ?>


<?php $__env->startSection('css'); ?>
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendors/css/extensions/swiper.min.css')); ?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/pages/app-ecommerce-details.css')); ?>">
    <!-- END: Page CSS-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- app ecommerce details start -->
    <section class="app-ecommerce-details">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">

                    </div>
                    <?php if(auth()->check() && auth()->user()->hasRole('supplier')): ?>
                    <div class="col-md-3 text-right">
                        <a class="btn btn-primary" href="<?php echo e(route('products.edit',$product->id)); ?>"> Edit Product</a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="row mb-5 mt-2">
                    <div class="col-12 col-md-5 <!--d-flex align-items-start justify-content-center mb-2 mb-md-0-->">
                        <div class="row">
                            <img src="<?php echo e($product->image); ?>" class="img-fluid" alt="product image">
                        </div>

                        <div class="row mt-1">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4" style="margin-bottom: 5px;margin-top: 5px">
                                    <img src="<?php echo e($image->src); ?>" class="img-fluid" alt="product image">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </div>
                    <div class="col-12 col-md-6">
                        <h5><?php echo e($product->title); ?></h5>
                        <?php
                            $minPrice = (float) $product_variants->min('price');
                        ?>

                        <?php
                          $maxPrice = (float) $product_variants->max('price');
                            ?>


                        <h4 class="pull-right text-primary"><?php if($minPrice > 0 && $maxPrice > 0): ?>  <?php if($minPrice == $maxPrice): ?> $<?php echo e(number_format($minPrice,2)); ?>  <?php else: ?> $<?php echo e(number_format($minPrice,2)); ?> - $<?php echo e(number_format($maxPrice,2)); ?> <?php endif; ?> <?php else: ?> $<?php echo e(number_format($product->price,2)); ?> <?php endif; ?></h4>
                        <p class="text-muted mb-0">by <span class="text-primary"><?php echo e($product->vendor); ?></span></p>
                        <p class="text-muted"><?php if($product->sold_count > 0 ): ?> Added to import list <?php echo e($product->sold_count); ?> times <?php endif; ?></p>
                        <hr>
                        <p><?php echo html_entity_decode($product->body_html); ?></p>
                        <?php if($product->option1 != 'Title'): ?>
                            <p class="font-weight-bold"><i class="feather icon-box mr-50 font-medium-2"></i>Options available
                            </p>
                            <hr>
                            

                            <?php if($product->option1 != null): ?>

                                <div class="form-group">
                                    <label class="font-weight-bold"><?php echo e($product->option1); ?></label>
                                    <ul class="list-unstyled mb-0 product-color-options">
                                        <?php if($product->value1 != null): ?>
                                            <?php $__currentLoopData = json_decode($product->value1, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem">
                                                    <?php echo e($value1); ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                    <hr>
                                </div>
                            <?php endif; ?>
                            <?php if($product->option2 != null): ?>
                                <div class="form-group">
                                    <label class="font-weight-bold"><?php echo e($product->option2); ?></label>
                                    <ul class="list-unstyled mb-0 product-color-options">
                                        <?php if($product->value2 != null): ?>
                                            <?php $__currentLoopData = json_decode($product->value2, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem">
                                                    <?php echo e($value2); ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                    <hr>
                                </div>
                            <?php endif; ?>
                            <?php if($product->option3 != null): ?>
                                <div class="form-group">
                                    <label class="font-weight-bold"><?php echo e($product->option3); ?></label>
                                    <ul class="list-unstyled mb-0 product-color-options">
                                        <?php if( $product->value3 != null): ?>
                                            <?php $__currentLoopData = json_decode($product->value3, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem">
                                                    <?php echo e($value3); ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                    <hr>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if($product->sub_categories != null): ?>
                            <p class="font-weight-bold"><i class=" feather icon-tag  mr-50 font-medium-2"></i>Categories</p>
                            <hr>
                                <div class="form-group">
                                    <ul class="list-unstyled mb-0 product-color-options">
                                            <?php $__currentLoopData = $product->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sub_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="d-inline-block border-primary px-2" style="padding: 0.5rem;">
                                                    <?php echo e($product_sub_category->category->name . ' - ' . $product_sub_category->name); ?>

                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <hr>
                                </div>
                        <?php endif; ?>
                        <?php if($product->tags != null): ?>
                            <p class="font-weight-bold"><i class=" fa fa-tags mr-50 font-medium-2"></i>Tags</p>
                            <hr>
                            <div class="form-group">
                                <ul class="list-unstyled mb-0 product-color-options">
                                    <?php $__currentLoopData = explode(',',$product->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="d-inline-block border-primary px-2" style="padding: 0.2rem;margin-bottom: 5px">
                                            <?php echo e($tag); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <hr>
                            </div>

                        <?php endif; ?>
                        <?php
                        $quantityTotal = $product_variants->sum('quantity');
                        ?>
                        <?php if($quantityTotal > 0): ?>
                            <p>Available - <span class="text-success">In stock</span> (<?php echo e($quantityTotal); ?> items in <?php echo e(count($product_variants)); ?> variants) </p>
                            <?php else: ?>
                            <p>Unavailable - <span class="text-danger">Not In stock</span> (0 items in <?php echo e(count($product_variants)); ?> variants)</p>
                            <?php endif; ?>



                    </div>
                    <?php if(count($product_variants) > 0): ?>
                        <div class="col-12">
                            <table class="table">
                                <thead class="font-weight-bolder">
                                <td>IMAGE</td>
                                <td>OPTION</td>
                                <td>PRICE</td>
                                <td>QTY</td>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $product_variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($variant->src != null): ?>
                                                <img src="<?php echo e($variant->src); ?>" alt="<?php echo e($variant->title); ?>" height="80px" width="80px">
                                            <?php else: ?>
                                                <img src="https://image.shutterstock.com/image-vector/no-image-available-icon-vector-260nw-1323742826.jpg" alt="<?php echo e($variant->title); ?>" height="80px" width="80px">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($variant->title); ?></td>
                                        <td>$<?php echo e(number_format($variant->price, 2)); ?></td>
                                        <td><?php echo e($variant->quantity); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="col-12">
                            <p>This product has no variants</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- app ecommerce details end -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo e(asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/js/extensions/swiper.min.js')); ?>"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?php echo e(asset('js/scripts/pages/app-ecommerce-details.js')); ?>"></script>
    <script src="<?php echo e(asset('js/scripts/forms/number-input.js')); ?>"></script>
    <!-- END: Page JS-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/products/product.blade.php ENDPATH**/ ?>