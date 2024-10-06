$(document).ready(function() {

    if ($("#datatableViewExcel").length>0) {

        $('#datatableViewExcel').DataTable({
            // processing: true,
            // serverSide: true,
            // ajax: {
            //     "url": "./audit-logs/ajax",
            //     "type": "POST",
            //     "data": function (d) {
            //         d._token = $('meta[name="csrf-token"]').attr('content');
            //         d.type = $('#auditTable').data('type');
            //     }
            // },
            searching: false,
            lengthChange: false,
        });
    }
});

