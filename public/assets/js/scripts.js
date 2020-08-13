$(document).ready(function () {
    $('.products-checkboxes').show();
});
(function (window, undefined) {
    'use strict';

    /*
    NOTE:
    ------
    PLACE HERE YOUR OWN JAVASCRIPT CODE IF NEEDED
    WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR JAVASCRIPT CODE PLEASE CONSIDER WRITING YOUR SCRIPT HERE.  */
    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': false,
        'progressBar': true,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'showDuration': '3000',
        'hideDuration': '3000',
        'timeOut': '5000',
        'extendedTimeOut': '2000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    };


//search_products page
    var cart = $(".cart");
    // var url = 'http://127.0.0.1:8000';
    var url = 'https://app.dropshiprepublic.com';

    var import_list = [];

    // $('html').change(function () {
    //     if ($(this).hasClass('loaded')) {
    //         $('#overlay').attr('hidden', true);
    //     }
    // });

    $('#btn-see-more-categories').on('click', function () {
        $('.see-more-categories').attr('hidden', false);
        $('#btn-see-less-categories').attr('hidden', false);
        $('#btn-see-more-categories').attr('hidden', true);

    });

    $('#btn-see-less-categories').on('click', function () {
        $('.see-more-categories').attr('hidden', true);
        $('#btn-see-more-categories').attr('hidden', false);
        $('#btn-see-less-categories').attr('hidden', true);
    });

    $('#btn-see-more-vendors').on('click', function () {
        $('.see-more-vendors').attr('hidden', false);
        $('#btn-see-less-vendors').attr('hidden', false);
        $('#btn-see-more-vendors').attr('hidden', true);

    });

    $('#btn-see-less-vendors').on('click', function () {
        $('.see-more-vendors').attr('hidden', true);
        $('#btn-see-more-vendors').attr('hidden', false);
        $('#btn-see-less-vendors').attr('hidden', true);
    });

    $('#filter-form-1').change(function () {
        $(this).submit();
    });

    $('#filter-form-2').change(function () {
        var form = $(this).serialize();
        var urlToGo = document.location.href;

        if (document.location.href.includes('sub-category-filter')) {
            if (document.location.href.includes('?')) {
                document.location.href = urlToGo + '&' + form;
            } else {
                document.location.href = urlToGo + '?' + form;
            }
        } else {
            if (document.location.href.includes('?')) {
                document.location.href = document.location.href + '&' + form;
            } else {
                document.location.href = document.location.href + '?' + form;
            }
        }
    });

    $('.products-checkboxes').click(function () {
        if ($(this).parents('tr').hasClass('selected')) {
            $(this).parents('tr').removeClass('selected')
        } else {
            $(this).parents('tr').addClass('selected')
        }
    });

    $('.products-add-to-import-list').click(function () {
        if ($(this).parent().hasClass('selected')) {
            $(this).parent().removeClass('selected')
        } else {
            $(this).parent().addClass('selected')
        }
    });

    cart.on("click", function () {
        var $this = $(this);
        var current_text = $this.text();

        if (current_text.includes('Already added to import list') || current_text.includes('Already added to your store')) {
            console.log('already added');
        } else {
            var product_id = $this.attr('data-product-id');
            var profitMarginModal = $('#setProfitMarginModal' + product_id);
            var ask_every_time = $('#ask-every-time').text();
            var modal_btn_import_product = $('#modal-btn-import-product-' + product_id);

            if (ask_every_time == '1') {
                profitMarginModal.modal('show');
            } else if (ask_every_time == '0') {
                modal_btn_import_product.click();
            }

        }

    });

    $('.import-product').click(function () {
        var id = $(this).attr('data-product-id');

        $('#loading-animation-modal').modal('show');
        $('#loader-animation').attr('hidden', false);
        $('#loading-message').text();
        $('#setProfitMarginModal' + id).modal('hide');


        var percentage = $('#input-percentage-value-' + id).val();
        var fixed = $('#input-fixed-value-' + id).val();

        console.log('percentage: ' + percentage);
        console.log('fixed: ' + fixed);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: url + '/retailer/add/product-to-draft/' + id,
            type: 'POST',
            data: {
                'percentage': percentage,
                'fixed': fixed
            },
            success: function (success) {
                if (success['status'] == 200) {
                    setTimeout(
                        function () {
                            toastr.success(success['message']);
                            $('#loading-animation-modal').modal('hide');
                        }, 2500);

                } else if (success['status'] == 201) {
                    toastr.info(success['message']);
                    $('#loading-animation-modal').modal('hide');
                }
            },
            error: function (error) {
                console.log(error);
                // alert('error')
            },
        });
    });

    $('.profit-margin-type').change(function () {
        var $this = $(this),
            selectedValue = $this.val(),
            product_id = $this.attr('data-product-id'),
            input_fixed = $('#input-fixed-value-' + product_id),
            input_percentage = $('#input-percentage-value-' + product_id),
            div_percentage = $('#percentage-profit-' + product_id),
            div_fixed = $('#fixed-profit-' + product_id)
        ;
        console.log('selectedValue: ' + selectedValue);
        input_percentage.val('');
        input_fixed.val('');

        if (selectedValue == 1) {

            div_percentage.attr('hidden', false);
            div_fixed.attr('hidden', true);
        } else if (selectedValue == 2) {
            div_percentage.attr('hidden', true);
            div_fixed.attr('hidden', false);
        }
    });

    $('#profit-margin-type').change(function () {
        var $this = $(this),
            selectedValue = $this.val(),
            input_fixed = $('#input-fixed-value'),
            input_percentage = $('#input-percentage-value'),
            div_percentage = $('#percentage-profit'),
            div_fixed = $('#fixed-profit')
        ;
        console.log('selectedValue: ' + selectedValue);
        input_percentage.val('');
        input_fixed.val('');

        if (selectedValue == 1) {

            div_percentage.attr('hidden', false);
            div_fixed.attr('hidden', true);
        } else if (selectedValue == 2) {
            div_percentage.attr('hidden', true);
            div_fixed.attr('hidden', false);
        }
    });

    check_for_atleast_one_order_with_not_zero();

    $('#fulfil-order-submit-btn').click(function () {
        var ordersWithWrongInputExists = 0, totalInputFields = 0;

        $('#fulfill-form').submit();
        $('#fulfil-order-submit-btn').attr('disabled', false);
    });

    $('.fulfillment-quantity').change(function () {
        check_for_atleast_one_order_with_not_zero()
    });

    function check_for_atleast_one_order_with_not_zero() {
        var totalItems = 0;
        var itemsWithOne = 0;

        $('.fulfillment-quantity').each(function () {
            var current_value = $(this).val();
            totalItems++;
            if (current_value >= 1) {
                $(this).attr('disabled', false);
                itemsWithOne++;
            } else if (current_value == 0) {

            }
        });

        if (itemsWithOne > 0) {
            $('#fulfil-order-submit-btn').attr('disabled', false);
        } else {
            $('#fulfil-order-submit-btn').attr('disabled', true);
        }
    }

    $('#button-add-products-to-import-list').click(function () {

        var ask_every_time = $(this).next().text();
        var modal_set_profit_margin = $('#setProfitMarginModal');

        $.each($("input[name='products_selected']:checked"), function(){
            import_list.push($(this).attr('data-id'));
        });

        if (ask_every_time == 1){
            modal_set_profit_margin.modal('show')
        } else {
            $('#modal-btn-import-products').click();
        }
    });

    $('#modal-btn-import-products').click(function () {
        var fixed_profit = $('#fixed-profit');
        var percentage_profit = $('#percentage-profit');

        $('#loading-animation-modal').modal('show');
        $('#loader-animation').attr('hidden', false);
        $('#loading-message').text();

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: url + '/retailer/add/products/to/import-list',
            type: 'POST',
            data: {
                'fixed': fixed_profit.val(),
                'percentage': percentage_profit.val(),
                'products': import_list
            },
            success: function (success) {
                $('#loader-animation').attr('hidden', true);
                $('#loading-animation-modal').modal("hide");

                if (success['status'] == 200){
                    toastr.success(success['message']);
                } else {
                    toastr.warning(success['message']);
                }


            },
            error: function (error) {
                toastr.error(error);
                // $('#loading-message').text();
                $('#loader-animation').attr('hidden', true);
                $('#loading-animation-modal').modal("hide");
            }
        });
    });

    $('body').on('change','.dt-checkboxes',function () {
        if($(this).is(':checked')){
            $('.table-responsive').find('.bulk-remove-product-list').removeClass('d-none');
        }
        else{
           var count = 0;
            $('.dt-checkboxes').each(function () {
                if($(this).is(':checked')){
                  count =  count+1;
                }
            });
            if(count > 0){
                $('.table-responsive').find('.bulk-remove-product-list').removeClass('d-none');
            }
            else{
                $('.table-responsive').find('.bulk-remove-product-list').addClass('d-none');

            }

        }
    });
    $('body').on('change','.dt-checkboxes-select-all input[type=checkbox]',function () {
        if($(this).is(':checked')){
            $('.table-responsive').find('.bulk-remove-product-list').removeClass('d-none');
        }
        else{
            $('.table-responsive').find('.bulk-remove-product-list').addClass('d-none');
        }
    });

})(window);
