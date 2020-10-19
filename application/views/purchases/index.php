<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <a href="<?php echo base_url(); ?>purchase/addpurchase" class="btn btn-primary"><i class="fa fa-plus"></i> Purchase</a>
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
              <th>Order ID</th>
              <th>Supplier Name</th>
              <th class="no-sort">Supplier Phone</th>
              <th>Order Date</th>
              <th>Total Products</th>
              <th class="no-sort">Total Amount</th>
              <th>Paid Status</th>
              <?php if ($this->session->userdata('role_id') == 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') : ?>
                <th class="no-sort">Last User Create</th>
              <?php endif; ?>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody id="show_data_purchase">
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

  // https://adminlte.io/themes/dev/AdminLTE/pages/examples/invoice.html

  $(document).ready(function() {
    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("textarea").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("select").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });

    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>purchase/show_ajax_purchase",
        "type": "POST"
      },
      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdf',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Order',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7]
        }
      }, {
        extend: 'print',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Order',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7]
        }
      }],
      'order': [],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });

    $('#purchase_date').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    })

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

  function repayment_purchase(id) {
    $('#repayment-purchase-form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('hutang/get_repayment/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="hutang_id"]').val(data.hutang_id);
        $('[name="purchase_id"]').val(data.purchase_id);
        $('[name="remaining_paid"]').val(data.remaining);
        $('#modal-repayment-purchase').modal('show'); // show bootstrap modal when complete loaded
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
      $("#msg_amountpaid_error").html('Jumlah hutang yang akan dibayar lebih banyak dari sisa hutang !');
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
      url: "<?php echo base_url('hutang/repayment') ?>",
      type: "POST",
      data: $('#repayment-purchase-form').serialize(),
      dataType: "JSON",
      success: function(data) {

        if (data == 'success') //if success close modal and reload ajax table
        {
          $('#modal-repayment-purchase').modal('hide');

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

  function delete_purchase(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('purchase/delete_purchase') ?>",
        data: {
          id: id
        },
        success: function(data) {
          $('#modal-delete').modal('hide');

          table.ajax.reload(null, false);

          $('.msg-alert').html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            'Data has been deleted !' +
            '</div>'
          );
          effect_msg();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            'Error deleting data !' +
            '</div>'
          );
          effect_msg();
        }
      })
    })
  }
</script>