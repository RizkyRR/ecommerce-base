<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 order-1 order-lg-2">
        <div class="product-show-option">
          <div class="row">
            <div class="col-lg-12 col-md-5 text-right">
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
                      <img src="<?php echo base_url(); ?>image/product/<?php echo $val['image'] ?>" alt="" /> <!-- style="height: 404px; width: 360px;" -->

                      <?php if ($val['discount_charge_rate'] > 0) : ?>
                        <div class="sale pp-sale">Sale-<?php echo $val['discount_charge_rate'] ?>%</div>
                      <?php endif; ?>

                      <?php if ($wishlist != null) : ?>
                        <?php foreach ($wishlist as $w) : ?>
                          <?php if ($w['product_id'] == $val['id_product']) :  ?>
                            <div class="icon">
                              <a href="<?php echo base_url() ?>set-wishlist-customer/<?php echo $val['id_product'] ?>"><i class="fa fa-heart"></i></a>
                            </div>
                          <?php else : ?>
                            <div class="icon">
                              <a href="<?php echo base_url() ?>set-wishlist-customer/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                            </div>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <div class="icon">
                          <a href="<?php echo base_url() ?>set-wishlist-customer/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                        </div>
                      <?php endif; ?>

                      <ul>
                        <!-- <li id="cart-icon" class="w-icon active">
                          <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart('<?php echo $val['id_product'] ?>')">

                            <i class="fa fa-cart-plus" aria-hidden="true"></i>

                          </a>
                        </li> -->

                        <li class="quick-view"><a href="<?php echo base_url(); ?>product-detail/<?php echo $val['slug'] ?>">+ See Details</a></li>
                      </ul>
                    </div>
                    <div class="pi-text">
                      <div class="catagory-name"><?php echo $val['category_name'] ?></div>
                      <a href="<?php echo base_url(); ?>product-detail/<?php echo $val['slug'] ?>">
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
              <h3>Sorry, you have no wishlist!</h3>
            <?php endif; ?>

          </div>
        </div>

        <div class="mb-3">
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</section>