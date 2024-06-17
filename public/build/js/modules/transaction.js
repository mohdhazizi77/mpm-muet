$(document).ready(function() {

    if ($("#transactionTable").length>0) {

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
                    data: "payment_date",
                    orderable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + 1;
                    // }
                },
                {
                    data: "txn_id",
                    orderable: true,
                    // render(data, type, row) {
                    //     let html = '';
                    //     html = '<p>'+row.user_name+'</p> <p>ID : '+data+'</p>';
                    //     return html;
                    // }
                },
                {
                    data: "ref_no",
                    orderable: true,
                },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        // html = '<p> Receipt No : <a href="'+row.receipt+'">'+row.receipt_number+'</a></p> <p> Amount : RM'+row.amount+'</p>';
                        html = '<p> Amount : RM'+row.amount+'</p>';
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
                    data: "ref_no",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<a class="btn btn-sm btn-warning btnCheckTrx" data-id="'+data+'"><i class="bx bx-refresh"></i> Refetch </a>';
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
            searching: false,
            lengthChange: false,
        });
    }

    $('.btn-excel-trx').removeClass('dt-button');
    $('.btn-print-trx').removeClass('dt-button');

    //filter
    $(document).on('click', '#filterBtnTrx', function (){
        tableTrx.ajax.reload();
    })

    //clear filter
    $(document).on('click', '#resetBtnTrx', function (){
        $('#start-date-trx').val('');
        $('#end-date-trx').val('');
        $('#text-search-trx').val('');

        tableTrx.ajax.reload();
    })

    $(document).on('click', '.btnCheckTrx', function(){

        var ref_no = $(this).data('id')

        var postData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            ref_no: ref_no
        };

        $.ajax({
            url: './transaction/check',
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
    })

    $(document).on('click', '#button-export-xlsx-trans', function (){
        window.location.href = './transaction/excel';
    });
    
    $(document).on('click', '#button-export-pdf-trans', function (){
        window.open('./transaction/pdf', '_blank');
    });
});
