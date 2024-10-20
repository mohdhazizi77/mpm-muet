
// Import jQuery
// import $ from 'jquery'
// window.jQuery = window.$ = $

// import $ from 'jquery';
// import 'bootstrap';
// import 'bootstrap/dist/css/bootstrap.min.css';

// window.$ = $;
// window.jQuery = $;

// Import sweetalert
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
window.Swal = Swal;

// Import DataTables
import 'datatables.net';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';
import 'datatables.net-responsive-bs4';


// Modules
import './modules/user';
import './modules/candidates';
import './modules/order';
import './modules/tracking_order';
import './modules/pos';
import './modules/audit_log';
import './modules/transaction';
import './modules/admin'
import './modules/finance'

// Chart
import './charts/admin'


// import './app-template';

//dropdown logout
$(document).ready(function() {
    $('#page-header-user-dropdown').click(function() {
        var dropdownMenu = new bootstrap.Dropdown(this);
        dropdownMenu.toggle();
    });

    var $body = $('body');
    var $sidebar = $('#sidebar');
    var $sidebarToggleButton = $('#topnav-hamburger-icon');

    // Toggle sidebar visibility on button click
    $sidebarToggleButton.on('click', function() {
        $body.addClass('vertical-sidebar-enable');
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

//template loading
// Swal.fire({
//     title: 'Loading...', // Optional title for the alert
//     allowEscapeKey: false,  // Disables escape key closing the alert
//     allowOutsideClick: false, // Disables outside click closing the alert
//     showConfirmButton: false, // Hides the "Confirm" button
//     didOpen: () => {
//         Swal.showLoading(Swal.getDenyButton()); // Show loading indicator on the Deny button
//     }
// });
// Swal.close()


