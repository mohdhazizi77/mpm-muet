$(document).ready(function() {

    if ($("#candidatesTable").length) {

        $('#candidatesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "./candidates/ajax",
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

                        console.log(data, row.is_more2year, row.is_selfPrintPaid, row.is_mpmPrintPaid);
                        var modalSelf = 'modalVerifyPDF';
                        var modalMPM = 'modalVerifyMPM';
                        var modalPayment = 'modalPayment';

                        if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                            buttonPrintPDF =
                            '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                'PRINT PDF' +
                            '</button>'

                            buttonPrintMPM =
                            '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                                'PRINTING BY MPM' +
                            '</button> '
                        } else {
                            buttonPrintPDF =
                            '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#'+modalSelf+'">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                                'PRINT PDF' +
                            '</button>'

                            buttonPrintMPM =
                            '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
                                '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                                'PRINTING BY MPM' +
                            '</button> '
                        }

                        if (row.is_mpmPrintPaid ) {
                            var buttonCheckCert =
                            '<a href="{{ route("candidates.muet-status") }}" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                                '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                                'CERTIFICATE STATUS' +
                            '</a>'
                        }

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
        });
    }

    $(document).on('click', '.select_negeri', function() {
    });

});
