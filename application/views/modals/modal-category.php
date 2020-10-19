<div class="modal fade" id="modal-category">
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
              <label for="name">Category name</label>
              <input type="hidden" class="form-control" name="id" id="id">
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter category name">
              <span id="msg_name_error" class="help-block"></span>
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