import $ from 'jquery'
window.jQuery = window.$ = $

$(document).ready(function() {

    if ($('#dt-user').length) {

        $('#dt-user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "./users/ajax",
                "type": "POST",
                "data": function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "name",
                    orderable: true,
                },
                {
                    data: "email",
                    orderable: false,
                },
                {
                    data: "phoneNum",
                    orderable: false,
                },
                {
                    data: "role",
                    orderable: true,
                    render(data, type, row) {

                        let html = '';
                        html = '<span class="badge badge-pill badge-primary">'+data+'</span>';

                        return html;
                    }
                },
                {
                    data: "status",
                    orderable: true,
                    render(data, type, row) {

                        let html = '';

                        if (data == 0) { //active
                            html = '<span class="badge badge-pill badge-success">Active</span>';
                        } else {
                            html = '<span class="badge badge-pill badge-danger">Inactive</span>';
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
                        btn = '<button type="button" data-id="'+data+'" class="btn btn-info btn-icon waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#modalUpdatePos" ><i class="ri-information-line fs-22"></i></button>';

                        btn =
                       '<a href="/users/edit/'+data+'" type="button" class="btn btn-soft-info waves-effect text-black mx-2" >' +
                            '<i class="ri-edit-line label-icon align-middle fs-16 me-2"></i>' +
                            'EDIT' +
                        '</a>'

                        return btn;
                    }
                }
                // {
                //     data: "id",
                //     orderable: false,
                // },
                // {
                //     data: "id",
                //     orderable: false,
                //     render: function (data, type, row, meta) {

                //         var buttonCheckCert = '';
                //         var buttonPrintPDF = '';
                //         var buttonPrintMPM = '';

                //         console.log(data, row.is_more2year, row.is_selfPrintPaid, row.is_mpmPrintPaid);
                //         var modalSelf = 'modalVerifyPDF';
                //         var modalMPM = 'modalVerifyMPM';
                //         var modalPayment = 'modalPayment';

                //         if (row.is_more2year && !row.is_selfPrintPaid) { //lebih 2 tahun and tak bayar lagi
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             // '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 '+modalPayment+'" data-bs-toggle="modal" data-bs-target="#'+modalPayment+'">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '
                //             '<a href="/candidates-printmpm/'+data+'" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</a> '
                //         } else {
                //             buttonPrintPDF =
                //             '<a data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalSelf+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i>' +
                //                 'PRINT PDF' +
                //             '</a>'

                //             buttonPrintMPM =
                //             '<button type="button" data-id='+data+' class="btn btn-soft-info waves-effect text-black mx-2 modalVerify" data-bs-toggle="modal" data-bs-target="#'+modalMPM+'">' +
                //                 '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //                 'PRINTING BY MPM' +
                //             '</button> '
                //             // '<a href="/candidates-printmpm" class="btn btn-soft-info waves-effect text-black mx-2 ">' +
                //             //     '<i class="ri-printer-line label-icon align-middle fs-16 me-2"></i> ' +
                //             //     'PRINTING BY MPM' +
                //             // '</a> '

                //         }

                //         if (row.is_mpmPrintPaid ) {
                //             var buttonCheckCert =
                //             '<a href="/muet-status" data-id='+data+' class="btn btn-soft-secondary waves-effect text-black mx-2">' +
                //                 '<i class="ri-list-check-2 label-icon align-middle fs-16 me-2"></i>' +
                //                 'CERTIFICATE STATUS' +
                //             '</a>'
                //         }

                //         return buttonPrintPDF + buttonPrintMPM + buttonCheckCert;

                //     },
                //     // className: ,
                // }
            ],
            pageLength: 50,
            order: [[0, "asc"]],
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
