const $ = require( 'jquery' );

global.$ = global.jQuery = $;
//var dt = require( 'datatables.net' );
var dtbs = require( 'datatables.net-bs4' );

require('bootstrap');
require('bootstrap/dist/css/bootstrap.min.css');
require('bootstrap/dist/js/bootstrap.bundle.js');

require('datatables.net-bs4/css/dataTables.bootstrap4.min.css');


require('jquery.easing/jquery.easing.js');

require('@fortawesome/fontawesome-free/css/all.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('startbootstrap-sb-admin-2/css/sb-admin-2.min.css');
require('startbootstrap-sb-admin-2/js/sb-admin-2.min.js');

require('chart.js/dist/Chart.min.js');

//var bootstrapMultiselect = require("bootstrap-multiselect");

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('#table').DataTable();
    $('[data-toggle="popover"]').popover();
});