$(document).ready(function() {

    if ($('#posNewTable').length) {

        $('#posNewTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/new/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posNewTable').data('type');
                }
            },
            columns: [
                // Checkbox column
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return '<input type="checkbox" class="row-checkbox" data-id="' + data.id + '">';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
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
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';

                        // btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos" ><i class="ri-information-line fs-22"></i></button>';
                        // btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos" data-bs-toggle="modal" data-bs-target="#modalUpdatePos" ><i class="ri-information-line fs-22"></i></button>';
                        // btn += data == 'NEW' ? '<button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target=".modalUpdatePos"><i class="ri-information-line fs-22"></i></button>' : '';
                        // btn += row.actionDelete ? '<a id="button-delete" href="javascript:void(0);" data-url="' + row.actionDelete + '" style="margin-left: 5px; margin-right: 5px;" class="text-danger btn-delete"><i class="mdi mdi-delete font-size-18"></i></a>' : '';
                        return btn;
                    }
                }
                // {
                //     data: "id",
                //     orderable: false,
                // },
                // {
                //     data: "id",
                //     orderable: false,
                //     render: function (data, type, row, meta) {

                //         var buttonCheckCert = '';
                //         var buttonPrintPDF = '';
                //         var buttonPrintMPM = '';

                //         console.log(data, row.is_more2year, row.is_selfPrintPaid, row.is_mpmPrintPaid);
                //         var modalSelf = 'modalVerifyPDF';
                //         var modalMPM = 'modalVerifyMPM';
                //         var modalPayment = 'modalPayment';

                //         if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             // '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '
                //             '<a href="/candidates-printmpm/'+data+'" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</a> '
                //         } else {
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalSelf+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</button> '
                //             // '<a href="/candidates-printmpm" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '

                //         }

                //         if (row.is_mpmPrintPaid ) {
                //             var buttonCheckCert =
                //             '<a href="/muet-status" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                //                 '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                //                 'CERTIFICATE STATUS' +
                //             '</a>'
                //         }

                //         return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;

                //     },
                //     // className: ,
                // }
            ],
            // pageLength: 50,
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
            searching: true,
            lengthChange: false,
        });
    }

    // Add click event listener to the button within the DataTable
    $(document).on('click', '.btn-update-pos', function() {

        var recordId = $(this).data('id');
        $.ajax({
            url: './new/getPosDetail', // Replace with your endpoint
            method: 'GET',
            data: { id: recordId },
            beforeSend:function(){
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
            success: function(response) {
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

                    $('#button-print-certificate-pdf').attr('href', '/pos/candidates-downloadpdf/' + response.candidate.candidate_cryptId);

                }


                // Show the modal
                $('#modalUpdatePos').modal('show');
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    });

    $(document).on('click', '.btn-approve-new', function() {

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
                    success: function(response){
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
                    error: function(xhr, status, error){
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    if ($('#posProcessTable').length) {

        $('#posProcessTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/process/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posProcessTable').data('type');
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return '<input type="checkbox" class="row-checkbox" data-id="' + data.id + '">';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
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
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';

                        // btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos" ><i class="ri-information-line fs-22"></i></button>';
                        // btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos" data-bs-toggle="modal" data-bs-target="#modalUpdatePos" ><i class="ri-information-line fs-22"></i></button>';
                        // btn += data == 'NEW' ? '<button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target=".modalUpdatePos"><i class="ri-information-line fs-22"></i></button>' : '';
                        // btn += row.actionDelete ? '<a id="button-delete" href="javascript:void(0);" data-url="' + row.actionDelete + '" style="margin-left: 5px; margin-right: 5px;" class="text-danger btn-delete"><i class="mdi mdi-delete font-size-18"></i></a>' : '';
                        return btn;
                    }
                }
                // {
                //     data: "id",
                //     orderable: false,
                // },
                // {
                //     data: "id",
                //     orderable: false,
                //     render: function (data, type, row, meta) {

                //         var buttonCheckCert = '';
                //         var buttonPrintPDF = '';
                //         var buttonPrintMPM = '';

                //         console.log(data, row.is_more2year, row.is_selfPrintPaid, row.is_mpmPrintPaid);
                //         var modalSelf = 'modalVerifyPDF';
                //         var modalMPM = 'modalVerifyMPM';
                //         var modalPayment = 'modalPayment';

                //         if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             // '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '
                //             '<a href="/candidates-printmpm/'+data+'" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</a> '
                //         } else {
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalSelf+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</button> '
                //             // '<a href="/candidates-printmpm" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '

                //         }

                //         if (row.is_mpmPrintPaid ) {
                //             var buttonCheckCert =
                //             '<a href="/muet-status" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                //                 '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                //                 'CERTIFICATE STATUS' +
                //             '</a>'
                //         }

                //         return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;

                //     },
                //     // className: ,
                // }
            ],
            // pageLength: 50,
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
            lengthChange: false,
        });
    }

    $(document).on('click', '.btn-approve-processing', function() {

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
                    success: function(response){
                        if (response.success) {
                            // Close modal
                            $('#modalUpdatePos').modal('hide');

                            Swal.fire("Saved!", "", "success");

                            // Refresh data table
                            $('#posProcessTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                            // Optionally, you can also redraw the DataTable to update the UI
                            $('#posProcessTable').DataTable().draw(); // This line redraws the DataTable
                        } else {
                            console.log(response);
                            // Swal.fire("Error!", "Failed to update data.", "error");
                            Swal.fire("Error!", response.message, "error");

                        }
                    },
                    error: function(xhr, status, error){
                        // Handle error
                        Swal.fire("Error!", "Failed to update data.", "error");
                    }
                });
            } else {

            }
        });
    })

    if ($('#posCompleteTable').length) {
        $('#posCompleteTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/pos/complete/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#posCompleteTable').data('type');
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
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
                },
                {
                    data: 'id',
                    class: 'text-center',
                    orderable: false,
                    searchable: false,
                    render(data, type, row) {
                        let btn = '';
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';
                        return btn;
                    }
                }

            ],
            // pageLength: 50,
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
            lengthChange: false,
        });
    }

    $(document).on('click', '.check-all', function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Button action to get selected rows and display them in console
    $(document).on('click', '#btnBulkApprove', function() {
        var orderIds = [];

        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });

        console.log(orderIds);
        console.log($('meta[name="csrf-token"]').attr('content'));

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        Swal.fire({
            title: 'Loading...', // Optional title for the alert
            allowEscapeKey: false,  // Disables escape key closing the alert
            allowOutsideClick: false, // Disables outside click closing the alert
            showConfirmButton: false, // Hides the "Confirm" button
        });
        Swal.close()

        if(orderIds.length > 0){
            Swal.fire({
                title: "Are you sure to bulk approve?",
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
                        url: '/pos/new/bulk/update',
                        type: 'POST',
                        data: postData,
                        beforeSend:function(){
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
                        success: function(response){
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
                        error: function(xhr, status, error){
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

    $(document).on('click', '#btnBulkCancel', function() {
        var orderIds = [];
        $('.row-checkbox:checked').each(function() {
            orderIds.push($(this).data('id'));
        });

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            orderID: orderIds
        };

        if(orderIds.length > 0){
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
                        beforeSend:function(){
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
                        success: function(response){
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
                        error: function(xhr, status, error){
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

    $(document).on('click', '#btnExportExcel', function (){

        var type = $(this).data('type');
        window.location.href = '/pos-management/'+type+'/generateExcel';
    })

});
