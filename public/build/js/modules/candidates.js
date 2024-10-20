$(document).ready(function () {

    if ($("#candidatesTable").length > 0) {

        var table = $('#candidatesTable').DataTable({
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
                // {
                //     data: "no",
                //     orderable: false,
                //     responsivePriority: 1
                // },
                {
                    data: null,
                    // className: 'dt-control',  // Ensure the class for expand icon
                    orderable: false,
                    defaultContent: '',
                    responsivePriority: 1, // This column will always show the expand icon
                    render: function(data, type,row,meta) {
                        return '<i class="ri-add-circle-line d-md-none"></i>';
                    }
                },
                {
                    data: "type",
                    orderable: false,
                    responsivePriority: 2
                },
                {
                    data: "session",
                    orderable: false,
                    responsivePriority: 3
                },
                {
                    data: "band",
                    orderable: false,
                    responsivePriority: 4
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

                        if (row.is_more2year) {
                            if (row.is_selfPrintPaid) {
                                if (row.is_mpmPrintPaid) {
                                    buttonPrintPDF =
                                        '<a href="/candidate/view-result/' + data + '" data-id=' + data + ' class="btn btn-success fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 printPdfButton modalVerify">' +
                                        '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i>' +
                                        'PDF SELF PRINT' +
                                        '</a>';
                                } else {
                                    buttonPrintPDF =
                                        '<a href="/candidate/view-result/' + data + '" data-id=' + data + ' class="btn btn-soft-info fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 printPdfButton modalVerify">' +
                                        '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i>' +
                                        'PDF SELF PRINT' +
                                        '</a>';
                                }
                            } else {
                                if (row.is_mpmPrintPaid) {
                                    buttonPrintPDF =
                                        '<a href="/candidate/view-result/' + data + '" data-id=' + data + ' class="btn btn-success fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 printPdfButton modalVerify">' +
                                        '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i>' +
                                        'PDF SELF PRINT' +
                                        '</a>';
                                } else {
                                    buttonPrintPDF =
                                        '<a data-id=' + data + ' class="btn btn-soft-info fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 ' + modalPayment + '" data-bs-toggle="modal" data-bs-target="#' + modalPayment + '">' +
                                        '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i>' +
                                        'PDF SELF PRINT' +
                                        '</a>';
                                }
                            }
                            buttonPrintMPM =
                                '<a data-id=' + data + ' class="btn btn-soft-info fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 modalUpcoming1 modalPaymentMpm" data-bs-toggle="modal" data-bs-target="#modalPaymentMpm">' +
                                '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i> ' +
                                'PRINTING BY MPM' +
                                '</a>';
                        } else {
                            buttonPrintPDF =
                                '<button data-type="SELF_PRINT" type="button" data-id=' + data + ' class="btn btn-soft-info fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 modalVerify" data-bs-toggle="modal" data-bs-target="#' + modalMPM + '">' +
                                '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i>' +
                                'PDF SELF PRINT' +
                                '</button>';

                            buttonPrintMPM =
                                '<button data-type="MPM_PRINT" type="button" data-id=' + data + ' class="btn btn-soft-info fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2 modalUpcoming1 modalVerify" data-bs-toggle="modal" data-bs-target="#' + modalMPM + '">' +
                                '<i class="ri-printer-line label-icon align-middle fs-12 me-2"></i> ' +
                                'PRINTING BY MPM' +
                                '</button>';
                        }

                        var buttonCheckCert =
                            '<a href="/candidate/order/' + data + '" data-id=' + data + ' class="btn btn-soft-secondary fs-12 waves-effect text-black d-block d-md-inline-block mb-2 mx-md-2">' +
                            '<i class="ri-list-check-2 label-icon align-middle fs-12 me-2"></i>' +
                            'ORDER HISTORY' +
                            '</a>';

                        return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;
                    },
                    responsivePriority: 5
                }
            ],
            // dom: 'frtp',
            pageLength: 10,
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
            drawCallback: function () {
                // Initialize tooltips after the table is drawn
                $('[data-toggle="tooltip"]').tooltip();
            },
            columnDefs: [
                {
                    // Set first column to be the row number
                    "targets": 0,
                    "data": null,
                    "defaultContent": "",
                    "orderable": false // Disable sorting for this column
                }
            ],
            // columnDefs: [
            //     {
            //         targets: 0, // Place the expand icon in the first column
            //         className: 'dt-control',
            //         orderable: false,
            //         data: null,
            //         defaultContent: '<i class="ri-arrow-down-s-line"></i>', // Expand icon
            //         responsivePriority: 1 // High priority to make sure it stays visible
            //     }
            // ],
            order: [[1, 'asc']], // Order by the second column by default
            rowCallback: function(row, data, index) {
                // Display the row number in the first column
                $('td:eq(0)', row).html(index + 1);
            },
            responsive: true,
        });


        // Add row click handler to expand/collapse row
        // $('#candidatesTable tbody').on('click', 'tr', function () {
        //     var row = table.row(this);

        //     if (row.child.isShown()) {
        //         row.child.hide();
        //         $(this).removeClass('shown');
        //     } else {
        //         row.child.show();
        //         $(this).addClass('shown');
        //     }
        // });

    }

    $(document).on('click', '.modalPayment', function () {
        var certID = $(this).data('id');
        // Construct the dynamic URL based on the data-id
        var dynamicUrl = '/candidate/selfprint/' + certID;

        // Update the href attribute of the "Continue" button
        $('#modalPayment a.btn-success').attr('href', dynamicUrl);
    });

    $(document).on('click', '.modalPaymentMpm', function () {
        var certID = $(this).data('id');
        // Construct the dynamic URL based on the data-id
        var dynamicUrl = '/candidate/pos-result/' + certID;

        // Update the href attribute of the "Continue" button
        $('#modalPaymentMpm a.btn-success').attr('href', dynamicUrl);
    });

    $(document).on('click', '.modalVerify', function () {
        $('#indexNumber').val('')
        var certID = $(this).data('id');
        // console.log("Modal Verify Button Clicked");
        var type = $(this).data('type');
        // console.log(type, certID);

        $(document).off('click', '#verifyIndexNumber').on('click', '#verifyIndexNumber', function () {
            var indexNum = $('#indexNumber').val();

            // console.log(type, certID, indexNum);

            // Perform AJAX request to check the index number
            $.ajax({
                url: './candidate/verifyIndexNumber',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    indexNumber: indexNum,
                    certID: certID
                },
                success: function (response) {
                    if (response.success) {
                        // If index number is valid, redirect or perform further actions
                        // console.log(response)
                        if (type == "MPM_PRINT") {
                            window.location.href = '/candidate/pos-result/' + response.id;
                        } else { //SELF_PRINT
                            window.location.href = '/candidate/view-result/' + response.id;
                        }
                    } else {
                        // console.log(response)

                        // If index number is invalid, show SweetAlert error
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle AJAX errors
                    console.error(xhr.responseText);
                }
            });
        });
    });

    $(document).on('click', '.modalUpcoming', function () {
        Swal.fire({
            icon: "info",
            html: 'This feature will be enabled in future. Thank you.',
            showConfirmButton: false,
        });
    });

    $(document).on('click', '.btnForgotIndexNumber', function () {
        Swal.fire({
            title: "Forget your Index Number?",
            html: "<p>Kindly go to this link to find your index number.</p> <p>Link : <a href='http://webmpm1.mpm.edu.my/muetresults/ '>http://webmpm1.mpm.edu.my/muetresults/ </a></p>",
            icon: "question"
        });
    })

    $('#indexNumber').on('keyup', function() {
        // Get the value, convert it to uppercase, and set it back
        var uppercaseValue = $(this).val().toUpperCase();
        $(this).val(uppercaseValue);
    });
});

$(document).ready(function () {
    if ($('#dt-candidate').length) {

        // Initialize the DataTable
        var table = $('#dt-candidate').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "./manage-candidate/ajax",
                data: function (d) {
                    d.search = $('#search_term').val(); // Capture the search term dynamically
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'identity_card_number', name: 'identity_card_number' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pageLength: 10,
            lengthMenu: [[10], [10]], // Disable the entries per page dropdown by only allowing one option
            order: [[0, "asc"]],
            responsive: true,
            autoWidth: false,
            language: {
                // "zeroRecords": "There are no records to display.",
                // "paginate": {
                // "info": "Display _START_ / _END_ of _TOTAL_ records",
                // "infoEmpty": "Showing 0 to 0 of 0 entries",
                // "infoFiltered": "(filter of _MAX_ record)",
                "processing": "Processing...",
                // "search": "Search:"
            },
            searching: false,
            lengthChange: false,

        });

        // Search Button Click Event
        $('#searchBtn').on('click', function () {
            // Dynamically update the search term and reload the DataTable
            table.ajax.reload();
        });

        // Reset Button Click Event
        $('#resetBtn').on('click', function () {
            $('#search_term').val(''); // Clear the search input field

            // Reload the DataTable to reset it with no search term
            table.ajax.reload();
        });

        // if ($('.dt-search').length) {
        //     $('.dt-search').show()
        // }

        $(document).on('click', '#show_edit_modal', function (e) {
            e.preventDefault();

            $('#name_text_edit').text('');
            $('#nric_text_edit').text('');
            $('#form_candidate_edit').removeClass('was-validated');

            var rowData = table.row($(this).parents('tr')).data();
            $('#form_candidate_edit [name="id"]').val(rowData.id);
            $('#form_candidate_edit [name="name"]').val(decodeHTMLEntities(rowData.name));
            $('#form_candidate_edit [name="nric"]').val(rowData.nric);

            $('#modal_edit').modal('show');
        })

        function decodeHTMLEntities(text) {
            var textarea = document.createElement('textarea');
            textarea.innerHTML = text;
            return textarea.value;
        }

        $(document).on('click', '#submit', function (e) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData($('#form_candidate_edit')[0]);

            const id = $('#id').val();

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Candidates will be updated!',
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
                    $.ajax({
                        url: './manage-candidate/update/' + id,
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
                                allowEscapeKey: false, // Disables escape key closing the alert
                                allowOutsideClick: false, // Disables outside click closing the alert
                                showConfirmButton: false, // Hides the "Confirm" button
                                didOpen: () => {
                                    Swal.showLoading(Swal
                                        .getDenyButton()); // Show loading indicator on the Deny button
                                }
                            });
                        },
                        success: function (response) {
                            console.log(response)
                            Swal.close()
                            if (response.success) {
                                $('#form_candidate_edit').removeClass('was-validated');
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Candidate successfully updated!',
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        confirmButton: 'my-swal-confirm',
                                        cancelButton: 'my-swal-cancel',
                                    }
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_edit').modal('hide');
                                        $('#dt-candidate').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    type: 'warning',
                                    title: 'Fail',
                                    text: response.message,
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        confirmButton: 'my-swal-confirm',
                                        cancelButton: 'my-swal-cancel',
                                    }
                                })
                                // .then((result) => {
                                //     if (result.value) {
                                //         $('#modal_edit').modal('hide');
                                //         $('#dt-candidate').DataTable().ajax.reload();
                                //     }
                                // });
                            }
                        },
                        error: function (xhr, status, errors) {
                            $('#form_candidate_edit').addClass('was-validated');
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $('#name_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.name ? xhr.responseJSON.errors.name[0] : '');
                                $('#nric_text_edit').text(xhr.responseJSON.errors && xhr.responseJSON.errors.nric ? xhr.responseJSON.errors.nric[0] : '');

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
                            }
                        }
                    });
                }
            });
        });

    }
})
