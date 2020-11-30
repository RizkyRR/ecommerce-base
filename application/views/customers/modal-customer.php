<div class="modal fade" id="modal-customer">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>

      <div class="modal-body form">
        <form role="form" id="form-customer" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="customer_id">Customer ID</label>
                <input type="text" class="form-control" name="customer_id" id="customer_id" readonly>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="customer_name" id="customer_name_label">Customer Name</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="customer_gender">Gender</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-venus-mars"></i>
                  </span>
                  <input type="text" class="form-control" name="customer_gender" id="customer_gender" readonly>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="birth_date">Birth Date</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-birthday-cake"></i>
                  </span>
                  <input type="text" class="form-control" name="birth_date" id="birth_date" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                  </span>
                  <input type="text" class="form-control" name="customer_email" id="customer_email" readonly>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="customer_phone">Customer Phone</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                  </span>
                  <input type="text" class="form-control" name="customer_phone" id="customer_phone" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="customer_address">Customer Address</label>
            <textarea class="form-control" name="customer_address" id="customer_address" readonly rows="5"></textarea>

            <span class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="image">Customer photo</label>
            <div id="image-container"></div>

            <span class=" help-block"></span>
          </div>

          <div class="form-group">
            <label for="created_at">Joined At</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              <input type="text" class="form-control" name="created_at" id="created_at" readonly>
            </div>

            <span class="help-block"></span>
          </div>
          <!-- /.box-body -->
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btnClose" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->