<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> <?php echo $company['company_name'] ?>
          <small class="pull-right">Date: <?php echo $return_date ?></small>
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
        <b>Invoice <?php echo $data_return['invoice_return'] ?></b><br>
        <br>
        <b>Return ID:</b> <?php echo $data_return['id_return'] ?><br>
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

            <?php if ($detail_return != null && $detail_return != 0) : ?>
              <?php $no = 1; ?>
              <?php foreach ($detail_return as $val) : ?>
                <tr>
                  <td><?php echo $no++; ?></td>

                  <td><?php echo $val['product_name'] ?></td>

                  <td><?php echo $val['weight_return'] ?> Gram</td>
                  <td>Rp. <?php echo number_format($val['price'], 0, ',', '.') ?></td>
                  <td><?php echo $val['qty_return'] ?></td>
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
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <!-- <p class="lead">Amount Due 2/22/2014</p> -->

        <div class="table-responsive">
          <table class="table">

            <tr>
              <th style="width:50%">Gross Amount:</th>
              <td>Rp. <?php echo number_format($data_return['gross_amount'], 0, ',', '.') ?></td>
            </tr>

            <?php if ($data_return['ship_amount'] != null && $data_return['ship_amount'] != 0) : ?>
              <tr>
                <th>
                  <strong>Shipping cost</strong>
                </th>
                <td>Rp. <?php echo number_format($data_return['ship_amount'], 0, ',', '.') ?> (<?php echo $data_return['courier'] ?> - <?php echo $data_return['service'] ?>)</td>
              </tr>
            <?php endif; ?>

            <tr>
              <th>
                <strong>Total</strong>
              </th>
              <td>
                <strong>Rp. <?php echo number_format($data_return['net_amount'], 0, ',', '.') ?></strong>
              </td>
            </tr>

            <tr>
              <th>
                <strong>Status Order</strong>
              </th>
              <td>
                <strong><?php echo $data_return['status_name'] ?></strong>
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