$(document).ready(function() {

    if ($("#financeMuetTable").length>0) {

        var tableMuet = $('#financeMuetTable').DataTable({
            dom: 'Bfrtip',
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
                        window.open('./muet/pdf', '_blank');
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
                }
            },
            columns: [
                {
                    data: "txn_id",
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
                        html = '<p> Amount : RM'+data+'</p>';
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
            ],
            pageLength: 100,
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
                // "search": "Carian:"
            },
            searching: true,
            lengthChange: false,
        });
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
    })

    //clear filter
    $(document).on('click', '#resetBtnFinMuet', function (){
        $('#start-date-fin-muet').val('');
        $('#end-date-fin-muet').val('');
        $('#text-search-fin-muet').val('');

        tableMuet.draw();
    })

    //text search
    $('#text-search-fin-muet').on('keyup change', function() {
        tableMuet.search(this.value).draw();
    });


    // -------------------------------------------------------------------------
    
    if ($("#financeModTable").length>0) {

        var tableMod = $('#financeModTable').DataTable({
            dom: 'Bfrtip',
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
                        window.open('./mod/pdf', '_blank');
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
                }
            },
            columns: [
                {
                    data: "txn_id",
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
                        html = '<p> Amount : RM'+data+'</p>';
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
            ],
            pageLength: 100,
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
                // "search": "Carian:"
            },
            searching: true,
            lengthChange: false,
        });
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
    $(document).on('click', '#filterBtnFinMuet', function (){
        tableMod.ajax.reload();
    })

    //clear filter
    $(document).on('click', '#resetBtnFinMuet', function (){
        $('#start-date-fin-mod').val('');
        $('#end-date-fin-mod').val('');
        $('#text-search-fin-mod').val('');

        tableMod.draw();
    })

    //text search
    $('#text-search-fin-mod').on('keyup change', function() {
        tableMod.search(this.value).draw();
    });

});

