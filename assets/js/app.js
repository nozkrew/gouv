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

require('jquery-ui/ui/widgets/autocomplete');

require('jquery-mask-plugin/dist/jquery.mask.min.js');

var bootstrapSelect = require("bootstrap-select");
require("bootstrap-select/dist/css/bootstrap-select.min.css");

require('../css/app.css');

//import { bootstrapMultiselect } from 'bootstrap-multiselect/dist/js/bootstrap-multiselect';
//require('bootstrap-multiselect/dist/js/bootstrap-multiselect');

//var bootstrapMultiselect = require("bootstrap-multiselect");

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('.dataTable').DataTable();
    //$('[data-toggle="popover"]').popover();
    
    formFavorisSubmit();
    
    function formFavorisSubmit(){
        $('form[name="app_main_favorisadd"]').on('submit', function(e){
            e.preventDefault();
            $('[data-toggle="tooltip"]').tooltip('dispose');
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                success: function(response){
                    if(!response.error){
                        $(form).replaceWith(response.html);
                        $('[data-toggle="tooltip"]').tooltip('update');
                        formFavorisSubmit();
                    }
                    else{
                        //TODO
                    }
                },
                error:function(error){}
            });
        });
    }
});