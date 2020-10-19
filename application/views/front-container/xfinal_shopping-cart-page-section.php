<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="cart-table">
          <table>
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
              <a href="#" class="primary-btn continue-shop">Continue shopping</a>
              <a href="#" class="primary-btn up-cart">Update cart</a>
            </div>
            <div class="discount-coupon">
              <h6>Discount Codes</h6>
              <form action="#" class="coupon-form">
                <input type="text" placeholder="Enter your codes">
                <button type="submit" class="site-btn coupon-btn">Apply</button>
              </form>
            </div>
          </div>
          <div class="col-lg-4 offset-lg-4">
            <div class="proceed-checkout">
              <ul>
                <li class="subtotal">Subtotal <span>$240.00</span></li>
                <li class="cart-total">Total <span>$240.00</span></li>
              </ul>
              <a href="#" class="proceed-btn">PROCEED TO CHECK OUT</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Shopping Cart Section End -->

<script>
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
        var table = '';
        var i;

        // $('#image_container').html('<img class="img-responsive" src="' + '<?php echo base_url(); ?>image/product/' + '' + data.image + '" />');

        for (i = 0; i < data.length; i++) {
          table += '<tr>' +
            '<td class="cart-pic first-row"><img style="width: 170px; height: 170px" src="' + base_url + 'image/product/' + data[i].image + '" alt=""></td>' +
            '<td class="cart-title first-row">' +
            '<h5>' + data[i].product_name + '</h5>' +
            '</td>' +
            '<td class="p-price first-row" id="qty_val">' + data[i].price + '</td>' +
            '<td class="qua-col first-row">' +
            '<div class="quantity">' +
            '<div class="pro-qty">' +
            '<input type="text" id="qty_val" value="' + data[i].cart_qty + '" onkeyup="numberFormat(this); getTotal()">' +
            '<input type="hidden" id="qty_val_hide" value="' + data[i].cart_qty + '" readonly>' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td class="total-price first-row" id="amount_val">' + data[i].amount_price + '</td>' +
            '<td class="close-td first-row"><i class="ti-close"></i></td>' +
            '</tr>';
        }

        $('#show-detail-shopping-cart').html(table);

        // $('#qty_val').val(data.qty);
        // $('.quantity #pro-qty').addClass('pro-qty');
        // $('#show-detail-shopping-cart').html(data.html);
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

  function getTotal() {
    var get_qty = $('#qty_val').val();
    var get_price = $('#price_val').text();

    var total = Number(get_qty) * get_price;
    total.toFixed();

    Number($('#amount_val').text(total));
  }
</script>