<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>back-assets/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<!-- <body onload="window.print();"> -->

<body>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?php echo $company_data['company_name']; ?>.
            <small class="pull-right">Date: <?php echo date('d M Y', strtotime($order['order_date'])) ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?= $company_data['company_name']; ?>.</strong><br>
            <?= $company_data['address']; ?><br>
            <?= $company_data['phone']; ?><br>
            Email: <?= $company_data['business_email']; ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?php echo $order['customer_name'] ?></strong><br>
            <?php echo $order['customer_address'] ?><br>
            <?php echo $order['customer_phone'] ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice #<?php echo substr($order['id'], 5, 8) ?></b><br>
          <br>
          <b>Order ID:</b> <?php echo $order['id'] ?><br>
          <!-- <b>Payment Due:</b> 2/22/2014<br> -->
          <b>Account:</b> 968-34567
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
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($order_detail as $val) : ?>
                <tr>
                  <td><?php echo $val['product_name'] ?></td>
                  <td><?php echo number_format($val['unit_price'], 0, ',', '.') ?></td>
                  <td><?php echo $val['qty'] ?></td>
                  <td><?php echo number_format($val['amount'], 0, ',', '.') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <!-- <div class="col-xs-6">
          <p class="lead">Payment Methods:</p>
          <img src="<?php echo base_url(); ?>back-assets/dist/img/credit/visa.png" alt="Visa">
          <img src="<?php echo base_url(); ?>back-assets/dist/img/credit/mastercard.png" alt="Mastercard">
          <img src="<?php echo base_url(); ?>back-assets/dist/img/credit/american-express.png" alt="American Express">
          <img src="<?php echo base_url(); ?>back-assets/dist/img/credit/paypal2.png" alt="Paypal">

          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
            jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
          </p>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-6">
          <!-- <p class="lead">Amount Due 2/22/2014</p> -->

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Gross Amount:</th>
                <td>Rp. <?php echo number_format($order['gross_amount'], 0, ',', '.') ?></td>
              </tr>
              <tr>
                <?php if ($order['service_charge'] > 0) : ?>
                  <th>Service Charge (<?php echo $order['service_charge_rate'] ?>%):</th>
                  <td>Rp. <?php echo number_format($order['service_charge'], 0, ',', '.') ?></td>
                <?php endif; ?>
              </tr>
              <tr>
                <?php if ($order['vat_charge'] > 0) : ?>
                  <th>Value Added Tax Charge (<?php echo $order['vat_charge_rate'] ?>%):</th>
                  <td>Rp. <?php echo number_format($order['vat_charge'], 0, ',', '.') ?></td>
                <?php endif; ?>
              </tr>
              <tr>
                <th>Discount:</th>

                <?php if ($order['discount']) : ?>
                  <td><?php echo $order['discount'] ?>%</td>
                <?php else : ?>
                  <td>-</td>
                <?php endif; ?>

              </tr>
              <tr>
                <th>Net Amount:</th>
                <td>Rp. <?php echo number_format($order['net_amount'], 0, ',', '.') ?></td>
              </tr>
              <tr>
                <th>Paid Status:</th>
                <td><strong><?php echo $order['paid_status'] ?></strong></td>
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
</body>

</html>