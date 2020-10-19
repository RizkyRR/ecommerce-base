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