<div class="modal fade" id="modal-order">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="id">Order ID</label>
                <input type="text" class="form-control" name="id" id="id" readonly>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="order_date">Order date</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text" class="form-control" name="order_date" id="order_date">
                </div>
                <span id="msg_date_error" class="help-block"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="c_name">Customer name</label>
                <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Enter customer name">
                <span id="msg_name_error" class="help-block"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="c_phone">Customer phone</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </span>
                  <input type="text" class="form-control" name="c_phone" id="c_phone" placeholder="Enter customer phone">
                </div>
                <span id="msg_phone_error" class="help-block"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="c_address">Customer address</label>
            <textarea class="form-control" name="c_address" id="c_address" cols="10" placeholder="Enter customer address"></textarea>
            <span id="msg_address_error" class="help-block"></span>
          </div>

          <!-- For Table -->
          <div class="table-responsive">
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
            <div class="col-md-6 col-xs-12 pull pull-right">
              <div class="form-group">
                <label for="gross_amount" class="col-sm-5 control-label">Gross amount</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                  <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                </div>
                <span id="msg_gross_amount_error" class="help-block"></span>
              </div>

              <?php if ($is_service_enabled == true) : ?>
                <div class="form-group">
                  <label for="service_charge" class="col-sm-5 control-label">Service charge <?php echo $company_data['service_charge_value'] ?> %</label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="service_charge" name="service_charge" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="service_charge_value" name="service_charge_value" autocomplete="off">
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($is_vat_enabled == true) : ?>
                <div class="form-group">
                  <label for="vat_charge" class="col-sm-5 control-label">Value added tax <?php echo $company_data['vat_charge_value'] ?> %</label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled autocomplete="off">
                    <input type="hidden" class="form-control" id="vat_charge_value" name="vat_charge_value" autocomplete="off">
                  </div>
                </div>
              <?php endif; ?>

              <div class="form-group">
                <label for="discount" class="col-sm-5 control-label">Discount</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="discount" name="discount" placeholder="Discount..." onkeyup="subAmount()" autocomplete="off">
                  <span class="input-group-addon">
                    <i class="fa fa-percent"></i>
                  </span>
                </div>
                <span id="msg_discount_error" class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="net_amount" class="col-sm-5 control-label">Net Amount</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" id="net_amount" name="net_amount" disabled autocomplete="off">
                  <input type="hidden" class="form-control" id="net_amount_value" name="net_amount_value" autocomplete="off">
                </div>
              </div>

              <div class="form-group">
                <label for="amount_paid" class="col-sm-5 control-label">Amount paid</label>
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" id="amount_paid" name="amount_paid" placeholder="Amount paid..." onkeyup="numberFormat(this)">
                </div>
                <span id="msg_amount_paid_error" class="help-block"></span>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->