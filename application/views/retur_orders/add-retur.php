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
          <h4><i class="fa fa-bullhorn"></i> Attention.</h4>

          <p>Once you do a retur order, you cannot edit and delete it. Please be careful when entering into input fields. !</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="<?php echo base_url() ?>order_retur/insertDataRetur" method="POST" id="form-add-order-return" enctype="multipart/form-data">
        <div class="box-body">

          <div class="row">
            <div class="col-md-7">

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="invoice_return">Invoice Return</label>
                    <input type="text" class="form-control" name="invoice_return" id="invoice_return" readonly>
                    <input type="hidden" class="form-control" name="id_return" id="id_return" readonly>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="date_return">Date Return*</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" class="form-control" name="date_return" id="date_return" value="<?php echo set_value('date_return'); ?>" readonly>
                    </div>
                    <span class="help-block"><?php echo form_error('date_return') ?></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="invoice_order">Invoice Order*</label>
                <select name="invoice_order" id="invoice_order" class="form-control select-invoice-order" onchange="getCustomerOrderData()" required>
                </select>

                <input type="hidden" name="invoice_order_val" id="invoice_order_val" readonly>

                <span class="help-block"></span>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_name">Customer name</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </span>
                      <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Enter customer name" readonly>
                      <input type="hidden" class="form-control" name="c_email" id="c_email" readonly>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_phone">Customer phone</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </span>
                      <input type="text" class="form-control" name="c_phone" id="c_phone" placeholder="Enter customer phone" readonly>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="c_address">Customer address</label>
                <textarea class="form-control" name="c_address" id="c_address" cols="10" placeholder="Enter customer address" readonly></textarea>
                <input type="hidden" name="company_city_id" id="company_city_id" value="<?php echo $company_address['city_id'] ?>" readonly>
                <input type="hidden" name="customer_city_id" id="customer_city_id" readonly>
              </div>

            </div>
          </div>

          <!-- For Table -->
          <div class="box-body table-responsive">
            <table class="table table-bordered" id="product_info_table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width:20%">Product*</th>
                  <th style="width:30%">Keterangan Retur Product</th>
                  <th style="width:10%">Quantity*</th>
                  <th style="width:15%">Unit Price (Rp.)</th>
                  <th style="width:15%">Amount</th>
                  <th style="width:10%">
                    <button type="button" id="add_row" class="btn btn-primary btn-xs"> <i class="fa fa-plus"></i></i> </button>
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr id="row_1">
                  <td>
                    <select name="product[]" id="product_1" class="form-control select_product product" data-row-id="row_1" style="width: 100%;" onchange="getProductData(1); countWeightTotal()" required>
                    </select>

                    <span class="help-block"></span>
                  </td>

                  <td>
                    <input type="text" name="description[]" id="description_1" placeholder="Enter description..." class="form-control">
                  </td>

                  <td>
                    <input type="text" name="qty[]" id="qty_1" class="form-control" placeholder="Enter quantity..." required onkeyup="numberFormat(this); getOrderValidityQty(1); getTotal(1)">
                    <input type="hidden" name="weight_val[]" id="weight_val_1" readonly>
                  </td>

                  <td>
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" name="price[]" id="price_1" class="form-control" disabled autocomplete="off">
                      <input type="hidden" name="price_value[]" id="price_value_1" class="form-control" autocomplete="off">
                    </div>
                  </td>

                  <td>
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" name="amount[]" id="amount_1" class="form-control" disabled autocomplete="off">
                      <input type="hidden" name="amount_value[]" id="amount_value_1" class="form-control" autocomplete="off">
                    </div>
                  </td>

                  <td>
                    <button type="button" class="btn btn-danger btn-xs" onclick="removeRow('1')"><i class="fa fa-times"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- For Table -->

          <div class="row">
            <div class="col-md-6 col-xs-12 pull pull-left">
              <div class="form-group">
                <label for="gross_amount" class="col-sm-5 control-label">Gross amount</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">

                    <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                    <input type="hidden" name="weight_val_total" id="weight_val_total" readonly>
                  </div>

                  <span class="help-block"><?php echo form_error('gross_amount') ?></span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-5 control-label" for="courier">Courier*</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-truck" aria-hidden="true"></i></span>
                    <select class="form-control select-courier" style="width: 100%;" name="courier" id="courier" required>
                      <option value="">Select Courier</option>
                      <option value="jne">JNE (Jalur Nugraha Ekakurir)</option>
                      <option value="pos">Pos (Pos Indonesia)</option>
                      <option value="tiki">TIKI (Titipan Kilat)</option>
                    </select>
                  </div>

                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-5 control-label" for="service">Service*</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-info" aria-hidden="true"></i></span>
                    <select class="form-control select-courier" name="service" id="service" style="width: 100%;" required>
                    </select>
                  </div>

                  <input type="hidden" name="service_val" id="service_val" readonly>
                  <input type="hidden" name="etd_val" id="etd_val" readonly>
                  <input type="hidden" name="cost_val" id="cost_val" readonly>

                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-5 control-label" for="estimate">Estimated Date</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" nama="estimate" id="estimate" readonly>
                  </div>

                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group">
                <label for="shipping_cost" class="col-sm-5 control-label">Shipping Cost</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="shipping-cost-val" name="shipping_cost" readonly>
                  </div>

                  <span class="help-block"></span>
                </div>
              </div>

              <div class="form-group">
                <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="net_amount" name="net_amount" readonly>
                    <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                  </div>

                  <span class="help-block"><?php echo form_error('net_amount') ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /.box-body -->
        <div class="box-footer">
          <a href="<?php echo base_url(); ?>order_retur" class="btn btn-default">Back</a>
          <input type="submit" class="btn btn-primary" name="save" id="submitFile" value="Submit">
        </div>
      </form>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    // FOR TABLE NEW ORDER
    $(".select_product").select2({
      placeholder: 'Select for a product',
      allowClear: true
    });

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    // var row_id = 1;
    // Add new row in the table
    $("#add_row").unbind('click').bind('click', function() {
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;

      for (x = 0; x < count_table_tbody_tr; x++) {
        var tr = $("#product_info_table tbody tr")[x];
        var count = $(tr).attr('id');
        count = parseInt(count.substring(4));
      } // for

      row_id = count + 1;

      // row_id++;
      var invoice_order = $("#invoice_order").val();

      $.ajax({
        url: '<?php echo base_url(); ?>' + 'order_retur/getCustomerOrderProduct',
        type: 'POST',
        data: {
          invoice_order: invoice_order
        },
        dataType: 'JSON',
        success: function(response) {

          // console.log(reponse.x);
          var html = '<tr id="row_' + row_id + '">' +
            '<td>' +
            '<select class="form-control select_product product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + '); countWeightTotal()">' +
            '<option value=""></option>';
          $.each(response, function(index, value) {
            html += '<option value="' + value.id_product + '">' + value.product_name + '</option>';
          });

          html += '</select>' +
            '</td>' +
            '<td><input type="text" class="form-control" name="description[]" id="description_' + row_id + '" placeholder="Enter description..."></td>' +

            '<td><input type="text" class="form-control" name="qty[]" id="qty_' + row_id + '" placeholder="Enter quantity..." onkeyup="numberFormat(this); getOrderValidityQty(' + row_id + '); getTotal(' + row_id + ')"><input type="hidden" name="weight_val[]" id="weight_val_' + row_id + '" readonly><span class="help-block"></span></td>' +

            '<td><div class="input-group"><span class="input-group-addon">Rp</span><input type="text" name="price[]" id="price_' + row_id + '" class="form-control" disabled></div><input type="hidden" name="price_value[]" id="price_value_' + row_id + '" class="form-control"></div></td>' +

            '<td><div class="input-group"><span class="input-group-addon">Rp</span><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled></div><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></div></td>' +

            '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-times"></i></button></td>' +
            '</tr>';

          if (count_table_tbody_tr >= 1) {
            $("#product_info_table tbody tr:last").after(html);
          } else {
            $("#product_info_table tbody").html(html);
          }

          $(".select_product").select2({
            placeholder: 'Select for a product',
            allowClear: true
          });
        }
      });

      return false;
    });
    // FOR TABLE NEW ORDER

    /* $('#date_return').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    }).val();

    let today = new Date().toISOString().replace(/T/, ' ').replace(/\..+/, '');
    $('#date_return').val(today); */

    /* SELECT INVOICE ORDER START */
    $(".select-invoice-order").select2({
      ajax: {
        url: "<?php echo base_url(); ?>order_retur/getCustomerPurchaseOrder",
        type: "POST",
        dataType: 'JSON',
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
      placeholder: 'Select for a invoice order',
    });
    /* SELECT INVOICE ORDER END */

    /* START SHOW PRODUCT IN ORDER AFTER TRIGGER SELECT_INVOICE_ORDER */
    $('.select-invoice-order').on('change', function() {
      var invoice_order = $(".select-invoice-order option:selected").val();
      var invoice_order_val = $(".select-invoice-order option:selected").text();

      $('#invoice_order_val').val(invoice_order);

      $('.select_product').empty();
      $(this).valid();

      if (invoice_order != null && invoice_order != 0) {
        $.ajax({
          url: "<?php echo base_url(); ?>order_retur/getCustomerOrderProduct",
          type: 'POST',
          data: {
            invoice_order: invoice_order
          },
          dataType: 'JSON',
          success: function(data) {
            var html = '<option value=""></option>';
            var i;

            for (i = 0; i < data.length; i++) {
              html += '<option value="' + data[i].id_product + '">' + data[i].product_name + '</option>';
            }

            $('.select_product').html(html);
          }
        })
      }
    });

    // Untuk menghilangkan pesan validasi jika sudah terisi
    $('.select_product').on('change', function() {
      $(this).valid();

      var product_name = $(".select_product option:selected").text();
      $('#regency_name').val(product_name);

      countWeightTotal();
    });
    /* END SHOW PRODUCT IN ORDER AFTER TRIGGER SELECT_INVOICE_ORDER */
  });

  create_code();

  function removeRow(tr_id) {
    // $("#product_info_table tbody tr#row_" + tr_id).remove();

    var count_table_tbody_tr = $("#product_info_table tbody tr").length;

    if (count_table_tbody_tr > 1) {
      $("#product_info_table tbody tr#row_" + tr_id).remove();
    }

    countWeightTotal();
    subAmount();
  }

  /* VALIDATOR START */
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

  var $validator = $("#form-add-order-return").validate({
    rules: {
      invoice_order: {
        required: true
      },
      date_return: {
        required: true
      },
      product: {
        required: true
      },
      qty: {
        required: true
      },
      courier: {
        required: true
      },
      service: {
        required: true
      }
    }
  });
  /* VALIDATOR END */

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  // AUTOMATIC CREATE CODE INVOICE RETURN
  function create_code() {
    $.ajax({
      url: '<?php echo base_url('order_retur/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#invoice_return').val(data.order_return_invoice);
        $('#id_return').val(data.order_return_id);
        $('#date_return').val(data.order_return_datetime);
      }
    })
  }

  // GET DATA CUSTOMER ORDER
  function getCustomerOrderData() {
    var invoice_order = $("#invoice_order").val();

    if (invoice_order == "") {
      $("#c_name").val("");
      $("#c_email").val("");
      $("#c_phone").val("");
      $("#c_address").val("");
      $("#customer_city_id").val("");
    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>order_retur/getCustomerPurchaseOrderByID',
        type: 'POST',
        data: {
          invoice_order: invoice_order
        },
        dataType: 'JSON',
        success: function(data) {
          // setting the price value into the price input field
          $("#c_name").val(data.customer_name);
          $("#c_email").val(data.customer_email);
          $("#c_phone").val(data.customer_phone);

          var address = data.street_name + ',' + data.city_name + ',' + data.province;
          $("#c_address").val(address);
          $("#customer_city_id").val(data.city_id);
        }
      });
      return false;
    }
  }

  // GET PRODUCT DATA FROM ORDER CUSTOMER
  function getProductData(row_id) {
    var product_id = $("#product_" + row_id).val();

    if (product_id == "") {
      $("#price_" + row_id).val("");
      $("#price_value_" + row_id).val("");

      $("#qty_" + row_id).val("");
      $("#weight_val_" + row_id).val("");

      $("#amount_" + row_id).val("");
      $("#amount_value_" + row_id).val("");

      $("#gross_amount_" + row_id).val("");
      $("#gross_amount_value_" + row_id).val("");

      $("#net_amount_" + row_id).val("");
      $("#net_amount_value_" + row_id).val("");

      countWeightTotal();
      subAmount();
    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>' + 'order_retur/getProductDetailValueCustomerOrder', //samakan yang ada di details order
        type: 'POST',
        data: {
          product_id: product_id
        },
        dataType: 'JSON',
        success: function(response) {
          // setting the price value into the price input field

          $("#price_" + row_id).val(response.unit_price);
          $("#price_value_" + row_id).val(response.unit_price);

          $("#qty_" + row_id).val(1);
          $("#qty_value_" + row_id).val(1);
          $("#weight_val_" + row_id).val(response.weight_order);

          var total = Number(response.unit_price) * 1;
          total = total.toFixed();
          $("#amount_" + row_id).val(total);
          $("#amount_value_" + row_id).val(total);

          countWeightTotal();
          subAmount();
        } // /success
      }); // /ajax function to fetch the product data
    }
  }

  // CHECK QTY INPUT
  function getOrderValidityQty(row = null) {
    var qty = $("#qty_" + row).val();

    if (qty != 0) {
      if (row) {
        $.ajax({
          url: "<?php echo base_url(); ?>order_retur/getOrderValidityQty",
          data: {
            invoice_order: $("#invoice_order").val(),
            product_id: $("#product_" + row).val(),
            qty: qty,
          },
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == "true") {
              console.log(true);
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });

              // $("#amount_" + row).text(price_val);
              // $("#amount_val_" + row).val(price_val);
              $("#qty_" + row).val(1);

              getTotal(row);
              subAmount();
            }
          },
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "No row, please refresh the page!",
          showConfirmButton: false,
          timer: 5000,
        });
      }
    } else {
      Swal.fire({
        icon: "error",
        title: "Sorry, for the minimum quantity retur is 1!",
        showConfirmButton: false,
        timer: 5000,
      });

      $("#qty_" + row).val(1);
    }
  }

  // USING COURIER FOR SHIPPING START
  function countWeightTotal() {
    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalWeight = 0;

    for (x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalWeight = Number(totalWeight) + Number($("#weight_val_" + count).val());
    } // /for

    totalWeight = totalWeight.toFixed();

    $('#weight_val_total').val(totalWeight);
  }

  $("#courier").on("change", function() {
    var courier_id = $("#courier option:selected").val();
    var origin_id = $("#company_city_id").val();
    var destination_id = $("#customer_city_id").val();
    var weight_val = $("#weight_val_total").val();
    $(this).valid();

    if (courier_id != null && courier_id != 0) {
      $.ajax({
        url: "<?php echo base_url(); ?>order_retur/getCostShippingRajaOngkir",
        type: "GET",
        data: {
          origin: origin_id,
          destination: destination_id,
          weight: weight_val,
          courier: courier_id,
        },
        dataType: "JSON",
        success: function(data) {
          console.log(data);

          var result = data[0].costs;
          var html = '<option value="">Select Service</option>';
          var i;

          for (i = 0; i < result.length; i++) {
            var text = result[i].description + " (" + result[i].service + ")";
            html +=
              '<option value="' +
              result[i].cost[0].value +
              '" etd="' +
              result[i].cost[0].etd +
              '">' +
              text +
              "</option>";
          }

          $("#service").html(html);
        },
      });
    } else {
      $("#service").html([]);
      $("#service").val([]).trigger("change");
      // $("#service").val([]);
      // $('#estimate').val('');
    }
  });

  var ongkir = 0;

  $("#service").on("change", function() {
    var estimate = $("#service option:selected").attr("etd");
    var service_val = $("#service option:selected").text();
    ongkir = parseInt($(this).val());

    if ($(this).val() != null && $(this).val() != 0) {
      $("#estimate").val(estimate).prop("readonly", true);

      $("#service_val").val(service_val).prop("readonly", true);
      $("#etd_val").val(estimate).prop("readonly", true);
      $("#cost_val").val(ongkir).prop("readonly", true);

      $("#shipping-cost-val").val(ongkir);
    } else {
      $("#estimate").val("").prop("readonly", true);

      $("#service_val").val("").prop("readonly", true);
      $("#etd_val").val("").prop("readonly", true);
      $("#cost_val").val(0).prop("readonly", true);

      $("#shipping-cost-val").val(0);
    }

    subAmount();
  });
  // USING COURIER FOR SHIPPING END

  function getTotal(row = null) {
    if (row) {
      var total = Number($("#price_" + row).val()) * Number($("#qty_" + row).val());
      total = total.toFixed();
      $("#amount_" + row).val(total);
      $("#amount_value_" + row).val(total);

      subAmount();

    } else {
      Swal.fire({
        icon: "error",
        title: 'No row!! please refresh the page',
        showConfirmButton: false,
        timer: 5000,
      });
    }
  }

  // calculate the total amount of the order
  function subAmount() {
    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;

    for (x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = parseInt(totalSubAmount) + parseInt($("#amount_" + count).val());
    } // /for

    totalSubAmount = parseInt(totalSubAmount);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    var shipping_cost = parseInt($("#cost_val").val());

    if (shipping_cost) {
      var grandTotal = parseInt(totalSubAmount + shipping_cost);

      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalSubAmount);
      $("#net_amount_value").val(totalSubAmount);
    }
  }

  // SUBMIT ORDER INTO THE SERVER 
  $('#submitFile').click(function() {
    $('#submitFile').text('Submitting...'); //change button text
    $('#submitFile').attr('disabled', true); //set button disable 

    var $valid = $("#form-add-order-return").valid();

    if (!$valid) {
      $("#submitFile").text("Submit"); //change button text
      $("#submitFile").attr("disabled", false); //set button enable
      return false;
    } else {
      $('#submitFile').text('Submit'); //change button text
      $('#submitFile').attr('disabled', false); //set button enable 
    }
  });
</script>