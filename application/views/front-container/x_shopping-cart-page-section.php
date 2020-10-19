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
            <tbody>

              <?php if ($carts != null) : ?>
                <?php $i = 1; ?>
                <?php foreach ($carts as $val) : ?>
                  <tr id="row_<?php echo $i; ?>">

                    <td class="cart-pic">
                      <img style="width: 170px; height: 170px" src="<?php echo base_url(); ?>image/product/<?php echo $val['image'] ?>" alt="" />
                      <input type="hidden" name="id_product[]" id="id_product_<?php echo $i; ?>" value="<?php echo $val['id_product'] ?>" readonly>
                    </td>

                    <td class="cart-title">
                      <h5><?php echo $val['product_name'] ?></h5>
                    </td>

                    <td class="p-price"><?php echo number_format($val['price'], 0, ',', '.') ?>
                      <input type="hidden" name="price_val[]" id="price_val_<?php echo $i; ?>" value="<?php echo $val['price'] ?>" readonly>
                    </td>

                    <td class="qua-col">
                      <div class="quantity">
                        <div class="pro-qty">
                          <input type="text" name="qty_val[]" id="qty_val_<?php echo $i; ?>" value="<?php echo $val['cart_qty'] ?>" onkeyup="numberFormat(this); getTotal(<?php echo $i; ?>)">
                        </div>
                      </div>
                    </td>

                    <td class="total-price"><?php echo number_format($val['amount_price'], 0, ',', '.') ?>
                      <input type="hidden" name="amount_val[]" id="amount_val_<?php echo $i; ?>" value="<?php echo $val['amount_price'] ?>" readonly>
                    </td>

                    <td class="close-td">
                      <i class="ti-close" onclick="deleteShoppingCart('<?php echo $val['id_cart'] ?>'); removeRow('<?php echo $i; ?>')"></i>
                    </td>

                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="10" style="text-align: center">Data not found !</td>
                </tr>
              <?php endif; ?>

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
                <input type="text" placeholder="Enter your codes" />
                <button type="submit" class="site-btn coupon-btn">
                  Apply
                </button>
              </form>
            </div>
          </div>
          <div class="col-lg-4 offset-lg-4">
            <div class="proceed-checkout">
              <ul>
                <li class="subtotal">Subtotal <span id="sub_total"></span>
                  <input type="hidden" name="sub_total_val" id="sub_total_val" readonly>
                </li>

                <li class="cart-total">Total <span id="total"></span>
                  <input type="hidden" name="total_val" id="total_val" readonly>
                </li>
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
  subAmount();

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
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
      console.log(tr);
      var count = $(tr).attr('id');
      console.log(count);
      count = count.substring(4);
      console.log(count);

      total_sub_amount += Number($("#amount_val_" + count).val());
      console.log(total_sub_amount);
    }

    total_sub_amount = total_sub_amount.toFixed();

    // sub total
    $('#sub_total').text(total_sub_amount);
    $('#sub_total_val').val(total_sub_amount);
  }
</script>