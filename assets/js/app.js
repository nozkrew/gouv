const $ = require( 'jquery' );
//var dt = require( 'datatables.net' );
var dtbs = require( 'datatables.net-bs4' );
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
require('bootstrap/dist/css/bootstrap.min.css');
//require('datatables.net-dt/css/jquery.dataTables.min.css');
require('datatables.net-bs4/css/dataTables.bootstrap4.min.css');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('#table').DataTable();
    $('[data-toggle="popover"]').popover();
});