$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('#dt-pos').length > 0) {
        var dt = $('#dt-pos').DataTable({
            responsive: true, processing: true, serverSide: false, ajax: {
                "url": "./transaction/ajax", "type": "POST", "data": function (data) {
                },
            }, columns: [
                {
                    data: 'date', name: 'date', class: 'text-center', orderable: true, searchable: true,
                }, {
                    data: 'transaction_ref', name: 'transaction_ref', class: 'text-center', orderable: false, searchable: true,
                }, {
                    data: 'details', name: 'details', class: 'text-center', orderable: false, searchable: true,
                }, {
                    data: 'status', name: 'status', class: 'text-center', orderable: true, searchable: true,
                }, {
                    data: 'date_completed', name: 'date_completed', class: 'text-center', orderable: false, searchable: true,
                },],
            order: [[1, 'desc']], pageLength: 25,


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