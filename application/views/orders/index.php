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
        <table class="table table-hover" id="table-data-purchase-order">
          <thead>
            <tr>
              <th class="no-sort">No</th>
              <th>Invoice Order</th>
              <th>Customer Email</th>
              <th>Customer Name</th>
              <th>Order Date</th>
              <th class="no-sort">Total Products</th>
              <th class="no-sort">Total Amount</th>
              <th>Status Order</th>
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

    $('#repayment_date').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    });

    // ZoomImage
    // $('#image-container').zoom();

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

    var $validatorPaymentApprove = $("#form-payment-approve").validate({
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

    $('#btnPaymentApprove').click(function(e) {
      $('#btnPaymentApprove').text('Submitting...'); //change button text
      $('#btnPaymentApprove').attr('disabled', true); //set button disable 

      var formData = new FormData($("#form-payment-approve")[0]);
      var $valid = $("#form-payment-approve").valid();
      var url;

      if (save_method_approve == 'save') {
        url = '<?php echo base_url(); ?>order/setPurchaseOrderForApprove';
      } else {
        url = '<?php echo base_url(); ?>order/updatePurchaseOrderForApprove';
      }

      if (!$valid) {
        $("#btnPaymentApprove").text("Submit"); //change button text
        $("#btnPaymentApprove").attr("disabled", false); //set button enable
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

            $('#modal-payment-approve').modal('hide');
            table_purchase_order.ajax.reload(null, false);

            $('#btnPaymentApprove').text('Submit'); //change button text
            $('#btnPaymentApprove').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: textStatus,
              showConfirmButton: false,
              timer: 3000,
            });

            $('#btnPaymentApprove').text('Submit'); //change button text
            $('#btnPaymentApprove').attr('disabled', false); //set button enable 
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
      $('.msg-alert').fadeOut(3000);
    }, 3000);
  }

  function payment_approve(id) {
    $('#form-payment-approve')[0].reset(); // reset form on modals
    $('#form-payment-approve').valid();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#image_new').hide();
    $('#image').show();

    save_method_approve = 'save';

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order/getPurchaseOrderForApprove') ?>",
      data: {
        order_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('[name="invoice_order"]').val(data.invoice_order);
        $('[name="order_id"]').val(data.id_order);
        $('[name="order_date"]').val(data.created_date);
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);
        $('[name="shipping_courier"]').val(data.courier);
        $('[name="shipping_service"]').val(data.service);
        $('[name="airwaybill_number"]').val(data.delivery_receipt_number).prop('readonly', false); // tambahan

        $('#modal-payment-approve').modal('show'); // show bootstrap modal when complete loaded
        $('#btnPaymentApprove').show();
        $('.modal-title').text('Order Payment Approve'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function update_approve(id) {
    $('#form-payment-approve')[0].reset(); // reset form on modals
    $('#form-payment-approve').valid();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#image').hide();
    $('#image_new').show();

    save_method_approve = 'update';

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order/getUpdatePurchaseOrderForApprove') ?>",
      data: {
        order_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('[name="invoice_order"]').val(data.invoice_order);
        $('[name="order_id"]').val(data.id_order);
        $('#order_date_label').text('Approved date'); // tambahan
        $('[name="order_date"]').val(data.approve_date); // isinya beda
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);

        $('[name="old_image"]').val(data.image);
        $('#image-container').html('<img class="img-responsive" style="width: auto; height: auto;" src="' + '<?php echo base_url(); ?>image/customer_payment/' + '' + data.image + '" />'); // tambahan

        // ZoomImage ZoomMaster
        $('#image-container').zoom({
          on: 'mouseover'
        });

        $('[name="shipping_courier"]').val(data.courier);
        $('[name="shipping_service"]').val(data.service);
        $('[name="airwaybill_number"]').val(data.delivery_receipt_number).prop('readonly', false); // tambahan

        $('#modal-payment-approve').modal('show'); // show bootstrap modal when complete loaded
        $('#btnPaymentApprove').show();
        $('.modal-title').text('Order Payment Approved Update'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function detail_approve(id) {
    $('#form-payment-approve')[0].reset(); // reset form on modals
    $('#form-payment-approve').valid();
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#image').hide();
    $('#image_new').hide();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order/getUpdatePurchaseOrderForApprove') ?>",
      data: {
        order_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {

        $('[name="invoice_order"]').val(data.invoice_order).prop('readonly', true);
        $('[name="order_id"]').val(data.id_order);
        $('#order_date_label').text('Approved date'); // tambahan
        $('[name="order_date"]').val(data.approve_date); // isinya beda
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_name"]').val(data.customer_name);

        $('#image-container').html('<img class="img-responsive" style="width: auto; height: auto;" src="' + '<?php echo base_url(); ?>image/customer_payment/' + '' + data.image + '" />'); // tambahan

        // ZoomImage ZoomMaster
        $('#image-container').zoom({
          on: 'mouseover'
        });

        $('[name="shipping_courier"]').val(data.courier);
        $('[name="shipping_service"]').val(data.service);
        $('[name="airwaybill_number"]').val(data.delivery_receipt_number).prop('readonly', true); // tambahan

        $('#modal-payment-approve').modal('show'); // show bootstrap modal when complete loaded
        $('#btnPaymentApprove').hide();
        // $('.btnCancelApprove').text('Close');
        // $('.btnCancelApprove').removeClass('pull-left');
        // $('.btnCancelApprove').addClass('pull-right');
        $('.modal-title').text('Order Payment Approved Detail'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function cancel_order(id) {
    $("#btnCancelOrder").prop("disabled", true); //set button disable

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
        $("#btnCancelOrder").hide(); //set button disable
        $("#btnModalPaymentApprove").hide();

        $.ajax({
          url: '<?php echo base_url() ?>order/cancelPayment',
          type: 'POST',
          data: {
            email: $('#email_customer_' + id).val(),
            order_id: id
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

              table_purchase_order.ajax.reload(null, false);
            } else {
              Swal.fire({
                icon: "error",
                title: response.message,
                showConfirmButton: false,
                timer: 5000,
              });

              $("#btnCancelOrder").show();
              $("#btnModalPaymentApprove").show();
              $("#btnCancelOrder").prop("disabled", false); //set button disable
            }
          }
        })
      }
    });
  }

  function complete_order(id) {
    $("#btnCompleteOrder").prop("disabled", true); //set button disable

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
        $("#btnCompleteOrder").hide(); //set button disable

        $.ajax({
          url: '<?php echo base_url() ?>order/completeOrder',
          type: 'POST',
          data: {
            email: $('#email_customer_' + id).val(),
            order_id: id
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

              table_purchase_order.ajax.reload(null, false);
            } else {
              Swal.fire({
                icon: "error",
                title: response.message,
                showConfirmButton: false,
                timer: 5000,
              });

              $("#btnCompleteOrder").show();
              $("#btnCompleteOrder").prop("disabled", false); //set button disable
            }
          }
        })
      }
    });
  }

  function detail_order(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('order/getDetailCustomerOrder') ?>",
      data: {
        email: $('#email_customer_' + id).val(),
        order_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('#show-data-detail-order').html(data.html);

        $('#modal-detail-order').modal('show');
        $('.modal-title').text('Detail Order ' + data.invoice); // Set title to Bootstrap modal title
      },
    });
  }
</script>