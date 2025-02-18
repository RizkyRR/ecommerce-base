<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
  <div class="container">
    <!-- <div class="row">
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
    </div> -->

    <form action="" method="POST" class="checkout-form" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-6">
          <h4>Biiling Details</h4>
          <div class="row">
            <div class="col-lg-12">
              <label for="name">Customer Name<span>*</span></label>
              <input type="text" id="name" name="name" readonly>
            </div>

            <div class="col-lg-12">
              <label for="street">Street Address<span>*</span></label>
              <!-- <input type="text" id="street" name="street" class="street-first" placeholder="Example: Jalan Abc No. 1 RT 001 / RW 002, Kelurahan A, Kecamatan B" required> -->
              <textarea class="street-first" name="street" id="street" cols="500" rows="20" placeholder="Please complete this address on your profile page address list" required readonly></textarea>
              <input type="hidden" name="city_id" id="city_id" readonly>
              <input type="hidden" name="company_city_id" id="company_city_id" readonly>
            </div>

            <div class="col-lg-6 mt-3">
              <label for="email">Email Address<span>*</span></label>
              <input type="text" id="email" name="email" readonly>
            </div>

            <div class="col-lg-6 mt-3 mb-3">
              <label for="phone">Phone<span>*</span></label>
              <input type="text" id="phone" name="phone" readonly>
            </div>

            <div class="col-lg-12 mb-3">
              <label for="courier">Courier<span>*</span></label>
              <select name="courier" id="courier" style="width: 100%;" required>
                <option value="">Select Courier</option>
                <option value="jne">JNE (Jalur Nugraha Ekakurir)</option>
                <option value="pos">Pos (Pos Indonesia)</option>
                <option value="tiki">TIKI (Titipan Kilat)</option>
              </select>
            </div>

            <div class="col-lg-6 mb-3">
              <label for="service">Service<span>*</span></label>
              <select name="service" id="service" style="width: 100%;" required>
              </select>

              <input type="hidden" name="service_val" id="service_val" readonly>
              <input type="hidden" name="etd_val" id="etd_val" readonly>
              <input type="hidden" name="cost_val" id="cost_val" readonly>
            </div>

            <div class="col-lg-6 mb-3">
              <label for="estimate">Estimated Date<span>*</span></label>
              <input type="text" nama="estimate" id="estimate">
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

                <li class="fw-normal">Subtotal <span id="check-out-subtotal"></span>
                  <input type="hidden" name="check_out_subtotal_val" id="check-out-subtotal-val" readonly>
                  <input type="hidden" name="check_out_weight_val" id="check-out-weight-val" readonly>
                </li>

                <li class="fw-normal">Ppn <span id="check-out-ppn"></span>
                  <input type="hidden" name="check_out_ppn_charge_rate" id="check-out-ppn-charge-rate" readonly>
                  <input type="hidden" name="check_out_ppn_charge_val" id="check-out-ppn-charge-val" readonly>
                  <input type="hidden" name="check_out_ppn_charge" id="check-out-ppn-charge" readonly>
                </li>

                <li class="fw-normal">Shipping costs <span id="check-out-shippingcost"></span>
                  <input type="hidden" name="check_out_shippingcost" id="check-out-shippingcost-val" readonly>
                </li>

                <li class="total-price">Total <span id="check-out-total"></span>
                  <input type="hidden" name="check_out_total" id="check-out-total-val" readonly>
                </li>
              </ul>
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
  getInfoFullAddress();

  function getInfoFullAddress() {
    $.ajax({
      url: "<?php echo base_url(); ?>get-full-address",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var streetName = data.street_name;

        if (streetName != '') {
          streetName = data.street_name + ', ' + data.city_name + ', ' + data.province;
        }

        $("#name").val(data.name).attr("readonly", true);
        $('#street').val(streetName).attr("readonly", true);
        $('#city_id').val(data.city_id).attr("readonly", true);
        $("#email").val(data.email).attr("readonly", true);
        $("#phone").val(data.phone).attr("readonly", true);
      }
    })
  }

  $.validator.setDefaults({
    highlight: function(element) {
      $(element).closest(".form-group").addClass("has-error");
    },
    unhighlight: function(element) {
      $(element).closest(".form-group").removeClass("has-error");
    },
    errorElement: "span",
    errorClass: "error-message",
    errorPlacement: function(error, element) {
      if (element.parent('.input-group').length) {
        error.insertAfter(element.parent()); // radio/checkbox?
      }
      /* else if (element.hasClass('select2')) {
             error.insertAfter(element.next('span')); // select2
           } */
      else if (element.hasClass("select2-hidden-accessible")) {
        error.insertAfter(element.next('span.select2')); // select2 new ver
      } else {
        error.insertAfter(element); // default
      }
    },
  });

  var $validator = $(".checkout-form").validate({
    rules: {
      name: {
        required: true
      },
      street: {
        required: true,
        minlength: 50
      },
      email: {
        required: true
      },
      phone: {
        required: true,
        number: true
      },
      courier: {
        required: true
      },
      service: {
        required: true
      }
    },
    messages: {
      street: {
        required: "Street name is required!",
        minlength: "Your street name too short, at least 50 char!"
      },
      courier: {
        required: "Courier is required!"
      },
      service: {
        required: "Service is required!"
      }
    },
  });
</script>