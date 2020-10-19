<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="product-show-option">
    <div class="row">
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('success'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php elseif ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('error'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
    </div>

    <div class="row">
      <div class="card mb-3 shadow" style="width: 100%;">

        <form action="" id="form-address" method="POST" enctype="multipart/form-data">
          <div class="row no-gutters">
            <div class="col-md-12">
              <div class="card-body">
                <h5 class="card-title">Change password</h5>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Old password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="old_password" id="old_password" value="<?php echo set_value('old_password') ?>">
                    <span class="help-block"><?php echo form_error('old_password') ?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">New password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="new_password" id="new_password" value="<?php echo set_value('new_password') ?>">
                    <span class="help-block"><?php echo form_error('new_password') ?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Confirm new password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="<?php echo set_value('confirm_password') ?>">
                    <span class="help-block"><?php echo form_error('confirm_password') ?></span>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-warning btn-sm" id="btnSave"><i class="fa fa-pencil"></i> Update</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</section>
<!-- Main content from side menu customer section end -->