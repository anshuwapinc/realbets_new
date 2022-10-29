<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

if (!isset($_SESSION['my_userdata']) || empty($_SESSION['my_userdata'])) {
  redirect('/');
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sports Book</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/extra/ionicons.min.css">
  <!-- Daterange picker -->
  <!-- summernote -->
  <!-- Google Font: Source Sans Pro -->
  <link href="<?php echo base_url(); ?>assets/extra/css.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/extra/font-awesome.min.css">
  <?php echo $template_css; ?>
  <?php echo $template_js; ?>
  <!-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" /> -->
  <!-- <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" /> -->

  <link href="<?php echo base_url(); ?>assets/plugins/datatables-buttons/css/buttons.dataTables.min.css" rel="stylesheet" />
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>

  <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
  <!-- <script src="https://rawgit.com/creativetimofficial/material-kit/master/assets/js/core/jquery.min.js"></script> -->
  <script src="https://rawgit.com/creativetimofficial/material-kit/master/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="https://rawgit.com/creativetimofficial/material-kit/master/assets/js/plugins/moment.min.js"></script>
  <script src="https://rawgit.com/creativetimofficial/material-kit/master/assets/js/plugins/bootstrap-datetimepicker.js"></script>
  <script src="https://rawgit.com/creativetimofficial/material-kit/master/assets/js/material-kit.js"></script>
</head>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">



    <?php echo $template_header; ?>
    <?php echo $template_content; ?>
    <?php echo $template_footer; ?>
  </div>


  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
</body>

</html>