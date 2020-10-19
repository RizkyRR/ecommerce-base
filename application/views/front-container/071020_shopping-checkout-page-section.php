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
              <label for="street">Street Address<span>*</span></label>
              <!-- <input type="text" id="street" name="street" class="street-first" placeholder="Example: Jalan Abc No. 1 RT 001 / RW 002, Kelurahan A, Kecamatan B" required> -->
              <textarea class="street-first" name="street" id="street" cols="500" rows="20" placeholder="Example: Jalan Abc No. 1 RT 001 / RW 002, Kelurahan A, Kecamatan B" required></textarea>
            </div>

            <!-- RAJA ONGKIR PURPOSES -->
            <div class="col-lg-12 mb-3">
              <label for="province">Province<span>*</span></label>
              <select name="province" id="province" style="width: 100%;" required>
              </select>
            </div>

            <div class="col-lg-12 mb-3">
              <label for="cityregency">City / Regency<span>*</span></label>
              <select name="cityregency" id="cityregency" style="width: 100%;" required>
              </select>
            </div>
            <!-- RAJA ONGKIR PURPOSES -->

            <div class="col-lg-6 mt-3">
              <label for="email">Email Address<span>*</span></label>
              <input type="text" id="email" name="email">
            </div>

            <div class="col-lg-6 mt-3 mb-3">
              <label for="phone">Phone<span>*</span></label>
              <input type="text" id="phone" name="phone">
            </div>

            <div class="col-lg-6 mb-3">
              <label for="service">Service<span>*</span></label>
              <select name="service" id="service" style="width: 100%;" required>
              </select>
            </div>

            <div class="col-lg-6 mb-3">
              <label for="estimate">Estimate<span>*</span></label>
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

    $("#province").select2({
      placeholder: 'Select for a province',
      theme: 'bootstrap'
    });

    $("#cityregency").select2({
      placeholder: 'Select for a regency',
      theme: "bootstrap"
    });

    $('#province').on('change', function() {
      var province_id = $("#province option:selected").val();
      $('#cityregency').empty();
      $(this).valid();

      if (province_id != null && province_id != 0) {
        $.ajax({
          url: "<?php echo base_url(); ?>get-api-city",
          type: 'GET',
          data: {
            province_id: province_id
          },
          dataType: 'JSON',
          success: function(data) {

            var html = '<option value=""></option>';
            var i;

            for (i = 0; i < data.length; i++) {
              html += '<option value="' + data[i].city_id + '">' + data[i].city_name + ' (' + data[i].type + ')</option>';
            }

            $('#cityregency').html(html);
          }
        })
      }
    });

    $('#cityregency').on('change', function() {
      var city_id = $("#cityregency option:selected").val();
      $(this).valid();

      if (city_id != null && city_id != 0) {
        $.ajax({
          url: "<?php echo base_url(); ?>get-api-cost-shipment",
          type: 'GET',
          data: {
            origin: 154,
            destination: city_id,
            weight: 800,
            courier: 'jne'
          },
          dataType: 'JSON',
          success: function(data) {
            console.log(data);

            var result = data[0].costs;
            var html = '<option value="">Select Service</option>';
            var i;

            for (i = 0; i < result.length; i++) {
              var text = result[i].description + " (" + result[i].service + ")";
              html += '<option value="' + result[i].cost[0].value + '" etd="' + result[i].cost[0].etd + '">' + text + '</option>';
            }

            $('#service').html(html);
          }
        })
      }
    });

    var ongkir = 0;

    $('#service').on('change', function() {
      var estimate = $("#service option:selected").attr('etd');
      ongkir = parseInt($(this).val);

      $('#estimate').val(estimate + " Hari").prop('readonly', true);
    });

    // Untuk menghilangkan pesan validasi jika sudah terisi
    /* $('#cityregency').on('change', function() {
      $(this).valid();
    }); */
  });

  showDataProvince();

  function showDataProvince() {
    $.ajax({
      url: "<?php echo base_url(); ?>get-api-province",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id + '">' + data[i].text + '</option>';
        }
        $('#province').html(html);
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
      province: {
        required: true
      },
      cityregency: {
        required: true
      },
      street: {
        required: true,
        minlength: 50
      },
      service: {
        required: true
      }
    },
    messages: {
      province: {
        required: "Province is required!",
      },
      cityregency: {
        required: "Regency is required!"
      },
      street: {
        required: "Street name is required!",
        minlength: "Your street name too short, at least 50 char!"
      },
      service: {
        required: "Service is required!"
      }
    },
  });
</script>