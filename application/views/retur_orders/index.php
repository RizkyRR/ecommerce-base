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
        <div class="callout callout-warning">
          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Warning.</h4>

          <p>Once you do a retur order, you cannot edit and delete it. Please be careful when entering into input fields. !</p>
        </div>
      </div>
    </div>
  </section>

  <section class="content-header">
    <a href="<?php echo base_url(); ?>order_retur/addretur" class="btn btn-primary"><i class="fa fa-plus"></i> Order Retur</a>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover" id="table-data-purchase-return">
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
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody id="show_data_retur">
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
  var table_purchase_return;

  // https://adminlte.io/themes/dev/AdminLTE/pages/examples/invoice.html

  $(document).ready(function() {
    table_purchase_return = $('#table-data-purchase-return').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>order_retur/show_ajax_retur",
        "type": "POST"
      },
      dom: 'Bfrtip',
      buttons: [{
        extend: 'pdf',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Retur Order',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
      }, {
        extend: 'print',
        oriented: 'potrait',
        pageSize: 'Legal',
        title: 'Data Retur Order',
        download: 'open',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }
      }],
      'order': [],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
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

    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0}');

    var $validatorPaymentApprove = $("#form-return-approve").validate({
      focusInvalid: false,
      rules: {
        image: {
          required: true,
          accept: "image/jpeg,image/jpg,image/png",
          filesize: 1000 * 1024,
        },
        image_new: {
          accept: "image/jpeg,image/jpg,image/png",
          filesize: 1000 * 1024,
        },
        airwaybill_number: {
          required: true
        }
      },
      messages: {
        image: {
          filesize: " File size must be less than 1Mb.",
          accept: "Please upload .jpg or .png or .jpg file of notice.",
          required: "Please upload file."
        },
        image_new: {
          filesize: " File size must be less than 1Mb.",
          accept: "Please upload .jpg or .png or .jpg file of notice.",
        }
      }
    });

    $('#btnReturnApprove').click(function(e) {
      $('#btnReturnApprove').text('Submitting...'); //change button text
      $('#btnReturnApprove').attr('disabled', true); //set button disable 

      var return_id = $('#return_id').val();

      $('#btnCancelReturn_' + return_id).attr('disabled', true); //set button disable
      $('#btnCompleteReturn_' + return_id).attr('disabled', true); //set button disable

      var formData = new FormData($("#form-return-approve")[0]);
      var $valid = $("#form-return-approve").valid();
      var url;

      if (save_method_approve == 'save') {
        url = '<?php echo base_url(); ?>order_retur/setPurchaseReturnForApprove';
      } else {
        url = '<?php echo base_url(); ?>order_retur/updatePurchaseReturnForApprove';
      }

      if (!$valid) {
        $("#btnReturnApprove").text("Submit"); //change button text
        $("#btnReturnApprove").attr("disabled", false); //set button enable

        $('#btnCancelReturn_' + return_id).attr('disabled', false);
        $('#btnCompleteReturn_' + return_id).attr('disabled', false); //set button disable
        return false;
      } else {
        $.ajax({
          url: url,
          type: "POST",
          processData: false,
          contentType: false,
          cache: false,
          data: formData,
          enctype: 'multipart/form-data',
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) //if success close modal and reload ajax table
            {
              Swal.fire({
                icon: "success",
                title: data.message,
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 3000,
              });
            }

            $('#btnCancelReturn_' + return_id).attr('disabled', false);
            $('#btnCompleteReturn_' + return_id).attr('disabled', false); //set button disable

            $('#modal-return-approve').modal('hide');
            $('#form-return-approve')[0].reset(); // reset form on modals
            $('#form-return-approve').valid();
            table_purchase_return.ajax.reload(null, false);

            $('#btnReturnApprove').text('Submit'); //change button text
            $('#btnReturnApprove').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: textStatus,
              showConfirmButton: false,
              timer: 3000,
            });

            $('#btnCancelReturn_' + return_id).attr('disabled', false);
            $('#btnCompleteReturn_' + return_id).attr('disabled', false); //set button disable

            $('#btnReturnApprove').text('Submit'); //change button text
            $('#btnReturnApprove').attr('disabled', false); //set button enable 
          }
        });
      }
    });
  });

  var save_method_approve;

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 3000);
  }

  function approve_return(id) {
    $('#form-return-approve')[0].reset(); // reset form on modals
    $('#form-return-approve').valid();

    $('#btnCancelReturn_' + id).attr('disabled', false);

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#image-container').hide();
    $('#image_new').hide();
    $('#image').show();

    save_method_approve = 'save';

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order_retur/getPurchaseReturnForApprove') ?>",
      data: {
        return_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('[name="invoice_return"]').val(data.invoice_return);
        $('[name="return_id"]').val(data.id_return);
        $('[name="return_date"]').val(data.purchase_return_date);
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);
        $('[name="shipping_courier"]').val(data.courier);
        $('[name="shipping_service"]').val(data.service);
        $('[name="airwaybill_number"]').attr('readonly', false); // tambahan

        $('#modal-return-approve').modal('show'); // show bootstrap modal when complete loaded
        $('#btnReturnApprove').show();
        $('.modal-title').text('Order Return Approve'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Approve return error get data from ajax',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    });
  }

  function update_approved_return(id) {
    $('#form-return-approve')[0].reset(); // reset form on modals
    $('#form-return-approve').valid();

    $('#btnCancelReturn_' + id).attr('disabled', false);
    $('#btnCompleteReturn_' + id).attr('disabled', false); //set button disable

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#image-container').show();
    $('#image').hide();
    $('#image_new').show();

    save_method_approve = 'update';

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order_retur/getUpdatePurchaseReturnForApprove') ?>",
      data: {
        return_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('[name="invoice_return"]').val(data.invoice_return);
        $('[name="return_id"]').val(data.id_return);
        $('#return_date_label').text('Approved date'); // tambahan
        $('[name="return_date"]').val(data.approve_date); // isinya beda
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);

        $('[name="old_image"]').val(data.image);
        $('#image-container').html('<img class="img-responsive" style="width: auto; height: auto;" src="' + '<?php echo base_url(); ?>image/customer_return/' + '' + data.image + '" />'); // tambahan

        // ZoomImage ZoomMaster
        $('#image-container').zoom({
          on: 'mouseover'
        });

        $('[name="shipping_courier"]').val(data.courier);
        $('[name="shipping_service"]').val(data.service);
        $('[name="airwaybill_number"]').val(data.delivery_receipt_number).attr('readonly', false); // tambahan

        $('#modal-return-approve').modal('show'); // show bootstrap modal when complete loaded
        $('#btnReturnApprove').show();
        $('.modal-title').text('Order Return Approved Update'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Approve return update error get data from ajax',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    });
  }

  function complete_return(id) {
    $("#btnCancelReturn_" + id).attr("disabled", true); //set button disable
    $("#btnUpdateApproveReturn_" + id).attr("disabled", true); //set button disable
    $("#btnCompleteReturn_" + id).attr("disabled", true); //set button disable

    Swal.fire({
      icon: 'warning',
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Complete Order'
    }).then((result) => {
      if (result.value) {
        $("#btnCompleteReturn_" + id).hide(); //set button disable

        $.ajax({
          url: '<?php echo base_url() ?>order_retur/completeReturn',
          type: 'POST',
          data: {
            email: $('#email_customer_' + id).val(),
            return_id: id
          },
          dataType: 'JSON',
          success: function(response) {
            if (response.status == true) {
              Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 5000,
              });

              table_purchase_return.ajax.reload(null, false);
            } else {
              Swal.fire({
                icon: "error",
                title: response.message,
                showConfirmButton: false,
                timer: 5000,
              });

              $("#btnCompleteReturn_" + id).show();

              $("#btnCancelReturn_" + id).attr("disabled", false); //set button disable
              $("#btnUpdateApproveReturn_" + id).attr("disabled", false); //set button disable
              $("#btnCompleteReturn_" + id).attr("disabled", false); //set button disable
            }
          }
        })
      } else {
        $("#btnCancelReturn_" + id).attr("disabled", false); //set button disable
        $("#btnUpdateApproveReturn_" + id).attr("disabled", false); //set button disable
        $("#btnCompleteReturn_" + id).attr("disabled", false); //set button disable
      }
    });
  }

  function detail_approved_return(id) {
    $('#form-return-approve')[0].reset(); // reset form on modals
    $('#form-return-approve').valid();

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#image-container').show();
    $('#image').hide();
    $('#image_new').hide();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order_retur/getUpdatePurchaseReturnForApprove') ?>",
      data: {
        return_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('[name="invoice_return"]').val(data.invoice_return).attr('readonly', true);
        $('[name="return_id"]').val(data.id_return);
        $('#return_date_label').text('Approved date'); // tambahan
        $('[name="return_date"]').val(data.approve_date); // isinya beda
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);

        $('#image-container').html('<img class="img-responsive" style="width: auto; height: auto;" src="' + '<?php echo base_url(); ?>image/customer_return/' + '' + data.image + '" />'); // tambahan

        // ZoomImage ZoomMaster
        $('#image-container').zoom({
          on: 'mouseover'
        });

        $('[name="shipping_courier"]').val(data.courier);
        $('[name="shipping_service"]').val(data.service);
        $('[name="airwaybill_number"]').val(data.delivery_receipt_number).attr('readonly', true); // tambahan

        $('#modal-return-approve').modal('show'); // show bootstrap modal when complete loaded
        $('#btnReturnApprove').hide();
        // $('.btnCancelApprove').text('Close');
        // $('.btnCancelApprove').removeClass('pull-left');
        // $('.btnCancelApprove').addClass('pull-right');
        $('.modal-title').text('Order Return Approved Detail'); // Set title to Bootstrap modal title

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

  function detail_return(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order_retur/getDetailCustomerReturn') ?>",
      data: {
        email: $('#email_customer_' + id).val(),
        return_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('#show-data-detail-return').html(data.html);

        $('#modal-detail-return').modal('show');
        $('.modal-title').text('Detail Return ' + data.invoice); // Set title to Bootstrap modal title
      },
    });
  }

  function cancel_return(id) {
    $("#btnCancelReturn_" + id).attr("disabled", true); //set button disable
    $("#btnApproveReturn_" + id).attr("disabled", true); //set button disable
    $("#btnUpdateApproveReturn_" + id).attr("disabled", true); //set button disable
    $("#btnCompleteReturn_" + id).attr("disabled", true); //set button disable

    Swal.fire({
      icon: 'warning',
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cancel Payment'
    }).then((result) => {
      if (result.value) {
        $("#btnCancelReturn_" + id).hide(); //set button disable

        $.ajax({
          url: '<?php echo base_url() ?>order_retur/cancelReturn',
          type: 'POST',
          data: {
            email: $('#email_customer_' + id).val(),
            return_id: id
          },
          dataType: 'JSON',
          success: function(response) {
            if (response.status == true) {
              Swal.fire({
                icon: "success",
                title: response.message,
                showConfirmButton: false,
                timer: 5000,
              });

              table_purchase_return.ajax.reload(null, false);
            } else {
              Swal.fire({
                icon: "error",
                title: response.message,
                showConfirmButton: false,
                timer: 5000,
              });

              $("#btnCancelReturn_" + id).show();

              $("#btnApproveReturn_" + id).attr("disabled", false); //set button disable
              $("#btnUpdateApproveReturn_" + id).attr("disabled", false); //set button disable
              $("#btnCompleteReturn_" + id).attr("disabled", false); //set button disable
              $("#btnCancelReturn_" + id).attr("disabled", false); //set button disable
            }
          }
        })
      } else {
        $("#btnCancelReturn_" + id).attr("disabled", false); //set button disabled
        $("#btnApproveReturn_" + id).attr("disabled", false); //set button disable
        $("#btnUpdateApproveReturn_" + id).attr("disabled", false); //set button disable
        $("#btnCompleteReturn_" + id).attr("disabled", false); //set button disable
      }
    });
  }
</script>