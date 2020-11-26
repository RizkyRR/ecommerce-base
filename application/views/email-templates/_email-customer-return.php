<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Fashi Template">
  <meta name="keywords" content="Fashi, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

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
                      <strong>Sub-total</strong>
                    </td>
                    <td class="right">Rp. <?php echo number_format($data_return['gross_amount'], 0, ',', '.') ?></td>
                  </tr>

                  <?php if ($data_return['ship_amount'] != null && $data_return['ship_amount'] != 0) : ?>
                    <tr>
                      <td class="left">
                        <strong>Shipping cost</strong>
                      </td>
                      <td class="right">Rp. <?php echo number_format($data_return['ship_amount'], 0, ',', '.') ?> (<?php echo $data_order['courier'] ?> - <?php echo $data_order['service'] ?>)</td>
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
  <!-- Main content from side menu customer section end -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>