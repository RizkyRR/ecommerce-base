<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> <?php echo $company['company_name'] ?>
          <small class="pull-right">Date: <?php echo $order_date ?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>

    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?php echo $company['company_name'] ?>.</strong><br>
          <?php echo $company_address['street_name'] ?>, <?php echo $company_address['city_name'] ?>, <?php echo $company_address['province'] ?><br>
          Email: <?php echo $company['business_email'] ?>
          Phone: <?php echo $company['phone'] ?><br>
          <?php if ($company_bank != null) : ?>
            <?php foreach ($company_bank as $val) : ?>
              <strong><?php echo $val['bank_name'] ?>: <?php echo $val['account'] ?> (<?php echo $val['account_holder_name'] ?>)</strong><br>
            <?php endforeach; ?>
          <?php endif; ?>
        </address>
      </div>
      <!-- /.col -->

      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $customer['customer_name'] ?></strong><br>
          <?php echo $customer['street_name'] ?>, <?php echo $customer['city_name'] ?>, <?php echo $customer['province'] ?><br>
          Email: <?php echo $customer['email'] ?><br>
          Phone: <?php echo $customer['customer_phone'] ?><br>
          <!-- Email: john.doe@example.com -->
        </address>
      </div>
      <!-- /.col -->

      <div class="col-sm-4 invoice-col">
        <b>Invoice <?php echo $data_order['invoice_order'] ?></b><br>
        <br>
        <b>Order ID:</b> <?php echo $data_order['id_order'] ?><br>
        <b>Payment Due:</b> <?php echo $order_date_due; ?> (<?php echo $data_order['status_name'] ?>)<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Item Name</th>
              <th>Weight</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>

            <?php if ($detail_order != null && $detail_order != 0) : ?>
              <?php $no = 1; ?>
              <?php foreach ($detail_order as $val) : ?>
                <tr>
                  <td><?php echo $no++; ?></td>

                  <td><?php echo $val['product_name'] ?></td>

                  <td><?php echo $val['weight_order'] ?> Gram</td>
                  <td>Rp. <?php echo number_format($val['price'], 0, ',', '.') ?></td>
                  <td><?php echo $val['qty_order'] ?></td>
                  <td>Rp. <?php echo number_format($val['amount'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>

          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods:</p>
        <img src="<?php echo base_url() ?>back-assets/dist/img/credit/visa.png" alt="Visa">
        <img src="<?php echo base_url() ?>back-assets/dist/img/credit/mastercard.png" alt="Mastercard">
        <img src="<?php echo base_url() ?>back-assets/dist/img/credit/american-express.png" alt="American Express">
        <img src="<?php echo base_url() ?>back-assets/dist/img/credit/paypal2.png" alt="Paypal">

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <!-- <p class="lead">Amount Due 2/22/2014</p> -->

        <div class="table-responsive">
          <table class="table">

            <tr>
              <th style="width:50%">Gross Amount:</th>
              <td>Rp. <?php echo number_format($data_order['gross_amount'], 0, ',', '.') ?></td>
            </tr>

            <?php if ($data_order['ship_amount'] != null && $data_order['ship_amount'] != 0) : ?>
              <tr>
                <th>
                  <strong>Shipping cost</strong>
                </th>
                <td>Rp. <?php echo number_format($data_order['ship_amount'], 0, ',', '.') ?> (<?php echo $data_order['courier'] ?> - <?php echo $data_order['service'] ?>)</td>
              </tr>
            <?php endif; ?>

            <tr>
              <th>
                <strong>VAT (<?php echo $data_order['vat_charge_rate'] ?>%)</strong>
              </th>
              <td>Rp. <?php echo number_format($data_order['vat_charge_val'], 0, ',', '.') ?></td>
            </tr>

            <?php if ($data_order['coupon_charge_rate'] != null && $data_order['coupon_charge_rate'] != 0) : ?>
              <tr>
                <th>
                  <strong>Coupon (<?php echo $data_order['coupon_charge_rate'] ?>%)</strong>
                </th>
                <td>Rp. <?php echo number_format($data_order['coupon_charge'], 0, ',', '.') ?></td>
              </tr>
            <?php endif; ?>

            <tr>
              <th>
                <strong>Total</strong>
              </th>
              <td>
                <strong>Rp. <?php echo number_format($data_order['net_amount'], 0, ',', '.') ?></strong>
              </td>
            </tr>

            <tr>
              <th>
                <strong>Status Order</strong>
              </th>
              <td>
                <strong><?php echo $data_order['status_name'] ?></strong>
              </td>
            </tr>

          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->