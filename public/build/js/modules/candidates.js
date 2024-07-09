$(document).ready(function() {

    if ($("#candidatesTable").length > 0) {

        $('#candidatesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "./candidate/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                // {
                //     data: ,
                //     orderable: ,
                //     render: ,
                //     className: ,
                // },
                {
                    data: "no",
                    orderable: false,
                },
                {
                    data: "type",
                    orderable: false,
                },
                {
                    data: "session",
                    orderable: false,
                },
                {
                    data: "band",
                    orderable: false,
                },
                {
                    data: "id",
                    orderable: false,
                    render: function (data, type, row, meta) {

                        var buttonCheckCert = '';
                        var buttonPrintPDF = '';
                        var buttonPrintMPM = '';

                        var modalSelf = 'modalVerifyPDF';
                        var modalMPM = 'modalVerifyMPM';
                        var modalPayment = 'modalPayment';
                        var modalPaymentMpm = 'modalPaymentMpm';

                        // if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                        if (row.is_more2year) { //lebih 2 tahun and tak bayar lagi
                            if (row.is_selfPrintPaid) {
                                buttonPrintPDF =
                                '<a href="/candidate/view-result/'+data+'" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 printPdfButton modalVerify">' +
                                    '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                    'PDF SELF PRINT' +
                                '</a>'

                            } else {
                                buttonPrintPDF =
                                '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                                    '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                    'PDF SELF PRINT' +
                                '</a>'
                            }

                            buttonPrintMPM =
                            // href="/candidate/pos-result/'+data+'"
                            '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalUpcoming modalPaymentMpm1" data-bs-toggle="modal" data-bs-target="#modalPaymentMpm1">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                                'PRINTING BY MPM' +
                            '</a> '
                        } else {
                            buttonPrintPDF =
                            // '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#1'+modalSelf+'">' +
                            //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                            //     'PRINT PDF' +
                            // '</a>'

                            // '<a href="/candidate/'+data+'/printpdf" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify">' +
                            '<button data-type="SELF_PRINT" type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                'PDF SELF PRINT' +
                            '</button>'

                            buttonPrintMPM =
                            '<button data-type="MPM_PRINT" type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalUpcoming modalVerify1" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'1">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                                'PRINTING BY MPM' +
                            '</button> '
                            // '<a href="/candidate-printmpm" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                            //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                            //     'PRINTING BY MPM' +
                            // '</a> '

                        }

                        // if (row.is_mpmPrintPaid || row.is_selfPrintPaid ) {
                            var buttonCheckCert =
                            '<a href="/candidate/order/'+data+'" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                                '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                                'ORDER HISTORY' +
                            '</a>'
                        // }

                        return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;

                    },
                    // className: ,
                }
            ],
            // dom: 'frtp',
            pageLength: 10,
            order: [[0, "asc"]],
            buttons: {
                dom: {
                    button: {
                        tag: 'button',
                        className: 'btn btn-sm'
                    }
                },
                buttons: [
                    {
                        extend: "copyHtml5",
                        text: "Salin",
                        className: 'btn-secondary'
                    },
                    // {
                    //     extend: "csvHtml5",
                    //     text: "CSV",
                    //     className: 'btn-secondary'
                    // }
                ],
            },
            language: {
                // "zeroRecords": "There are no records to display.",
                // "paginate": {
                // "info": "Display _START_ / _END_ of _TOTAL_ records",
                // "infoEmpty": "Showing 0 to 0 of 0 entries",
                // "infoFiltered": "(filter of _MAX_ record)",
                // "processing": "Processing...",
                // "search": "Search:"
            },
            searching: false,
            lengthChange: false,
            drawCallback: function() {
                // Initialize tooltips after the table is drawn
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    $(document).on('click', '.modalPayment', function() {
        var certID = $(this).data('id');
        // Construct the dynamic URL based on the data-id
        var dynamicUrl = '/candidate/selfprint/' + certID;

        // Update the href attribute of the "Continue" button
        $('#modalPayment a.btn-success').attr('href', dynamicUrl);
    });

    $(document).on('click', '.modalPaymentMpm', function() {
        var certID = $(this).data('id');
        // Construct the dynamic URL based on the data-id
        var dynamicUrl = '/candidate/pos-result/' + certID;

        // Update the href attribute of the "Continue" button
        $('#modalPaymentMpm a.btn-success').attr('href', dynamicUrl);
    });

    $(document).on('click', '.modalVerify', function() {
        $('#indexNumber').val('')
        var certID = $(this).data('id');
        console.log("Modal Verify Button Clicked");
        var type = $(this).data('type');
        console.log(type, certID);

            $(document).off('click', '#verifyIndexNumber').on('click', '#verifyIndexNumber', function(){
            var indexNum = $('#indexNumber').val();

            console.log(type, certID, indexNum);

            // Perform AJAX request to check the index number
            $.ajax({
                url: './candidate/verifyIndexNumber',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    indexNumber: indexNum,
                    certID: certID
                },
                success: function(response) {
                    if (response.success) {
                        // If index number is valid, redirect or perform further actions
                        console.log(response)
                        if (type == "MPM_PRINT") {
                            window.location.href = '/candidate/pos-result/'+response.id;
                        }else{ //SELF_PRINT
                            window.location.href = '/candidate/view-result/'+response.id;
                        }
                    } else {
                        console.log(response)

                        // If index number is invalid, show SweetAlert error
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    console.error(xhr.responseText);
                }
            });
        });
    });

    $(document).on('click', '.modalUpcoming', function(){
        Swal.fire({
            icon: "info",
            html: 'This feature will be enabled in future. Thank you.',
            showConfirmButton: false,
        });
    });

});
