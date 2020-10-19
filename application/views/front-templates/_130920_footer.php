<!-- Footer Section Begin -->
<footer class="footer-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="footer-left">
          <div class="footer-logo">
            <a href="<?php echo base_url(); ?>">
              <img src="<?php echo base_url(); ?>front-assets/img/Untitled-3.png" alt="">
            </a>
          </div>
          <ul>
            <li>Address: <?php echo $company['address'] ?></li>
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
<script>
  $(document).ready(function() {
    function effect_msg() {
      // $('.msg-alert').hide();
      $(".msg-alert").show(500);
      setTimeout(function() {
        $(".msg-alert").slideUp(500);
      }, 5000);
    }

    showCategoryData();

    function showCategoryData() {
      $.ajax({
        type: "GET",
        url: '<?php echo base_url(); ?>' + "get-data-category",
        dataType: "JSON",
        success: function(data) {
          var category =
            '<li><a href="' +
            '<?php echo base_url(); ?>' +
            'product-section">All Product</a></li>';
          var i;

          for (i = 0; i < data.length; i++) {
            category +=
              '<li><a href="' +
              '<?php echo base_url(); ?>' +
              "product-section-category/" +
              data[i].category_name +
              '">' +
              data[i].category_name +
              "</a></li>";
          }

          $("#show-data-category").html(category);
        },
      });
    }

    $(".depart-hover").on("shown.bs.tab", function(e) {
      $(".active").attr("data-value");
    });

    $("li#cart-icon").removeClass("active");
  });

  showShoppingCart();
  showDetailCart();
  getCheckOutBilling();
  getCheckOutOrder();

  function setShoppingCart(id) {
    var qty = 1;
    $.ajax({
      url: '<?php echo base_url(); ?>' + "set-shopping-cart/" + id,
      type: "POST",
      data: {
        qty: qty,
      },
      dataType: "JSON",
      success: function(data) {
        if (data.auth_status == true) {
          Swal.fire({
            title: "Sorry, you need to sign in!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, sign in!",
          }).then((result) => {
            if (result.value) {
              location.href = '<?php echo base_url(); ?>' + "sign-in";
            }
          });
        } else {
          if (data.insert_status == true) {
            Swal.fire({
              icon: "success",
              title: "Successfully added to your shopping cart!",
              showConfirmButton: false,
              timer: 1500,
            });
          }

          if (data.update_status == true) {
            Swal.fire({
              icon: "success",
              title: "Successfully updated from your shopping cart!",
              showConfirmButton: false,
              timer: 1500,
            });
          }

          showShoppingCart();
        }
      },
    });
  }

  function showShoppingCart() {
    $.ajax({
      url: '<?php echo base_url(); ?>' + "get-shopping-cart",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        if (data.count_rows > 0) {
          $(".cart-hover").show();
        } else {
          $(".cart-hover").hide();
        }

        $("#show_count_cart").html(data.count_rows);

        $("#show_shopping_cart").html(data.shopping_cart);
        $("#total-cart").html("<h5>" + data.price + "</h5>");
        $(".cart-price").html(data.price);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: textStatus,
          showConfirmButton: false,
          timer: 1500,
        });
      },
    });
  }

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function showDetailCart() {


    $.ajax({
      url: '<?php echo base_url(); ?>' + "get-detail-shopping-cart",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        // $('#qty_val').val(data.qty);
        // $('.quantity #pro-qty').addClass('pro-qty');
        $("#show-detail-shopping-cart").html(data.html);

        subAmount();
      },
      /* ,
            error: function(jqXHR, textStatus, errorThrown) {
              Swal.fire({
                icon: 'error',
                title: 'Show detail cart error!',
                showConfirmButton: false,
                timer: 1500
              })
            } */
    });
  }

  function getTotal(row = null) {


    if (row) {
      var total =
        Number($("#price_val_" + row).val()) * Number($("#qty_val_" + row).val());
      // total = total.toFixed();

      $("#amount_" + row).text(total);
      $("#amount_val_" + row).val(total);

      subAmount();

      $.ajax({
        url: '<?php echo base_url(); ?>' + "update-cart",
        data: {
          product_id: $("#id_product_" + row).val(),
          qty: $("#qty_val_" + row).val(),
          amount: $("#amount_val_" + row).val(),
        },
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == true) {
            showShoppingCart();
          } else {
            Swal.fire({
              icon: "error",
              title: "Quantity is required and, must be more than 0!",
              showConfirmButton: false,
              timer: 2000,
            });
          }
        },
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "No row, please refresh the page!",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  }

  function subAmount() {
    var table_cart_length = $("#cart_table tbody tr").length;
    var total_sub_amount = 0;

    for (var i = 0; i < table_cart_length; i++) {
      var tr = $("#cart_table tbody tr")[i];
      var count = $(tr).attr("id");

      if (count != null) {
        count = count.substring(4);
      }

      total_sub_amount += Number($("#amount_val_" + count).val());
    }

    total_sub_amount = total_sub_amount.toFixed();

    if (total_sub_amount > 0) {
      // sub total
      $("#sub_total").text(total_sub_amount);
      $("#sub_total_val").val(total_sub_amount);

      //total amount JIKA ADA COUPONT TARUH INPUT HIDDEN DIBAWAH FIELD COUPONT BERISIKAN VALUE DISCOUNT
      $("#total").text(total_sub_amount);
      $("#total_val").val(total_sub_amount);
    } else {
      // sub total
      $("#sub_total").text(0);
      $("#sub_total_val").val(0);

      //total amount JIKA ADA COUPONT TARUH INPUT HIDDEN DIBAWAH FIELD COUPONT BERISIKAN VALUE DISCOUNT
      $("#total").text(0);
      $("#total_val").val(0);
    }
  }

  function removeRow(tr_id) {
    $("#cart_table tbody tr #row_" + tr_id).remove();
    subAmount();
  }

  // CHECK OUT
  function getCheckOutBilling() {


    $.ajax({
      url: '<?php echo base_url(); ?>' + "get-check-out-billing",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $("#name").val(data.customer_name).prop("readonly", true);
        $("#province").val(data.provinsi_nama).prop("readonly", true);
        $("#cityregency").val(data.kabupaten_nama).prop("readonly", true);
        $("#district").val(data.kecamatan_nama).prop("readonly", true);
        $("#subdistrict").val(data.kelurahan_nama).prop("readonly", true);
        $("#street").val(data.street_name).prop("readonly", true);
        $("#email").val(data.email).prop("readonly", true);
        $("#phone").val(data.customer_phone).prop("readonly", true);
      },
    });
  }

  function getCheckOutOrder() {


    $.ajax({
      url: '<?php echo base_url(); ?>' + "get-check-out-order",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $("#show-check-out-data").html(data.html);
        $("#check-out-subtotal").html(data.cart_total);
        $("#check-out-total").html(data.cart_total);
      },
    });
  }

  // FOR DETAIL PRODUCT CART
  function setDetailButtonCart() {
    var qty = $("#number_qty").val();
    var qty_val = $("#number_qty_val").val();
    var product_id = $("#product_id").val();
    var variant_id = $("#select_variant").val();

    if (qty != 0) {
      $.ajax({
        url: "<?php echo base_url(); ?>set-detail-shopping-cart",
        data: {
          qty: qty_val,
          product_id: product_id,
        },
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == "auth") {
            Swal.fire({
              title: "Sorry, you need to sign in!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, sign in!",
            }).then((result) => {
              if (result.value) {
                location.href = "<?php echo base_url(); ?>sign-in";
              }
            });
          } else {
            if (data.status == "insert") {
              Swal.fire({
                icon: "success",
                title: "Successfully added to your shopping cart!",
                showConfirmButton: false,
                timer: 1500,
              });
            } else if (data.status == "update") {
              Swal.fire({
                icon: "success",
                title: "Successfully updated to your shopping cart!",
                showConfirmButton: false,
                timer: 1500,
              });
            }

            showShoppingCart();
          }
        },
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Quantity is required and, must be more than 0!",
        showConfirmButton: false,
        timer: 2000,
      });
    }
  }

  // MILIK SEMUA
  function deleteShoppingCart(id) {


    $.ajax({
      url: '<?php echo base_url(); ?>' + "delete-shopping-cart/" + id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.auth_status == true) {
          Swal.fire({
            title: "Sorry, you need to sign in!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, sign in!",
          }).then((result) => {
            if (result.value) {
              location.href = '<?php echo base_url(); ?>' + "sign-in";
            }
          });
        } else {
          if (data.status == true) {
            Swal.fire({
              icon: "success",
              title: "Successfully deleted to your shopping cart!",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Unsuccessfully deleted to your shopping cart, please try again!",
              showConfirmButton: false,
              timer: 1500,
            });
          }

          showShoppingCart();
          showDetailCart();
          getCheckOutOrder();
        }
      },
    });
  }
</script>

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