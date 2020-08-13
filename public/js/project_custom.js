$(function () {
    var custom_carrier = $('#custom_carrier');
    var default_carrier = $('#default_carrier');
    var carrier_dropdown = $('#carrier_dropdown');


    carrier_dropdown.on('change', function () {

        var val = $(this).val();

        console.log(val);

        if (val !== 'other') {
            default_carrier.attr('hidden', false);
            custom_carrier.attr('hidden', true);
        } else {
            default_carrier.attr('hidden', true);
            custom_carrier.attr('hidden', false);
        }
    });





});
