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
                    <label for="id">Purchase ID</label>
                    <input type="text" class="form-control" name="id" id="id">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="order_date">Purchase date</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </span>
                      <input type="text" class="form-control" name="purchase_date" id="purchase_date" value="<?php echo set_value('purchase_date'); ?>" readonly>
                    </div>
                    <span class="help-block"><?php echo form_error('purchase_date') ?></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="noref">Nomor ref.</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-info"></i>
                  </span>
                  <input type="text" class="form-control" name="noref" id="noref" placeholder="Enter purchase nomor reference" value="<?php echo set_value('noref'); ?>">
                </div>
                <p><i style="color: #00c0ef" class="fa fa-info-circle"></i> Leave empty if it isn't available.</p>
                <span class="help-block"><?php echo form_error('noref'); ?></span>
              </div>

              <div class="form-group">
                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" class="form-control select-supplier" onchange="getSupplierData(); show_data_product()" required>
                </select>
              </div>

              <div class="form-group">
                <label for="phone">Supplier phone</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </span>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter supplier phone" value="<?php echo set_value('phone'); ?>" readonly>
                </div>
                <span class="help-block"><?php echo form_error('phone') ?></span>
              </div>

              <div class="form-group">
                <label for="address">Supplier address</label>
                <textarea class="form-control" name="address" id="address" cols="10" placeholder="Enter supplier address" readonly><?php echo set_value('address'); ?></textarea>
                <span class="help-block"><?php echo form_error('address') ?></span>
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
                      <input type="text" name="price[]" id="price_1" class="form-control" autocomplete="off" onkeyup="numberFormat(this); getTotal(1)">
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

              <div class="form-group">
                <label for="tax_charge" class="col-sm-5 control-label">Tax</label>
                <div class="col-sm-6">
                  <div class="input-group">
                    <input type="text" class="form-control" id="tax_charge" name="tax_charge" placeholder="Tax..." onkeyup="numberFormat(this); subAmount()" autocomplete="off" value="<?php echo set_value('tax_charge'); ?>">

                    <input type="hidden" class="form-control" id="tax_amount_charge" name="tax_amount_charge">
                    <span class="input-group-addon">
                      <i class="fa fa-percent"></i>
                    </span>
                  </div>
                  <span class="help-block"><?php echo form_error('tax_charge') ?></span>
                </div>
              </div>

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
                    <input type="text" class="form-control" id="amount_paid" name="amount_paid" placeholder="Amount paid..." onkeyup="numberFormat(this); amountPaid()" value="<?php echo set_value('amount_paid'); ?>">
                  </div>
                  <span id="msg_amountpaid_error" class="help-block"></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /.box-body -->

        <div class="box-footer">
          <a href="<?php echo base_url(); ?>purchase" class="btn btn-default">Back</a>
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
  show_data_supplier();

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
      var supplier_id = $('#supplier').val();

      $.ajax({
        url: '<?php echo base_url(); ?>' + 'purchase/getTableProductRow/',
        type: 'POST',
        data: {
          supplier_id: supplier_id
        },
        dataType: 'JSON',
        success: function(response) {

          // console.log(reponse.x);
          var html = '<tr id="row_' + row_id + '">' +
            '<td>' +
            '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
            '<option value=""></option>';
          $.each(response, function(index, value) {
            html += '<option value="' + value.product_id + '">' + value.product_name + '</option>';
          });

          html += '</select>' +
            '</td>' +
            '<td><input type="text" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="numberFormat(this); getTotal(' + row_id + ')"></td>' +

            '<td><div class="input-group"><span class="input-group-addon">Rp</span><input type="text" name="price[]" id="price_' + row_id + '" class="form-control" onkeyup="numberFormat(this); getTotal(' + row_id + ')" required autocomplete="off"></div></div></td>' +

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

    $('#purchase_date').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    })
  });

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('purchase/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id').val(data).prop("readonly", true);
      }
    })
  }

  function show_data_supplier() {
    $('.select-supplier').select2();
    $.ajax({
      url: "<?php echo base_url(); ?>purchase/getSupplier",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id + '">' + data[i].supplier_name + '</option>';
        }
        $('.select-supplier').html(html);
      }
    })
  }

  function getSupplierData() {
    var supplier_id = $("#supplier").val();

    if (supplier_id == "") {
      $("#phone").val("");
      $("#address").val("");

    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>purchase/getSupplierValueById',
        type: 'POST',
        data: {
          supplier_id: supplier_id
        },
        dataType: 'JSON',
        success: function(data) {
          // setting the price value into the price input field
          $("#phone").val(data.supplier_phone);
          $("#address").val(data.supplier_address);
        } // /success
      }); // /ajax function to fetch the order data
      return false;
    }
  }

  function show_data_product() {
    var supplier_id = $('#supplier').val();

    $.ajax({
      url: "<?php echo base_url(); ?>purchase/getTableProductRow",
      type: 'POST',
      data: {
        supplier_id: supplier_id
      },
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].product_id + '">' + data[i].product_name + '</option>';
        }
        $('.select_group').html(html);
      }
    })
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
        url: '<?php echo base_url(); ?>' + 'purchase/getProductValueById',
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

  function amountPaid() {
    var net_amount = Number($("#net_amount_value").val());
    var amount_paid = Number($("#amount_paid").val());

    if (net_amount < amount_paid) {
      $("#msg_amountpaid_error").parent().parent().addClass('has-error');
      $("#msg_amountpaid_error").html('Jumlah uang yang akan dibayar terlalu banyak !');
    } else {
      $("#msg_amountpaid_error").parent().parent().removeClass('has-error');
      $("#msg_amountpaid_error").next().empty();
      $("#msg_amountpaid_error").html('');
    }
  }

  // calculate the total amount of the order
  function subAmount() {
    var tax_charge = Number($("#tax_charge").val());
    var discount = Number($("#discount").val());
    var ship_amount = Number($("#ship_amount").val());
    var grandTotalSubAmount = 0;

    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    for (x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);

      totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
    } // /for

    // totalSubAmount = totalSubAmount.toFixed();
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    if (ship_amount) {
      grandTotalSubAmount = totalSubAmount + ship_amount;
      grandTotalSubAmount = grandTotalSubAmount.toFixed();
      Number($("#net_amount").val(grandTotalSubAmount));
      Number($("#net_amount_value").val(grandTotalSubAmount));
    } else {
      grandTotalSubAmount = totalSubAmount.toFixed();
      Number($("#net_amount").val(grandTotalSubAmount));
      Number($("#net_amount_value").val(grandTotalSubAmount));
    }
    // totalSubAmount = totalSubAmount.toFixed();

    var commonTax = (Number(grandTotalSubAmount) / 100) * tax_charge;

    // tax and discount conditions
    if (tax_charge && discount) {
      var setDiscount = Number(grandTotalSubAmount) * (discount / 100);
      var getDiscount = Number(grandTotalSubAmount) - setDiscount;

      var getTax = (tax_charge / 100);
      var setTax = getTax * getDiscount;

      // https://blog.ruangguru.com/cara-menghitung-pajak-dan-diskon
      // cara menghitung pajak dan diskon

      var grandTotal = getDiscount + setTax;
      grandTotal = grandTotal.toFixed();

      Number($('#tax_amount_charge').val(commonTax));
      Number($('#after_discount').val(setDiscount));

      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);

      /* var tax = (Number(totalSubAmount) / 100) * tax_charge;
      tax = tax.toFixed();
      var totalAmount = (Number(totalSubAmount) + Number(tax));
      totalAmount = totalAmount.toFixed();

      var grandTotal = Number(totalAmount) - discount;
      grandTotal = grandTotal.toFixed();
      $("#net_amount").val(grandTotal); */

    } else if (tax_charge) {
      // tax = tax.toFixed();
      var totalAmount = (Number(grandTotalSubAmount) + Number(commonTax));
      totalAmount = totalAmount.toFixed();

      Number($('#tax_amount_charge').val(commonTax));

      Number($('#after_discount').val(""));
      $('#after_discount').removeAttr('value');

      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);
    } else if (discount) {
      var getDiscount = Number(grandTotalSubAmount) * (discount / 100);
      var grandTotal = Number(grandTotalSubAmount) - getDiscount;
      grandTotal = grandTotal.toFixed();

      Number($('#tax_amount_charge').val(""));
      $('#tax_amount_charge').removeAttr('value');

      Number($('#after_discount').val(getDiscount));

      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      Number($('#tax_amount_charge').val(""));
      $('#tax_amount_charge').removeAttr('value');

      Number($('#after_discount').val(""));
      $('#after_discount').removeAttr('value');

      $("#net_amount").val(grandTotalSubAmount);
      $("#net_amount_value").val(grandTotalSubAmount);
    }

  } // /sub total amount

  function removeRow(tr_id) {
    $("#product_info_table tbody tr#row_" + tr_id).remove();
    subAmount();
  }
</script>