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
                    d.search = $('#search_term').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'nric', name: 'nric' },
                { data: 'angka_giliran', name: 'angka_giliran' },
                { data: 'sidang', name: 'sidang' },
                { data: 'tahun', name: 'tahun' },
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

            // Clear any previous validation errors or data
            $('#name_text_edit').text('');
            $('#nric_text_edit').text('');
            $('#form_candidate_edit').removeClass('was-validated');

            // Fetch the data for the clicked row
            var rowData = table.row($(this).parents('tr')).data();
            console.log("Row Data:", rowData); // Log the raw data

            // Populate the form fields
            $('#form_candidate_edit [name="id"]').val(rowData.id);
            $('#form_candidate_edit [name="name"]').val(decodeHTMLEntities(rowData.name));
            $('#form_candidate_edit [name="nric"]').val(rowData.nric);

            // Prefill the score fields
            var mkhbaru = rowData.mkhbaru ? rowData.mkhbaru.split(',') : [];  // Split string into array

            if (Array.isArray(mkhbaru) && mkhbaru.length >= 4) {
                $('#form_candidate_edit [name="listening_score"]').val(mkhbaru[0].trim()); // Listening score
                $('#form_candidate_edit [name="speaking_score"]').val(mkhbaru[1].trim());  // Speaking score
                $('#form_candidate_edit [name="reading_score"]').val(mkhbaru[2].trim());   // Reading score
                $('#form_candidate_edit [name="writing_score"]').val(mkhbaru[3].trim());   // Writing score
            } else {
                console.error("Invalid mkhbaru data: ", mkhbaru);
            }

            // Populate the aggregated score and band fields
            $('#form_candidate_edit [name="aggregated_score"]').val(rowData.skor_agregat);  // Set Aggregated Score
            $('#form_candidate_edit [name="band_achieved"]').val(rowData.band);  // Set Band

            // Show the modal with the filled data
            $('#modal_edit').modal('show');
        });

        // Helper function to decode HTML entities
        function decodeHTMLEntities(text) {
            var textarea = document.createElement('textarea');
            textarea.innerHTML = text;
            return textarea.value;
        }

        $(document).on('click', '#submit', function (e) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData($('#form_candidate_edit')[0]);

            const id = $('#id').val();

            // Get the values from the editable score fields
            var listeningScore = $('#listening-score').val();
            var speakingScore = $('#speaking-score').val();
            var readingScore = $('#reading-score').val();
            var writingScore = $('#writing-score').val();
            var aggregatedScore = $('#aggregated-score').val();
            var bandAchieved = $('#band-achieved').val();

            // Ensure the scores are filled correctly
            formData.append('listening_score', listeningScore);
            formData.append('speaking_score', speakingScore);
            formData.append('reading_score', readingScore);
            formData.append('writing_score', writingScore);
            formData.append('aggregated_score', aggregatedScore);
            formData.append('band_achieved', bandAchieved);

            // Show confirmation before submission
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Candidates will be updated!',
                showCancelButton: true,
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
                                title: 'Loading...',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton());
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close()
                            if (response.success) {
                                $('#form_candidate_edit').removeClass('was-validated');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Candidate successfully updated!'
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_edit').modal('hide');

                                        // Redraw the DataTable
                                        $('#dt-candidate').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Fail',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr) {
                            $('#form_candidate_edit').addClass('was-validated');
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $('#name_text_edit').text(xhr.responseJSON.errors.name || '');
                                $('#nric_text_edit').text(xhr.responseJSON.errors.nric || '');
                                Swal.fire({
                                    icon: "error",
                                    title: 'Gagal',
                                    text: xhr.responseJSON.message
                                });
                            }
                        }
                    });
                }
            });
        });

    }
})

//MUET ON DEMAND (MOD)
$(document).ready(function () {
    if ($('#dt-candidate-mod').length) {

        // Initialize the DataTable
        var table = $('#dt-candidate-mod').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "./manage-mod-candidate/ajax",
                data: function (d) {
                    d.search = $('#search_term_mod').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'nric', name: 'nric' },
                { data: 'angka_giliran', name: 'angka_giliran' },
                { data: 'sidang', name: 'sidang' },
                { data: 'tahun', name: 'tahun' },
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
        $('#searchBtnMod').on('click', function () {
            // Dynamically update the search term and reload the DataTable
            table.ajax.reload();
        });

        // Reset Button Click Event
        $('#resetBtnMod').on('click', function () {
            $('#search_term_mod').val(''); // Clear the search input field

            // Reload the DataTable to reset it with no search term
            table.ajax.reload();
        });

        // if ($('.dt-search').length) {
        //     $('.dt-search').show()
        // }

        $(document).on('click', '#show_edit_modal', function (e) {
            e.preventDefault();

            // Clear any previous validation errors or data
            $('#name_text_edit').text('');
            $('#nric_text_edit').text('');
            $('#form_candidate_edit').removeClass('was-validated');

            // Fetch the data for the clicked row
            var rowData = table.row($(this).parents('tr')).data();
            console.log("Row Data:", rowData); // Log the raw data

            // Populate the form fields
            $('#form_candidate_edit [name="id"]').val(rowData.id);
            $('#form_candidate_edit [name="name"]').val(decodeHTMLEntities(rowData.name));
            $('#form_candidate_edit [name="nric"]').val(rowData.nric);

            // Prefill the score fields
            var skorbaru = rowData.skorbaru ? rowData.skorbaru.split(',') : [];  // Split string into array

            if (Array.isArray(skorbaru) && skorbaru.length >= 4) {
                $('#form_candidate_edit [name="listening_score"]').val(skorbaru[0].trim()); // Listening score
                $('#form_candidate_edit [name="speaking_score"]').val(skorbaru[1].trim());  // Speaking score
                $('#form_candidate_edit [name="reading_score"]').val(skorbaru[2].trim());   // Reading score
                $('#form_candidate_edit [name="writing_score"]').val(skorbaru[3].trim());   // Writing score
            } else {
                console.error("Invalid skorbaru data: ", skorbaru);
            }

            // Populate the aggregated score and band fields
            $('#form_candidate_edit [name="aggregated_score"]').val(rowData.skor_agregat);  // Set Aggregated Score
            $('#form_candidate_edit [name="band_achieved"]').val(rowData.band);  // Set Band

            // Show the modal with the filled data
            $('#modal_edit').modal('show');
        });

        // Helper function to decode HTML entities
        function decodeHTMLEntities(text) {
            var textarea = document.createElement('textarea');
            textarea.innerHTML = text;
            return textarea.value;
        }

        $(document).on('click', '#submitMod', function (e) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData($('#form_candidate_edit')[0]);

            const id = $('#id').val();

            // Get the values from the editable score fields
            var listeningScore = $('#listening-score').val();
            var speakingScore = $('#speaking-score').val();
            var readingScore = $('#reading-score').val();
            var writingScore = $('#writing-score').val();
            var aggregatedScore = $('#aggregated-score').val();
            var bandAchieved = $('#band-achieved').val();

            // Ensure the scores are filled correctly
            formData.append('listening_score', listeningScore);
            formData.append('speaking_score', speakingScore);
            formData.append('reading_score', readingScore);
            formData.append('writing_score', writingScore);
            formData.append('aggregated_score', aggregatedScore);
            formData.append('band_achieved', bandAchieved);

            // Show confirmation before submission
            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Candidates will be updated!',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: './manage-candidate-mod/update/' + id,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function () {
                            Swal.fire({
                                title: 'Loading...',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading(Swal.getDenyButton());
                                }
                            });
                        },
                        success: function (response) {
                            Swal.close();
                            if (response.success) {
                                $('#form_candidate_edit').removeClass('was-validated');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Candidate successfully updated!'
                                }).then((result) => {
                                    if (result.value) {
                                        $('#modal_edit').modal('hide');

                                        // Redraw the DataTable
                                        $('#dt-candidate-mod').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Fail',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr) {
                            $('#form_candidate_edit').addClass('was-validated');
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $('#name_text_edit').text(xhr.responseJSON.errors.name || '');
                                $('#nric_text_edit').text(xhr.responseJSON.errors.nric || '');
                                Swal.fire({
                                    icon: "error",
                                    title: 'Gagal',
                                    text: xhr.responseJSON.message
                                });
                            }
                        }
                    });
                }
            });
        });

    }
})
