<?php $__env->startSection('content'); ?>

    <div class="">
        <h4 class="mt-2 page-title">Update your store details</h4>
        <div class="mt-2 p-1 bg-white">
            <form action="<?php echo e(route('supplier.store.update', $store->id )); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <div class="mb-1">Store Domain</div>
                    <input type="text" name="shop_domain" value="<?php echo e($store->shop_domain); ?>" placeholder="Enter your store domain" required class="form-control">
                </div>
                <div class="form-group">
                    <div class="mb-1">API Key</div>
                    <input type="text" name="api_key" value="<?php echo e($store->api_key); ?>" placeholder="Enter your api key" required class="form-control">
                </div>
                <div class="form-group">
                    <div class="mb-1">Password</div>
                    <input type="text" name="password" value="<?php echo e($store->password); ?>" placeholder="Enter your app's password" required class="form-control">
                </div>
                <div class="form-group">
                    <div class="mb-1">Shared Secret Key</div>
                    <input type="text" name="shared_secret" value="<?php echo e($store->shared_secret); ?>" placeholder="Enter your shared secret key" required class="form-control">
                </div>


                <button type="submit" class="btn btn-primary mt-3">Update</button>
            </form>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.new_theme', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/store/edit.blade.php ENDPATH**/ ?>