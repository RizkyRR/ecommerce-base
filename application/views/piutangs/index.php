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
              <th>Piutang ID</th>
              <th>Order ID</th>
              <th>Piutang Paid History</th>
              <th>Amount Paid</th>
              <th class="no-sort">Remaining Paid</th>
              <?php if ($this->session->userdata('role_id') == 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') : ?>
                <th class="no-sort">Last User Create</th>
              <?php endif; ?>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody id="show_data_piutang">
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
  var table;

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>piutang/show_ajax_piutang",
        "type": "POST"
      },
      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdf',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Piutang',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      }, {
        extend: 'print',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Piutang',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      }],
      'order': [],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });

    $('#repayment_date').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    })
  });

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 3000);
  }

  function repayment_order(id) {
    $('#repayment-piutang-form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('piutang/get_repayment/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="piutang_id"]').val(data.piutang_id);
        $('[name="order_id"]').val(data.order_id);
        $('[name="remaining_paid"]').val(data.remaining);
        $('#modal-repayment-piutang').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Repayment Order'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function amountPaid() {
    var remaining_paid = Number($("#remaining_paid").val());
    var amount_paid = Number($("#amount_paid").val());

    if (remaining_paid < amount_paid) {
      $("#msg_amountpaid_error").parent().parent().addClass('has-error');
      $("#msg_amountpaid_error").html('Jumlah piutang yang akan dibayar lebih banyak dari sisa piutang !');
    } else {
      $("#msg_amountpaid_error").parent().parent().removeClass('has-error');
      $("#msg_amountpaid_error").next().empty();
      $("#msg_amountpaid_error").html('');

      var set_paid = remaining_paid - amount_paid;

      Number($('#amount_paid_value').val(set_paid));
    }
  }

  function pay() {
    $('#btnPay').text('saving...'); //change button text
    $('#btnPay').attr('disabled', true); //set button disable

    // ajax adding data to database
    $.ajax({
      url: "<?php echo base_url('piutang/repayment') ?>",
      type: "POST",
      data: $('#repayment-piutang-form').serialize(),
      dataType: "JSON",
      success: function(data) {

        if (data == 'success') //if success close modal and reload ajax table
        {
          $('#modal-repayment-piutang').modal('hide');

          table.ajax.reload(null, false);

          $('.msg-alert').html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            'Data saved successfully !' +
            '</div>'
          );
          effect_msg();
        } else {
          if (data.repayment_date) {
            $("#msg_date_error").parent().parent().addClass('has-error');
            $("#msg_date_error").html(data.repayment_date);
          }

          if (data.amount_paid) {
            $("#msg_amountpaid_error").parent().parent().addClass('has-error');
            $("#msg_amountpaid_error").html(data.amount_paid);
          }
        }

        $('#btnPay').text('save'); //change button text
        $('#btnPay').attr('disabled', false); //set button enable 

      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('.msg-alert').html(
          '<div class="alert alert-danger alert-dismissible">' +
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
          '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
          'Error save data !' +
          '</div>'
        );
        effect_msg();
        $('#btnPay').text('save'); //change button text
        $('#btnPay').attr('disabled', false); //set button enable 

      }
    });
  }
</script>