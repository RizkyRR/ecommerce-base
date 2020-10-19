<div class="modal fade" id="modal-supplier">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form" action="" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="id">Supplier ID</label>
              <input type="text" class="form-control" name="id" id="id">
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="name">Supplier name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter supplier name">
              <span id="msg_name_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="phone">Supplier phone</label>
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter supplier phone">
              <span id="msg_phone_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="address">Supplier address</label>
              <textarea class="form-control" name="address" id="address" cols="20" placeholder="Enter supplier address"></textarea>
              <span id="msg_address_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="cc_type">Supplier credit card type</label>
              <input type="text" class="form-control" name="cc_type" id="cc_type" placeholder="Enter supplier credit card type">
              <span id="msg_cc_type_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="cc_number">Supplier credit card number</label>
              <input type="text" class="form-control" name="cc_number" id="cc_number" placeholder="Enter supplier credit card number">
              <span id="msg_cc_number_error" class="help-block"></span>
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