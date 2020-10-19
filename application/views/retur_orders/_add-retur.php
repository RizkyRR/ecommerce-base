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

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="" method="POST" enctype="multipart/form-data">
        <div class="box-body">

          <div class="row">
            <div class="col-md-7">

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="id">Retur ID</label>
                    <input type="text" class="form-control" name="id" id="id">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="retur_date">Retur date</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" class="form-control" name="retur_date" id="retur_date" value="<?php echo set_value('retur_date'); ?>" readonly>
                    </div>
                    <span class="help-block"><?php echo form_error('retur_date') ?></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="order_id">Order ID</label>
                <select name="order_id" id="order_id" class="form-control select-order" onchange="getOrderData(); show_data_product()" required>
                </select>
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

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_bankname">Bank name</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-university"></i>
                      </span>
                      <input type="text" class="form-control" name="c_bankname" id="c_bankname" placeholder="Enter customer bank name" readonly>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_norek">No. rek</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-credit-card"></i>
                      </span>
                      <input type="text" class="form-control" name="c_norek" id="c_norek" placeholder="Enter customer nomor rekening" readonly>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="c_address">Customer address</label>
                <textarea class="form-control" name="c_address" id="c_address" cols="10" placeholder="Enter customer address" readonly></textarea>
              </div>

            </div>
          </div>

          <!-- For Table -->
          <div class="box-body table-responsive">
            <table class="table table-bordered" id="product_info_table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="width:40%">Product</th>
                  <th style="width:10%">Quantity</th>
                  <th style="width:20%">Unit Price (Rp.)</th>
                  <th style="width:20%">Amount</th>
                  <th style="width:10%">
                    <button type="button" id="add_row" class="btn btn-primary btn-xs"> <i class="fa fa-plus"></i></i> </button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr id="row_1">
                  <td>
                    <select name="product[]" id="product_1" class="form-control select_group product" data-row-id="row_1" style="width: 100%;" onchange="getProductData(1)" required>
                    </select>
                  </td>
                  <td>
                    <input type="text" name="qty[]" id="qty_1" class="form-control" required onkeyup="getTotal(1); numberFormat(this)">
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
                  </div>
                  <span class="help-block"><?php echo form_error('gross_amount') ?></span>
                </div>
              </div>

              <div class="form-group">
                <label for="discount" class="col-sm-5 control-label">Discount</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount..." onkeyup="subAmount()" autocomplete="off" value="<?php echo set_value('discount'); ?>">
                    <span class="input-group-addon">
                      <i class="fa fa-percent"></i>
                    </span>
                  </div>
                  <span class="help-block"><?php echo form_error('discount') ?></span>
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
          <input type="submit" name="save" value="Submit" class="btn btn-primary">
        </div>
      </form>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  create_code();
  show_data_product();
  show_data_order();

  $(document).ready(function() {
    // FOR TABLE NEW ORDER
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    // Add new row in the table
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
        url: '<?php echo base_url(); ?>' + 'order/getTableProductRow/',
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {

          // console.log(reponse.x);
          var html = '<tr id="row_' + row_id + '">' +
            '<td>' +
            '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
            '<option value=""></option>';
          $.each(response, function(index, value) {
            html += '<option value="' + value.id + '">' + value.product_name + '</option>';
          });

          html += '</select>' +
            '</td>' +
            '<td><input type="text" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + '); numberFormat()"></td>' +

            '<td><div class="input-group"><span class="input-group-addon">Rp</span><input type="text" name="price[]" id="price_' + row_id + '" class="form-control" disabled></div><input type="hidden" name="price_value[]" id="price_value_' + row_id + '" class="form-control"></div></td>' +

            '<td><div class="input-group"><span class="input-group-addon">Rp</span><input type="text" name="amount[]" id="amount_' + row_id + '" class="form-control" disabled></div><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></div></td>' +

            '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-times"></i></button></td>' +
            '</tr>';

          if (count_table_tbody_tr >= 1) {
            $("#product_info_table tbody tr:last").after(html);
          } else {
            $("#product_info_table tbody").html(html);
          }

          $(".select_group").select2();

        }
      });

      return false;
    });
    // FOR TABLE NEW ORDER

    $('#retur_date').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    })
  });

  function show_data_order() {
    $('.select-order').select2();
    $.ajax({
      url: "<?php echo base_url(); ?>order_retur/getCustomerOrder",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].id + '">' + data[i].id + '</option>';
        }
        $('.select-order').html(html);
      }
    })
  }

  function getOrderData() {
    var order_id = $("#order_id").val();
    if (order_id == "") {
      $("#c_name").val("");
      $("#c_phone").val("");
      $("#c_bankname").val("");
      $("#c_norek").val("");
      $("#c_address").val("");

    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>order_retur/getOrderValueById',
        type: 'POST',
        data: {
          order_id: order_id
        },
        dataType: 'JSON',
        success: function(data) {
          // setting the price value into the price input field
          $("#c_name").val(data.customer_name);
          $("#c_phone").val(data.customer_phone);
          $("#c_bankname").val(data.bank_name);
          $("#c_norek").val(data.no_rek);
          $("#c_address").val(data.customer_address);
        } // /success
      }); // /ajax function to fetch the order data
      return false;
    }
  }

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  function getTotal(row = null) {
    if (row) {
      var total = Number($("#price_" + row).val()) * Number($("#qty_" + row).val());
      total = total.toFixed();
      $("#amount_" + row).val(total);
      $("#amount_value_" + row).val(total);

      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }

  // get the product information from the server
  function getProductData(row_id) {
    var product_id = $("#product_" + row_id).val();
    if (product_id == "") {
      $("#price_" + row_id).val("");
      $("#price_value_" + row_id).val("");

      $("#qty_" + row_id).val("");

      $("#amount_" + row_id).val("");
      $("#amount_value_" + row_id).val("");

    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>' + 'order/getProductValueById',
        type: 'POST',
        data: {
          product_id: product_id
        },
        dataType: 'JSON',
        success: function(response) {
          // setting the price value into the price input field

          $("#price_" + row_id).val(response.price);
          $("#price_value_" + row_id).val(response.price);

          $("#qty_" + row_id).val(1);
          $("#qty_value_" + row_id).val(1);

          var total = Number(response.price) * 1;
          total = total.toFixed();
          $("#amount_" + row_id).val(total);
          $("#amount_value_" + row_id).val(total);

          subAmount();
        } // /success
      }); // /ajax function to fetch the product data
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

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed();

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    // vat
    var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
    vat = vat.toFixed();
    $("#vat_charge").val(vat);
    $("#vat_charge_value").val(vat);

    // service
    var service = (Number($("#gross_amount").val()) / 100) * service_charge;
    service = service.toFixed();
    $("#service_charge").val(service);
    $("#service_charge_value").val(service);

    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
    totalAmount = totalAmount.toFixed();

    var discount = Number($("#discount").val());
    if (discount) {
      // own condition
      var getDiscount = Number(totalAmount) * (discount / 100);
      var grandTotal = Number(totalAmount) - getDiscount;

      // var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed();
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);

    } // /else discount

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('order_retur/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id').val(data).prop("readonly", true);
      }
    })
  }

  function show_data_product() {
    var order_id = $('#order_id').val();

    $.ajax({
      url: "<?php echo base_url(); ?>order_retur/getTableProductRow",
      type: 'POST',
      data: {
        order_id: order_id
      },
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].product_id + '">' + data[i].product_name + '</option>';
        }
        $('.select_group').html(html);
      }
    })
  }
</script>