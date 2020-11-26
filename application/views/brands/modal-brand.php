<div class="modal fade" id="modal-brand">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Role Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form-brand" action="" method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="form-group">
              <label for="name">Brand name</label>
              <input type="hidden" name="id_brand" id="id_brand">
              <input type="text" class="form-control" name="name_brand" id="name_brand" placeholder="Enter brand name">

              <span class="help-block"></span>
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