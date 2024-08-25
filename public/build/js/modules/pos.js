$(document).ready(function () {

    if ($('#posNewTable').length) {

        var table = $('#posNewTable').DataTable({
            // dom: '<"top"rt><"bottom"lp><"clear">', // Hides the built-in search bar
            processing: true,
            serverSide: true,

            ajax: {
                "url": "/pos/new/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posNewTable').data('type');
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                    d.textSearch = $('#text-search').val();
                    d.examType = $('#exam_type').val();
                }
            },
            columns: [
                // Checkbox column
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return '<input type="checkbox" class="form-check-input row-checkbox" data-id="' + data.id + '">';
                    }
                },
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // },
                {
                    data: "order_date",
                    orderable: false,
                },
                {
                    data: "order_id",
                    orderable: false,
                },
                {
                    data: "details",
                    orderable: false,
                    render(data, type, row) {
                        let txt = '';
                        txt = '<div style="text-align:left;">' + data + '<br>' + row.candidate_name + '</div>';
                        return txt;
                    }
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="' + data + '" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';
                        return btn;
                    }
                }
            ],
            dom: 'frtp',
            pageLength: 10,
            order: [[0, "asc"]],
            // buttons: {
            //     dom: {
            //         button: {
            //             tag: 'button',
            //             className: 'btn btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: "copyHtml5",
            //             text: "Salin",
            //             className: 'btn-secondary'
            //         },
            //         // {
            //         //     extend: "csvHtml5",
            //         //     text: "CSV",
            //         //     className: 'btn-secondary'
            //         // }
            //     ],
            // },
            language: {
                // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                // "paginate": {
                // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                // "processing": "Sila tunggu...",
                // "search": "Carian:"
            },
            searching: true,
            lengthChange: true,
            // scrollX: true,
            // initComplete: function(settings, json) {
            //     $('.dt-scroll-body thead').css('visibility', 'visible');
            //     $('.dt-scroll-head thead').css('visibility', 'collapse');

            //     $(window).resize(function() {
            //         var screenWidth = $(window).width();
            //         if (screenWidth < 768) {
            //             $('.dt-scroll-body thead').css('visibility', 'visible');
            //             $('.dt-scroll-head thead').css('visibility', 'collapse');
            //         } else {
            //             $('.dt-scroll-body thead').css('visibility', 'visible');
            //             $('.dt-scroll-head thead').css('visibility', 'collapse');
            //         }
            //     }).trigger('resize');
            // }
        });
    }

    $(document).on('click', '.btn-cancel-pos', function () {

        Swal.fire({
            title: "Are you sure?",
            // text: "Once approved, the data will be updated!",
            icon: "warning",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            reverseButtons: true
            // denyButtonText: `Don't save`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pos/new/cancel',
                    type: 'POST',
                    data: $('form').serialize(),
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Loading...', // Optional title for the alert
                            allowEscapeKey: false,  // Disables escape key closing the alert
                            allowOutsideClick: false, // Disables outside click closing the alert
                            showConfirmButton: false, // Hides the "Confirm" button
                            didOpen: () => {
                                Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                            }
                        });
                    },
                    success: function (response) {
                        Swal.close()
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    $(document).on('click', '.btn-approve-new', function () {

        Swal.fire({
            title: "Are you sure?",
            text: "Once approved, the data will be updated!",
            icon: "warning",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            reverseButtons: true
            // denyButtonText: `Don't save`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pos/new/update',
                    type: 'POST',
                    data: $('form').serialize(),
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Loading...', // Optional title for the alert
                            allowEscapeKey: false,  // Disables escape key closing the alert
                            allowOutsideClick: false, // Disables outside click closing the alert
                            showConfirmButton: false, // Hides the "Confirm" button
                            didOpen: () => {
                                Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                            }
                        });
                    },
                    success: function (response) {
                        Swal.close()
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    $(document).on('click', '.btn-update-pos', function () {

        var recordId = $(this).data('id');
        $.ajax({
            url: './new/getPosDetail', // Replace with your endpoint
            method: 'GET',
            data: { id: recordId },
            beforeSend: function () {
                Swal.fire({
                    title: 'Loading...', // Optional title for the alert
                    allowEscapeKey: false,  // Disables escape key closing the alert
                    allowOutsideClick: false, // Disables outside click closing the alert
                    showConfirmButton: false, // Hides the "Confirm" button
                    didOpen: () => {
                        Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                    }
                });
            },
            success: function (response) {
                Swal.close()
                console.log(response);
                // Populate modal with record details
                $('#name').val(response.candidate.nama)
                $('#nric').val(response.candidate.kp)
                // $('#phone_num').val(response.candidate.phone_num)
                // $('#email').val(response.candidate.email)
                $('#address').val(response.candidate.alamat1)
                $('#postcode').val(response.candidate.poskod)
                $('#city').val(response.candidate.bandar)
                $('#state').val(response.candidate.negeri_id)
                // $('#name').val(response.name);
                // $('#email').val(response.email);
                $('#order_id').val(response.order.order_id)

                if ($(".shipping_info").length) {
                    $('#ship_name').val(response.order.name)
                    $('#ship_phoneNum').val(response.order.phone_num)
                    $('#ship_email').val(response.order.email)
                    $('#ship_address').val(response.order.address1)
                    $('#ship_postcode').val(response.order.postcode)
                    $('#ship_city').val(response.order.city)
                    $('#ship_state').val(response.order.state)
                    $('#ship_trackNum').val(response.order.tracking_number)
                    $('#ship_trackRemarks').val(response.order.type)

                    $('#button-print-certificate-pdf').attr('href', '/pos/downloadpdf/' + response.candidate.candidate_cryptId);

                }


                // Show the modal
                $('#modalUpdatePos').modal('show');
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    });

    if ($('#posProcessTable').length) {

        var table = $('#posProcessTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/processing/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posProcessTable').data('type');
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                    d.noTracking = $('#noTracking').val();
                    d.textSearch = $('#text-search').val();
                    d.examType = $('#exam_type').val();
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return '<input type="checkbox" class="form-check-input row-checkbox" data-id="' + data.id + '">';
                    }
                },
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // },
                {
                    data: "order_date",
                    orderable: true,
                },
                {
                    data: "order_id",
                    orderable: false,
                },
                {
                    data: "details",
                    orderable: false,
                    render(data, type, row) {
                        let html = '';
                        // html = data + '<br><p>Tracking Number : ' + row.tracking_number + '</p>';
                        html = '<div style="text-align:left;">' + data + '<br>' + row.candidate_name + '<br>Tracking Number : ' + row.tracking_number + '</div>';
                        return html;
                    }
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="' + data + '" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';

                        return btn;
                    }
                },
                {
                    data: "tracking_number",
                    orderable: false,
                    visible: false,
                },
            ],
            dom: 'frtp',
            pageLength: 10,
            // order: [[0, "asc"]],
            // buttons: {
            //     dom: {
            //         button: {
            //             tag: 'button',
            //             className: 'btn btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: "copyHtml5",
            //             text: "Salin",
            //             className: 'btn-secondary'
            //         },
            //         // {
            //         //     extend: "csvHtml5",
            //         //     text: "CSV",
            //         //     className: 'btn-secondary'
            //         // }
            //     ],
            // },
            language: {
                // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                // "paginate": {
                // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                // "processing": "Sila tunggu...",
                // "search": "Carian:"
            },
            searching: false,
            lengthChange: true,
            // scrollX: true,
            // initComplete: function(settings, json) {
            //     $('.dt-scroll-body thead').css('visibility', 'visible');
            //     $('.dt-scroll-head thead').css('visibility', 'collapse');

            //     $(window).resize(function() {
            //         var screenWidth = $(window).width();
            //         if (screenWidth < 768) {
            //             $('.dt-scroll-body thead').css('visibility', 'visible');
            //             $('.dt-scroll-head thead').css('visibility', 'collapse');
            //         } else {
            //             $('.dt-scroll-body thead').css('visibility', 'visible');
            //             $('.dt-scroll-head thead').css('visibility', 'collapse');
            //         }
            //     }).trigger('resize');
            // },

        });
    }

    $('#noTracking').on('change', function () {
        if (this.checked) {
            $(this).prop('value', '1');
            $('#noTrackingLabel').text('Got Tracking Number');
        } else {
            $(this).prop('value', '0');
            $('#noTrackingLabel').text('Get Orders Without Tracking');
        }
    });

    $(document).on('click', '.btn-approve-processing', function () {

        Swal.fire({
            title: "Are you sure?",
            text: "Once approved, the data will be updated!",
            icon: "warning",
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Save",
            reverseButtons: true
            // denyButtonText: `Don't save`
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/pos/processing/update',
                    type: 'POST',
                    data: $('form').serialize(),
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Loading...', // Optional title for the alert
                            allowEscapeKey: false,  // Disables escape key closing the alert
                            allowOutsideClick: false, // Disables outside click closing the alert
                            showConfirmButton: false, // Hides the "Confirm" button
                            didOpen: () => {
                                Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                            }
                        });
                    },
                    success: function (response) {
                        Swal.close()
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            table.ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            table.draw(); // This line redraws the DataTable
                        } else {
                            console.log(response);
                            // Swal.fire("Error!", "Failed to update data.", "error");
                            Swal.fire("Error!", response.message, "error");

                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    $(document).on('click', '#button-save-pos-processing', function () {

        if (
            $('#ship_name').val() == "" ||
            $('#ship_phoneNum').val() == "" ||
            $('#ship_email').val() == "" ||
            $('#ship_address').val() == "" ||
            $('#ship_postcode').val() == "" ||
            $('#ship_city').val() == "" ||
            $('#ship_state').val() == "" ||
            $('#ship_trackNum').val() == ""
        ) {
            Swal.fire("Error!", "Please fill all field", "error");
        } else {

            Swal.fire({
                title: "Are you sure?",
                text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/save/update',
                        type: 'POST',
                        data: $('form').serialize(),
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                table.ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                table.draw(); // This line redraws the DataTable
                            } else {
                                console.log(response);
                                // Swal.fire("Error!", "Failed to update data.", "error");
                                Swal.fire("Error!", response.message, "error");

                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        }

    })

    if ($('#posCompleteTable').length) {
        var table = $('#posCompleteTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/complete/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posCompleteTable').data('type');
                    d.textSearch = $('#text-search').val();
                    d.startDate = $('#start-date').val();
                    d.endDate = $('#end-date').val();
                    d.examType = $('#exam_type').val();
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        return '<input type="checkbox" class="form-check-input row-checkbox" data-id="' + data.id + '">';
                    }
                },
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         return meta.row + 1;
                //     }
                // },
                {
                    data: "order_date",
                    orderable: true,
                },
                {
                    data: "order_id",
                    orderable: false,
                },
                // {
                //     data: "details",
                //     orderable: false,
                // },
                {
                    data: "details",
                    orderable: false,
                    render(data, type, row) {
                        let html = '';
                        html = '<div style="text-align:left;">' + data + '<br>' + row.candidate_name + '<br>Tracking Number : ' + row.tracking_number + '</div>';
                        return html;
                    }
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<a href="' + row.consignment_note + '" target=_blank type="button" data-id="' + data + '" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-download-2-line" aria-hidden="true"></i></a>';
                        btn += '<button type="button" data-id="' + data + '" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';
                        return btn;
                    }
                }

            ],
            dom: 'frtp',
            pageLength: 10,
            // order: [[0, "asc"]],
            // buttons: {
            //     dom: {
            //         button: {
            //             tag: 'button',
            //             className: 'btn btn-sm'
            //         }
            //     },
            //     buttons: [
            //         {
            //             extend: "copyHtml5",
            //             text: "Salin",
            //             className: 'btn-secondary'
            //         },
            //         // {
            //         //     extend: "csvHtml5",
            //         //     text: "CSV",
            //         //     className: 'btn-secondary'
            //         // }
            //     ],
            // },
            language: {
                // "zeroRecords": "Tiada rekod untuk dipaparkan.",
                // "paginate": {
                // "info": "Paparan _START_ / _END_ dari _TOTAL_ rekod",
                // "infoEmpty": "Paparan 0 / 0 dari 0 rekod",
                // "infoFiltered": "(tapisan dari _MAX_ rekod)",
                // "processing": "Sila tunggu...",
                // "search": "Carian:"
            },
            searching: false,
            lengthChange: true,
            // scrollX: true,
            // initComplete: function(settings, json) {
            //     $('.dt-scroll-body thead').css('visibility', 'visible');
            //     $('.dt-scroll-head thead').css('visibility', 'collapse');

            //     $(window).resize(function() {
            //         var screenWidth = $(window).width();
            //         if (screenWidth < 768) {
            //             $('.dt-scroll-body thead').css('visibility', 'visible');
            //             $('.dt-scroll-head thead').css('visibility', 'collapse');
            //         } else {
            //             $('.dt-scroll-body thead').css('visibility', 'visible');
            //             $('.dt-scroll-head thead').css('visibility', 'collapse');
            //         }
            //     }).trigger('resize');
            // },
        });
    }
    // // Handle change event on custom dropdown
    // $('#entries').on('change', function() {
    //     var length = $(this).val();
    //     table.page.len(length).draw();  // Update the DataTable page length
    // });

    // // Optional: Set the initial value of the dropdown based on the DataTable's page length
    // $('#entries').val(table.page.len());

    var today = new Date().toISOString().split('T')[0];
    $('#start-date').attr('max', today);

    // Enable/disable the end date input based on the start date value
    $('#start-date').on('change', function () {
        if ($(this).val()) {
            $('#end-date').prop('disabled', false);
        } else {
            $('#end-date').prop('disabled', true);
        }

        var startDate = $(this).val();
        $('#end-date').attr('min', startDate).prop('disabled', !startDate);
        $('#end-date').val(startDate)
    });

    $('#text-search').on('keyup change', function () {
        table.search(this.value).draw();
    });

    $(document).on('click', '#filterBtn', function () {

        table.ajax.reload();
    })

    //clear filter
    $(document).on('click', '#resetBtn', function () {
        $('#start-date').val('');
        $('#end-date').val('');
        $('#text-search').val('');
        $('#exam_type').val('');

        $('#noTracking').prop('value', '0');
        $('#noTracking').prop('checked', false);

        table.ajax.reload();
    })


    // BULK ACTION
    $(document).on('click', '.check-all', function () {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });

    $(document).on('click', '#btnBulkCancel', function () {
        var orderIds = [];
        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure to bulk cancel?",
                text: "Once cancel, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/new/bulk/cancel',
                        type: 'POST',
                        data: postData,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }

    });

    $(document).on('click', '#btnBulkApprove', function () {
        var orderIds = [];

        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure to bulk approve?",
                text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/new/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }

    });

    $(document).on('click', '#btnBulkComplete', function () {
        var orderIds = [];

        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });
        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure to bulk approve?",
                text: "Please make sure all the record already have tracking number. Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/processing/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posNewTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posNewTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }

    });

    $(document).on('click', '#btnExportExcel', function () {

        var orderIds = [];

        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();
        const textSearch = $('#text-search').val();

        var postData = {
            orderID: orderIds,
            startDate: startDate,
            endDate: endDate,
            textSearch: textSearch,
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure to export xlsx?",
                // text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Export",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var type = $(this).data('type');
                    const url = '/admin/pos-management/' + type + '/generateExcel';
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: postData,
                        xhrFields: {
                            responseType: 'blob' // Important for file download
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (data) {
                            Swal.close()
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            a.href = url;
                            a.download = 'report-' + type + '.xlsx';
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        },
                        error: function () {
                            alert('Error generating the report.');
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }
    });

    $(document).on('click', '#button-export-xlsx', function () {

        var orderIds = [];

        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();
        const textSearch = $('#text-search').val();
        const noTracking = $('#noTracking').val();
        var postData = {
            orderID: orderIds,
            startDate: startDate,
            endDate: endDate,
            textSearch: textSearch,
            noTracking: noTracking,
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure want to export record to excel?",
                // text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var type = $(this).data('type');
                    const url = '/admin/pos-management/' + type + '/generateExcel';
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: postData,
                        xhrFields: {
                            responseType: 'blob' // Important for file download
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (data) {
                            Swal.close()
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            a.href = url;
                            a.download = 'report-' + type + '.xlsx';
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        },
                        error: function () {
                            alert('Error generating the report.');
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }
    });

    $(document).on('click', '#button-export-pos-xlsx', function () {

        var orderIds = [];

        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();
        const textSearch = $('#text-search').val();
        const noTracking = $('#noTracking').val();

        var postData = {
            orderID: orderIds,
            startDate: startDate,
            endDate: endDate,
            textSearch: textSearch,
            noTracking: noTracking,
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure want to export POS excel?",
                // text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var type = $(this).data('type');
                    const url = '/admin/pos-management/' + type + '/generateExcelPos';
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: postData,
                        xhrFields: {
                            responseType: 'blob' // Important for file download
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (data) {
                            Swal.close()

                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            a.href = url;
                            a.download = 'report-' + type + '.xlsx';
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        },
                        error: function () {
                            alert('Error generating the report.');
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }
    });

    $(document).on('click', '#button-import-pos-xlsx', function () {
        $('#formFile').val('');
        $('#modal_upload_xlsx').modal('show');
    });

    $(document).on('click', '#submit-upload', function (e) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = new FormData($('#form_upluad_xlsx')[0]);

        Swal.fire({
            type: 'warning',
            title: 'Adakah Anda Pasti?',
            text: 'Fail Xlsx Akan di Muat Naik!',
            customClass: {
                popup: 'my-swal-popup',
                confirmButton: 'my-swal-confirm',
                cancelButton: 'my-swal-cancel',
            },
            showCancelButton: true, // Show the cancel button
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                var type = 'PROCESSING';
                var url = '/admin/pos-management/' + type + '/generateImportExcelPos';
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Loading...', // Optional title for the alert
                            allowEscapeKey: false,  // Disables escape key closing the alert
                            allowOutsideClick: false, // Disables outside click closing the alert
                            showConfirmButton: false, // Hides the "Confirm" button
                            didOpen: () => {
                                Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                            }
                        });
                    },
                    success: function (response) {
                        $('#form_upluad_xlsx').removeClass('was-validated');
                        Swal.fire({
                            type: 'success',
                            title: 'Berjaya',
                            text: 'Berjaya Muat Naik Xlsx',
                            customClass: {
                                popup: 'my-swal-popup',
                                confirmButton: 'my-swal-confirm',
                                cancelButton: 'my-swal-cancel',
                            }
                        }).then((result) => {
                            if (result.value) {
                                $('#modal_upload_xlsx').modal('hide');
                                window.location.reload();
                            }
                        });
                    },
                    error: function (xhr, status, errors) {
                        $('#form_upluad_xlsx').addClass('was-validated');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            console.log(xhr.responseJSON.errors);
                            Swal.fire({
                                icon: "error",
                                title: 'Gagal',
                                text: xhr.responseJSON.message,
                                customClass: {
                                    popup: 'my-swal-popup',
                                    confirmButton: 'my-swal-confirm',
                                    cancelButton: 'my-swal-cancel',
                                }
                            });

                            var firstError = Object.values(xhr.responseJSON.errors)[0][0];
                            $('#show-validate').text(firstError);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: 'Gagal',
                                text: xhr.responseText,
                                customClass: {
                                    popup: 'my-swal-popup',
                                    confirmButton: 'my-swal-confirm',
                                    cancelButton: 'my-swal-cancel',
                                }
                            });
                            $('#show-validate').text(xhr.responseText);
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '#btnBulkProcessing', function () {
        var orderIds = [];

        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if (orderIds.length > 0) {
            Swal.fire({
                title: "Are you sure to bulk approve?",
                text: "Once approved, the data will be updated!",
                icon: "warning",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes",
                reverseButtons: true
                // denyButtonText: `Don't save`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/pos/processing/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...', // Optional title for the alert
                                allowEscapeKey: false,  // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close()
                            if (response.success) {
                                // Close modal
                                $('#modalUpdatePos').modal('hide');

                                Swal.fire("Saved!", "", "success");

                                // Refresh data table
                                $('#posProcessTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                                // Optionally, you can also redraw the DataTable to update the UI
                                $('#posProcessTable').DataTable().draw(); // This line redraws the DataTable
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        },
                        error: function (xhr, status, error) {
                            // Handle error
                            Swal.fire("Error!", "Failed to update data.", "error");
                        }
                    });
                } else {

                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }

    });

    $(document).on('click', '#btnBulkPrintProcessing', function () {
        var orderIds = [];
        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        if (orderIds.length > 0) {
            Swal.fire({
                title: 'Preparing Bulk MUET Result...', // Optional title for the alert
                allowEscapeKey: false,  // Disables escape key closing the alert
                allowOutsideClick: false, // Disables outside click closing the alert
                showConfirmButton: false, // Hides the "Confirm" button
                didOpen: () => {
                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                }
            });
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/pos/bulkdownloadpdf',
                method: 'POST',
                data: { orderIds: orderIds },
                xhrFields: {
                    responseType: 'blob' // Important for file download
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    window.open(url, '_blank');
                    Swal.close();
                },
                error: function () {
                    Swal.close();
                    Swal.fire({
                        title: "Error generating the Bulk Result",
                        // text: "Once approved, the data will be updated!",
                        icon: "error",
                    })
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }

    });

    $(document).on('click', '#btnBulkConsignment', function () {
        var orderIds = [];
        $('.row-checkbox:checked').each(function () {
            orderIds.push($(this).data('id'));
        });

        if (orderIds.length > 0) {
            Swal.fire({
                title: 'Preparing Bulk Consignment Note...', // Optional title for the alert
                allowEscapeKey: false,  // Disables escape key closing the alert
                allowOutsideClick: false, // Disables outside click closing the alert
                showConfirmButton: false, // Hides the "Confirm" button
                didOpen: () => {
                    Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
                }
            });
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/pos/bulkdownloadconnote',
                method: 'POST',
                data: { orderIds: orderIds },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (data) {
                    console.log(data)
                    if (data) {
                        // Open the PDF in a new tab
                        // window.open(data, '_blank');
                        Swal.close();
                        // Create a temporary link element
                        var link = document.createElement('a');
                        link.href = data;
                        link.download = 'Bulk_Connote.pdf'; // The name you want the file to be saved as

                        // Append the link to the body (it must be in the DOM to work)
                        document.body.appendChild(link);

                        // Programmatically click the link to trigger the download
                        link.click();

                        // Remove the link from the DOM
                        document.body.removeChild(link);
                    } else {
                        console.error('PDF URL not provided in response');
                        Swal.fire({
                            title: "Error",
                            text: "Failed to retrieve PDF URL.",
                            icon: "error"
                        });
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire({
                        title: "Error generating the Bulk Result",
                        icon: "error",
                    });
                }
            });
        } else {
            Swal.fire({
                title: "No row selected",
                // text: "Once approved, the data will be updated!",
                icon: "error",
            })
        }

    });
});
