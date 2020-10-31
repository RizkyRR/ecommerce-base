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
      <div class="container">
        <div class="card mb-3 shadow">
          <div class="card-body">
            <a href="<?php echo base_url(); ?>print-customer-return/<?php echo $data_return['id_return'] ?>" target="__blank" rel="noreferrer noopener" class="btn btn-sm btn-secondary"><i class="fa fa-print" aria-hidden="true"></i> Print return</a>
            <a href="#" class="btn btn-sm btn-info"><i class="fa fa-phone" aria-hidden="true"></i> Contact admin</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="container">
        <div class="card mb-3 shadow">
          <div class="card-header">
            Invoice
            <strong><?php echo $data_return['invoice_return'] ?></strong>
            <span class="float-right"> <strong>Status:</strong> <?php echo $data_return['status_name'] ?></span>

          </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-sm-6">
                <h6 class="mb-3">From:</h6>
                <div>
                  <strong><?php echo $customer['customer_name'] ?></strong>
                </div>
                <div><?php echo $customer['street_name'] ?>, <?php echo $customer['city_name'] ?>, <?php echo $customer['province'] ?></div>
                <div>Email: <?php echo $customer['email'] ?></div>
                <div>Phone: <?php echo $customer['customer_phone'] ?></div>
              </div>

              <div class="col-sm-6">
                <h6 class="mb-3">To:</h6>
                <div>
                  <strong><?php echo $company['company_name'] ?></strong>
                </div>
                <div><?php echo $company_address['street_name'] ?>, <?php echo $company_address['city_name'] ?>, <?php echo $company_address['province'] ?></div>
                <div>Email: <?php echo $company['business_email'] ?></div>
                <div>Phone: <?php echo $company['phone'] ?></div>
              </div>
            </div>

            <div class="table-responsive-sm">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="center">#</th>
                    <th>Item Name</th>
                    <th>Weight</th>
                    <th class="right">Price</th>
                    <th class="center">Qty</th>
                    <th class="right">Total</th>
                  </tr>
                </thead>
                <tbody>

                  <?php if ($detail_return != null && $detail_return != 0) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($detail_return as $val) : ?>
                      <tr>
                        <td class="center"><?php echo $no++; ?></td>

                        <td class="left strong"><?php echo $val['product_name'] ?></td>

                        <td class="center"><?php echo $val['weight_return'] ?> Gram</td>
                        <td class="right">Rp. <?php echo number_format($val['price'], 0, ',', '.') ?></td>
                        <td class="center"><?php echo $val['qty_return'] ?></td>
                        <td class="right">Rp. <?php echo number_format($val['amount'], 0, ',', '.') ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>

                </tbody>
              </table>
            </div>
            <div class="row">

              <div class="col-lg-6 col-sm-5 ml-auto">
                <table class="table table-clear">
                  <tbody>
                    <tr>
                      <td class="left">
                        <strong>Subtotal</strong>
                      </td>
                      <td class="right">Rp. <?php echo number_format($data_return['gross_amount'], 0, ',', '.') ?></td>
                    </tr>

                    <?php if ($data_return['ship_amount'] != null && $data_return['ship_amount'] != 0) : ?>
                      <tr>
                        <td class="left">
                          <strong>Shipment</strong>
                        </td>
                        <td class="right">Rp. <?php echo number_format($data_return['ship_amount'], 0, ',', '.') ?></td>
                      </tr>
                    <?php endif; ?>

                    <tr>
                      <td class="left">
                        <strong>Total</strong>
                      </td>
                      <td class="right">
                        <strong>Rp. <?php echo number_format($data_return['net_amount'], 0, ',', '.') ?></strong>
                      </td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</section>
<!-- Main content from side menu customer section end -->