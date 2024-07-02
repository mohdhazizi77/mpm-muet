$(document).ready(function() {

    if ($("#orderTable").length) {
        // console.log($('#orderTable').data('id'));
        $('#orderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/candidate/order/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content')
                    d.candidate_id = $('#orderTable').data('id')
                }
            },
            columns: [

                {
                    data: "no",
                    orderable: false,
                },
                {
                    data: "orderDate",
                    orderable: false,
                },
                {
                    data: "uniqueOrderId",
                    orderable: false,
                },
                {
                    data: "orderFor",
                    orderable: false,
                },
                {
                    data: "status",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        var html = '<span class="badge rounded-pill bg-'+row.color+'">'+data+'</span>';
                        return html;
                    },
                    // render: function (data, type, row, meta) {
                    //     var html = '';
                    //      //'PAID', 'NEW', 'PROCESSING', 'COMPLETE' , 'CANCEL', 'FAIL'
                    //     // if (data == "SUCCESS") {
                    //     //     html = '<span class="badge rounded-pill bg-success">SUCCESS</span>';
                    //     // } else if (data == "PENDING") {
                    //     //     html = '<span class="badge rounded-pill bg-warning">PENDING</span>';
                    //     // } else if (data == "FAILED") {
                    //     //     html = '<span class="badge rounded-pill bg-danger">FAILED</span>';
                    //     // } else {
                    //     //     html = '<span class="badge rounded-pill bg-danger">'+data+'</span>';
                    //     // }
                    //     // return html;

                    //     switch(data) {
                    //         case "PAID":
                    //             html = '<span class="badge rounded-pill bg-success">PAID</span>';
                    //             break;
                    //         case "NEW":
                    //             html = '<span class="badge rounded-pill bg-primary">NEW</span>';
                    //             break;
                    //         case "PROCESSING":
                    //             html = '<span class="badge rounded-pill bg-warning">PROCESSING</span>';
                    //             break;
                    //         case "COMPLETE":
                    //             html = '<span class="badge rounded-pill bg-success">COMPLETE</span>';
                    //             break;
                    //         case "CANCEL":
                    //             html = '<span class="badge rounded-pill bg-secondary">CANCEL</span>';
                    //             break;
                    //         case "FAIL":
                    //             html = '<span class="badge rounded-pill bg-danger">FAIL</span>';
                    //             break;
                    //         default:
                    //             html = '<span class="badge rounded-pill bg-danger">'+data+'</span>';
                    //     }
                    //     return html;

                    // },

                },
                {
                    data: "id",
                    orderable: false,
                    render: function (data, type, row, meta) {

                        var buttonCheckCert = '';
                        var buttonPrintPDF = '';
                        var buttonPrintMPM = '';

                        // if (row.status != "FAILED" ) {
                            var buttonCheckCert =
                            '<a href="/candidate/muet-status/'+data+'" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                                '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                                'CERTIFICATE STATUS' +
                            '</a>'
                        // }

                        return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;

                    },
                    // className: ,
                }
            ],
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

    if ($("#trackOrderTable").length) {
        $('#trackOrderTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/candidate/track-order/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content')
                    d.order_id = $('#trackOrderTable').data('id')
                }
            },
            columns: [

                {
                    data: "no",
                    orderable: false,
                },
                {
                    data: "date",
                    orderable: false,
                },
                {
                    data: "detail",
                    orderable: false,
                },
                {
                    data: "status",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        var html = '<span class="badge rounded-pill bg-'+row.color+'">'+data+'</span>';
                        return html;
                    },

                },
            ],
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

    if ($("#trackShippingTable").length) {
        $('#trackShippingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "/candidate/track-shipping/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content')
                    d.track_id = $('#trackShippingTable').data('id')
                }
            },
            columns: [

                {
                    data: "no",
                    orderable: false,
                },
                {
                    data: "date",
                    orderable: false,
                },
                {
                    data: "detail",
                    orderable: false,
                },
                {
                    data: "status",
                    orderable: false,
                    // render: function (data, type, row, meta) {
                    //     var html = '<span class="badge rounded-pill bg-'+row.color+'">'+data+'</span>';
                    //     return html;
                    // },

                },
            ],
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
});
