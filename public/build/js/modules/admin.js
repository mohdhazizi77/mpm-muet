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
$(document).ready(function() {
    var $body = $('body');
    var $sidebar = $('#sidebar');
    var $sidebarToggleButton = $('#topnav-hamburger-icon');

    // Toggle sidebar visibility on button click
    $sidebarToggleButton.on('click', function() {
        // alert(123)
        $body.toggleClass('vertical-sidebar-enable');
    });

    // Click outside the sidebar to hide it
    $(document).on('click', function(event) {
        // Check if the click is outside the sidebar and not on the hamburger button
        if (!$sidebar.is(event.target) && !$sidebar.has(event.target).length &&
            !$sidebarToggleButton.is(event.target) && !$sidebarToggleButton.has(event.target).length) {
            $body.removeClass('vertical-sidebar-enable');
        }
    });
});

