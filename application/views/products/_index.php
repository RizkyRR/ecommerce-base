<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <button onclick="add_product()" class="btn btn-primary"><i class="fa fa-plus"></i> Product</button>
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
              <th>Category</th>
              <th>Supplier</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="show_data_product">
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
  // show_data_product();
  show_data_category();
  show_data_supplier();
  // show_image();

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>product/show_ajax_product",
        "type": "POST"
      },
      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdf',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Product',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5]
        }
      }, {
        extend: 'print',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Product',
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

  function show_data_category() {
    $.ajax({
      url: "<?php echo base_url(); ?>product/getProduct",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].id + '">' + data[i].category_name + '</option>';
        }
        $('#category').html(html);
        // $('#category').select2();
      }
    })
  }

  function show_data_supplier() {
    $.ajax({
      url: "<?php echo base_url(); ?>product/getSupplier",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].id + '">' + data[i].supplier_name + '</option>';
        }
        $('#supplier').html(html);
        // $('#supplier').select2();
      }
    })
  }

  //datatables
  /* var table = $('#table-data').dataTable({

    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,

  });

  window.onload = function() {
    show_data_product();
  }

  function refresh() {
    table = $('#table-data').dataTable();
  } */

  /* function show_data_product() {
    $.ajax({
      type: 'GET',
      url: '<?php echo base_url('product/data_product') ?>',
      async: true,
      dataType: 'JSON',
      success: function(data) {
        var html = '';
        var no = 0;
        var status = "";
        var i;
        for (i = 0; i < data.length; i++) {
          no++;
          html +=
            '<tr>' +
            '<td>' + no + '</td>' +
            '<td>' + data[i].product_name + '</td>' +
            '<td>' + data[i].category_name + '</td>' +
            '<td>' + data[i].supplier_name + '</td>' +
            '<td>' + data[i].qty + '</td>' +
            '<td>' + data[i].price + '</td>' +
            '<td>' +
            '<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="edit_product(\'' + data[i].product_id + '\')" title="edit data"><i class="fa fa-pencil"></i></a>' + ' ' +
            '<a href="javascript:void(0)" onclick="delete_product(\'' + data[i].product_id + '\')" class="btn btn-danger btn-sm" title="delete data"><i class="fa fa-trash-o"></i></a>' + ' ' +
            '<a href="javascript:void(0)" onclick="detail_product(\'' + data[i].product_id + '\')" class="btn btn-info btn-sm" title="detail data"><i class="fa fa-search"></i></a>' +
            '</td>' +
            '</tr>';
        }
        table.fnDestroy();
        $('#show_data_product').html(html);
        refresh();
      }
    })
  } */

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('product/create_code') ?>',
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

  function add_product() {
    save_method = 'add';
    create_code();
    show_data_category();
    show_data_supplier();

    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal-product').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Product'); // Set Title to Bootstrap modal title
  }

  function edit_product(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('product/edit_product/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.product_id);
        $('[name="name"]').val(data.product_name);
        $('[name="category"]').val(data.category_id);
        $('[name="supplier"]').val(data.supplier_id);
        $('[name="old_image"]').val(data.image);
        $('[name="description"]').val(data.description);
        $('[name="price"]').val(data.price);
        $('#modal-product').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Data Product'); // Set title to Bootstrap modal title

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
      url = "<?php echo base_url('product/add_product') ?>";
    } else {
      url = "<?php echo base_url('product/update_product') ?>";
    }

    var formData = new FormData($("#form")[0]);

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      processData: false,
      contentType: false,
      // data: $('#form').serialize(),
      data: formData,
      contentType: false,
      dataType: "JSON",
      success: function(data) {

        if (data == 'success') //if success close modal and reload ajax table
        {
          $('#modal-product').modal('hide');

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
          if (data.category) {
            $("#msg_category_error").parent().parent().addClass('has-error');
            $("#msg_category_error").html(data.category);
          }

          if (data.supplier) {
            $("#msg_supplier_error").parent().parent().addClass('has-error');
            $("#msg_supplier_error").html(data.supplier);
          }

          if (data.description) {
            $("#msg_description_error").parent().parent().addClass('has-error');
            $("#msg_description_error").html(data.description);
          }

          // if (data.image_error) {
          //   $("#msg_image_error").parent().parent().addClass('has-error');
          //   $("#msg_image_error").html(data.image_error);
          // }

          if (data.price) {
            $("#msg_price_error").parent().parent().addClass('has-error');
            $("#msg_price_error").html(data.price);
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

  function detail_product(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('product/detail_product/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="detail_id"]').val(data.product_id);
        $('[name="detail_name"]').val(data.product_name);
        $('[name="detail_category"]').val(data.category_name);
        $('[name="detail_supplier"]').val(data.supplier_name);
        $('#image_container').html('<img class="img-responsive" src="' + '<?php echo base_url(); ?>image/product/' + '' + data.image + '" />');
        // $('[name="detail_image"]').val(data.image);
        $('[name="detail_description"]').val(data.description);
        $('[name="detail_price"]').val(data.price);
        $('[name="detail_qty"]').val(data.qty);
        $('#modal-detail-product').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Data Product'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_product(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('product/delete_product') ?>",
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