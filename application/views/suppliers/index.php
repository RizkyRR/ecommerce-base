<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <button onclick="add_supplier()" class="btn btn-primary"><i class="fa fa-plus"></i> Supplier</button>
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
              <th>Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Bank</th>
              <th>Bank Account Number</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="show_data_supplier">
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
  var save_method; //for save method string
  var table;

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>supplier/show_ajax_supplier",
        "type": "POST"
      },
      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdf',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Supplier',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      }, {
        extend: 'print',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Supplier',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      }],
      "columnDefs": [{
        "targets": [6],
        "orderable": false,
        "searchable": false
      }],
      'order': []
    });

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
  });

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('supplier/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id').val(data).prop("readonly", true);
      }
    })
  }

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 3000);
  }

  function add_supplier() {
    save_method = 'add';
    create_code();
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal-supplier').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Supplier'); // Set Title to Bootstrap modal title
  }

  function edit_supplier(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('supplier/edit_supplier/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id).prop("readonly", true);
        $('[name="name"]').val(data.supplier_name);
        $('[name="phone"]').val(data.supplier_phone);
        $('[name="address"]').val(data.supplier_address);
        $('[name="cc_type"]').val(data.credit_card_type);
        $('[name="cc_number"]').val(data.credit_card_number);
        $('#modal-supplier').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Data Supplier'); // Set title to Bootstrap modal title

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
      url = "<?php echo base_url('supplier/add_supplier') ?>";
    } else {
      url = "<?php echo base_url('supplier/update_supplier') ?>";
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
          $('#modal-supplier').modal('hide');
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
          if (data.name) {
            $("#msg_name_error").parent().parent().addClass('has-error');
            $("#msg_name_error").html(data.name);
          }
          if (data.phone) {
            $("#msg_phone_error").parent().parent().addClass('has-error');
            $("#msg_phone_error").html(data.phone);
          }

          if (data.address) {
            $("#msg_address_error").parent().parent().addClass('has-error');
            $("#msg_address_error").html(data.address);
          }

          if (data.cc_type) {
            $("#msg_cc_type_error").parent().parent().addClass('has-error');
            $("#msg_cc_type_error").html(data.cc_type);
          }

          if (data.cc_number) {
            $("#msg_cc_number_error").parent().parent().addClass('has-error');
            $("#msg_cc_number_error").html(data.cc_number);
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

  function delete_supplier(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('supplier/delete_supplier') ?>",
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