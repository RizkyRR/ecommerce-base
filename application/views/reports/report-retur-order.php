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
    <div class="row">
      <form id="form-daterange" action="" method="post" enctype="multipart/form-data">
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
      </form>

      <form id="form-print-order-return" action="" method="post" enctype="multipart/form-data">
        <div class="col-lg-6">
          <div class="form-group">
            <div id="button-print-order-return"></div>

            <input type="hidden" name="start_date_val" id="start_date_val" readonly>
            <input type="hidden" name="end_date_val" id="end_date_val" readonly>
            <input type="hidden" name="search_val" id="search_val" readonly>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover" id="table-data-report-order-return">
          <thead>
            <tr>
              <th class="no-sort">No</th>
              <th>Invoice Return</th>
              <th>Invoice Order</th>
              <th>Customer Email</th>
              <th>Customer Name</th>
              <th>Return Date</th>
              <th>Total Return</th>
              <th>Total Amount</th>
              <th>Status Return</th>
            </tr>
          </thead>
          <tbody id="table_report_retur_order">
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var table_report_order_return;

  $(document).ready(function() {
    $('.applyBtn').click(function(e) {
      var startDatetime = $('#start_date_val').val();
      var endDatetime = $('#end_date_val').val();

      if (startDatetime != null && endDatetime != null) {
        $('#table-data-report-order-return').DataTable().destroy();
        fetch_data(startDatetime, endDatetime);
      } else {
        Swal.fire({
          icon: "error",
          title: 'Both Date is Required and Choose what to show!',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    })

    //Date range picker
    $('#reservation').daterangepicker({
      locale: {
        format: 'YYYY-MM-DD'
      }
    }, function(start, end, label) {
      startDate = moment(start).format('YYYY-MM-DD');
      endDate = moment(end).format('YYYY-MM-DD');

      console.log(start.format('YYYY-MM-DD'));
      console.log(end.format('YYYY-MM-DD'));

      $('input[name="daterangepicker_start"]').val(startDate);
      $('input[name="daterangepicker_end"]').val(endDate);

      $('#table-data-report-order-return').DataTable().destroy();
      fetch_data(startDate, endDate);

      $('#start_date_val').val(startDate);
      $('#end_date_val').val(endDate);
    });

    $('#table-data-report-order-return').on('search.dt', function() {
      var value = $('.dataTables_filter input').val();
      console.log(value); // <-- the value

      $('#search_val').val(value);

      $.ajax({
        url: '<?php echo base_url(); ?>report_retur_order/getOrderReturnDatePrint',
        data: {
          startDate: $('#start_date_val').val(),
          endDate: $('#end_date_val').val(),
          search: $('#search_val').val()
        },
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
          console.log(response);

          if (response.url != null) {
            $('#button-print-order-return').html('<a href="' + response.url + '" target="__blank" rel="noreferrer noopener" class="btn btn-default btnPrintOrderReturn"><i class="fa fa-print"></i> Print</a>');
          } else {
            $('#button-print-order-return').html('<a href="#" target="__blank" rel="noreferrer noopener" class="btn btn-default btnPrintOrderReturn" disabled><i class="fa fa-print"></i> Print</a>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: "Make sure you set up start date and end date.",
            showConfirmButton: false,
            timer: 3000,
          });
        }
      })
    });

    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('YYYY-MM-DD'));
      console.log(picker.endDate.format('YYYY-MM-DD'));

      $('#start_date_val').val(picker.startDate.format('YYYY-MM-DD'));
      $('#end_date_val').val(picker.endDate.format('YYYY-MM-DD'));

      $.ajax({
        url: '<?php echo base_url(); ?>report_retur_order/getOrderReturnDatePrint',
        data: {
          startDate: picker.startDate.format('YYYY-MM-DD'),
          endDate: picker.endDate.format('YYYY-MM-DD'),
          search: $('#search_val').val()
        },
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
          console.log(response);

          if (response.url != null) {
            $('#button-print-order-return').html('<a href="' + response.url + '" target="__blank" rel="noreferrer noopener" class="btn btn-default btnPrintOrderReturn"><i class="fa fa-print"></i> Print</a>');
          } else {
            $('#button-print-order-return').html('<a href="#" target="__blank" rel="noreferrer noopener" class="btn btn-default btnPrintOrderReturn" disabled><i class="fa fa-print"></i> Print</a>');
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: "Make sure you set up start date and end date.",
            showConfirmButton: false,
            timer: 3000,
          });
        }
      })
    });
  })

  function fetch_data(start_date = '', end_date = '') {
    table_report_order_return = $("#table-data-report-order-return").DataTable({
      processing: true,
      serverSide: true,
      bLengthChange: true,
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      pageLength: 10,
      ajax: {
        url: "<?php echo base_url() ?>report_retur_order/showAjaxReportOrderReturn",
        type: "POST",
        data: {
          start_date: start_date,
          end_date: end_date
        }
      },
      dom: 'Blfrtip',
      buttons: [{
        extend: 'excel',
        text: 'Download Excel',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Order Return ' + moment(start_date).format('DD MMMM YYYY 00:00:00') + ' - ' + moment(end_date).format('DD MMMM YYYY 23:59:59'),
        download: 'open',
        exportOptions: {
          // columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
          modifier: {
            search: 'applied',
            order: 'applied'
          }
        }
      }],
      order: [],
      columnDefs: [{
        targets: "no-sort",
        orderable: false,
      }, ],
    });
  }
</script>