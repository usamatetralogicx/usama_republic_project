<?php $__env->startSection('title', 'Create Product'); ?>


<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('dist/fileuploads/css/dropify.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('dist/summernote-bs4.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('dist/bootstrap-tagsinput/css/bootstrap-tagsinput.css')); ?>" rel="stylesheet"/>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

    <!-- File drop css -->
    <link href="<?php echo e(asset('plugins/fileuploads/css/dropify.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('plugins/bootstrap-tagsinput/css//bootstrap-tagsinput.css')); ?>" rel="stylesheet"/>
    <style>
        .note-popover .popover-content>.btn-group, .card-header.note-toolbar>.btn-group {
            margin-top: 5px;
             margin-right: 0 !important;
             margin-left: 0 !important;
        }
        .note-btn-group .btn-light {
            background-color: #7367f0 !important;
        }
        .categories-div{
            height: 400px;
            overflow: auto;
        }
        .sub-div {
            margin-left: 28px;
            display: none;
        }
    </style>
    <div class="">
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Add Product</h4>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <form id="images-form" action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row mt-2 p-1">
                <div class=" col-md-8">
                    <div class="p-1 bg-white">
                        <div class="form-group">
                            <div class="mb-1"><strong>Title</strong></div>
                            <input type="text" placeholder="Title" name="title" required id="title" class="form-control">
                        </div>
                    </div>
                    <div class="mt-2 p-1 bg-white">
                        <div style="width: 100%;">
                            <div class="mb-1"><strong>Description</strong></div>
                            <textarea style="display: none" name="body_html" id="summernote"></textarea>
                        </div>
                    </div>
                    <div id="for-image-upload" class="mt-2 p-1 bg-white">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <div class="mb-1"><strong>Product Image</strong></div>
                                    <input type="file" name="images[]" accept="image/jpeg, image/png" class="dropify bg-transparent mt-1" multiple data-height="300"/>
                                </div>
                            </div><!-- end col -->
                        </div>
                    </div>
                    <div class="p-1 mt-2 bg-white">
                        <div class="mb-1"><strong>Pricing</strong></div>
                        <div class="row pl-1">
                            <div class="col-12 form-check-inline">
                                <div class="col-6 form-group pl-0">
                                    <div class="mb-1"><strong>Price</strong></div>
                                    <input type="number" name="price" id="product-price" placeholder="US$ 0.00" class="form-control">
                                </div>
                                <div class="col-6 form-group pr-0">
                                    <div class="mb-1"><strong>Cost</strong></div>
                                    <input type="number" name="cost" placeholder="US$ 0.00" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-1 mt-2 bg-white">
                        <div class="mb-1"><strong>Inventory</strong></div>
                        <div class="row pl-1">
                            <div class="col-12 form-check-inline">
                                <div class="col-6 form-group pl-0">
                                    <div class="mb-1"><strong>SKU (Stock Keeping Unit)</strong></div>
                                    <input type="text" name="sku" id="product-sku" placeholder="" class="form-control">
                                </div>
                                <div class="col-6 form-group pr-0">
                                    <div class="mb-1"><strong>Barcode</strong></div>
                                    <input type="text" name="barcode" id="product-barcode" placeholder="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-1 mt-2 bg-white">
                        <div class="mb-1"><strong>Shipping</strong></div>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox" type="checkbox" checked="">
                            <label for="checkbox">This is a physical product</label>
                        </div>

                        <hr>
                        <div id="if-physical-product" class="form-group col-3 pl-0">
                            <div class="mb-1"><strong>Weight</strong></div>
                            <input type="number" name="grams" class="form-control" value="0.0">
                        </div>
                    </div>
                    <div class="p-1 mt-2 bg-white col-12">
                        <div class="mb-1"><strong>Variants</strong></div>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox1" class="mb-1" name="hasVariants" type="checkbox">
                            <label for="checkbox1">This product has multiple variants</label>
                        </div>

                        <hr hidden class="p-0 m-0" id="variant-hr">

                        <div hidden class="p-1" id="variant-options">
                            <h6>Options</h6>
                            <div id="options">
                                <div class="mt-2 mb-1"><strong>Option1</strong></div>
                                <div class="row">
                                    <div class="col-3"><input id="option-1-name" name="option1" type="text" placeholder="Name" class="form-control"></div>
                                    <div class="col-9">
                                        <input id="option-1-value" data-role="tagsinput" autofocus name="value1" class="form-control variant-options">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button hidden type="button" id="btn-add-another-option" class="btn btn-success mt-2">Add another option</button>

                        <div hidden id="variants-pair-container">
                            <div class=" mt-2">
                                <div><strong>Preview</strong></div>
                                <table class="table table-borderless table-responsive-sm">
                                    <thead>
                                    <tr>
                                        <th>Variant</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>SKU</th>
                                        <th>Barcode</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Add product</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-1 bg-white">
                        <div class="mb-1"><strong>Organization</strong></div>

                        <div class="form-group">
                            <div class="mb-1"><strong>Vendor</strong></div>
                            <input type="text" name="vendor" class="form-control" placeholder="Enter vendor name">
                        </div>
                        <div class="form-group">
                            <div class="mb-1"><strong>Type</strong></div>
                            <input type="text" name="type" class="form-control" placeholder="Enter product type">
                        </div>

                        <div class="form-group">
                            <div class="mb-1"><strong>Tags</strong></div>
                            <input id="variant-tags" data-role="tagsinput" autofocus name="tags" class="form-control">
                        </div>

                    </div>
                    <div class="p-1 mt-2 bg-white ">
                        <div class="mb-1"><strong>Category</strong></div>
                        <div class="form-group categories-div">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="cat-div">
                                    <fieldset >
                                        <i class="fa fa-chevron-right opener" style="vertical-align: super;font-size: 10px;color: #7367f0;"></i>
                                        <div class="vs-checkbox-con vs-checkbox-primary d-inline-flex">
                                            <input type="checkbox" class="category_checkbox"
                                                   name="category[]" value="<?php echo e($category->id); ?>">
                                            <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                            <span class=""><?php if($category->name == 'Electronic Components & Supplies'): ?> Electronic Components <?php else: ?> <?php echo e($category->name); ?><?php endif; ?></span>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="sub-div">
                                    <?php $__currentLoopData = $category->sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <fieldset>
                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                <input type="checkbox" class="sub_cat_checkbox"
                                                       name="subcategory[]" value="<?php echo e($sub->id); ?>">
                                                <span class="vs-checkbox">
                                                            <span class="vs-checkbox--check">
                                                                <i class="vs-icon feather icon-check"></i>
                                                            </span>
                                                        </span>
                                                <span class=""><?php echo e($sub->name); ?></span>
                                            </div>
                                        </fieldset>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(asset('dist/fileuploads/js/dropify.js')); ?>"></script>
    <script src="<?php echo e(asset('dist/bootstrap-tagsinput/js/bootstrap-tagsinput.js')); ?>"></script>
    <script src="<?php echo e(asset('dist/summernote-bs4.js')); ?>"></script>


    <script>
        var selectedImages = [];
        var options = 1;
        var allValues = [];

        $(document).ready(function () {
            var count = 0;
            $('body').on('change','.category_checkbox',function () {
                if($(this).is(':checked')){
                    // $(this).parents('.cat-div').next().find('input[type=checkbox]').prop('checked','true');
                    $(this).parents('.cat-div').next().show();
                }
                else{
                    // $(this).parents('.cat-div').next().find('input[type=checkbox]').prop('checked',false);
                    $(this).parents('.cat-div').next().hide();
                }
            });
            $('body').on('change','.sub_cat_checkbox',function () {
                if($(this).is(':checked')){
                    $(this).parents('.sub-div').prev().find('.category_checkbox').prop('checked','true');
                }
                else{
                    var checked = $(this).parents('.sub-div').find('input[type=checkbox]:checked').length;
                    if(checked === 0){
                        $(this).parents('.sub-div').prev().find('.category_checkbox').prop('checked',false);
                    }
                }
            });

            $('.opener').click(function () {

                if($(this).hasClass('fa-chevron-right')){
                    $(this).removeClass('fa-chevron-right');
                    $(this).addClass('fa-chevron-down');
                }
                else{
                    $(this).removeClass('fa-chevron-down');
                    $(this).addClass('fa-chevron-right');
                }
                $(this).parents('.cat-div').next().toggle();
            });

            $('#summernote').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                ],
                fontNames: ['Roboto', 'Calibri', 'Times New Roman', 'Arial'],
                fontNamesIgnoreCheck: ['Roboto', 'Calibri'],

                tabsize: 2,
                popover: false,
                height: 250,
            });

            $('#upload-button').on('click', function () {
                var input = document.getElementById('DropZone56');
                input.click();
            });

            $('#btn-add-another-option').on('click', function () {

                if (options < 3) {
                    options++;
                    $('#options').parent().append('<div><div class="row"><div class="col-6"><div class="my-1"><strong>Option' + options + ' </strong></div></div><div class="col-6"><a hidden class="float-right remove-clicked-option">remove</a></div></div><div class="row"><div class="col-3"><input type="text" name="option' + options + '" placeholder="Name" class="form-control">' +
                        '</div><div class="col-9"><input id="option-' + options + '-value" name="value' + options + '" class="form-control variant-options" type="text"></div></div>');
                    if (options === 3) {
                        $('#btn-add-another-option').hide();
                    }
                }
            });

            //change normal input fields to tagsinput
            $("body").delegate(".variant-options", "click", function () {
                // console.log(this);
                var elt = $('.variant-options'); // get element
                elt.tagsinput();
                elt.focus();
            });

            //this will detect if there's any change in first option
            $('#option-1-value').change(function () {
                var array1 = $(this).tagsinput('items');
                var array2 = $('#option-2-value').tagsinput('items');
                var array3 = $('#option-3-value').tagsinput('items');
                var product_sku = $('#product-sku').val();
                var product_barcode = $('#product-barcode').val();
                var product_price = parseFloat($('#product-price').val());

                if (array1.length == 0 && (array2 == undefined || array2.length == 0) && (array3 == undefined || array3.length == 0)) {
                    $('#variants-pair-container').attr('hidden', true);
                    $('#tbody').empty();
                    return;
                }

                $.ajax({
                    url: '<?php echo e(env('APP_URL')); ?>/supplier/product/add/request/for/all/pairs',
                    type: 'post',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        'array1': array1,
                        'array2': array2,
                        'array3': array3,
                    },
                    success: function (success) {

                        if (success['status'] === 'success') {
                            console.log(success['pairs']);
                            console.log("control comes here in option 1 success");

                            if (success['pairs'] == null) {
                                $('#variants-pair-container').attr('hidden', true);
                                $('#tbody').empty();
                                return;
                            }

                            if (success['pairs'].length > 100) {
                                alert('variants can\'t be more than 100');
                            } else {
                                $('#variants-pair-container').attr('hidden', false);
                                $('#tbody').empty();
                                for (var i = 0; i < success['pairs'].length; i++) {
                                    if (success['pairs'][i]['item3'] == undefined && success['pairs'][i]['item2'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '>' +
                                            '<td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item2'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else if (success['pairs'][i]['item2'] == undefined && success['pairs'][i]['item3'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item3'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item3'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item3'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else if (success['pairs'][i]['item1'] != undefined && success['pairs'][i]['item2'] != undefined && success['pairs'][i]['item3'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-' + i + '"><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' / ' + success['pairs'][i]['item3'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' / ' + success['pairs'][i]['item3'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item2'] + '">' +
                                            '<input type="hidden" name="individualOptions3[]" value="' + success['pairs'][i]['item3'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '" ></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else {

                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    }
                                }
                            }
                        }
                    },
                    errors: function (errors) {
                        console.log(errors);
                    },
                });
            });

            //this will detect if there's any change in second option
            $("body").delegate("#option-2-value", "change", function () {
                var array1 = $('#option-1-value').tagsinput('items');
                var array2 = $(this).tagsinput('items');
                var array3 = $('#option-3-value').tagsinput('items');
                var product_sku = $('#product-sku').val();
                var product_price = parseFloat($('#product-price').val());
                var product_barcode = $('#product-barcode').val();


                if (array2.length == 0 && (array3 == undefined || array3.length == 0) && (array1 == undefined || array1.length == 0)) {
                    $('#variants-pair-container').attr('hidden', true);
                    $('#tbody').empty();
                    return;
                }

                $.ajax({
                    url: '<?php echo e(env('APP_URL')); ?>/supplier/product/add/request/for/all/pairs',
                    type: 'post',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        'array1': array1,
                        'array2': array2,
                        'array3': array3,
                    },
                    success: function (success) {

                        if (success['status'] === 'success') {
                            console.log(success['pairs']);
                            console.log("control comes here in option 2 success");

                            if (success['pairs'] == null) {
                                $('#variants-pair-container').attr('hidden', true);
                                $('#tbody').empty();
                                return;
                            }


                            if (success['pairs'].length > 100) {
                                alert('variants can\'t be more than 100');
                            } else {
                                $('#variants-pair-container').attr('hidden', false);
                                $('#tbody').empty();
                                for (var i = 0; i < success['pairs'].length; i++) {
                                    if (success['pairs'][i]['item3'] == undefined && success['pairs'][i]['item2'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item2'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '" ></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else if (success['pairs'][i]['item2'] == undefined && success['pairs'][i]['item3'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item3'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item3'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item3'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else if (success['pairs'][i]['item1'] != undefined && success['pairs'][i]['item2'] != undefined && success['pairs'][i]['item3'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-' + i + '"><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' / ' + success['pairs'][i]['item3'] + ' </td>' +
                                            '<input  type="hidden"  name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' / ' + success['pairs'][i]['item3'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item2'] + '">' +
                                            '<input type="hidden" name="individualOptions3[]" value="' + success['pairs'][i]['item3'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '" ></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '" ></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i] + ' </td>' +
                                            '<input  type="hidden" name="variant_title[]" value="' + success['pairs'][i] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    }
                                }
                            }
                        }
                    },
                    errors: function (errors) {
                        console.log(errors);
                    },
                });
            });

            //this will detect if there's any change in third option
            $("body").delegate("#option-3-value", "change", function () {
                var array1 = $('#option-1-value').tagsinput('items');
                var array2 = $('#option-2-value').tagsinput('items');
                var array3 = $(this).tagsinput('items');
                var product_sku = $('#product-sku').val();
                var product_price = parseFloat($('#product-price').val());
                var product_barcode = $('#product-barcode').val();

                if (array3.length == 0 && (array2 == undefined || array2.length == 0) && (array1 == undefined || array1.length == 0)) {
                    $('#variants-pair-container').attr('hidden', true);
                    $('#tbody').empty();
                    return;
                }

                $.ajax({
                    url: '<?php echo e(env('APP_URL')); ?>/supplier/product/add/request/for/all/pairs',
                    type: 'post',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        'array1': array1,
                        'array2': array2,
                        'array3': array3,
                    },
                    success: function (success) {

                        if (success['status'] === 'success') {
                            if (success['pairs'].length > 100) {
                                alert('variants can\'t be more than 100');
                            } else {
                                $('#variants-pair-container').attr('hidden', false);
                                $('#tbody').empty();
                                for (var i = 0; i < success['pairs'].length; i++) {
                                    if (success['pairs'][i]['item3'] == undefined && success['pairs'][i]['item2'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item2'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '" ></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else if (success['pairs'][i]['item2'] == undefined && success['pairs'][i]['item3'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item3'] + ' </td>' +
                                            '<input type="hidden" name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item3'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item3'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else if (success['pairs'][i]['item1'] != undefined && success['pairs'][i]['item2'] != undefined && success['pairs'][i]['item3'] != undefined) {
                                        $('#tbody').append('<tr id="variant-pair-' + i + '"><td>' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' / ' + success['pairs'][i]['item3'] + ' </td>' +
                                            '<input  type="hidden"  name="variant_title[]" value="' + success['pairs'][i]['item1'] + ' / ' + success['pairs'][i]['item2'] + ' / ' + success['pairs'][i]['item3'] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i]['item1'] + '">' +
                                            '<input type="hidden" name="individualOptions2[]" value="' + success['pairs'][i]['item2'] + '">' +
                                            '<input type="hidden" name="individualOptions3[]" value="' + success['pairs'][i]['item3'] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '" ></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    } else {
                                        $('#tbody').append('<tr id="variant-pair-"' + i + '><td>' + success['pairs'][i] + ' </td>' +
                                            '<input  type="hidden" name="variant_title[]" value="' + success['pairs'][i] + '">' +
                                            '<input type="hidden" name="individualOptions1[]" value="' + success['pairs'][i] + '">' +
                                            '<td><input class="pl-2 form-control" type="text" name="variant_price[]" value="' + product_price + '" placeholder="$0.00"></td>' +
                                            '<td><input class="pl-2 form-control" type="number" name="variant_quantity[]" placeholder="0"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_sku[]" value="' + product_sku + i + '"></td>' +
                                            '<td><input  class="pl-2 form-control" type="text" name="variant_barcode[]" value="' + product_barcode + '"></td>' +
                                            '<td id="variant_' + i + '_remove" class="variant-remove"><i class="fa fa-remove"></i></td>' +
                                            '</tr>');
                                    }

                                }
                            }

                        }

                    },
                    errors: function (errors) {
                        console.log(errors);

                    },
                });
            });

            $("body").delegate(".variant-remove", "click", function () {
                console.log('clicked');
                $(this).parent().remove();
            });

            $('#checkbox').on('change', function () {
                if ($(this).prop('checked') === true) {
                    $('#if-physical-product').attr('hidden', false);
                } else {
                    $('#if-physical-product').attr('hidden', true);
                }
            });

            $('#checkbox1').on('change', function () {
                if ($(this).prop('checked') === true) {
                    $('#variant-options').attr('hidden', false);
                    $('#btn-add-another-option').attr('hidden', false);
                    $('#variant-hr').attr('hidden', false);
                } else {
                    $('#variant-options').attr('hidden', true);
                    $('#btn-add-another-option').attr('hidden', true);
                    $('#variant-hr').attr('hidden', true);

                }
            });

            $('.image-delete').on('click', function () {
                console.log('cross clicked');
            });

            $("#DropZone56").change(function () {
                readURL(this);
            });

            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (1M max).'
                }
            });
        });

        function readURL(input) {
            var files = input.files;
            console.log(files);
            if (input.files) {

                var container = $('#images-container');

                for (let i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var addImageDiv = '<div class="row m-2" ><div class="col-2"><img src="" style="margin: 5px 10px; height: 100px;width: 100px;" class="d-block" id="image-id-' + count + '"' +
                            ' alt=""></div><div id="image-title-' + count + '" class="col-9" style="align-self: center"></div><div class="col-1 image-delete text-right" onclick="deleteClicked(' + count + ')" id="image-delete-' + count + '" ' +
                            'style="color: #ff4236;font-size: 30px;font-weight: bold;align-self: center">&times;</div></div>';

                        container.append(addImageDiv);
                        $('#image-id-' + count).attr('src', e.target.result);
                        $('#image-title-' + count).text(files[i].name);
                        selectedImages.push(files[i]);
                        console.log(selectedImages);
                        count++;
                    };
                    reader.readAsDataURL(files[i]);
                }
            }

        }

        function deleteClicked(imageID) {
            $('#image-id-' + imageID).parent().parent().empty();
            selectedImages.splice(imageID, 1);
            console.log(selectedImages);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.ecommerce', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/362288.cloudwaysapps.com/dzpjshsreq/public_html/resources/views/products/create.blade.php ENDPATH**/ ?>