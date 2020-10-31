<div class="row">
  <div class="container">
    <div class="card mb-3 shadow">
      <div class="card-header">
        Invoice
        <strong><?php echo $data_order['invoice_order'] ?></strong>
        <span class="float-right"> <strong>Status:</strong> <?php echo $data_order['status_name'] ?></span>

      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-sm-6">
            <h6 class="mb-3">From:</h6>
            <div>
              <strong><?php echo $company['company_name'] ?></strong>
            </div>
            <div><?php echo $company_address['street_name'] ?>, <?php echo $company_address['city_name'] ?>, <?php echo $company_address['province'] ?></div>
            <div>Email: <?php echo $company['business_email'] ?></div>
            <div>Phone: <?php echo $company['phone'] ?></div>

            <?php if ($company_bank != null) : ?>
              <?php foreach ($company_bank as $val) : ?>
                <div><strong><?php echo $val['bank_name'] ?>: <?php echo $val['account'] ?> (<?php echo $val['account_holder_name'] ?>)</strong></div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <div class="col-sm-6">
            <h6 class="mb-3">To:</h6>
            <div>
              <strong><?php echo $customer['customer_name'] ?></strong>
            </div>
            <div><?php echo $customer['street_name'] ?>, <?php echo $customer['city_name'] ?>, <?php echo $customer['province'] ?></div>
            <div>Email: <?php echo $customer['email'] ?></div>
            <div>Phone: <?php echo $customer['customer_phone'] ?></div>
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

              <?php if ($detail_order != null && $detail_order != 0) : ?>
                <?php $no = 1; ?>
                <?php foreach ($detail_order as $val) : ?>
                  <tr>
                    <td class="center"><?php echo $no++; ?></td>

                    <td class="left strong"><?php echo $val['product_name'] ?></td>

                    <td class="center"><?php echo $val['weight_order'] ?> Gram</td>
                    <td class="right">Rp. <?php echo number_format($val['price'], 0, ',', '.') ?></td>
                    <td class="center"><?php echo $val['qty_order'] ?></td>
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
                    <strong>Sub-total</strong>
                  </td>
                  <td class="right">Rp. <?php echo number_format($data_order['gross_amount'], 0, ',', '.') ?></td>
                </tr>

                <?php if ($data_order['ship_amount'] != null && $data_order['ship_amount'] != 0) : ?>
                  <tr>
                    <td class="left">
                      <strong>Shipping cost</strong>
                    </td>
                    <td class="right">Rp. <?php echo number_format($data_order['ship_amount'], 0, ',', '.') ?> (<?php echo $data_order['courier'] ?> - <?php echo $data_order['service'] ?>)</td>
                  </tr>
                <?php endif; ?>

                <tr>
                  <td class="left">
                    <strong>VAT (<?php echo $data_order['vat_charge_rate'] ?>%)</strong>
                  </td>
                  <td class="right">Rp. <?php echo number_format($data_order['vat_charge_val'], 0, ',', '.') ?></td>
                </tr>

                <?php if ($data_order['coupon_charge_rate'] != null && $data_order['coupon_charge_rate'] != 0) : ?>
                  <tr>
                    <td class="left">
                      <strong>Coupon (<?php echo $data_order['coupon_charge_rate'] ?>%)</strong>
                    </td>
                    <td class="right">Rp. <?php echo number_format($data_order['coupon_charge'], 0, ',', '.') ?></td>
                  </tr>
                <?php endif; ?>

                <tr>
                  <td class="left">
                    <strong>Total</strong>
                  </td>
                  <td class="right">
                    <strong>Rp. <?php echo number_format($data_order['net_amount'], 0, ',', '.') ?></strong>
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
<!-- Main content from side menu customer section end -->