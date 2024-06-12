$(document).ready(function() {

    if ($("#candidatesTable").length) {

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

                        // if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                        if (row.is_more2year) { //lebih 2 tahun and tak bayar lagi
                            if (row.is_selfPrintPaid) {
                                buttonPrintPDF =
                                '<a href="/candidate/view-result/'+data+'" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 printPdfButton modalVerify">' +
                                    '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                    'PRINT PDF' +
                                '</a>'

                            } else {
                                buttonPrintPDF =
                                '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                                    '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                    'PRINT PDF' +
                                '</a>'
                            }

                            buttonPrintMPM =
                            '<a href="/candidate/pos-result/'+data+'" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
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
                                'PRINT PDF' +
                            '</button>'

                            buttonPrintMPM =
                            '<button data-type="MPM_PRINT" type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
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
            // pageLength: 50,
            // order: [[0, "asc"]],
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
            drawCallback: function() {
                // Initialize tooltips after the table is drawn
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    }

    $(document).on('click', '.modalPayment', function() {
        var certID = $(this).data('id');
        console.log(certID);
        // Construct the dynamic URL based on the data-id
        var dynamicUrl = '/candidate/selfprint/' + certID;

        // Update the href attribute of the "Continue" button
        $('#modalPayment a.btn-success').attr('href', dynamicUrl);
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

    $(document).on('click', '.btnForgotIndexNumber', function(){
        Swal.fire({
            icon: "info",
            text: "To obtain your MUET registration number, please email the MPM at the email address provided.",
            footer: '<a href="mailto:mpm@yopmail.com">mpm@yopmail.com</a>'
          });
    })

});
