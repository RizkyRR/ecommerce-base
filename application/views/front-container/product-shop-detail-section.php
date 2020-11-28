<!-- Product Shop Section Begin -->
<section class="product-shop spad page-details">
  <div class="container">
    <div class="row">
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

    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-6">
            <div class="product-pic-zoom">

              <img class="product-big-img" src="<?php echo base_url(); ?>image/product/<?php echo $detail['image'] ?>" alt="">
              <div class="zoom-icon">
                <i class="fa fa-search-plus"></i>
              </div>

            </div>
            <div class="product-thumbs">
              <div class="product-thumbs-track ps-slider owl-carousel">

                <?php if ($images > 0) : ?>
                  <?php foreach ($images as $val) : ?>
                    <div class="pt active" data-imgbigurl="<?php echo base_url(); ?>image/product/<?php echo $val['product_image'] ?>"><img src="<?php echo base_url(); ?>image/product/<?php echo $val['product_image'] ?>" alt=""></div>
                  <?php endforeach; ?>
                <?php endif; ?>

              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="product-details">
              <div class="pd-title">
                <span><?php echo $detail['category_name'] ?></span>
                <h3><?php echo $detail['product_name'] ?></h3>

                <!-- Wishlist Status -->
                <?php if ($wishlist != null) : ?>
                  <?php foreach ($wishlist as $w) : ?>
                    <?php if ($w['product_id'] == $detail['id_product']) :  ?>
                      <a href="<?php echo base_url() ?>set-wishlist/<?php echo $detail['id_product'] ?>" class="heart-icon"><i class="fa fa-heart"></i></a>
                    <?php else : ?>
                      <a href="<?php echo base_url() ?>set-wishlist/<?php echo $detail['id_product'] ?>" class="heart-icon"><i class="fa fa-heart-o"></i></a>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php else : ?>
                  <a href="<?php echo base_url() ?>set-wishlist/<?php echo $detail['id_product'] ?>" class="heart-icon"><i class="fa fa-heart-o"></i></a>
                <?php endif; ?>
              </div>

              <!-- Products Rating -->
              <div class="pd-rating">
                <span><?php echo $avg_rating; ?></span>
                <?php echo $rating_comment; ?>
                <span>(<?php echo $get_count; ?>)</span>
              </div>

              <!-- Price Status -->
              <div class="pd-desc">
                <?php if ($detail['discount_charge_rate'] > 0) : ?>
                  <h4><?php echo "Rp. " . number_format($detail['price'], 0, ',', '.'); ?>
                    <span><?php echo "Rp. " . number_format($detail['before_discount'], 0, ',', '.'); ?>
                    </span></h4>
                <?php else : ?>
                  <h4><?php echo "Rp. " . number_format($detail['price'], 0, ',', '.'); ?></h4>
                <?php endif; ?>
              </div>

              <!-- Data Variant -->
              <ul class="pd-tags">
                <li><span>AVAILABLE STOCK</span>: <span class="info-available-stock"></span>
                </li>
              </ul>

              <!-- Button  -->
              <div class="quantity">
                <input type="number" style="width: 123px; height: 46px; border: 2px solid #ebebeb;padding: 0 15px; float: left; margin-right: 14px; font-size: 24px;" name="number_qty" id="number_qty" value="1" onkeyup="numberFormat(this)" onkeypress="getCurrentValueQty(); getValidateQty()" onchange="getCurrentValueQty(); getValidateQty()">

                <input type="hidden" name="number_qty_val" id="number_qty_val" readonly>

                <input type="hidden" name="product_id" id="product_id" value="<?php echo $detail['id_product'] ?>" readonly>
                <input type="hidden" name="product_price" id="product_price" value="<?php echo $detail['price'] ?>" readonly>

                <a href="javascript:void(0)" class="primary-btn pd-cart" id="btnCart" onclick="setDetailButtonCart()">Add To Cart</a>
              </div>

              <ul class="pd-tags">
                <li><span>Brand</span>: <?php echo $detail['brand_name'] ?></li>
              </ul>

              <div class="pd-share">
                <div class="pd-social">
                  <?php if ($detail_company > 0) : ?>
                    <?php foreach ($detail_company as $val) : ?>
                      <a href="<?php echo $val['url'] ?>" target="_blank"><i class="<?php echo $val['link_icon'] ?>"></i></a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="product-tab">
          <div class="tab-item">
            <ul class="nav" role="tablist">
              <li>
                <a class="active" data-toggle="tab" href="#tab-1" role="tab">DESCRIPTION</a>
              </li>
              <li>
                <a data-toggle="tab" href="#tab-2" role="tab">Customer Review/s <span id="count-info"></span></a>
              </li>
            </ul>
          </div>

          <div class="tab-item-content">
            <div class="tab-content">
              <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                <div class="product-content">
                  <div class="row">
                    <div class="col-lg-12">

                      <p><?php echo $detail['description'] ?></p>

                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="tab-2" role="tabpanel">
                <div class="customer-review-option">

                  <!-- show count comment -->
                  <h4>
                    <span id="count-comment"></span> Review/s
                  </h4>

                  <div id="comment-review" style="display: none;" class="mb-3">
                    <div class="personal-rating">
                      <h4>Your Rating</h4>
                      <div id="rateYo" data-rateyo-star-width="25px" data-rateyo-full-star="true" data-rateyo-rating="4"></div>
                      <input type="hidden" name="rate_val" id="rate_val" readonly>
                      <input type="hidden" name="id_comment" id="id_comment">
                    </div>

                    <div class="leave-comment">
                      <h4>Leave A Review</h4>

                      <form action="" method="POST" id="form-comment" enctype="multipart/form-data" class="comment-form">
                        <div class="row">
                          <div class="col-lg-12">
                            <textarea name="message" id="message" placeholder="Write your review for this product" required></textarea>

                            <span>File size: <span>Maximum 1 Megabytes</span></span>
                            <br>
                            <span>Number of files: <span>Maximum 5 images</span></span>
                            <br>
                            <span>Extensions allowed: <span>JPG, JPEG, GIF, PNG</span></span>
                            <div class="dropzone mt-1 mb-3">
                              <div class="dz-message">
                                <h4> Attach file in here</h4>
                              </div>
                            </div>

                            <button type="submit" id="btnSend" class="site-btn">Send review</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- show comment -->
                  <div class="comment-option" id="show-comment-option"></div>

                  <!-- show pagination -->
                  <div id="pagination"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Product Shop Section End -->

<!-- Related Products Section End -->
<div class="related-products spad">
  <div class="container">
    <?php if ($relatedProducts != null) : ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Related Products</h2>
          </div>
        </div>
      </div>

      <div class="row">
        <?php foreach ($relatedProducts as $val) : ?>
          <div class="col-lg-3 col-sm-6">
            <div class="product-item">
              <div class="pi-pic">
                <img src="<?php echo base_url() ?>image/product/<?php echo $val['image'] ?>" alt="" />

                <?php if ($val['discount_charge_rate'] > 0) : ?>
                  <div class="sale pp-sale">Sale-<?php echo $val['discount_charge_rate'] ?>%</div>
                <?php endif; ?>

                <?php if ($relatedWishlist != null) : ?>
                  <?php foreach ($relatedWishlist as $w) : ?>
                    <?php if ($w['product_id'] == $val['id_product']) :  ?>
                      <div class="icon">
                        <a href="<?php echo base_url() ?>set-wishlist/<?php echo $val['id_product'] ?>"><i class="fa fa-heart"></i></a>
                      </div>
                    <?php else : ?>
                      <div class="icon">
                        <a href="<?php echo base_url() ?>set-wishlist/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                      </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php else : ?>
                  <div class="icon">
                    <a href="<?php echo base_url() ?>set-wishlist/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                  </div>
                <?php endif; ?>

                <ul>
                  <!-- <li id="cart-icon" class="w-icon active">
                    <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart(\'' . $val['id_product'] . '\')">

                      <i class="fa fa-cart-plus" aria-hidden="true"></i>

                    </a>
                  </li> -->

                  <li class="quick-view"><a href="<?php echo base_url() ?>product-detail/<?php echo $val['slug'] ?>">+ See Details</a></li>
                </ul>
              </div>

              <div class="pi-text">
                <div class="catagory-name"><?php echo $val['category_name'] ?></div>

                <a href="<?php echo base_url() ?>product-detail/<?php echo $val['slug'] ?>">
                  <h5><?php echo $val['product_name'] ?></h5>
                </a>

                <div class="product-price">
                  <?php if ($val['discount_charge_rate'] > 0) : ?>
                    <?php echo "Rp. " . number_format($val['price'], 0, ',', '.'); ?>
                    <span><?php echo "Rp. " . number_format($val['before_discount'], 0, ',', '.'); ?>
                    </span>
                  <?php else : ?>
                    <?php echo "Rp. " . number_format($val['price'], 0, ',', '.'); ?>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>
</div>
<!-- Related Products Section End -->

<script>
  loadPagination(0);
  create_code();
  // showRelatedProducts();
  checkCustomerComment();
  showAvailableStock();

  $('.info-available-stock').html(0);

  function showAvailableStock() {
    var id_product = $('#product_id').val();

    // DO AJAX FOR GET DINAMICALLY STOCK
    $.ajax({
      url: '<?= base_url() ?>get-available-stock-product',
      data: {
        product_id: id_product
      },
      type: 'POST',
      dataType: 'JSON',
      success: function(data) {
        $('.info-available-stock').html(data.qty);
      }
    });
  }

  // number qty
  $("#number_qty").attr({
    "min": 1 // values (or variables) here
  });

  $("#number_qty_val").val(1);

  // set default message and its button
  // $('#message').prop('disabled', true);

  // rating star
  var ratingYo = $('#rateYo').data('rateyo-rating');
  $('#rate_val').val(ratingYo);

  $("#rateYo").rateYo()
    .on("rateyo.change", function(e, data) {

      var rating = data.rating;
      $('#rate_val').val(rating);
    });

  // show comment 
  // Detect pagination click
  $('#pagination').on('click', 'a', function(e) {
    e.preventDefault();
    var pageno = $(this).attr('data-ci-pagination-page');
    loadPagination(pageno);
  });

  // Load pagination
  function loadPagination(pageno) {
    var id = $('#product_id').val();

    $.ajax({
      url: '<?= base_url() ?>get-load-comment/' + pageno,
      data: {
        product_id: id
      },
      type: 'POST',
      dataType: 'JSON',
      success: function(data) {
        $('#pagination').html(data.pagination);

        getLoadComments(data.html, data.row, data.count_row_comment);
      }
    });
  }

  // show load product 
  function getLoadComments(result, no, row_comment) {
    no = Number(no);

    $('#count-info').text(row_comment)
    $('#count-comment').text(row_comment);
    $('#show-comment-option').html(result);
  }

  $.validator.setDefaults({
    highlight: function(element) {
      $(element).closest(".comment-form").addClass("has-error");
    },
    unhighlight: function(element) {
      $(element).closest(".comment-form").removeClass("has-error");
    },
    errorElement: "span",
    errorClass: "error-message",
    errorPlacement: function(error, element) {
      if (element.parent(".input-group").length) {
        error.insertBefore(element.parent()).css("color", "red");
      } else {
        error.insertBefore(element).css("color", "red");
      }

      Swal.fire({
        icon: "error",
        title: error,
        showConfirmButton: false,
        timer: 5000,
      });
    },
  });

  var $validator = $("#form-comment").validate({
    rules: {
      message: {
        required: true,
        minlength: 20
      },
    },
    messages: {
      message: {
        required: "Review message is required!",
        minlength: "Minimum of 20 characters"
      },
    },
  });

  // btnSend
  $("#btnSend").click(function() {
    // e.preventDefault();
    $("#btnSend").text("Sending..."); //change button text
    $("#btnSend").attr("disabled", true); //set button disable

    var $valid = $("#form-comment").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnSend").text("Send message"); //change button text
      $("#btnSend").attr("disabled", false); //set button enable
      return false;
    } else {
      $.ajax({
        url: '<?php echo base_url() ?>insert-comment-review',
        type: 'POST',
        dataType: 'JSON',
        data: {
          product_id: $('#product_id').val(),
          rate: $('#rate_val').val(),
          comment_id: $('#id_comment').val(),
          message: $('#message').val()
        },
        success: function() {
          $('#form-comment')[0].reset();
          var ratingYo = $('#rateYo').data('rateyo-rating');
          $("#rateYo").rateYo("option", "rating", ratingYo); //returns a jQuery Element
          $('#rate_val').val(ratingYo);


          create_code();

          Swal.fire({
            icon: "success",
            title: "Successfully sending your comment!",
            showConfirmButton: false,
            timer: 5000,
          });

          checkCustomerComment();
          loadPagination(0);

          $("#btnSend").text("Send message"); //change button text
          $("#btnSend").attr("disabled", false); //set button enable
        }
      })
    }
  })

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('get-comment-code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id_comment').val(data).prop("readonly", true);
      }
    })
  }

  // CHECK AND GET QTY PRODUCT
  function getCurrentValueQty() {
    var qty = $('#number_qty').val();
    $('#number_qty_val').val(qty);
  }

  function getValidateQty() {
    var qty_val = $('#number_qty_val').val();
    if (qty_val != 0) {
      $.ajax({
        url: '<?php echo base_url() ?>get-check-qty-product',
        data: {
          product_id: $('#product_id').val(),
          qty: qty_val
        },
        type: 'POST',
        dataType: 'JSON',
        success: function(data) {
          if (data.status == 'true') {
            console.log(true);
          } else {
            Swal.fire({
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 5000,
            });

            $('#number_qty').val(1);
            $('#number_qty_val').val(1);
          }
        }
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Sorry, for the minimum purchase is 1!",
        showConfirmButton: false,
        timer: 5000,
      });

      $('#number_qty').val(1);
      $('#number_qty_val').val(1);
    }
  }

  function checkCustomerComment() {
    $.ajax({
      url: '<?php echo base_url() ?>check-comment-customer',
      type: 'POST',
      data: {
        product_id: $('#product_id').val()
      },
      dataType: 'JSON',
      success: function(data) {
        if (data.status == true) {
          $('#comment-review').show();
        } else {
          $('#comment-review').hide();
        }
      }
    });
  }

  // IMAGE BY DROPZONE
  Dropzone.autoDiscover = false;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>insert-comment-image",
    autoProcessQueue: false,
    parallelUploads: 10,
    maxFilesize: 1,
    maxFiles: 5,
    method: "post",
    acceptedFiles: "image/*", // application/pdf,.psd
    paramName: "image",
    dictInvalidFileType: "This file type is not allowed",
    addRemoveLinks: true,
    success: function(file, response) {
      console.log(response);
    }
  });

  $('#btnSend').click(function() {
    $('#btnSend').text('Sending...'); //change button text
    $('#btnSend').attr('disabled', true); //set button disable 

    var $valid = $("#form-comment").valid();

    if (!$valid) {
      $("#btnSend").text("Sending Message"); //change button text
      $("#btnSend").attr("disabled", false); //set button enable
      return false;
    } else {
      foto_upload.processQueue();
      $('#btnSend').text('Sending Message'); //change button text
      $('#btnSend').attr('disabled', false); //set button enable 
    }
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", $('#id_comment').val());

    var th = this;
    setTimeout(function() {
      th.removeAllFiles();
    }, 5000);
  });

  function delete_comment(id) {
    Swal.fire({
      icon: 'warning',
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?php echo base_url() ?>delete-comment-review/' + id,
          type: 'POST',
          dataType: 'JSON',
          success: function(data) {
            if (data.status == true) {
              Swal.fire({
                icon: "success",
                title: "Successfully deleted your review!",
                showConfirmButton: false,
                timer: 5000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Failed deleted your review, please try again!",
                showConfirmButton: false,
                timer: 5000,
              });
            }

            checkCustomerComment();
            loadPagination(0);
          }
        });
      }
    });
  }
</script>