<?php foreach ($product as $val) : ?>
  <div class="modal fade" id="detail-modal<?= $val['product_id'] ?>">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail Product</h4>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <label for="detail_id">Product ID</label>
                <input type="text" class="form-control" name="detail_id" value="<?= $val['product_id'] ?>" readonly>
              </div>
            </div>

            <div class="col-lg-8">
              <div class="form-group">
                <label for="detail_name">Product name</label>
                <input type="text" class="form-control" name="detail_name" value="<?= $val['product_name'] ?>" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="detail_category">Product category</label>
                <input type="text" class="form-control" name="detail_category" value="<?= $val['category_name'] ?>" readonly>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group">
                <label for="detail_supplier">Product supplier</label>
                <input type="text" class="form-control" name="detail_supplier" value="<?= $val['supplier_name'] ?>" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="detail_image">Product image</label>

            <div class="row-prev-img">
              <?php foreach ($image as $key) : ?>
                <?php if ($key['product_id'] == $val['product_id']) : ?>
                  <div class="column-prev-img">
                    <img class="img-responsive" style="width:75%" src="<?php echo base_url(); ?>image/product/<?php echo $key['image'] ?>" alt="Product Image">
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>

          </div>

          <div class="form-group">
            <label for="detail_description">Product description</label>
            <textarea class="form-control" name="detail_description" rows="10" cols="10" readonly><?= $val['description'] ?></textarea>
          </div>

          <div class="form-group">
            <label for="detail_qty">Product quantity</label>
            <input type="text" class="form-control" name="detail_qty" value="<?= $val['qty'] ?>" readonly>
          </div>

          <div class="form-group">
            <label for="detail_price">Product price</label>
            <div class="input-group">
              <span class="input-group-addon">Rp</span>
              <input type="text" class="form-control" name="detail_price" value="<?= $val['price'] ?>" readonly>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<?php endforeach; ?>