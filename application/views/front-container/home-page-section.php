<!-- Hero Section Begin -->
<section class="hero-section">
  <div class="hero-items owl-carousel">

    <?php if ($store_banner > 0) : ?>

      <?php foreach ($store_banner as $val) : ?>
        <div class="single-hero-items set-bg" data-setbg="<?php echo base_url(); ?>image/gallery/<?php echo $val['image'] ?>">
          <div class="container">
            <div class="row">
              <div class="col-lg-5">
                <h1 style="color: #e7ab3c;"><?php echo $val['title'] ?></h1>

                <?php if ($val['button_link_title'] != "") : ?>
                  <p style="color: black;"><?php echo $val['sub_title'] ?></p>
                  <a href="<?php echo $val['button_link_url'] ?>" class="primary-btn"><?php echo $val['button_link_title'] ?></a>
                <?php else : ?>
                  <p style="color: black;"><?php echo $val['sub_title'] ?></p>
                <?php endif; ?>

              </div>
            </div>
            <!-- <div class="off-card">
              <h2>Sale <span>50%</span></h2>
            </div> -->
          </div>
        </div>
      <?php endforeach; ?>

    <?php endif; ?>

  </div>
</section>
<!-- Hero Section End -->

<section class="man-banner spad">
  <div class="container-fluid">
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
  </div>
</section>

<?php if ($discount_items > 0) : ?>
  <!-- Banner Section Begin -->
  <section class="man-banner spad">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Deal Products</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="product-slider owl-carousel">

            <?php foreach ($discount_items as $val) : ?>

              <div class="product-item">
                <div class="pi-pic">
                  <img src="<?php echo base_url(); ?>image/product/<?php echo $val['image'] ?>" alt=""> <!--  style="height: 404px; width: 360px;" -->

                  <div class="sale">Sale-<?php echo $val['discount_charge_rate'] ?>%</div>

                  <?php if ($wishlist != null) : ?>
                    <?php foreach ($wishlist as $w) : ?>
                      <?php if ($w['product_id'] == $val['id_product']) :  ?>
                        <div class="icon">
                          <a href="<?php echo base_url() ?>set-wishlist-home/<?php echo $val['id_product'] ?>"><i class="fa fa-heart"></i></a>
                        </div>
                      <?php else : ?>
                        <div class="icon">
                          <a href="<?php echo base_url() ?>set-wishlist-home/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <div class="icon">
                      <a href="<?php echo base_url() ?>set-wishlist-home/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                    </div>
                  <?php endif; ?>

                  <ul>
                    <!-- <li id="cart-icon" class="w-icon active">
                      <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart('<?php echo $val['id_product'] ?>')">

                        <i class="fa fa-cart-plus" aria-hidden="true"></i>

                      </a>
                    </li> -->

                    <li class="quick-view"><a href="<?php echo base_url(); ?>product-detail/<?php echo $val['id_product'] ?>">+ See Details</a></li>
                  </ul>
                </div>
                <div class="pi-text">
                  <div class="catagory-name"><?php echo $val['category_name'] ?></div>
                  <a href="<?php echo base_url(); ?>product-detail/<?php echo $val['id_product'] ?>">
                    <h5><?php echo $val['product_name'] ?></h5>
                  </a>
                  <div class="product-price">
                    <?php echo "Rp. " . number_format($val['price'], 0, ',', '.'); ?>
                    <span><?php echo "Rp. " . number_format($val['before_discount'], 0, ',', '.'); ?></span>
                  </div>
                </div>
              </div>

            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Banner Section End -->
<?php endif; ?>

<?php if ($hot_items > 0) : ?>
  <!-- Banner Section Begin -->
  <section class="man-banner spad">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Hot Products</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="product-slider owl-carousel">

            <?php foreach ($hot_items as $val) : ?>

              <div class="product-item">
                <div class="pi-pic">
                  <img src="<?php echo base_url(); ?>image/product/<?php echo $val['image'] ?>" alt=""> <!--  style="height: 404px; width: 360px;" -->

                  <?php if (date('m-Y') == date('m-Y', strtotime($val['created_at'])) && $val['discount_charge_rate'] > 0) : ?>
                    <div class="new">New</div>
                    <div class="sale">Sale-<?php echo $val['discount_charge_rate'] ?>%</div>
                  <?php elseif (date("m-Y") == date('m-Y', strtotime($val['created_at']))) : ?>
                    <div class="new">New</div>
                  <?php elseif ($val['discount_charge_rate'] > 0) : ?>
                    <div class="sale">Sale-<?php echo $val['discount_charge_rate'] ?>%</div>
                  <?php endif; ?>

                  <?php if ($wishlist != null) : ?>
                    <?php foreach ($wishlist as $w) : ?>
                      <?php if ($w['product_id'] == $val['id_product']) :  ?>
                        <div class="icon">
                          <a href="<?php echo base_url() ?>set-wishlist-home/<?php echo $val['id_product'] ?>"><i class="fa fa-heart"></i></a>
                        </div>
                      <?php else : ?>
                        <div class="icon">
                          <a href="<?php echo base_url() ?>set-wishlist-home/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <div class="icon">
                      <a href="<?php echo base_url() ?>set-wishlist-home/<?php echo $val['id_product'] ?>"><i class="fa fa-heart-o"></i></a>
                    </div>
                  <?php endif; ?>

                  <ul>
                    <!-- <li id="cart-icon" class="w-icon active">
                      <a href="javascript:void(0)" title="add to cart" onclick="setShoppingCart('<?php echo $val['id_product'] ?>')">

                        <i class="fa fa-cart-plus" aria-hidden="true"></i>

                      </a>
                    </li> -->

                    <li class="quick-view"><a href="<?php echo base_url(); ?>product-detail/<?php echo $val['id_product'] ?>">+ See Details</a></li>
                  </ul>
                </div>
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

            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Banner Section End -->
<?php endif; ?>