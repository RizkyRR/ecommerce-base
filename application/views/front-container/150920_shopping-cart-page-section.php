<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="cart-table">
          <table id="cart_table">
            <thead>
              <tr>
                <th>Image</th>
                <th class="p-name">Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th><i class="ti-close"></i></th>
              </tr>
            </thead>
            <tbody id="show-detail-shopping-cart">

            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="cart-buttons">
              <a href="<?php echo base_url(); ?>product-section" class="primary-btn continue-shop">Continue shopping</a>
              <!-- <a href="javascript:void(0)" class="primary-btn up-cart" onclick="updateCart()">Update cart</a> -->
            </div>
            <!-- <div class="discount-coupon">
              <h6>Discount Codes</h6>
              <form action="#" class="coupon-form">
                <input type="text" placeholder="Enter your codes">
                <button type="submit" class="site-btn coupon-btn">Apply</button>
              </form>
            </div> -->
          </div>
          <div class="col-lg-4 offset-lg-4">
            <div class="proceed-checkout">
              <ul>
                <li class="subtotal">Subtotal <span>Rp. <span id="sub_total"></span></span>
                  <input type="hidden" name="sub_total_val" id="sub_total_val" readonly>
                </li>

                <li class="cart-total">Total <span>Rp. <span id="total"></span></span>
                  <input type="hidden" name="total_val" id="total_val" readonly>
                </li>
              </ul>
              <a href="<?php echo base_url(); ?>check-out" class="proceed-btn">PROCEED TO CHECK OUT</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Shopping Cart Section End -->

<!-- <script>
  showDetailCart();

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function showDetailCart() {
    var base_url = '<?php echo base_url() ?>';
    $.ajax({
      url: '<?php echo base_url(); ?>get-detail-shopping-cart',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {

        // $('#qty_val').val(data.qty);
        // $('.quantity #pro-qty').addClass('pro-qty');
        $('#show-detail-shopping-cart').html(data.html);

        subAmount();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: 'error',
          title: textStatus,
          showConfirmButton: false,
          timer: 1500
        })
      }
    });
  }

  function getTotal(row = null) {
    if (row) {
      var total = Number($("#price_val_" + row).val()) * Number($("#qty_val_" + row).val());
      // total = total.toFixed();

      $("#amount_" + row).text(total);
      $("#amount_val_" + row).val(total);

      subAmount();

    } else {
      Swal.fire({
        icon: 'error',
        title: 'No row, please refresh the page!',
        showConfirmButton: false,
        timer: 1500
      })
    }
  }

  function subAmount() {
    var table_cart_length = $('#cart_table tbody tr').length;
    var total_sub_amount = 0;

    for (var i = 0; i < table_cart_length; i++) {
      var tr = $('#cart_table tbody tr')[i];
      var count = $(tr).attr('id');
      count = count.substring(4);

      total_sub_amount += Number($("#amount_val_" + count).val());
    }

    total_sub_amount = total_sub_amount.toFixed();

    // sub total
    $('#sub_total').text(total_sub_amount);
    $('#sub_total_val').val(total_sub_amount);

    //total amount JIKA ADA COUPONT TARUH INPUT HIDDEN DIBAWAH FIELD COUPONT BERISIKAN VALUE DISCOUNT
    $('#total').text(total_sub_amount);
    $('#total_val').val(total_sub_amount);
  }
</script> -->