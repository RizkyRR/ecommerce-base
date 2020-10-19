<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
  <div class="container">
    <div class="row">
      <?php if (validation_errors() != null) : ?>
        <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
          <br>
          <?php echo validation_errors(); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('success'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php elseif ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('error'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
    </div>

    <form action="" method="POST" class="checkout-form" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-6">
          <h4>Biiling Details</h4>
          <div class="row">
            <div class="col-lg-12">
              <label for="name">Customer Name<span>*</span></label>
              <input type="text" id="name" name="name">
            </div>

            <div class="col-lg-12">
              <label for="province">Province<span>*</span></label>
              <input type="text" id="province" name="province">
            </div>

            <div class="col-lg-12">
              <label for="cityregency">City / Regency<span>*</span></label>
              <input type="text" id="cityregency" name="cityregency">
            </div>

            <div class="col-lg-12">
              <label for="district">District<span>*</span></label>
              <input type="text" id="district" name="district">
            </div>

            <div class="col-lg-12">
              <label for="subdistrict">Sub-District<span>*</span></label>
              <input type="text" id="subdistrict" name="subdistrict">
            </div>

            <!-- RAJA ONGKIR PURPOSES -->
            <div class="col-lg-12">
              <label for="province">Province<span>*</span></label>
              <select name="province" id="province">
                <option value="">Select Province</option>
                <?php foreach ($province as $val) : ?>
                  <option value="<?php echo $val->province_id ?>"><?php echo $val->province ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-lg-12">
              <label for="cityregency">City / Regency<span>*</span></label>
              <input type="text" id="subdistrict" name="subdistrict">
            </div>
            <!-- RAJA ONGKIR PURPOSES -->

            <div class="col-lg-12">
              <label for="street">Street Address<span>*</span></label>
              <input type="text" id="street" name="street" class="street-first">
            </div>

            <div class="col-lg-6">
              <label for="email">Email Address<span>*</span></label>
              <input type="text" id="email" name="email">
            </div>

            <div class="col-lg-6">
              <label for="phone">Phone<span>*</span></label>
              <input type="text" id="phone" name="phone">
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <!-- <div class="checkout-content">
            <input type="text" id="coupon-code" placeholder="Enter Your Coupon Code">
          </div> -->
          <div class="place-order">
            <h4>Your Order</h4>
            <div class="order-total">
              <ul class="order-table">
                <li>Product <span>Total</span></li>

                <div id="show-check-out-data"></div>

                <li class="fw-normal">Subtotal <span id="check-out-subtotal"></span></li>
                <li class="total-price">Total <span id="check-out-total"></span></li>
              </ul>
              <div class="payment-check">
                <div class="pc-item">
                  <label for="pc-check">
                    Cheque Payment
                    <input type="checkbox" id="pc-check">
                    <span class="checkmark"></span>
                  </label>
                </div>
              </div>
              <div class="order-btn">
                <button type="submit" id="place-order" class="site-btn place-btn">Place Order</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<!-- Shopping Cart Section End -->

<script>
  $(document).ready(function() {
    /* $('#place-order').on('click', function(e) {
      e.preventDefault();

      $.ajax({
        url: '<?php echo base_url(); ?>insert-check-out',
        type: 'POST',
        data: {
          product_id: $('[name="product_id[]"]').val(),
          email: $('#email').val()
        },
        dataType: 'JSON',
        success: function(data) {
          if (data.status == true) {

          } else {
            Swal.fire({
              icon: 'error',
              title: data.message[0],
              showConfirmButton: false,
              timer: 1500
            })
          }
        }
      });
    }) */
  })
</script>