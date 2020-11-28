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
      <div class="col-lg-12">
        <?php if ($this->session->flashdata('success')) { ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php } else if ($this->session->flashdata('error')) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12">
        <div class="callout callout-info">
          <h4><i class="fa fa-bullhorn"></i> Attention.</h4>

          <p>Read a message by clicking the button <button class="btn btn-info btn-xs"><i class="fa fa-info" aria-hidden="true"></i> Info</button></p>
        </div>
      </div>
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
        <table class="table table-hover" id="table-data-message">
          <thead>
            <tr>
              <th class="no-sort">No</th>
              <th>Invoice Order</th>
              <th>Customer Email</th>
              <th>Customer Name</th>
              <th>Message</th>
              <th>Status</th>
              <th>Message datetime</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody id="show_data_message">
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  // var save_method; //for save method string
  var table_message;

  // https://adminlte.io/themes/dev/AdminLTE/pages/examples/invoice.html

  $(document).ready(function() {
    table_message = $('#table-data-message').DataTable({
      "processing": true,
      "serverSide": true,
      "bLengthChange": false,
      "ajax": {
        "url": "<?php echo base_url(); ?>message/show_ajax_message",
        "type": "POST"
      },
      'order': [],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });

    $('.btnCloseDetailMessage').click(function() {
      table_message.ajax.reload(null, false);
    })
  });

  function detail_message(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url() ?>message/getDetailMessagePayReport",
      data: {
        message_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('[name="invoice_order"]').val(data.invoice_order).attr('readonly', true);
        $('[name="order_id"]').val(data.id_order);
        $('[name="message_datetime"]').val(data.message_datetime); // isinya beda
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);

        $('#image-container').html('<img class="img-responsive" style="width: auto; height: auto;" src="' + '<?php echo base_url(); ?>image/pay_report/' + '' + data.image + '" />'); // tambahan

        // ZoomImage ZoomMaster
        $('#image-container').zoom({
          on: 'mouseover'
        });

        $('[name="message"]').val(data.message).attr('readonly', true); // tambahan

        table_message.ajax.reload(null, false);

        $('#modal-detail-message').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Pay Report Detail Message'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Error get data from ajax',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    });
  }
</script>