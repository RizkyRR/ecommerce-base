<!-- Product Shop Section Begin -->
<section class="product-shop spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 order-1 order-lg-2">
        <div class="product-show-option">
          <div class="row">
            <div class="col-lg-7 col-md-7">

              <div class="select-option">

                <form class="sorting-form" action="" method="POST" enctype="multipart/form-data">

                  <select class="sorting" name="input_sort" id="input_sort">
                    <option value="created_at">Date</option>
                    <option value="price">Price</option>
                    <option value="">Rating</option>
                  </select>
                  <button type="submit" class="primary-btn" style="height: 40px;"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i></button>

                </form>

              </div>

            </div>
            <div class="col-lg-5 col-md-5 text-right">
              <p>Show Product</p>
            </div>
          </div>
        </div>
        <div class="product-list">
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

          <div class="row" id="show-load-data">

          </div>
        </div>

        <!-- show pagination -->
        <div id="pagination"></div>

      </div>
    </div>
  </div>
</section>
<!-- Product Shop Section End -->

<script>
  $(document).ready(function() {
    // Detect pagination click
    $('#pagination').on('click', 'a', function(e) {
      e.preventDefault();
      var pageno = $(this).attr('data-ci-pagination-page');
      loadPagination(pageno);
    });

    loadPagination(0);

    // Load pagination
    function loadPagination(pagno) {
      $.ajax({
        url: '<?= base_url() ?>product_shop/getLoadAllRecordProduct/' + pagno,
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          $('#pagination').html(data.pagination);
          getLoadProducts(data.html, data.row);
        }
      });
    }

    // show load product 
    function getLoadProducts(result, no) {
      no = Number(no);

      $('#show-load-data').html(result);
    }

    // FOR WISHLIST 
    /* $('#set-shopping-wishlist').on('click', function(e) {
      var linkData = $(this).data('data');

      $.ajax({
        url: '<?php echo base_url() ?>product_shop/setWishlistInfo',
        data: {
          product_id: linkData
        },
        type: 'POST',
        dataType: 'JSON',
        success: function(data) {
          if (data.status == 'auth') {
            Swal.fire({
              title: data.message,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, sign in!'
            }).then((result) => {
              if (result.value) {
                location.href = '<?php echo base_url(); ?>sign-in';
              }
            })
          } else {
            if (data.status == 'delete') {
              $('a[data-data="' + linkData + '"] > i.whishstate').css({
                "color": "red"
              })
            } else {
              $('a[data-data="' + linkData + '"] > i.whishstate').css({
                "color": "red"
              })
            }
          }
        }
      });
    }) */

  })

  function setShoppingWishlist(id) {
    var linkData = $('#set-shopping-wishlist').data('data');

    $.ajax({
      url: '<?php echo base_url() ?>product_shop/setWishlistInfo',
      data: {
        product_id: id
      },
      type: 'POST',
      dataType: 'JSON',
      success: function(data) {
        if (data.status == 'auth') {
          Swal.fire({
            title: data.message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, sign in!'
          }).then((result) => {
            if (result.value) {
              location.href = '<?php echo base_url(); ?>sign-in';
            }
          })
        } else {
          if (data.status == 'delete') {
            $('a[data-data="' + linkData + '"] > i.whishstate').removeClass('fa fa-heart');
            $('a[data-data="' + linkData + '"] > i.whishstate').addClass('fa fa-heart-o');
          } else {
            $('a[data-data="' + linkData + '"] > i.whishstate').removeClass('fa fa-heart-o');
            $('a[data-data="' + linkData + '"] > i.whishstate').addClass('fa fa-heart');
          }
        }
      }
    });
  }
</script>