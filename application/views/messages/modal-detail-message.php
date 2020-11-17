<div class="modal fade" id="modal-detail-message">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>

      <div class="modal-body form">
        <form role="form" id="form-detail-message" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="id">Invoice order</label>
                <input type="text" class="form-control" name="invoice_order" id="invoice_order" readonly>
                <input type="hidden" class="form-control" name="order_id" id="order_id" readonly>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="message_datetime" id="message_datetime_label">Message datetime</label>
                <input type="text" class="form-control" name="message_datetime" id="message_datetime" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="customer_email">Customer email</label>
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
                <label for="customer_name">Customer name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </span>
                  <input type="text" class="form-control" name="customer_name" id="customer_name" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="image">Proof of transfer</label>
            <div id="image-container"></div>

            <span class=" help-block"></span>
          </div>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="message" cols="30" rows="10"></textarea>

            <span class="help-block"></span>
          </div>
          <!-- /.box-body -->
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-right btnCloseDetailMessage" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->