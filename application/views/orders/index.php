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

  /* // ZoomImage https://www.npmjs.com/package/js-image-zoom
  var options = {
    width: 400,
    zoomWidth: 500,
    offset: {
      vertical: 0,
      horizontal: 10
    },
    zoomPosition: 'original'
  };

  new ImageZoom(document.getElementById("image-container"), options); */

  var save_method_approve;

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

        $('#modal-payment-approve').modal('show'); // show bootstrap modal when complete loaded
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
        $('[name="airwaybill_number"]').val(data.delivery_receipt_number); // tambahan

        $('#modal-payment-approve').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Order Payment Approved Update'); // Set title to Bootstrap modal title

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

        $.ajax({
          url: '<?php echo base_url() ?>order/cancelPayment',
          type: 'POST',
          data: {
            email: $('#email_customer').val(),
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
              $("#btnCancelOrder").prop("disabled", false); //set button disable
            }
          }
        })
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

          table_purchase_order.ajax.reload(null, false);

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

          table_purchase_order.ajax.reload(null, false);

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

          table_purchase_order.ajax.reload(null, false);

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