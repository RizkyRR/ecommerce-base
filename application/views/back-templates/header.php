<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $company['company_name'] ?> | <?php echo $title ?></title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>image/logo/printing.png">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <style>
    .image_preview_boxes {
      display: inline-block;
      margin-top: 1em;
      margin-bottom: 1em;
      margin-left: 40px;
      margin-right: 40px;
    }

    /* * {
      box-sizing: border-box;
    } */

    .column-prev-img {
      /* float: left; */
      display: inline-block;
      width: 33.33%;
      padding: 25px;
    }

    /* Clearfix (clear floats) */
    .row-prev-img::after {
      content: "";
      clear: both;
      display: table;
    }

    .dz-message {
      text-align: center;
      font-size: 28px;
    }

    .dz-preview .dz-image img {
      width: 100% !important;
      height: 100% !important;
      object-fit: cover;
    }
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/timepicker/bootstrap-timepicker.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css">

  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/jvectormap/jquery-jvectormap.css">

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- Sweet Alert CSS -->
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/sweet_alert/dist/sweetalert2.min.css"> -->

  <!-- Select2 -->
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/select2/dist/css/select2.css"> -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/select2/css/select2.min.css">

  <!-- Dropzone CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/dropzone/min/dropzone.min.css'; ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/dropzone/min/basic.min.css'; ?>">

  <!-- fullCalendar -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/fullcalendar/dist/fullcalendar.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/fullcalendar/css/fullcalendar.css"> -->

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/dist/css/skins/_all-skins.min.css">

  <!-- Datetimepicker -->
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css'; ?>"> -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/datetimepicker_bs/css/bootstrap-datetimepicker.min.css'; ?>">

  <!-- ZOOM -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/zoom/css/zoom.css'; ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- DataTables -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/Buttons-1.5.1/js/buttons.flash.min.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/JSZip-2.5.0/jszip.min.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/pdfmake-0.1.32/pdfmake.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js"></script>
  <script src="<?php echo base_url(); ?>back-assets/plugins/DataTables/Buttons-1.5.1/js/buttons.print.min.js"></script>

  <!-- ZoomImage -->
  <!--  https://www.npmjs.com/package/js-image-zoom -->
  <!-- <script src="https://unpkg.com/js-image-zoom@0.4.1/js-image-zoom.js" type="application/javascript"></script> -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/zoom-master/jquery.zoom.js"></script> <!-- https://www.jqueryscript.net/blog/Best-Image-Zoom-jQuery-Plugins.html -->

  <!-- Sweet Alert Js -->
  <!-- <script src="<?php echo base_url(); ?>back-assets/plugins/sweet_alert/dist/sweetalert2.min.js"></script> -->
  <script src="<?php echo base_url(); ?>front-assets/js/sweetalert2.all.min.js"></script>

  <!-- Moment Js -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/moment/moment.js"></script>

  <!-- date-range-picker -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- bootstrap datepicker -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <!-- bootstrap color picker -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

  <!-- bootstrap time picker -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>

  <!-- Dropzone Js -->
  <script type="text/javascript" src="<?php echo base_url() . 'back-assets/plugins/dropzone/min/dropzone.min.js'; ?>"></script>

  <!-- Select 2 -->
  <!-- <script src="<?php echo base_url(); ?>back-assets/bower_components/select2/dist/js/select2.full.js"></script> -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/select2/js/select2.min.js"></script>

  <!-- Fullcalendar -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  <!-- <script src="<?php echo base_url(); ?>back-assets/plugins/fullcalendar/js/fullcalendar.min.js"></script> -->

  <!-- Datetimepicker -->
  <!-- <script type="text/javascript" src="<?php echo base_url() . 'back-assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js'; ?>"></script> -->
  <script type="text/javascript" src="<?php echo base_url() . 'back-assets/plugins/datetimepicker_bs/js/bootstrap-datetimepicker.js'; ?>"></script>

  <!-- Validator -->
  <script src="<?php echo base_url(); ?>front-assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>

  <!-- AutoNumeric -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/auto-numeric/autoNumeric.js"></script>

  <!-- ZOOM -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/zoom/js/zoom.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">