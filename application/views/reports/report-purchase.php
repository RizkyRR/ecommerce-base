<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12 msg-alert"></div>
    </div>
  </section>

  <section class="content-header">
    <form id="form-daterange" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="reservation">
            </div>
            <!-- /.input group -->
          </div>
        </div>
      </div>
    </form>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover" id="table-data">
          <thead>
            <tr>
              <th>No</th>
              <th>Purchase ID</th>
              <th>Supplier Name</th>
              <th>Supplier Phone</th>
              <th>Purchase Date</th>
              <th>Total Products</th>
              <th>Total Amount</th>
              <th>Paid Status</th>
            </tr>
          </thead>
          <tbody id="table_report_purchase">
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-body">
        <div id="show-print">
          <!-- put href link with ajax -->
        </div>
      </div>
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var save_method; //for save method string
  var table;

  var formatter = new Intl.NumberFormat('id');

  function show_report_purchase(startDate, endDate) {
    $.ajax({
      url: "<?php echo base_url('report_purchase/getDataPurchase') ?>",
      type: "POST",
      async: true,
      // data: $('#form-daterange').serialize(),
      data: {
        startDate: startDate,
        endDate: endDate
      },
      dataType: "JSON",
      success: function(response) {

        if (response.cetak) {
          $("#show-print").html('<a target="__blank" rel="noreferrer noopener" href="#" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Print All</a>');
          $("#show-print a").attr("href", response.cetak);

          $('#table_report_purchase').html(response.data);
        } else {
          $("#show-print").html('<a target="__blank" rel="noreferrer noopener" href="#" class="btn btn-default btn-sm disabled"><i class="fa fa-print"></i> Print All</a>');

          $('#table_report_purchase').html(response.data);
        }
      }
    })
  }

  //Date range picker
  $('#reservation').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    }
  }, function(start, end, label) {
    startDate = moment(start).format('YYYY-MM-DD');
    endDate = moment(end).format('YYYY-MM-DD');

    show_report_purchase(startDate, endDate);
  });
</script>