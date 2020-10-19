<div class="modal fade" id="modal-event">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Event Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form-event" action="" method="post" enctype="multipart/form-data">

          <!-- <div class="alert alert-validation"></div> -->

          <div class="box-body">
            <div class="form-group">
              <label for="title">Title *</label>
              <input type="hidden" class="form-control" name="id" id="id">
              <input type="text" class="form-control" name="title" id="title" placeholder="Enter event title" required>
              <span id="msg_title_error" class="help-block"></span>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" name="description" id="description" cols="30" rows="10" placeholder="Enter description"></textarea>

            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="start_date">Start</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-datetime" placeholder="yyyy-mm-dd hh:mm:ss" name="start_date" id="start_date" required readonly>
              </div>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="end_date">End</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-datetime" placeholder="yyyy-mm-dd hh:mm:ss" name="end_date" id="end_date" required readonly>
              </div>
            </div>
          </div>

          <div class="box-body">
            <div class="form-group">
              <label for="color">Color</label>
              <select class="form-control" name="color" id="color">
                <option style="color:#008000;" value="#008000">&#9724; Green</option>
                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
              </select>
            </div>
          </div>
          <!-- /.box-body -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger delete-event" style="display: none;">Delete</a>
        <button type="submit" class="btn btn-primary" id="btnUpdate">Update</button>
        <button type="button" class="btn btn-primary" id="btnSave" onclick="addNew()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->