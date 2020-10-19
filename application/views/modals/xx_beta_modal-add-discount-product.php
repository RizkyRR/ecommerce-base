<div class="modal fade modal-discount-product" id="modal-add-discount-product">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Role Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form" action="" method="post" enctype="multipart/form-data">
          <div class="box-body">

            <div class="form-group">
              <label for="product">Select product *</label>
              <input type="hidden" class="form-control" name="id" id="id" readonly>
              <input type="hidden" class="form-control" name="product_id" id="product_id" readonly>
              <select style="width: 100%;" class="form-control select-product" name="product" id="product" onchange="getLatestProductPrice()" required>
              </select>
              <span id="msg_product_error" class="help-block"></span>
            </div>

            <div class="form-group">
              <label for="l_price">Latest price</label>
              <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <input type="text" class="form-control" name="l_price" id="l_price" readonly>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="s_discount">Set discount *</label>
                  <div class="input-group">
                    <input type="text" class="form-control" name="s_discount" id="s_discount" placeholder="Enter discount" onkeyup="numberFormat(this); subAmount()" required>

                    <input type="hidden" class="form-control" id="s_discount_value" name="s_discount_value" readonly>
                    <span class="input-group-addon">
                      <i class="fa fa-percent"></i>
                    </span>
                  </div>
                  <span id="msg_discount_error" class="help-block"></span>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="d_price">Discount price</label>
                  <div class="input-group">
                    <span class="input-group-addon">Rp</span>
                    <input type="text" class="form-control" name="d_price" id="d_price" readonly>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="start_date">Start date</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control datepicker" name="start_date" id="start_date" placeholder="yyyy-mm-dd" required readonly>
                  </div>
                  <span id="msg_startdate_error" class="help-block"></span>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="end_date">End date</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control datepicker" name="end_date" id="end_date" placeholder="yyyy-mm-dd" required readonly>
                  </div>
                  <span id="msg_enddate_error" class="help-block"></span>
                </div>
              </div>
            </div>

          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnSave" onclick="saveDiscount()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->