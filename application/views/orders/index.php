<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <a href="<?php echo base_url(); ?>order/addorder" class="btn btn-primary"><i class="fa fa-plus"></i> Order</a>
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
              <th>Customer Name</th>
              <th>Customer Phone</th>
              <th>Order Date</th>
              <th class="no-sort">Total Products</th>
              <th class="no-sort">Total Amount</th>
              <th>Paid Status</th>
              <?php if ($this->session->userdata('role_id') == 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=') : ?>
                <th class="no-sort">Last User Create</th>
              <?php endif; ?>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody id="show_data_order">
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
        "url": "<?= base_url(); ?>order/show_ajax_order",
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

    $('#order_date').datepicker({
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

  /* function add_order() {
    save_method = 'add';
    create_code();

    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal-order').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Order'); // Set Title to Bootstrap modal title
  } */

  function edit_order(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order/edit_order/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="order_date"]').val(data.order_date);
        $('[name="c_name"]').val(data.customer_name);
        $('[name="c_phone"]').val(data.customer_phone);
        $('[name="c_bankname"]').val(data.bank_name);
        $('[name="c_norek"]').val(data.no_rek);
        $('[name="c_address"]').val(data.customer_address);
        $('#modal-order-edit').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Data Order'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
      url = "<?php echo base_url('order/add_order') ?>";
    } else {
      url = "<?php echo base_url('order/update_order') ?>";
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {

        if (data == 'success') //if success close modal and reload ajax table
        {
          $('#modal-order-edit').modal('hide');

          table.ajax.reload(null, false);

          $('.msg-alert').html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            'Data has been ' + save_method + ' !' +
            '</div>'
          );
          effect_msg();
        } else {
          if (data.order_date) {
            $("#msg_date_error").parent().parent().addClass('has-error');
            $("#msg_date_error").html(data.order_date);
          }
          if (data.c_name) {
            $("#msg_name_error").parent().parent().addClass('has-error');
            $("#msg_name_error").html(data.c_name);
          }

          if (data.c_phone) {
            $("#msg_phone_error").parent().parent().addClass('has-error');
            $("#msg_phone_error").html(data.c_phone);
          }

          if (data.c_bankname) {
            $("#msg_bankname_error").parent().parent().addClass('has-error');
            $("#msg_bankname_error").html(data.c_bankname);
          }

          if (data.c_norek) {
            $("#msg_norek_error").parent().parent().addClass('has-error');
            $("#msg_norek_error").html(data.c_norek);
          }

          if (data.c_address) {
            $("#msg_address_error").parent().parent().addClass('has-error');
            $("#msg_address_error").html(data.c_address);
          }
        }

        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('.msg-alert').html(
          '<div class="alert alert-danger alert-dismissible">' +
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
          '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
          'Error ' + save_method + ' data !' +
          '</div>'
        );
        effect_msg();
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      }
    });
  }

  function repayment_order(id) {
    $('#repayment-order-form')[0].reset(); // reset form on modals
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
        $('#modal-repayment-order').modal('show'); // show bootstrap modal when complete loaded
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
      data: $('#repayment-order-form').serialize(),
      dataType: "JSON",
      success: function(data) {

        if (data == 'success') //if success close modal and reload ajax table
        {
          $('#modal-repayment-order').modal('hide');

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

  function delete_order(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('order/delete_order') ?>",
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