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
                    <label for="id">Order ID</label>
                    <input type="text" class="form-control" name="id" id="id">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="order_date">Order date</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" class="form-control" name="order_date" id="order_date" value="<?php echo set_value('order_date'); ?>" readonly>
                    </div>
                    <span class="help-block"><?php echo form_error('order_date') ?></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_name">Customer name</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </span>
                      <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Enter customer name" value="<?php echo set_value('c_name'); ?>">
                    </div>
                    <span class="help-block"><?php echo form_error('c_name') ?></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_phone">Customer phone</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-phone"></i>
                      </span>
                      <input type="text" class="form-control" name="c_phone" id="c_phone" placeholder="Enter customer phone" value="<?php echo set_value('c_phone'); ?>">
                    </div>
                    <span class="help-block"><?php echo form_error('c_phone') ?></span>
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
                      <input type="text" class="form-control" name="c_bankname" id="c_bankname" placeholder="Enter customer bank name" value="<?php echo set_value('c_bankname'); ?>">
                    </div>
                    <span class="help-block"><?php echo form_error('c_bankname') ?></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="c_norek">No. rek</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-credit-card"></i>
                      </span>
                      <input type="text" class="form-control" name="c_norek" id="c_norek" placeholder="Enter customer nomor rekening" value="<?php echo set_value('c_norek'); ?>">
                    </div>
                    <span class="help-block"><?php echo form_error('c_norek') ?></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="c_address">Customer address</label>
                <textarea class="form-control" name="c_address" id="c_address" cols="10" placeholder="Enter customer address"><?php echo set_value('c_address'); ?></textarea>
                <span class="help-block"><?php echo form_error('c_address') ?></span>
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
                    <input type="text" name="qty[]" id="qty_1" class="form-control" required onkeyup="numberFormat(this); getTotal(1)">
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
                <label for="ship_amount" class="col-sm-5 control-label">Ship amount</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="ship_amount" name="ship_amount" onkeyup="numberFormat(this); subAmount()" placeholder="Ship amount..">
                  </div>
                  <span class="help-block"><?php echo form_error('ship_amount') ?></span>
                </div>
              </div>

              <?php if ($is_service_enabled == true) : ?>
                <div class="form-group">
                  <label for="service_charge" class="col-sm-5 control-label">Service charge <?php echo $company_data['service_charge_value'] ?> %</label>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" class="form-control" id="service_charge" name="service_charge" readonly>
                      <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                    </div>
                    <span class="help-block"><?php echo form_error('service_charge') ?></span>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($is_vat_enabled == true) : ?>
                <div class="form-group">
                  <label for="vat_charge" class="col-sm-5 control-label">Value added tax <?php echo $company_data['vat_charge_value'] ?> %</label>
                  <div class="col-sm-6">
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" readonly>
                      <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" autocomplete="off">
                    </div>
                    <span class="help-block"><?php echo form_error('vat_charge') ?></span>
                  </div>
                </div>
              <?php endif; ?>

              <div class="form-group">
                <label for="discount" class="col-sm-5 control-label">Discount</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount..." onkeyup="numberFormat(this); subAmount()" autocomplete="off" value="<?php echo set_value('discount'); ?>">

                    <input type="hidden" class="form-control" id="after_discount" name="after_discount">
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

              <div class="form-group">
                <label for="amount_paid" class="col-sm-5 control-label">Amount paid</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="amount_paid" name="amount_paid" placeholder="Amount paid..." onkeyup="numberFormat(this)" value="<?php echo set_value('amount_paid'); ?>">
                  </div>
                  <span class="help-block"><?php echo form_error('amount_paid') ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /.box-body -->

        <div class="box-footer">
          <a href="<?php echo base_url(); ?>order" class="btn btn-default">Back</a>
          <input type="hidden" class="form-control" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
          <input type="hidden" class="form-control" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
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
            '<option class="form-control" value=""></option>';
          $.each(response, function(index, value) {
            html += '<option class="form-control" value="' + value.id + '">' + value.product_name + '</option>';
          });

          html += '</select>' +
            '</td>' +
            '<td><input type="text" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="numberFormat(this); getTotal(' + row_id + ')"></td>' +

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

    $('#order_date').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    })
  });

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

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('order/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id').val(data).prop("readonly", true);
      }
    })
  }

  function show_data_product() {
    $.ajax({
      url: "<?php echo base_url(); ?>order/getTableProductRow",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id + '">' + data[i].product_name + '</option>';
        }
        $('.select_group').html(html);
      }
    })
  }

  // calculate the total amount of the order
  function subAmount() {
    var service_charge = "<?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value'] : 0; ?>";
    var vat_charge = "<?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value'] : 0; ?>";

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

    // total amount with ship amount
    var ship_amount = Number($("#ship_amount").val());
    ship_amount = ship_amount.toFixed();
    if (ship_amount) {
      var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service) + Number(ship_amount));
      totalAmount = totalAmount.toFixed();

      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
    } else {
      var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
      totalAmount = totalAmount.toFixed();

      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
    }

    var discount = Number($("#discount").val());
    if (discount) {
      // own condition
      var getDiscount = Number(totalAmount) * (discount / 100);
      var grandTotal = Number(totalAmount) - getDiscount;

      // var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed();

      Number($('#after_discount').val(getDiscount));

      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      Number($('#after_discount').val(""));
      $('#after_discount').removeAttr('value');

      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);

    } // /else discount

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }
</script>