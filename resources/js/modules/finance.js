$(document).ready(function() {

    if ($("#financeMuetTable").length>0) {

        var tableMuet = $('#financeMuetTable').DataTable({
            dom: '<"top"f>rt<"bottom d-flex justify-content-start"<"dataTables_paginate"p><"dataTables_length"l>><"clear">',
            buttons: [
                'excel',
                'print'
            ],
            buttons: [
                {
                    extend: 'excel',
                    text: 'EXPORT XLSX',
                    className: 'btn btn-soft-secondary waves-effect mb-2 btn-excel-fin-muet',
                    filename: 'ListTransation',
                    title: 'List of Transaction'
                },
                {
                    extend: 'print',
                    text: 'EXPORT PDF',
                    className: 'btn btn-soft-secondary waves-effect mb-2 btn-print-fin-muet',
                    filename: 'ListTransation',
                    title: 'List of Transaction',
                    action: function (e, dt, button, config) {
                        const textSearch = $('#text-search-fin-muet').val();
                        const startDate = $('#start-date-fin-muet').val();
                        const endDate = $('#end-date-fin-muet').val();
                        const exam_type_select = $('#exam_type').val();
                        const payment_for = $('#payment_for').val();
                        const status = $('#status_muet').val();


                        const url = `./muet/pdf?textSearch=${encodeURIComponent(textSearch)}
                        &startDate=${encodeURIComponent(startDate)}
                        &endDate=${encodeURIComponent(endDate)}
                        &exam_type_select=${encodeURIComponent(exam_type_select)}
                        &payment_for=${encodeURIComponent(payment_for)}
                        &status=${encodeURIComponent(status)}`;

                        window.open(url, '_blank');
                    }
                }
            ],

            processing: true,
            serverSide: true,
            ajax: {
                "url": "./muet/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.exam_type = 'muet';
                    d.startDate = $('#start-date-fin-muet').val();
                    d.endDate = $('#end-date-fin-muet').val();
                    d.textSearch = $('#text-search-fin-muet').val();
                    d.exam_type_select = $('#exam_type').val();
                    d.payment_for = $('#payment_for').val();
                    d.status = $('#status_muet').val();
                }
            },
            columns: [
                {
                    // data: "date_created",
                    data: "reference_id",
                    orderable: false,
                    // render: ,
                    // className: ,
                },
                {
                    data: "receipt_no",
                    orderable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + 1;
                    // }
                },
                {
                    data: "trx_date",
                    orderable: true,
                    // render(data, type, row) {
                    //     let html = '';
                    //     html = '<p>'+row.user_name+'</p> <p>ID : '+data+'</p>';
                    //     return html;
                    // }
                },
                {
                    data: "candidate_name",
                    orderable: true,
                },
                {
                    data: "amount",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        // html = '<p> Receipt No : <a href="'+row.receipt+'">'+row.receipt_number+'</a></p> <p> Amount : RM'+row.amount+'</p>';
                        html = '<p>RM '+data+'</p>';
                        return html;
                    }
                },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        // Generate pill button based on status
                        switch (data) {
                            // case 'new':
                            //     html = '<span class="badge bg-info">' + data + '</span>';
                            //     break;
                            case 'PENDING':
                                html = '<span class="badge bg-warning text-dark">' + data + '</span>';
                                break;
                            case 'SUCCESS':
                                html = '<span class="badge bg-success">' + data + '</span>';
                                break;
                            case 'FAIL':
                                html = '<span class="badge bg-danger">' + data + '</span>';
                                break;
                            default:
                                html = '<span class="badge bg-secondary">' + data + '</span>';
                        }
                        return html;
                    }
                },
                {
                    data: "receipt",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<a class="btn btn-sm btn-secondary" href="'+data+'" target=_blank ><i class="bx bx-download"></i> Receipt </a>';
                        return html;
                    }
                },
                {
                    data: "ref_no",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<a class="btn btn-sm btn-warning btnCheckTrxStatus" data-id="'+data+'"><i class="bx bx-refresh"></i> Refetch </a>';
                        return html;
                    }
                },
            ],
            // dom: 'frtp',
            pageLength: 10,
            order: [[0, "asc"]],
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
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
                lengthMenu: '<select class="form-select form-select-md" style="margin-left: 10px">'+
                    '<option value="10">10</option>'+
                    '<option value="25">25</option>'+
                    '<option value="50">50</option>'+
                    '<option value="100">100</option>'+
                    '<option value="-1">All</option>'+
                    '</select>'
            },
            searching: true,
            lengthChange: true,
        });

    fetchDataMuet();

    }

    $('.dt-search').hide();

    $('.btn-excel-fin-muet').removeClass('dt-button');
    $('.btn-print-fin-muet').removeClass('dt-button');

    var today = new Date().toISOString().split('T')[0];
    $('#start-date-fin-muet').attr('max', today);

    // Enable/disable the end date input based on the start date value
    $('#start-date-fin-muet').on('change', function() {
        if ($(this).val()) {
            $('#end-date-fin-muet').prop('disabled', false);
        } else {
            $('#end-date-fin-muet').prop('disabled', true);
        }

        var startDate = $(this).val();
        $('#end-date-fin-muet').attr('min', startDate).prop('disabled', !startDate);
        $('#end-date-fin-muet').val(startDate)
    });

    //filter
    $(document).on('click', '#filterBtnFinMuet', function (){
        tableMuet.ajax.reload();
        fetchDataMuet();
    })

    //clear filter
    $(document).on('click', '#resetBtnFinMuet', function (){
        $('#start-date-fin-muet').val('');
        $('#end-date-fin-muet').val('');
        $('#text-search-fin-muet').val('');
        $('#exam_type').val('');
        $('#payment_for').val('');
        $('#status_muet').val('');
        fetchDataMuet();

        tableMuet.draw();
    })

    //text search
    $('#text-search-fin-muet').on('keyup change', function() {
        tableMuet.search(this.value).draw();
        fetchDataMuet();
    });


    // -------------------------------------------------------------------------

    if ($("#financeModTable").length>0) {

        var tableMod = $('#financeModTable').DataTable({
           
            buttons: [
                'excel',
                'print'
            ],
            buttons: [
                {
                    extend: 'excel',
                    text: 'EXPORT XLSX',
                    className: 'btn btn-soft-secondary waves-effect mb-2 btn-excel-fin-mod',
                    filename: 'ListTransation',
                    title: 'List of Transaction'
                },
                {
                    extend: 'print',
                    text: 'EXPORT PDF',
                    className: 'btn btn-soft-secondary waves-effect mb-2 btn-print-fin-mod',
                    filename: 'ListTransation',
                    title: 'List of Transaction',
                    action: function (e, dt, button, config) {
                        const textSearch = $('#text-search-fin-mod').val();
                        const startDate = $('#start-date-fin-mod').val();
                        const endDate = $('#end-date-fin-mod').val();
                        const exam_type_select = $('#exam_type_mod').val();
                        const payment_for = $('#payment_for_mod').val();
                        const status = $('#status_mod').val();


                        const url = `./mod/pdf?textSearch=${encodeURIComponent(textSearch)}
                        &startDate=${encodeURIComponent(startDate)}
                        &endDate=${encodeURIComponent(endDate)}
                        &exam_type_select=${encodeURIComponent(exam_type_select)}
                        &payment_for=${encodeURIComponent(payment_for)}
                        &status=${encodeURIComponent(status)}`;

                        window.open(url, '_blank');
                    }
                }
            ],

            processing: true,
            serverSide: true,
            ajax: {
                "url": "./mod/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.exam_type = 'mod';
                    d.startDate = $('#start-date-fin-mod').val();
                    d.endDate = $('#end-date-fin-mod').val();
                    d.textSearch = $('#text-search-fin-mod').val();
                    d.exam_type_select = $('#exam_type_mod').val();
                    d.payment_for = $('#payment_for_mod').val();
                    d.status = $('#status_mod').val();
                }
            },
            columns: [
                {
                    // data: "txn_id",
                    data: "reference_id",
                    orderable: false,
                    // render: ,
                    // className: ,
                },
                {
                    data: "receipt_no",
                    orderable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + 1;
                    // }
                },
                {
                    data: "trx_date",
                    orderable: true,
                    // render(data, type, row) {
                    //     let html = '';
                    //     html = '<p>'+row.user_name+'</p> <p>ID : '+data+'</p>';
                    //     return html;
                    // }
                },
                {
                    data: "candidate_name",
                    orderable: true,
                },
                {
                    data: "amount",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        // html = '<p> Receipt No : <a href="'+row.receipt+'">'+row.receipt_number+'</a></p> <p> Amount : RM'+row.amount+'</p>';
                        html = '<p>RM'+data+'</p>';
                        return html;
                    }
                },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        // Generate pill button based on status
                        switch (data) {
                            // case 'new':
                            //     html = '<span class="badge bg-info">' + data + '</span>';
                            //     break;
                            case 'PENDING':
                                html = '<span class="badge bg-warning text-dark">' + data + '</span>';
                                break;
                            case 'SUCCESS':
                                html = '<span class="badge bg-success">' + data + '</span>';
                                break;
                            case 'FAIL':
                                html = '<span class="badge bg-danger">' + data + '</span>';
                                break;
                            default:
                                html = '<span class="badge bg-secondary">' + data + '</span>';
                        }
                        return html;
                    }
                },
                {
                    data: "receipt",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<a class="btn btn-sm btn-secondary" href="'+data+'" target=_blank ><i class="bx bx-download"></i> Receipt </a>';
                        return html;
                    }
                },
                {
                    data: "ref_no",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<a class="btn btn-sm btn-warning btnCheckTrxStatus" data-id="'+data+'"><i class="bx bx-refresh"></i> Refetch </a>';
                        return html;
                    }
                },
            ],
            // dom: 'frtp',
            dom: '<"top"f>rt<"bottom d-flex justify-content-start"<"dataTables_paginate"p><"dataTables_length"l>><"clear">',
            pageLength: 10,
            order: [[0, "asc"]],
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
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
                // "search": "Carian:"
                lengthMenu: '<select class="form-select form-select-md" style="margin-left: 10px">'+
                    '<option value="10">10</option>'+
                    '<option value="25">25</option>'+
                    '<option value="50">50</option>'+
                    '<option value="100">100</option>'+
                    '<option value="-1">All</option>'+
                    '</select>'
            },
            searching: true,
            lengthChange: true,
        });

        fetchDataMod();
    }

    $('.dt-search').hide();

    $('.btn-excel-fin-mod').removeClass('dt-button');
    $('.btn-print-fin-mod').removeClass('dt-button');

    $('#start-date-fin-mod').attr('max', today);

    // Enable/disable the end date input based on the start date value
    $('#start-date-fin-mod').on('change', function() {
        if ($(this).val()) {
            $('#end-date-fin-mod').prop('disabled', false);
        } else {
            $('#end-date-fin-mod').prop('disabled', true);
        }

        var startDate = $(this).val();
        $('#end-date-fin-mod').attr('min', startDate).prop('disabled', !startDate);
        $('#end-date-fin-mod').val(startDate)
    });

    //filter
    $(document).on('click', '#filterBtnFinMod', function (){
        tableMod.ajax.reload();
        fetchDataMod();
    })

    //clear filter
    $(document).on('click', '#resetBtnFinMod', function (){
        $('#start-date-fin-mod').val('');
        $('#end-date-fin-mod').val('');
        $('#text-search-fin-mod').val('');
        $('#exam_type_mod').val('');
        $('#payment_for_mod').val('');
        $('#status_mod').val('');
        fetchDataMod();

        tableMod.draw();
    })

    //text search
    $('#text-search-fin-mod').on('keyup change', function() {
        tableMod.search(this.value).draw();
    });

    // fetchDataMuet();
    // fetchDataMod();

    // $('#start-date-fin-muet').on('click', button id="end-date-fin-muet" fetchDataMuet);

    $(document).on('click', '.btnCheckTrxStatus', function(){

        var ref_no = $(this).data('id')

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ref_no: ref_no
        };

        $.ajax({
            url: '/admin/transaction/check',
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
            error: function(xhr, status, error){
                // Handle error
                Swal.fire("Error!", "Failed to update data.", "error");
            }
        });
    })
});

function fetchDataMuet(){
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    const startDate = $('#start-date-fin-muet').val();
    const endDate = $('#end-date-fin-muet').val();
    const exam_type = $('#exam_type').val();
    const payment_for = $('#payment_for').val();
    const status = $('#status_muet').val();
    const textSearch = $('#text-search-fin-muet').val();

    $.ajax({
        url: './muet/data', // Replace with your backend URL
        type: 'post', // or 'POST' depending on your backend method
        dataType: 'json',
        data: {
            startDate: startDate,
            endDate: endDate,
            textSearch: textSearch,
            exam_type: exam_type,
            payment_for: payment_for,
            status: status,
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(data) {
            $('#total_success').text(data.totalSuccess);
            $('#mpm_print').text(data.totalPayMpm);
            $('#self_print').text(data.totalPaySelf);
            $('#total_collection').text('RM ' +data.totalColection);
            // You can update your HTML elements with the fetched data here
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

function fetchDataMod(){
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    const startDate = $('#start-date-fin-mod').val();
    const endDate = $('#end-date-fin-mod').val();
    const exam_type = $('#exam_type_mod').val();
    const payment_for = $('#payment_for_mod').val();
    const status = $('#status_mod').val();
    const textSearch = $('#text-search-fin-mod').val();

    $.ajax({
        url: './mod/data', // Replace with your backend URL
        type: 'post', // or 'POST' depending on your backend method
        dataType: 'json',
        data: {
            startDate: startDate,
            endDate: endDate,
            textSearch: textSearch,
            exam_type: exam_type,
            payment_for: payment_for,
            status: status,
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(data) {
            $('#total_success_mod').text(data.totalSuccess);
            $('#mpm_print_mod').text(data.totalPayMpm);
            $('#self_print_mod').text(data.totalPaySelf);
            $('#total_collection_mod').text('RM ' +data.totalColection);
            // You can update your HTML elements with the fetched data here
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}


