<!-- Register Section Begin -->
<div class="register-login-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="register-form">
          <h2>Reset Password</h2>

          <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong>
              <br>
              <?php echo $this->session->flashdata('success'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php elseif ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
              <br>
              <?php echo $this->session->flashdata('error'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <form action="" method="POST" enctype="multipart/form-data">
            <div class="group-input">
              <label for="pass">New Password *</label>
              <input type="password" id="pass" name="pass">
              <span class="help-block"><?php echo form_error('pass') ?></span>
            </div>

            <div class="group-input">
              <label for="con-pass">Confirm Password *</label>
              <input type="password" id="con_pass" name="con_pass">
              <span class="help-block"><?php echo form_error('con_pass') ?></span>
            </div>

            <button type="submit" class="site-btn register-btn">Change Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Register Form Section End -->