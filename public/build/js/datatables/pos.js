$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('#dt-pos').length > 0) {
        var dt = $('#dt-pos').DataTable({
            responsive: true, processing: true, serverSide: true, ajax: {
                "url": "./pos/ajax", "type": "POST", "data": function (data) {
                },
            }, columns: [{
                data: 'id',
                name: 'id',
                class: 'text-center',
                orderable: false,
                searchable: false,
                
            }, {
                data: 'DT_RowIndex', name: 'DT_RowIndex',
            }, {
                data: 'date', name: 'date', class: 'text-center', orderable: true, searchable: true,
            }, {
                data: 'transaction_ref', name: 'transaction_ref', class: 'text-center', orderable: false, searchable: true,
            }, {
                data: 'details', name: 'details', class: 'text-center', orderable: false, searchable: true,
            }, {
                data: 'status', name: 'status', class: 'text-center', orderable: false, searchable: true, render(data, type, row) {
                    let btn = '';
                    btn += data == 'NEW' ? '<h5><span class="badge rounded-pill bg-primary">NEW</span></h5' : '';
                    btn += data == 'PROCESSING' ? '<h5><span class="badge rounded-pill bg-info">PROCESSING</span></h5>' : '';
                    btn += data == 'COMPLETED' ? '<h5><span class="badge rounded-pill bg-success">COMPLETED</span></h5>' : '';
                    btn += data == 'CANCELLED' ? '<h5><span class="badge rounded-pill bg-warning">CANCELLED</span></h5>' : '';
                    // btn += row.actionDelete ? '<a id="button-delete" href="javascript:void(0);" data-url="' + row.actionDelete + '" style="margin-left: 5px; margin-right: 5px;" class="text-danger btn-delete"><i class="mdi mdi-delete font-size-18"></i></a>' : '';
                    return btn;
                }
            }, {
                data: 'status', name: 'status', class: 'text-center', orderable: false, searchable: false, render(data, type, row) {
                    let btn = '';
                    btn += data == 'NEW' ? '<button type="button" class="btn btn-success btn-icon waves-effect waves-light me-2"><i class="ri-check-line"></i></button> <button type="button" class="btn btn-danger btn-icon waves-effect waves-light me-2"><i class="ri-close-line"></i></button>' : '';
                    btn += data == 'PROCESSING' ? '<button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-information-line"></i></button> <button type="button" class="btn btn-secondary btn-icon waves-effect waves-light me-2"><i class="ri-printer-line"></i></button>' : '';
                    btn += data == 'COMPLETED' ? '<button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-information-line"></i></button>' : '';
                    btn += data == 'CANCELLED' ? '<button type="button" class="btn btn-info btn-icon waves-effect waves-light me-2"><i class="ri-information-line"></i></button>' : '';
                    // btn += row.actionDelete ? '<a id="button-delete" href="javascript:void(0);" data-url="' + row.actionDelete + '" style="margin-left: 5px; margin-right: 5px;" class="text-danger btn-delete"><i class="mdi mdi-delete font-size-18"></i></a>' : '';
                    return btn;
                }
            },], scrollX: true, fixedHeader: true, columnDefs: [{
                targets: 0, orderable: false, checkboxes: {
                    selectRow: true
                }
            }], selectAllPages: true, stateSave: false, select: {
                style: 'multi', selector: 'td:first-child'
            }, order: [[1]], pageLength: 50,


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
