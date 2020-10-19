<div class="modal fade" id="modal-repayment-hutang">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>
      <div class="modal-body repayment-hutang-form">
        <form role="form" id="repayment-hutang-form" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="hutang_id">Hutang ID</label>
                <input type="text" class="form-control" name="hutang_id" id="hutang_id" readonly>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="repayment_date">Repayment date</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text" class="form-control" name="repayment_date" id="repayment_date" placeholder="yyyy-mm-dd" readonly>
                </div>
                <span id="msg_date_error" class="help-block"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="purchase_id">Purchase ID</label>
                <input type="text" class="form-control" name="purchase_id" id="purchase_id" readonly>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="remaining_paid">Remaining paid</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <strong>Rp </strong>
                  </span>
                  <input type="text" class="form-control" name="remaining_paid" id="remaining_paid" readonly>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="amount_paid">Amount paid</label>
            <div class="input-group">
              <span class="input-group-addon">
                <strong>Rp </strong>
              </span>
              <input type="text" class="form-control" name="amount_paid" id="amount_paid" placeholder="Amount paid..." onkeyup="numberFormat(this); amountPaid()">
              <input type="hidden" class="form-control" name="amount_paid_value" id="amount_paid_value">
            </div>
            <span id="msg_amountpaid_error" class="help-block"></span>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnPay" onclick="pay()">Pay</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->