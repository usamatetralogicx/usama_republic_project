/*=========================================================================================
    File Name: data-list-view.js
    Description: List View
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {
    "use strict"
    // init list view datatable
    // var url = 'http://127.0.0.1:8000';
    var url = 'https://app.dropshiprepublic.com';

    var selected_rows_global = [];

    var pageType = $('#page-type').text();

    // init thumb view datatable
    var dataThumbView;
    if (pageType == 'my products') {
        dataThumbView = $(".data-thumb-view").DataTable({
            responsive: false,
            columnDefs: [
                {
                    orderable: true,
                    targets: 0,
                    checkboxes: {selectRow: true}
                }
            ],
            dom:
                '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
            oLanguage: {
                sLengthMenu: "_MENU_",
                sSearch: ""
            },
            // select: true,
            aLengthMenu: [[10, 20, 30, 40], [10, 20, 30, 40]],
            order: [[1, "asc"]],
            bInfo: false,
            pageLength: 10,
            initComplete: function (settings, json) {
                $(".dt-buttons .btn").removeClass("btn-secondary")
            }
        });
    } else if (pageType == 'import list') {
        dataThumbView = $(".data-thumb-view").DataTable({
            responsive: false,
            columnDefs: [
                {
                    orderable: true,
                    targets: 0,
                    checkboxes: {selectRow: true}
                }
            ],
            dom:
                '<"top"<"actions action-btns"B><"action-filters"lf>><"clear">rt<"bottom"<"actions">p>',
            oLanguage: {
                sLengthMenu: "_MENU_",
                sSearch: ""
            },
            select: {
                style: 'multi'
            },
            aLengthMenu: [[10, 20, 30, 40], [10, 20, 30, 40]],
            order: [[1, "asc"]],
            bInfo: false,
            pageLength: 10,
            buttons: [
                {
                    text: "<i class='feather icon-plus'></i> Add to store",
                    action: function () {
                        $('#loader-animation').attr('hidden', false);
                        $(this).removeClass("btn-secondary");
                        $(".add-new-data").addClass("show");
                        $(".overlay-bg").addClass("show");


                        var table_row = $('tr[role=row]');

                        $.each(table_row, function (index, value) {
                            if ($(value).hasClass('selected')) {
                                selected_rows_global.push($(value).attr('data-selected-product-id'));
                            }
                        });

                        if (selected_rows_global.length > 0) {
                            console.log(selected_rows_global);
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                }
                            });

                            $('#loader-animation').attr('hidden', false);
                            $('#modal-close-button').attr('hidden', true);
                            $('#loading-animation-modal').modal('show');

                            //push multiple products to shopify
                            $.ajax({
                                url: url + '/retailer/products/push/to/shopify',
                                type: 'POST',
                                data: {
                                    'products': selected_rows_global
                                },
                                success: function (success) {

                                    if (success['status'] == 200) {
                                        if (success['message'] === 'saved') {
                                            toastr.success('Product has been imported successfully.');
                                            console.log('Product has been imported successfully.');
                                            $('#loader-animation').attr('hidden', true);
                                            $('#show-message').text('Product has been imported successfully.');
                                            $('#modal-close-button').attr('hidden', false);

                                        }
                                    } else {
                                        console.log(success['message']);
                                        toastr.warning(success['message']);
                                        $('#loading-animation-modal').modal('hide');
                                    }
                                },
                                error: function (error) {
                                    console.log(error);
                                    toastr.warning(error);
                                },
                            });
                        } else {
                            toastr.error('Please select any product first to add it to your shopify store')
                        }

                    },
                    className: "btn-outline-primary"
                },
                {
                    text: "<i class='feather icon-trash'></i> Remove Product From List",
                    action: function () {
                        $('#loading-animation-modal').modal('show');
                        $(".add-new-data").addClass("show");
                        $(".overlay-bg").addClass("show");
                        $('#loader-animation').attr('hidden', false);
                        $('#modal-close-button').attr('hidden', true);

                        var table_row = $('tr[role=row]');

                        $.each(table_row, function (index, value) {
                            if ($(value).hasClass('selected')) {
                                selected_rows_global.push($(value).attr('data-selected-product-id'));
                            }
                        });

                        if (selected_rows_global.length > 0) {
                            console.log(selected_rows_global);

                            $('#loader-animation').attr('hidden', false);
                            $('#modal-close-button').attr('hidden', true);
                            $('#loading-animation-modal').modal('show');
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                }
                            });
                            //push multiple products to shopify
                            $.ajax({
                                url: url + '/retailer/products/bulk/delete',
                                type: 'POST',
                                data: {
                                    'products': selected_rows_global
                                },
                                success: function (success) {

                                    if (success['status'] == 200) {
                                        if (success['message'] === 'deleted') {
                                            toastr.success('Product has been Deleted successfully.');
                                            $('#loader-animation').attr('hidden', true);
                                            $('#show-message').text('Product has been deleted successfully.');
                                            $('#modal-close-button').attr('hidden', false);

                                        }
                                    } else {
                                        console.log(success['message']);
                                        toastr.warning(success['message']);
                                        $('#loading-animation-modal').modal('hide');
                                    }
                                },
                                error: function (error) {
                                    console.log(error);
                                    toastr.warning(error);
                                },
                            });
                        } else {
                            toastr.error('Please select any product first to delete it to from your import list')
                        }

                    },
                    className: "btn-outline-danger d-none ml-1 bulk-remove-product-list"
                }
            ],
            initComplete: function (settings, json) {
                $(".dt-buttons .btn").removeClass("btn-secondary")
            }
        });

    }

    dataThumbView.on('draw.dt', function () {
        setTimeout(function () {
            if (navigator.userAgent.indexOf("Mac OS X") != -1) {
                $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
            }
        }, 50);
    });

    // To append actions dropdown before add new button
    var actionDropdown = $(".actions-dropodown")
    actionDropdown.insertBefore($(".top .actions .dt-buttons"))


    // Scrollbar
    if ($(".data-items").length > 0) {
        new PerfectScrollbar(".data-items", {wheelPropagation: false})
    }

    // Close sidebar
    $(".hide-data-sidebar, .cancel-data-btn, .overlay-bg").on("click", function () {
        $(".add-new-data").removeClass("show")
        $(".overlay-bg").removeClass("show")
        $("#data-name, #data-price").val("")
        $("#data-category, #data-status").prop("selectedIndex", 0)
    })

    // On Edit
    $('.action-edit').on("click", function (e) {
        e.stopPropagation();
        $('#data-name').val('Altec Lansing - Bluetooth Speaker');
        $('#data-price').val('$99');
        $(".add-new-data").addClass("show");
        $(".overlay-bg").addClass("show");
    });

    // On Delete
    $('.action-delete').on("click", function (e) {
        e.stopPropagation();
        $(this).closest('td').parent('tr').fadeOut();
    });


    // mac chrome checkbox fix
    if (navigator.userAgent.indexOf("Mac OS X") != -1) {
        $(".dt-checkboxes-cell input, .dt-checkboxes").addClass("mac-checkbox")
    }
});
