<div class="modal fade" id="modal-payment-approve">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form-payment-approve" action="" method="post" enctype="multipart/form-data">
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
                <label for="order_date" id="order_date_label">Order date</label>
                <input type="text" class="form-control" name="order_date" id="order_date" readonly>
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
            <label for="image">Attach proof of transfer</label>
            <input type="file" class="form-control" name="image" id="image">
            <input type="file" class="form-control" name="image_new" id="image_new">
            <input type="hidden" class="form-control" name="old_image" id="old_image">
            <h6>Recommended max file upload 1Mb</h6>

            <div id="image-container"></div>

            <span class=" help-block"></span>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="shipping_courier">Shipping courier</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-truck"></i>
                  </span>
                  <input type="text" class="form-control" name="shipping_courier" id="shipping_courier" readonly>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="shipping_service">Shipping service</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-cogs"></i>
                  </span>
                  <input type="text" class="form-control" name="shipping_service" id="shipping_service" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="airwaybill_number">Airwaybill number</label>
            <input type="text" class="form-control" name="airwaybill_number" id="airwaybill_number" placeholder="Enter airwaybill number">

            <span class="help-block"></span>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <a href="javascript:void(0)" class="btn btn-primary" id="btnPaymentApprove">Submit</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->