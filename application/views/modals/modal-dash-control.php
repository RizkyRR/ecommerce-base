<div class="modal fade" id="modal-dash-control">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="form-dash" action="" method="post" enctype="multipart/form-data">

          <div class="form-group">
            <label for="title">Title</label>
            <select class="form-control select-title" name="title" id="title" data-width="100%" required>
              <option value=""></option>
            </select>
            <span id="msg_title_error" class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="icon">Icon</label>
            <select style="font-family: FontAwesome" class="form-control select-icon" name="icon" id="icon" data-width="100%">
              <option value=""></option>
            </select>
            <span class="help-block"></span>

            <p><i style="color: #00c0ef" class="fa fa-info-circle"></i> For more icons, please see <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">https://fontawesome.com/v4.7.0/icons/</a></p>
          </div>

          <div class="form-group">
            <label for="color">Color</label>
            <select class="form-control select-color" name="color" id="color" data-width="100%">
              <option value=""></option>
            </select>
            <span class="help-block"></span>
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