<div class="modal fade" id="modal-product">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">User Form</h4>
      </div>
      <div class="modal-body form">
        <form role="form" id="form" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="id">Product ID</label>
            <input type="text" class="form-control" name="id" id="id" readonly>
          </div>

          <div class="form-group">
            <label for="name">Product name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name">
            <span id="msg_name_error" class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="category">Product category</label>
            <select class="form-control select-category" name="category" id="category">
              <option value=""></option>
            </select>
            <span id="msg_category_error" class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="supplier">Product supplier</label>
            <select class="form-control select-supplier" name="supplier" id="supplier">
              <option value=""></option>
            </select>
            <span id="msg_supplier_error" class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="image">Product image</label>
            <!-- <input type="file" class="form-control" name="image[]" multiple> -->
            <input type="file" class="form-control" name="image">
            <input type="hidden" class="form-control" name="old_image">
            <!-- <span id="msg_image_error" class="help-block"></span> -->
          </div>

          <div class="form-group">
            <label for="editor1">Product description</label>
            <textarea class="form-control" id="description" name="description" rows="10" cols="10"></textarea>
            <span id="msg_description_error" class="help-block"></span>
          </div>

          <div class="form-group">
            <label for="price">Product price</label>
            <div class="input-group">
              <span class="input-group-addon">Rp</span>
              <input type="text" class="form-control" name="price" id="price" placeholder="Enter product price">
            </div>
            <span id="msg_price_error" class="help-block"></span>
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