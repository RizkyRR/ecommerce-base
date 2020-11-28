<!-- Footer Section Begin -->
<footer class="footer-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="footer-left">
          <div class="footer-logo">
            <a href="<?php echo base_url(); ?>home">
              <img src="<?php echo base_url(); ?>image/logo/<?php echo $company['image'] ?>" alt="">
            </a>
          </div>
          <ul>
            <li>Address: <?php echo $company_address['street_name'] ?>, <?php echo $company_address['city_name'] ?>, <?php echo $company_address['province'] ?></li>
            <li>Phone: <?php echo $company['phone'] ?></li>
            <li>Email: <?php echo $company['business_email'] ?></li>
          </ul>
          <div class="footer-social">
            <?php if ($detail_company > 0) : ?>
              <?php foreach ($detail_company as $val) : ?>
                <a href="<?php echo $val['url'] ?>" target="_blank"><i class="<?php echo $val['link_icon'] ?>"></i></a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="footer-widget">
          <h5>Information</h5>
          <ul>
            <li><a href="<?php echo base_url(); ?>company-about">About Us</a></li>
            <li><a href="<?php echo base_url(); ?>check-out">Checkout</a></li>
            <li><a href="<?php echo base_url(); ?>company-contact">Contact</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="footer-widget">
          <h5>My Account</h5>
          <ul>
            <li><a href="<?php echo base_url(); ?>profile">My Account</a></li>
            <li><a href="<?php echo base_url(); ?>company-contact">Contact</a></li>
            <li><a href="<?php echo base_url(); ?>shopping-cart">Shopping Cart</a></li>
            <li><a href="<?php echo base_url(); ?>product-section">Shop</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright-reserved">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="copyright-text">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>
              document.write(new Date().getFullYear());
            </script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="<?php echo base_url(); ?>front-assets/js/main.js"></script>

<!-- Custom JS for its Product -->
<script src="<?php echo base_url(); ?>front-assets/js/product-shop.js"></script>

<!-- Custom JS for Payment DUe -->
<script src="<?php echo base_url(); ?>front-assets/js/payment-shop.js"></script>

<!-- Alert auto fade out -->
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(5000, 500).slideUp(500, function() {
      $(this).remove();
    });
  });

  $(function() {
    var current = location.pathname;
    $('.nav-menu ul li a').each(function() {
      var $this = $(this);
      // if the current path is like this link, make it active
      if ($this.attr('href').indexOf(current) !== -1) {
        $this.parent().addClass('active');
      }
    })
  })
</script>

</body>

</html>