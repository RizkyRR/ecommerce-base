<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="product-show-option">
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
      <div class="card-body mb-3">
        <h5 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Attention</h5>
        <p class="card-text">1. Please complete your payment before it's due or less than one day.</p>
        <p class="card-text">2. After you complete the payment, please include proof of transfer via your email by clicking the button via our WhatsApp.</p>
        <p class="card-text">2. <strong>Or you can confirm your payment report by clicking the info button and selecting "Report via Message"</strong>.</p>
        <a href="#" class="btn btn-sm mt-1 mb-1 btn-info btnWhatsApp" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i> Contact via Whatsapp</a>
      </div>
    </div>

    <div class="row">

      <div class="table-responsive">
        <table class="table" id="table-data-purchase-order">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice Order</th>
              <th>Order Date</th>
              <th>Total Products</th>
              <th>Total Amount</th>
              <th>Status Order</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="show-data-purchase-order">

          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
</div>
</div>
</section>
<!-- Main content from side menu customer section end -->