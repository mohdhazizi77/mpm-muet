$(document).ready(function () {

    if ($("#transactionTable").length > 0) {

        var tableTrx = $('#transactionTable').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'excel','print'
            // ],
            // buttons: [
            //     {
            //         extend: 'excel',
            //         text: 'EXPORT XLSX',
            //         className: 'btn btn-soft-secondary waves-effect mb-2 btn-excel-trx',
            //         filename: 'ListTransation',
            //         title: 'List of Transaction'
            //     },
            //     {
            //         extend: 'print',
            //         text: 'EXPORT PDF',
            //         className: 'btn btn-soft-secondary waves-effect mb-2 btn-print-trx',
            //         filename: 'ListTransation',
            //         title: 'List of Transaction',
            //     }
            // ],

            processing: true,
            serverSide: true,
            ajax: {
                "url": "./transaction/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#transactionTable').data('type');
                    d.startDateTrx = $('#start-date-trx').val();
                    d.endDateTrx = $('#end-date-trx').val();
                    d.textSearchTrx = $('#text-search-trx').val();
                    d.exam_type = $('#exam_type').val();
                    d.payment_for = $('#payment_for').val();
                    d.status = $('#status_trx').val();
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
                    data: "created_at",
                    orderable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + 1;
                    // }
                },
                {
                    data: "reference_id",
                    orderable: false,
                },
                {
                    data: "cert_type",
                    orderable: true,
                },
                {
                    data: "txn_type",
                    orderable: true,
                },
                {
                    data: "order_id",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<div style="line-height: 1.0;">' +
                            '<span style="display: block; margin-bottom: 5px;">' + row.candidate_name + '</span>' +
                            '<span style="display: block; margin-bottom: 5px;">NRIC: ' + row.candidate_nric + '</span>' +
                            '<span style="display: block;">' + row.session + '</span>' +
                            '</div>';

                        return html;
                    }
                },

                // {
                //     data: "status",
                //     orderable: true,
                //     render(data, type, row) {
                //         let html = '';
                //         // html = '<p> Receipt No : <a href="'+row.receipt+'">'+row.receipt_number+'</a></p> <p> Amount : RM'+row.amount+'</p>';
                //         html = '<p> Amount : RM'+row.amount+'</p>';
                //         return html;
                //     }
                // },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        // Generate pill button based on status
                        switch (data) {
                            case 'PENDING':
                            case 'PROCESSING':
                                html = '<span class="badge bg-warning text-dark">' + data + '</span>';
                                break;
                            case 'PAID':
                                html = '<span class="badge bg-secondary">' + data + '</span>';
                                break;
                            case 'NEW':
                                html = '<span class="badge bg-info">' + data + '</span>';
                                break;
                            case 'FAILED':
                            case 'CANCEL':
                                html = '<span class="badge bg-danger">' + data + '</span>';
                                break;
                            case 'COMPLETED':
                            case 'SUCCESS':
                                html = '<span class="badge bg-success">' + data + '</span>';
                                break;
                            default:
                                html = '<span class="badge bg-secondary">' + data + '</span>';
                        }

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
                        btn += '<button type="button" data-id="' + data + '" class="btn btn-info btn-icon waves-effect waves-light me-2 btn-update-pos"><i class="ri-information-line fs-22"></i></button>';
                        return btn;
                    }
                },
                // {
                //     data: "ref_no",
                //     orderable: true,
                //     render(data, type, row) {
                //         let html = '';
                //         html = '<a class="btn btn-sm btn-warning btnCheckTrx" data-id="'+data+'"><i class="bx bx-refresh"></i> Refetch </a>';
                //         return html;
                //     }
                // },
            ],
            pageLength: 10,
            dom: '<"top"f>rt<"bottom d-flex justify-content-start"<"dataTables_paginate"p><"dataTables_length"l>><"clear">',
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
                "processing": "Processing...",
                // "search": "Carian:",
                lengthMenu: '<select class="form-select form-select-md" style="margin-left: 10px">' +
                    '<option value="10">10</option>' +
                    '<option value="25">25</option>' +
                    '<option value="50">50</option>' +
                    '<option value="100">100</option>' +
                    '<option value="-1">All</option>' +
                    '</select>'
            },
            searching: false,
            lengthChange: true,
        });
    }

    $('.btn-excel-trx').removeClass('dt-button');
    $('.btn-print-trx').removeClass('dt-button');

    //filter
    $(document).on('click', '#filterBtnTrx', function () {
        tableTrx.ajax.reload();
    })

    // $('#text-search-trx').on('keyup change', function() {
    //     tableTrx.search(this.value).draw();
    // });

    //clear filter
    $(document).on('click', '#resetBtnTrx', function () {
        $('#start-date-trx').val('');
        $('#end-date-trx').val('');
        $('#text-search-trx').val('');
        $('#exam_type').val('');
        $('#payment_for').val('');
        $('#status_trx').val('');

        tableTrx.ajax.reload();
    })

    $(document).on('click', '.btnCheckTrx', function () {

        var ref_no = $(this).data('id')

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ref_no: ref_no
        };

        $.ajax({
            url: './transaction/check',
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

                    // Swal.fire("Error!", response.message, "success");

                    Swal.fire("Saved!", response.message, "success");

                    // Refresh data table
                    $('#transactionTable').DataTable().ajax.reload(); // This line refreshes the DataTable

                    // Optionally, you can also redraw the DataTable to update the UI
                    $('#transactionTable').DataTable().draw(); // This line redraws the DataTable
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function (xhr, status, error) {
                // Handle error
                Swal.fire("Error!", "Failed to update data.", "error");
            }
        });
    })

    $(document).on('click', '#button-export-xlsx-trans', function () {
        const textSearch = $('#text-search-trx').val();
        const startDate = $('#start-date-trx').val();
        const endDate = $('#end-date-trx').val();
        const exam_type = $('#exam_type').val();
        const payment_for = $('#payment_for').val();
        const status_trx = $('#status_trx').val();

        const url = `./transaction/excel?textSearch=${encodeURIComponent(textSearch)}
        &startDate=${encodeURIComponent(startDate)}
        &exam_type=${encodeURIComponent(exam_type)}
        &payment_for=${encodeURIComponent(payment_for)}
        &status_trx=${encodeURIComponent(status_trx)}
        &endDate=${encodeURIComponent(endDate)}`;

        window.location.href = url;
    });

    $(document).on('click', '#button-export-pdf-trans', function () {
        const textSearch = $('#text-search-trx').val();
        const startDate = $('#start-date-trx').val();
        const endDate = $('#end-date-trx').val();
        const exam_type = $('#exam_type').val();
        const payment_for = $('#payment_for').val();
        const status_trx = $('#status_trx').val();

        const url = `./transaction/pdf?textSearch=${encodeURIComponent(textSearch)}
        &startDate=${encodeURIComponent(startDate)}
        &exam_type=${encodeURIComponent(exam_type)}
        &payment_for=${encodeURIComponent(payment_for)}
        &status_trx=${encodeURIComponent(status_trx)}
        &endDate=${encodeURIComponent(endDate)}`;

        // Open the URL in a new tab
        window.open(url, '_blank');
    });
});
