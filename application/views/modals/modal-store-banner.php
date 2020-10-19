<div class="modal fade" id="modal-store-banner">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Banner Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form" action="" method="post" enctype="multipart/form-data">
          <div class="box-body">

            <div class="form-group">
              <label for="name">Title banner</label>
              <input type="hidden" id="id" name="id">
              <input type="text" class="form-control" name="title" id="title" placeholder="Enter title banner">
              <span id="msg_title_error" class="help-block"></span>
            </div>

            <div class="form-group">
              <label for="name">Sub title banner</label>
              <textarea class="form-control" name="sub_title" id="sub_title" cols="5" rows="10" placeholder="Enter sub title banner"></textarea>
              <span id="msg_subtitle_error" class="help-block"></span>
            </div>

            <div class="form-group">
              <label for="name">Image banner *</label>
              <input type="file" class="form-control" id="image" name="image" required>
              <input type="hidden" class="form-control" id="old_image" name="old_image">
              <h6>Recommended using and max file upload 2Mb</h6>

              <div id="image-container"></div>

              <span id="msg_image_error" class="help-block"></span>
            </div>

            <div class="form-group">
              <label for="name">Link title banner</label>
              <input type="text" class="form-control" name="link_title" id="link_title" placeholder="Enter title link button">
              <span id="msg_linktitle_error" class="help-block"></span>
            </div>

            <div class="form-group">
              <label for="name">Link url banner</label>
              <input type="text" class="form-control" name="link" id="link" placeholder="Enter url link button">
              <span id="msg_link_error" class="help-block"></span>
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