<!-- Product Shop Section Begin -->
<section class="product-shop spad page-details">
  <div class="container">
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
              <div class="pd-size-choose">
                <?php if ($variant != null) : ?>
                  <?php $i = 0; ?>
                  <?php foreach ($variant as $val) : ?>
                    <?php $i++; ?>
                    <div class="sc-item item-variant-<?php echo $i; ?>" onclick="changeVariant(<?php echo $i; ?>)">
                      <input type="radio" id="id_variant_<?php echo $i; ?>" name="id_variant_<?php echo $i; ?>" value="<?php echo $val['id_variant'] ?>">
                      <label for="size-<?php echo $val['id_variant'] ?>"><?php echo $val['variant_name'] ?></label>
                    </div>
                  <?php endforeach; ?>
                  <input type="hidden" name="select_variant" id="select_variant" readonly>
                <?php endif; ?>
              </div>

              <!-- Button  -->
              <div class="quantity">
                <input type="number" style="width: 123px; height: 46px; border: 2px solid #ebebeb;padding: 0 15px; float: left; margin-right: 14px; font-size: 24px;" name="number_qty" id="number_qty" value="1" onkeyup="numberFormat(this)" onkeypress="getCurrentValueQty(); getValidateQty()" onchange="getCurrentValueQty(); getValidateQty()">

                <input type="hidden" name="number_qty_val" id="number_qty_val" readonly>

                <input type="hidden" name="product_id" id="product_id" value="<?php echo $detail['id_product'] ?>" readonly>
                <input type="hidden" name="product_price" id="product_price" value="<?php echo $detail['price'] ?>" readonly>

                <a href="javascript:void(0)" class="primary-btn pd-cart" id="btnCart" onclick="setDetailButtonCart()">Add To Cart</a>
              </div>

              <ul class="pd-tags">
                <li><span>CATEGORIES</span>: <?php echo $detail['category_name'] ?></li>
              </ul>

              <div class="pd-share">
                <div class="p-code">Sku : 00012</div>
                <div class="pd-social">
                  <a href="#"><i class="ti-facebook"></i></a>
                  <a href="#"><i class="ti-twitter-alt"></i></a>
                  <a href="#"><i class="ti-linkedin"></i></a>
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
                <a data-toggle="tab" href="#tab-2" role="tab">Customer Reviews <span id="count-info"></span></a>
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
                    <span id="count-comment"></span> Comment
                  </h4>

                  <div id="comment-review" style="display: none;" class="mb-3">
                    <div class="personal-rating">
                      <h4>Your Rating</h4>
                      <div id="rateYo" data-rateyo-star-width="25px" data-rateyo-full-star="true" data-rateyo-rating="4"></div>
                      <input type="hidden" name="rate_val" id="rate_val" readonly>
                      <input type="hidden" name="id_comment" id="id_comment">
                    </div>

                    <div class="leave-comment">
                      <h4>Leave A Comment</h4>

                      <form action="" method="POST" id="form-comment" enctype="multipart/form-data" class="comment-form">
                        <div class="row">
                          <div class="col-lg-12">
                            <textarea name="message" id="message" placeholder="Messages" required></textarea>

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

                            <button type="submit" id="btnSend" class="site-btn">Send message</button>
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
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title">
          <h2>Related Products</h2>
        </div>
      </div>
    </div>

    <div class="row" id="show-related-product"></div>

  </div>
</div>
</div>
<!-- Related Products Section End -->

<script>
  loadPagination(0);
  create_code();
  showRelatedProducts();
  checkCustomerLogin();

  function changeVariant(row) {
    // var id_variant = $('input:radio[name="id_variant_"' + row + ']').val();
    var id_variant = $('#id_variant_' + row).val();
    console.log(id_variant);

    $('#select_variant').val(id_variant);
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
        timer: 2000,
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
        required: "Comment message is required!",
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
          /* if (data.status == true) {
            Swal.fire({
              icon: "success",
              title: "Successfully sending your comment!",
              showConfirmButton: false,
              timer: 2000,
            });

            loadPagination(0);
          } else {
            Swal.fire({
              icon: "error",
              title: "Failed to sending your comment, please try again!",
              showConfirmButton: false,
              timer: 2000,
            });
          } */
          $('#form-comment')[0].reset();
          var ratingYo = $('#rateYo').data('rateyo-rating');
          $("#rateYo").rateYo("option", "rating", ratingYo); //returns a jQuery Element
          $('#rate_val').val(ratingYo);

          // $('.dz-preview').remove();
          // Dropzone.forElement('.dropzone').removeAllFiles(true);
          /* $('.dropzone')[0].dropzone.files.forEach(function(file) {
            file.previewElement.remove();
          });
          $('.dropzone').removeClass('dz-started'); */

          create_code();

          Swal.fire({
            icon: "success",
            title: "Successfully sending your comment!",
            showConfirmButton: false,
            timer: 2000,
          });

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
    var variant_id = $("#select_variant").val();
    if (variant_id != 0) {
      $.ajax({
        url: '<?php echo base_url() ?>get-check-qty-product',
        data: {
          product_id: $('#product_id').val(),
          variant_id: $("#select_variant").val(),
          qty: $('#number_qty_val').val()
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
              timer: 2000,
            });

            $('#number_qty').val(1);
            $('#number_qty_val').val(1);
          }
        }
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "Please select 1 variant!",
        showConfirmButton: false,
        timer: 2000,
      });

      $('#number_qty').val(1);
      $('#number_qty_val').val(1);
    }
  }

  function showRelatedProducts() {
    var id = $('#product_id').val();

    $.ajax({
      url: '<?php echo base_url() ?>get-related-product',
      type: 'POST',
      data: {
        product_id: id
      },
      dataType: 'JSON',
      success: function(data) {
        $('#show-related-product').html(data.html);
      }
    })
  }

  function setShoppingWishlist(id_row) {
    if (id_row) {
      $.ajax({
        url: '<?php echo base_url() ?>' + "set-shopping-wishlist",
        data: {
          product_id: id_row
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
                location.href = '<?php echo base_url() ?>' + "sign-in";
              }
            });
          } else {
            if (data.status == "insert") {
              $('#wishstate-' + id_row).removeClass('fa fa-heart-o');
              $('#wishstate-' + id_row).addClass('fa fa-heart');

              showRelatedProducts();
            } else {
              $('#wishstate-' + id_row).removeClass('fa fa-heart');
              $('#wishstate-' + id_row).addClass('fa fa-heart-o');

              showRelatedProducts();
            }
          }
        },
      });
    } else {
      Swal.fire({
        icon: "error",
        title: "No row, please refresh the page!",
        showConfirmButton: false,
        timer: 2000,
      });
    }
  }

  function checkCustomerLogin() {
    $.ajax({
      url: '<?php echo base_url() ?>check-comment-auth',
      type: 'GET',
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
    /* init: function() {
      var th = this;
      this.on('queuecomplete', function() {
        setTimeout(function() {
          th.removeAllFiles();
        }, 5000);
      })
    }, */
    success: function(file, response) {
      console.log(response);
    }
  });

  $('#btnSend').click(function() {
    foto_upload.processQueue();

    /* $('.dz-preview').remove();
    $('.dropzone').removeClass('dz-started'); */

    /* $('.dropzone')[0].dropzone.files.forEach(function(file) {
      file.previewTemplate.remove();
    });

    $('.dropzone').removeClass('dz-started'); */

    /* var myDropzone = Dropzone.forElement(".dropzone");
    myDropzone.removeAllFiles(true); */
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", $('#id_comment').val());

    var th = this;
    setTimeout(function() {
      th.removeAllFiles();
    }, 2000);
  });

  /* foto_upload.on("complete", function(file) {
    foto_upload.removeFile(file);
  }); */

  /* foto_upload.on("queuecomplete", function() {
    // this.removeAllFiles();
    $('.dz-preview').remove();
    $('.dropzone').removeClass('dz-started');
  }); */

  /* foto_upload.on("queuecomplete", function() {
    var th = this;
    setTimeout(function() {
      th.removeAllFiles();
    }, 2000);
  }); */

  //Event ketika foto dihapus
  /* foto_upload.on("removedfile", function(a) {
    var token = a.token;
    $.ajax({
      type: "POST",
      data: {
        token: token
      },
      url: "<?php echo base_url() ?>remove-comment-image",
      cache: false,
      dataType: 'JSON',
      success: function() {
        console.log("Foto terhapus");
      },
      error: function() {
        console.log("Error");
      }
    });
  }); */

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
                title: "Successfully deleted your comment!",
                showConfirmButton: false,
                timer: 2000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Failed deleted your comment, please try again!",
                showConfirmButton: false,
                timer: 2000,
              });
            }

            loadPagination(0);
          }
        });
      }
    });
  }
</script>