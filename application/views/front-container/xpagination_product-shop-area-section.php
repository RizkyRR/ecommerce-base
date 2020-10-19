<!-- Product Shop Section Begin -->
<section class="product-shop spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 order-1 order-lg-2">
        <div class="product-show-option">
          <div class="row">
            <div class="col-lg-7 col-md-7">

              <div class="select-option">

                <form class="sorting-form" action="<?php echo base_url(); ?>product_shop" method="POST" enctype="multipart/form-data">

                  <select class="sorting" name="input_sort" id="input_sort">
                    <option value="created_at">Date</option>
                    <option value="price">Price</option>
                    <option value="">Rating</option>
                  </select>
                  <button type="submit" class="primary-btn" style="height: 40px;"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i></button>

                </form>

              </div>

            </div>
            <!-- <div class="col-lg-5 col-md-5 text-right">
              <p>Show <?php echo $total_rows ?> Product</p>
            </div> -->
          </div>
        </div>
        <div class="product-list">
          <div class="row" id="show-load-data">

            <!-- Show Products -->

          </div>

          <!-- <div class="row" id="load-more"></div> -->
        </div>

        <div class="loading-more">
          <i class="icon_loading"></i>
          <a href="#" id="load-more" data-val="0">
            Loading More
          </a>
        </div>

      </div>
    </div>
  </div>
</section>
<!-- Product Shop Section End -->

<!-- <script>
  $(document).ready(function() {

    var limit = 9;
    var start = 6;
    var action = 'inactive';

    function lazzy_loader(limit) {
      var output = '';
      for (var count = 0; count < limit; count++) {
        output += '<div class="col-lg-4 col-sm-6">';
        output += '<div class="product-item">';
        output += '<div class="pi-pic">';
        output += '<img src="" alt="" />';
        output += '<div class="icon">';
        output += '<i class="icon_heart_alt"></i>';
        output += '</div>';
        output += '<ul>';
        output += '<li class="w-icon active">';
        output += '<a href="#"><i class="icon_bag_alt"></i></a>';
        output += '</li>';
        output += '<li class="quick-view"><a href="#">+ See Details</a></li>';
        output += '<li class="w-icon">';
        output += '</li>';
        output += '</ul>';
        output += '</div>';
        output += '<div class="pi-text">';
        output += '<div class="catagory-name"></div>';
        output += '<a href="#">';
        output += '<h5></h5>';
        output += '</a>';
        output += '<div class="product-price">';
        output += '</div>';
        output += '</div>';
        output += '</div>';
        output += '</div>';
      }
      $('#load-more').html(output);
    }

    lazzy_loader(limit);

    function load_data(limit, start) {
      $.ajax({
        url: "<?php echo base_url(); ?>product_shop/loadScrollDataProductShop",
        method: "GET", // try with POST
        data: {
          limit: limit,
          start: start
        },
        dataType: 'JSON',
        cache: false,
        success: function(data) {
          if (data.result == '') {
            $('#load-more').html('<h3>No More Result Found</h3>');
            action = 'active';
          } else {
            $('#show-load-data').html(data.result);
            $('#load-more').html("");
            action = 'inactive';
          }
        }
      })
    }

    if (action == 'inactive') {
      action = 'active';
      load_data(limit, start);
    }

    $(window).scroll(function() {
      if ($(window).scrollTop() + $(window).height() > $("#show-load-data").height() && action == 'inactive') {
        lazzy_loader(limit);
        action = 'active';
        start = start + limit;
        setTimeout(function() {
          load_data(limit, start);
        }, 1000);
      }
    });

  });
</script> -->

<script>
  $(document).ready(function() {
    product(1);

    $("#load-more").click(function(e) {
      e.preventDefault();
      var page = $(this).data('val');
      product(page);
    });
  });

  var url = '<?php echo base_url(); ?>';

  // https://www.webslesson.info/2018/08/codeigniter-load-more-data-on-page-scroll-using-ajax.html

  var product = function(page) {
    $(".icon_loading").show();
    $("#load-more").show();
    $.ajax({
      url: url + "product_shop/loadButtonDataProductShop",
      type: 'GET',
      data: {
        page: page
      },
      dataType: 'JSON'
    }).done(function(response) {
      $("#show-load-data").html(response.result);
      $(".icon_loading").hide();
      $('#load-more').data('val', ($('#load-more').data('val') + 1));
      //scroll();
      if (response == "") {
        $("#load-more").hide();
      } else {
        $("#load-more").show();
      }
    });
  };
</script>