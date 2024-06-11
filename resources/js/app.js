
// Import jQuery
// import $ from 'jquery'
// window.jQuery = window.$ = $

import $ from 'jquery';
// import 'bootstrap';
// import 'bootstrap/dist/css/bootstrap.min.css';

window.$ = $;
window.jQuery = $;

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
import './modules/payment';


