<!-- Footer Section Begin -->
<footer class="footer-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="footer-left">
          <div class="footer-logo">
            <a href="<?php echo base_url(); ?>">
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
      <div class="col-lg-2 offset-lg-1">
        <div class="footer-widget">
          <h5>Information</h5>
          <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Checkout</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Serivius</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="footer-widget">
          <h5>My Account</h5>
          <ul>
            <li><a href="#">My Account</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Shopping Cart</a></li>
            <li><a href="#">Shop</a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="newslatter-item">
          <h5>Join Our Newsletter Now</h5>
          <p>Get E-mail updates about our latest shop and special offers.</p>
          <form method="POST" action="#" class="subscribe-form" enctype="multipart/form-data">
            <input type="text" placeholder="Enter Your Mail">
            <button type="button">Subscribe</button>
          </form>
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
          <div class="payment-pic">
            <img src="<?php echo base_url(); ?>front-assets/img/payment-method.png" alt="">
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
  })
</script>

</body>

</html>