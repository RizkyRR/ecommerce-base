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
              <th>Brand</th>
              <th>Supplier</th>
              <th>Weight</th>
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
  $(document).ready(function() {
    // TRY THIS IF YOU USING FUNCTION INSIDE DOCUMENTREADY 
    // https://stackoverflow.com/questions/5067887/function-is-not-defined-uncaught-referenceerror
    // https://stackoverflow.com/questions/17378199/uncaught-referenceerror-function-is-not-defined-with-onclick
    // https://stackoverflow.com/questions/50604003/uncaught-referenceerror-function-is-not-defined-but-it-is-defined

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
          columns: [0, 1, 2, 3, 4, 5, 6]
        }
      }, {
        extend: 'print',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Product',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6]
        }
      }],
      "columnDefs": [{
        "targets": [0, 7],
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

    // Select product for modal discount
    /* $('.select-product').select2({
      ajax: {
        url: "<?php echo base_url(); ?>product/getAllSelectProduct",
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
    }); */
  });

  var table;
  var base_url = "<?php echo base_url(); ?>";
  // getSelectProduct();
  getLatestProductPrice();

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 5000);
  }

  function detail_product(id) {
    $.ajax({
      url: '<?php echo base_url() ?>product/getDetailProduct/' + id,
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#modal-detail-product').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Product'); // Set title to Bootstrap modal title

        $('#image-detail').zoom({
          on: 'mouseover'
        });

        $('#show-data-detail-product').html(data.detail);
      }
    })
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

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function subAmount() {
    var setDiscount = Number($('#s_discount').val());
    var latestPrice = Number($('#l_price').val());

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
      if (element.parent('.input-group').length) {
        error.insertAfter(element.parent()); // radio/checkbox?
      }
      /* else if (element.hasClass('select2')) {
             error.insertAfter(element.next('span')); // select2
           } */
      else if (element.hasClass("select2-hidden-accessible")) {
        error.insertAfter(element.next('span.select2')); // select2 new ver
      } else {
        error.insertAfter(element); // default
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

  function add_discount() {
    save_method = 'add';

    // getSelectProduct();
    $("#modal-discount-product .delete-discount").hide();
    $("#product").attr('onchange', 'getLatestProductPrice()');

    $('#form')[0].reset(); // reset form on modals
    $('#product').val(null).trigger("change");

    $('.select-product').select2({
      ajax: {
        url: "<?php echo base_url(); ?>product/getAllSelectProduct",
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

    $('#modal-discount-product').modal('show'); // show bootstrap modal
    $('.modal-title').text('Set Discount Product'); // Set Title to Bootstrap modal title
  }

  function edit_discount(id) {
    save_method = 'update';

    $('#form')[0].reset(); // reset form on modals
    $('#product').val(null).trigger("change");

    $('.form-group').removeClass('has-error'); // clear error class
    $('.error-message').empty(); // clear error string

    $('#product').removeAttr("onchange", "getLatestProductPrice()");

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
      disabled: true
    });

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('product/edit_discount/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.discount_id);
        $('[name="product_id"]').val(data.product_id);

        $('#btnDelete').val(data.product_id);
        $("#modal-discount-product #btnDelete").show();

        // PRODUCT SELECTED TAPI TIDAK MELEMPAR ID JADI TIDAK BISA DIUPDATE / BISA TAPI PROP READONLY TRUE
        // $('#product option:selected').val(data.product_id).text(data.product_name).trigger('change');

        $("#product").select2("trigger", "select", {
          data: {
            id: data.product_id,
            text: data.product_name,
            disabled: true
          }
        });
        // https://www.codeproject.com/Questions/5247969/How-to-get-select2-dropdown-selected-value-while-g
        /* $('#product').val(data.product_id).find("option[value=" + data.product_id + "]").prop('selected', true);

        $('select').prop('readonly', true); */

        $('[name="l_price"]').val(data.before_discount);
        $('[name="s_discount"]').val(data.discount_charge_rate);
        $('[name="s_discount_value"]').val(data.discount_charge);
        $('[name="d_price"]').val(data.after_discount);
        moment($('[name="start_date"]').val(data.start_time_discount)).format("YYYY-MM-DD");
        moment($('[name="end_date"]').val(data.end_time_discount)).format("YYYY-MM-DD");

        $('#modal-discount-product').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Discount Product'); // Set title to Bootstrap modal title

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
      url = "<?php echo base_url('product/add_discount') ?>";
    } else {
      url = "<?php echo base_url('product/update_discount') ?>";
    }

    var $valid = $("#form").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {
          $('#modal-discount-product').modal('hide');

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
            'There is something wrong, please contact admin!' +
            '</div>'
          );

          effect_msg();

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        }
      });
    }
  }

  function delete_discount(id) {
    $('#modal-discount-product').modal('hide');
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('#btnDelete').val(); // reset form on modals
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('product/delete_discount') ?>",
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

  function delete_product(id) {
    Swal.fire({
      icon: 'warning',
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?php echo base_url('product/delete_product') ?>',
          data: {
            id: id
          },
          type: 'POST',
          dataType: 'JSON',
          success: function(data) {
            if (data.status == true) {
              Swal.fire({
                icon: "success",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            }

            table.ajax.reload(null, false);
          }
        });
      }
    });
  }
</script>