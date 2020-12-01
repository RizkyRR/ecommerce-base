<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Fashi Template">
  <meta name="keywords" content="Fashi, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $company['company_name'] ?> - <?php echo $title ?>.</title>
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>front-assets/img/clothes.png">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/themify-icons.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/elegant-icons.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/owl.carousel.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/nice-select.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/jquery-ui.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/slicknav.min.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>front-assets/css/style.css" type="text/css">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Select2 -->
  <link href="<?php echo base_url(); ?>back-assets/plugins/select2/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/plugins/select2/css/select2-bootstrap.min.css">

  <!-- Star Rating CSS -->
  <link rel="stylesheet" href="<?php echo base_url() . 'front-assets/plugins/jquery-rateyo/jquery.rateyo.min.css'; ?>">

  <!-- Dropzone CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/dropzone/min/dropzone.min.css'; ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/dropzone/min/basic.min.css'; ?>">

  <!-- datatables bootstrap3 -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'front-assets/plugins/datatables/datatables.min.css'; ?>">

  <!-- ZOOM -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/zoom/css/zoom.css'; ?>">
  <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'back-assets/plugins/zoom-zoomove/dist/zoomove.min.css'; ?>"> -->


  <!-- Js Plugins -->
  <script src="<?php echo base_url(); ?>front-assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/bootstrap.min.js"></script>

  <script src="<?php echo base_url(); ?>front-assets/js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/jquery.countdown.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/jquery.nice-select.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/jquery.zoom.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/jquery.dd.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/jquery.slicknav.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/js/owl.carousel.min.js"></script>

  <!-- bootstrap datepicker -->
  <script src="<?php echo base_url(); ?>back-assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  <!-- Select 2 -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/select2/js/select2.min.js"></script>

  <!-- Validator -->
  <script src="<?php echo base_url(); ?>front-assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?php echo base_url(); ?>front-assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>

  <!-- SweetAlert -->
  <!-- <script src="<?php echo base_url(); ?>front-assets/js/sweetalert.min.js"></script> -->

  <!-- SweetAlert2 -->
  <script src="<?php echo base_url(); ?>front-assets/js/sweetalert2.all.min.js"></script>

  <!-- AutoNumeric -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/auto-numeric/autoNumeric.js"></script>

  <!-- Star Rating jquery -->
  <script src="<?php echo base_url() . 'front-assets/plugins/jquery-rateyo/jquery.rateyo.min.js'; ?>"></script>

  <!-- Dropzone Js -->
  <script type="text/javascript" src="<?php echo base_url() . 'back-assets/plugins/dropzone/min/dropzone.min.js'; ?>"></script>

  <!-- datatables bootstrap3 -->
  <script type="text/javascript" src="<?php echo base_url() . 'front-assets/plugins/datatables/datatables.min.js'; ?>"></script>

  <!-- ZOOM -->
  <script src="<?php echo base_url(); ?>back-assets/plugins/zoom/js/zoom.js"></script>
  <!-- https://www.jqueryscript.net/blog/Best-Image-Zoom-jQuery-Plugins.html -->
  <!-- <script src="<?php echo base_url(); ?>back-assets/plugins/zoom-master/jquery.zoom.js"></script> -->
  <!-- <script src="<?php echo base_url(); ?>back-assets/plugins/zoom-zoomove/dist/zoomove.min.js"></script> -->

</head>

<body>
  <!-- Page Preloder -->
  <div id="preloder">
    <div class="loader"></div>
  </div>

  <!-- Header Section Begin -->
  <header class="header-section">
    <div class="header-top">
      <div class="container">
        <div class="ht-left">
          <div class="mail-service">
            <i class=" fa fa-envelope"></i>
            <?php echo $company['business_email'] ?>
          </div>
          <div class="phone-service">
            <i class=" fa fa-phone"></i>
            <?php echo $company['phone'] ?>
          </div>
        </div>
        <div class="ht-right">

          <?php if ($this->session->userdata('customer_email')) : ?>
            <a href="<?php echo base_url(); ?>profile" class="login-panel"><i class="fa fa-user"></i><?php echo $this->session->userdata('customer_name') ?></a>
          <?php else : ?>
            <a href="<?php echo base_url(); ?>sign-in" class="login-panel"><i class="fa fa-lock" aria-hidden="true"></i>Sign In</a>
          <?php endif; ?>

          <div class="top-social">
            <?php if ($detail_company > 0) : ?>
              <?php foreach ($detail_company as $val) : ?>
                <a href="<?php echo $val['url'] ?>" target="_blank"><i class="<?php echo $val['link_icon'] ?>"></i></a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="inner-header">
        <div class="row">
          <div class="col-lg-2 col-md-2">
            <div class="logo">
              <a href="<?php echo base_url(); ?>home">
                <img src="<?php echo base_url(); ?>image/logo/<?php echo $company['image'] ?>" alt="">
              </a>
            </div>
          </div>
          <div class="col-lg-7 col-md-7">
            <form action="<?php echo base_url(); ?>product-section" method="POST" enctype="multipart/form-data">
              <div class="advanced-search">
                <div class="input-group">
                  <input type="text" id="search" name="search" placeholder="What do you need?">
                  <button type="submit" id="btnSearch"><i class="ti-search"></i></button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-3 text-right col-md-3">
            <ul class="nav-right">

              <li class="heart-icon">
                <a href="<?php echo base_url() ?>get-wishlist">
                  <i class="icon_heart_alt" title="wishlist"></i>

                  <?php if ($count_wishlist > 0) : ?>
                    <span><?php echo $count_wishlist; ?></span>
                  <?php else : ?>
                    <span>0</span>
                  <?php endif; ?>

                </a>
              </li>

              <li class="cart-icon">
                <a href="#">
                  <i class="icon_bag_alt"></i>

                  <span id="show_count_cart">0</span>
                </a>

                <div class="cart-hover" style="display: none;">
                  <div class="select-items">
                    <table>
                      <tbody id="show_shopping_cart">

                      </tbody>
                    </table>
                  </div>

                  <div class="select-total">
                    <span>total:</span>

                    <div id="total-cart"></div>

                  </div>

                  <div class="select-button">
                    <a href="<?php echo base_url(); ?>shopping-cart" class="primary-btn view-card">VIEW CARD</a>
                    <a href="<?php echo base_url(); ?>check-out" class="primary-btn checkout-btn">CHECK OUT</a>
                  </div>
                </div>
              </li>

              <li class="cart-price">
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="nav-item">
      <div class="container">
        <div class="nav-depart">
          <div class="depart-btn">
            <i class="ti-menu"></i>
            <span>Categories</span>
            <ul class="depart-hover">
              <div id="show-data-category"></div>
            </ul>
          </div>
        </div>
        <nav class="nav-menu mobile-menu">
          <ul>
            <li><a href="<?php echo base_url(); ?>home" class="active">Home</a></li>
            <li><a href="<?php echo base_url(); ?>product-section">Shop</a></li>
            <li><a href="<?php echo base_url(); ?>company-about">About Us</a></li>
            <li><a href="<?php echo base_url(); ?>company-contact">Contact Us</a></li>
          </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
      </div>
    </div>
  </header>
  <!-- Header End -->