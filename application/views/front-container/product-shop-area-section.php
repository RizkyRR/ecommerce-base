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
                  </select>
                  <button type="submit" class="primary-btn" style="height: 40px;"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i></button>

                </form>

              </div>

            </div>
            <div class="col-lg-5 col-md-5 text-right">
              <p>Show <?php echo $total_rows ?> Product</p>
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

            <?php if ($products != null) : ?>
              <?php foreach ($products as $val) : ?>

                <!-- Show load product -->
                <div class="col-lg-4 col-sm-6">
                  <div class="product-item">
                    <div class="pi-pic">
                      <img style="height: 404px; width: 360px;" src="<?php echo base_url(); ?>image/product/<?php echo $val['image'] ?>" alt="" />

                      <?php if ($val['discount_charge_rate'] > 0) : ?>
                        <div class="sale">Sale-<?php echo $val['discount_charge_rate'] ?>%</div>
                      <?php endif; ?>

                      <!-- WISHLIST -->
                      <?php if ($wishlist != null) : ?>
                        <?php foreach ($wishlist as $w) : ?>
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

                      <!-- DETAIL AND CART BUTTON -->
                      <ul>
                        <!-- <li id="cart-icon" class="w-icon active">
                          <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart('<?php echo $val['id_product'] ?>')">

                            <i class="fa fa-cart-plus" aria-hidden="true"></i>

                          </a>
                        </li> -->

                        <li class="quick-view"><a href="<?php echo base_url(); ?>product-detail/<?php echo $val['id_product'] ?>">+ See Details</a></li>
                      </ul>


                    </div>
                    <!-- QUICK INFORMATION -->
                    <div class="pi-text">
                      <div class="catagory-name"><?php echo $val['category_name'] ?></div>
                      <a href="<?php echo base_url(); ?>product-detail/<?php echo $val['id_product'] ?>">
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
                <!-- End show load product -->

              <?php endforeach; ?>
            <?php else : ?>
              <h3>Sorry, data not found!</h3>
            <?php endif; ?>

          </div>
        </div>

        <?php echo $pagination; ?>

      </div>
    </div>
  </div>
</section>
<!-- Product Shop Section End -->