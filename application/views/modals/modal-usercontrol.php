<div class="modal fade" id="modal-user">
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
              <label for="name">User name</label>
              <input type="hidden" name="user_id" id="user_id">
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter user name">

              <span id="msg_name_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="email">User email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Enter user email">

              <span id="msg_email_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body created_date">
            <div class="form-group">
              <label for="date">Created at</label>
              <input type="text" class="form-control" name="date" id="date" placeholder="Enter create date">

              <span id="msg_date_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="role">User role</label>
              <select class="form-control select-role" name="role" id="role" style="width: 100%;">

              </select>

              <span id="msg_role_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="status" id="status">
                Is active ?
              </label>
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