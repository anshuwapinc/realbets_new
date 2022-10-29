<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['default_css'] = array(
    // 'menu' => array('name' => 'assets/exchange/menu.css'),
    // 'custom' => array('name' => 'assets/exchange/custom.css'),
    'font-awesome' => array('name' => 'assets/font-awesome/css/font-awesome.min.css'),
);

$config['default_js'] = array(
    'jquery' => array('name' => 'assets/exchange/jquery.js'),
     'moment' => array('name' => 'assets/exchange/moment.min.js"'),
    'daterangepicker' => array('name' => 'assets/exchange/daterangepicker.js'),
    'general' => array('name' => 'assets/js/general.js'),
    'blockUI' => array('name' => 'assets/js/jquery-block-ui.js'),
    'jquery.validate' => array('name' => 'assets/plugins/validation/jquery.validate.min.js'),

    // 'mobile-detect' => array('name' => 'assets/js/mobile-detect.js'),
    // 'jquery-print' => array('name' => 'assets/js/jQuery.print.js')
   );


$config['admin_default_css'] = array(
    // 'menu' => array('name' => 'assets/exchange/menu.css'),
    // 'custom' => array('name' => 'assets/exchange/custom.css'),
    'font-awesome' => array('name' => 'assets/extra/font-awesome.min.css'),
    // 'bootstrap' => array("name" => 'assets/exchange/bootstrap.min.css')
);

$config['admin_default_js'] = array(
    // 'jquery' => array('name' => 'assets/exchange/jquery.js'),
    'moment' => array('name' => 'assets/exchange/moment.min.js"'),
    'general' => array('name' => 'assets/js/general.js'),
    'blockUI' => array('name' => 'assets/js/jquery-block-ui.js'),
    'jquery.validate' => array('name' => 'assets/plugins/validation/jquery.validate.min.js'),

   'daterangepicker' => array('name' => 'assets/exchange/daterangepicker.js'),
);



$config['css_arr'] = array(
    'datepicker' => array('name' => 'assets/plugins/datepicker/bootstrap-datepicker.min.css'),
    'jquery.dataTables.bootstrap' => array('name' => 'assets/plugins/datatables/dataTables.bootstrap.css'),
    'datatables' => array('name' => 'assets/plugins/datatable/css/bootstrap.datatable.min.css'),
    'colorbox' => array('name' => 'assets/plugins/colorbox/colorbox.css'),
    'datepicker' => array('name' => 'assets/plugins/datepicker/bootstrap-datepicker.min.css'),
    'datatables-buttons' => array('name' => 'assets/plugins/datatable/css/buttons.dataTables.min.css'),
    'chosen' => array('name' => 'assets/css/chosen.css'),
    'customstylesheet' => array('name' => 'assets/css/customstylesheet.css'),
    'icheck' => array('name' => 'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'),
    'dashboard' => array('name' => 'assets/css/dashboard.css'),
    'dropify' => array('name' => 'assets/plugins/dropify/css/dropify.css'),
    'select2' => array('name' => 'assets/plugins/select2/select2.css'),
    'fileinput' => array('name' => 'assets/plugins/bootstrap-fileinput-master/css/fileinput.css'),
    'jquery-ui' => array('name' => 'assets/jquery-ui.css'),
    'sponsor' => array('name' => 'assets/css/sponsor.css'),
    'sponsorstyle' => array('name' => 'assets/css/sponsorstyle.css'),
    'all.min.css' => array('name' => 'assets/plugins/fontawesome-free/css/all.min.css'),
    'adminlte.min.css' => array('name' => 'assets/dist/css/adminlte.min.css'),
    'ionicons.min.css' => array('name' => 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'),
    'dataTables.bootstrap4' => array('name' => 'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'),
    'responsive.bootstrap4' => array('name' => 'assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'),
    'select2' => array('name' => 'assets/plugins/select2/css/select2.min.css'),
    'select2-bootstrap4-theme' => array('name' => 'assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'),
    'daterangepicker' => array('name' => 'assets/plugins/daterangepicker/daterangepicker.css'),

  

);

$config['js_arr'] = array(
    'jquery.dataTables' => array('name' => 'assets/plugins/datatables/jquery.dataTables.min.js'),
    'jquery.dataTables.bootstrap' => array('name' => 'assets/plugins/datatables/dataTables.bootstrap.js'),
    'datepicker' => array('name' => 'assets/plugins/datepicker/bootstrap-datepicker.min.js'),
    'dataTables.fnFilterOnReturn' => array('name' => 'assets/plugins/datatables/dataTables.fnFilterOnReturn.js'),
    'dataTables.fnReloadAjax' => array('name' => 'assets/plugins/datatables/fnReloadAjax.js'),
    'jquery.validate.min' => array('name' => 'assets/js/validation/jquery.validate.min.js'),
    'additional-methods.min' => array('name' => 'assets/plugins/validation/additional-methods.min.js'),
    'bootstrap.datatables' => array('name' => 'assets/plugins/datatable/js/dataTables.bootstrap.js'),
    'ckeditor' => array('name' => 'assets/plugins/ckeditor/ckeditor.js'),
    'jquery-ui' => array('name' => 'assets/plugins/jQueryUI/jquery-ui.js'),
    'colorbox' => array('name' => 'assets/plugins/colorbox/jquery.colorbox.js'),
    'typeahead.bundle' => array('name' => 'assets/js/typeahead.bundle.min.js'),
    'inputmasked' => array('name' => 'assets/js/jquery.maskedinput.js'),
    'button-print' => array('name' => 'assets/plugins/datatable/js/buttons.print.min.js'),
    'datatable-button' => array('name' => 'assets/plugins/datatable/js/dataTables.buttons.min.js'),
    'jquery.validate' => array('name' => 'assets/plugins/validation/jquery.validate.min.js'),
    'chosen' => array('name' => 'assets/js/chosen.jquery.js'),
    'icheck' => array('name' => 'assets/plugins/iCheck/js/icheck.min.js'),
    'chart' => array('name' => 'assets/js/chart.min.js'),
    'easypiechart' => array('name' => 'assets/js/easypiechart.js'),
    'chart-data' => array('name' => 'assets/js/chart-data.js'),
    'easypiechart-data' => array('name' => 'assets/js/easypiechart-data.js'),
    'lumino' => array('name' => 'assets/js/lumino.glyphs.js'),
    'dropify' => array('name' => 'assets/plugins/dropify/js/dropify.js'),
    'select2' => array('name' => 'assets/plugins/select2/select2.js'),
    'search' => array('name' => 'assets/js/search.js'),
    'combodate' => array('name' => 'assets/js/combodate.js'),
    'moment' => array('name' => 'assets/js/moment.js'),
    'fileinput' => array('name' => 'assets/plugins/bootstrap-fileinput-master/js/fileinput.js'),
    'purify' => array('name' => 'assets/plugins/bootstrap-fileinput-master/js/purify.js'),
    'sortable' => array('name' => 'assets/plugins/bootstrap-fileinput-master/js/sortable.js'),
    'dataTables.min' => array('name' => 'assets/plugins/datatables/jquery.dataTables.min.js'),
    'dataTables.bootstrap4' => array('name' => 'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'),
    'dataTables.responsive' => array('name' => 'assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'),
    'responsive.bootstrap4' => array('name' => 'assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'),
    'select2' => array('name' => 'assets/plugins/select2/js/select2.full.min.js'),
    'daterangepicker' => array('name' => 'assets/plugins/daterangepicker/daterangepicker.js'),
    'blockUI' => array('name' => 'assets/js/jquery-block-ui.js'),

);
