<div class="modal fade" id="modal-order-edit">
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
                  <input type="text" class="form-control" name="order_date" id="order_date" readonly>
                </div>
                <span id="msg_date_error" class="help-block"></span>
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
                  <input type="text" class="form-control" name="c_name" id="c_name" placeholder="Enter customer name">
                </div>
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

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="c_bankname">Bank name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-university"></i>
                  </span>
                  <input type="text" class="form-control" name="c_bankname" id="c_bankname" placeholder="Enter customer bank name">
                </div>
                <span id="msg_bankname_error" class="help-block"></span>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="c_norek">No. rek</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-credit-card"></i>
                  </span>
                  <input type="text" class="form-control" name="c_norek" id="c_norek" placeholder="Enter customer nomor rekening">
                </div>
                <span id="msg_norek_error" class="help-block"></span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="c_address">Customer address</label>
            <textarea class="form-control" name="c_address" id="c_address" cols="10" placeholder="Enter customer address"></textarea>
            <span id="msg_address_error" class="help-block"></span>
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