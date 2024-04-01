$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('#dt-pos').length > 0) {
        var dt = $('#dt-pos').DataTable({
            responsive: true, processing: true, serverSide: false, ajax: {
                "url": "./pos-processing/ajax", "type": "POST", "data": function (data) {
                },
            }, columns: [{
                data: 'id', name: 'id', class: 'text-center', orderable: false, searchable: false,

            }, {
                data: 'date', name: 'date', class: 'text-center', orderable: true, searchable: true,
            }, {
                data: 'transaction_ref', name: 'transaction_ref', class: 'text-center', orderable: false, searchable: true,
            }, {
                data: 'details', name: 'details', class: 'text-center', orderable: false, searchable: true,
            }, {
                data: 'date_printed', name: 'date_printed', class: 'text-center', orderable: false, searchable: true,
            }, {
                data: 'status', name: 'status', class: 'text-center', orderable: false, searchable: false, render(data, type, row) {
                    let btn = '';
                    btn += data == 'PROCESSING' ? '<button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target=".modalUpdatePos"><i class="ri-information-line fs-22"></i></button>' : '';
                    // btn += row.actionDelete ? '<a id="button-delete" href="javascript:void(0);" data-url="' + row.actionDelete + '" style="margin-left: 5px; margin-right: 5px;" class="text-danger btn-delete"><i class="mdi mdi-delete font-size-18"></i></a>' : '';
                    return btn;
                }
            },], scrollX: true, fixedHeader: true, columnDefs: [{
                targets: 0, orderable: false, checkboxes: {
                    selectRow: true
                }
            }], selectAllPages: true, stateSave: false, select: {
                style: 'multi', selector: 'td:first-child'
            }, order: [[1, 'desc']], pageLength: 25,


            language: {
                lengthMenu: "Display _MENU_ records each page",
                zeroRecords: "No records found.",
                info: "Showing _START_ / _END_ from _TOTAL_ records",
                infoEmpty: "Showing 0 / 0 from 0 records",
                infoFiltered: "(filtering from _MAX_ records)",
                processing: "Please wait...",
                search: "Search :",
                paginate: {
                    next: "<i class='bx bx-chevron-right'>", previous: "<i class='bx bx-chevron-left'>", first: "<i class='bx bx-chevrons-left'>", last: "<i class='bx bx-chevrons-right'>",
                },
            },
        });


        $('#dt-pos').on('processing.dt', function (e, settings, processing) {
            if (processing) {
                $('#button-search-icon').removeClass();
                $('#button-search-icon').addClass('bx bx-loader bx-spin font-size-16 align-middle me-1');
                $('#button-search').prop('disabled', true);
            } else {
                $('#button-search-icon').removeClass();
                $('#button-search-icon').addClass('fas fa-search me-1');
                $('#button-search').prop('disabled', false);
            }
        });


    }
});
