<div class="modal fade" id="modal-review">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>

      <div class="modal-body form">
        <form role="form" id="form-review" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="review_message">Review message</label>
            <textarea class="form-control" name="review_message" id="review_message" rows="10" readonly></textarea>
            <input type="hidden" class="form-control" name="comment_id" id="comment_id" readonly>
          </div>

          <div class="form-group">
            <label for="reply_message">Reply message</label>
            <textarea class="form-control" name="reply_message" id="reply_message" rows="10"></textarea>
            <input type="hidden" class="form-control" name="reply_id" id="reply_id" readonly>
          </div>

          <div class="form-group">
            <label for="image">Attach proof of transfer</label>
            <div class="dropzone">

              <div class="dz-message">
                <h3> click or drop a picture here</h3>
              </div>

            </div>
            <h6>Recommended max file upload 2Mb</h6>

            <span class="help-block"></span>
          </div>
          <!-- /.box-body -->
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btnCancelReply" data-dismiss="modal">Cancel</button>
        <a href="javascript:void(0)" class="btn btn-primary" id="btnReply">Reply</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->