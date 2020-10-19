<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <a href="<?php echo base_url(); ?>product/addproduct" class="btn btn-primary"><i class="fa fa-plus"></i> Product</a>

    <button onclick="add_discount()" class="btn btn-warning"><i class="fa fa-percent"></i> Set Discount</button>
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

<script>
  var table;

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

    $('.datepicker').datepicker({
      todayBtn: "linked",
      todayHighlight: true,
      format: "yyyy-mm-dd",
      autoclose: true
    });
  });

  $.validator.setDefaults({
    highlight: function(element) {
      $(element).closest(".form-group").addClass("has-error");
    },
    unhighlight: function(element) {
      $(element).closest(".form-group").removeClass("has-error");
    },
    errorElement: "span",
    errorClass: "error-message",
    errorPlacement: function(error, element) {
      if (element.parent(".input-group").length) {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
      }
    },
  });

  var $validator = $("#form").validate({
    rules: {
      product: {
        required: true,
      },
      s_discount: {
        required: true,
        number: true
      },
      start_date: {
        required: true
      },
      end_date: {
        required: true
      }
    },
    messages: {
      product: {
        required: "Product is required!",
      },
      s_discount: {
        required: "Set discount is required",
        number: "Set discount must contain numbers"
      },
      start_date: {
        required: "Start date is required"
      },
      end_date: {
        required: "End date is required"
      }
    },
  });

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 5000);
  }

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  // get latest price after sleect product
  function getLatestProductPrice() {
    var product_id = $("#product").val();
    if (product_id == "") {
      $("#l_price").val("");
    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>product/getLatestProductPrice',
        type: 'POST',
        data: {
          product_id: product_id
        },
        dataType: 'JSON',
        success: function(data) {
          // setting the price value into the price input field
          $("#l_price").val(data.price);

          subAmount();
        } // /success
      });
    }
  }

  function subAmount() {
    var setDiscount = $('#s_discount').val();
    var latestPrice = $('#l_price').val();

    if (setDiscount == "") {
      $('#d_price').val("");
    } else {
      var getDiscount = latestPrice * (setDiscount / 100);
      $('#s_discount_value').val(getDiscount);

      var getAmount = latestPrice - getDiscount;

      getAmount = getAmount.toFixed();
      $('#d_price').val(getAmount);
    }
  }

  function add_discount() {
    $('#form')[0].reset(); // reset form on modals
    $('#product').val([]).trigger("change");

    $("#product").select2({
      ajax: {
        url: "<?php echo base_url(); ?>product/getAllProductSetDiscount",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      },
      placeholder: 'Select for a product',
      disabled: false
    });

    $('.form-group').removeClass('has-error'); // clear error class
    $('.error-message').empty(); // clear error string

    $('#modal-add-discount-product').modal('show'); // show bootstrap modal
    $('.modal-title').text('Set Discount Product'); // Set Title to Bootstrap modal title
  }

  function saveDiscount() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 

    var $valid = $("#form").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: "<?php echo base_url('product/add_discount') ?>",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {
          $('#modal-add-discount-product').modal('hide');

          if (data.status == true) //if success close modal and reload ajax table
          {
            table.ajax.reload(null, false);
            $('.msg-alert').html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );
            effect_msg();
          } else {
            $('.msg-alert').html(
              '<div class="alert alert-warning alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );

            effect_msg();
          }

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            data.notif +
            '</div>'
          );

          effect_msg();

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        }
      });
    }
  }

  function edit_discount(id) {
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.error-message').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('product/edit_discount/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('[name="id"]').val(data.discount_id);
        $('[name="product_id"]').val(data.product_id);
        $('[name="product_name"]').val(data.product_name);
        $('[name="l_price"]').val(data.before_discount);
        $('[name="s_discount"]').val(data.discount_charge_rate);
        $('[name="s_discount_value"]').val(data.discount_charge);
        $('[name="d_price"]').val(data.after_discount);
        moment($('[name="start_date"]').val(data.start_time_discount)).format("YYYY-MM-DD");
        moment($('[name="end_date"]').val(data.end_time_discount)).format("YYYY-MM-DD");

        $('#modal-edit-discount-product').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Discount Product'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function updateDiscount() {
    $('#btnUpdate').text('updating...'); //change button text
    $('#btnUpdate').attr('disabled', true); //set button disable 

    var $valid = $("#form").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnUpdate").text("Update"); //change button text
      $("#btnUpdate").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: "<?php echo base_url('product/update_discount') ?>",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {
          $('#modal-edit-discount-product').modal('hide');

          if (data.status == true) //if success close modal and reload ajax table
          {
            table.ajax.reload(null, false);
            $('.msg-alert').html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );
            effect_msg();
          } else {
            $('.msg-alert').html(
              '<div class="alert alert-warning alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );

            effect_msg();
          }

          $('#btnUpdate').text('update'); //change button text
          $('#btnUpdate').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            'There is something error with system, please contact your admin.' +
            '</div>'
          );

          effect_msg();

          $('#btnUpdate').text('update'); //change button text
          $('#btnUpdate').attr('disabled', false); //set button enable 

        }
      });
    }
  }

  function delete_discount(id) {
    $('#modal-edit-discount-product').modal('hide');
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('product/delete_discount') ?>",
        data: {
          id: id,
          l_price: $('#modal-edit-discount-product #l_price').val()
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

          $('.msg-alert').show(1000);
          setTimeout(function() {
            $('.msg-alert').fadeOut(1000);
          }, 3000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            'Error deleting data !' +
            '</div>'
          );

          $('.msg-alert').show(1000);
          setTimeout(function() {
            $('.msg-alert').fadeOut(1000);
          }, 3000);
        }
      })
    })
  }
</script>