$(document).ready(function() {

    if ($("#dt-auditLog").length>0) {

        $('#dt-auditLog').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "./audit-logs/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.type = $('#auditTable').data('type');
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
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "user_id",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<p>'+row.user_name+'</p> <p>ID : '+data+'</p>';
                        return html;
                    }
                },
                {
                    data: "action",
                    orderable: true,
                    render(data, type, row) {
                        let html = '';
                        html = '<p>'+data+'</p> <p>'+row.created_date+'</p>';
                        return html;
                    }
                },
                {
                    data: "data",
                    orderable: false,
                    className: "text-start",
                    render(data, type, row) {
                        let html = '';

                        if (data['table']) {
                            html = '<p>'+data['table']+' ID:'+data['id']+'</p>';
                            html += '<p>'+row.created_date.date+'</p>';

                            if (data['data']['old']) {
                                html += '<p class="pt-3 fw-bold">Old</p>';
                                html += '<ul>';
                                Object.entries(data['data']['old']).forEach(([key, value]) => {
                                    html += '<li>' + key + ': ' + value + '</li>';
                                });
                                html += '</ul>';
                            }

                            if (data['data']['new']) {
                                html += '<p class="pt-3 fw-bold">New</p>';
                                html += '<ul>';
                                Object.entries(data['data']['new']).forEach(([key, value]) => {
                                    html += '<li>' + key + ': ' + value + '</li>';
                                });
                                html += '</ul>';
                            }
                        } else {
                            console.log(data)
                        }
                        return html;
                    }
                },
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 2 }, // Example: First column with highest priority
            ],
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
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
});
