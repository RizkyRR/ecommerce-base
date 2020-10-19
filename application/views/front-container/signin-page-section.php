<!-- Register Section Begin -->
<div class="register-login-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="login-form">
          <h2>Sign In</h2>

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

          <form action="<?php echo base_url(); ?>sign-in" method="POST" enctype="multipart/form-data">
            <div class="group-input">
              <label for="username">Email address *</label>
              <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>">
              <span class="help-block"><?php echo form_error('email') ?></span>
            </div>

            <div class="group-input">
              <label for="pass">Password *</label>
              <input type="password" id="pass" name="pass">
              <span class="help-block"><?php echo form_error('pass') ?></span>
            </div>

            <div class="group-input gi-check">
              <div class="gi-more">
                <a href="<?php echo base_url(); ?>forgot-password" class="forget-pass">Forget your Password</a>
              </div>
            </div>

            <button type="submit" class="site-btn login-btn">Sign In</button>
          </form>
          <div class="switch-login">
            <a href="<?php echo base_url(); ?>sign-up" class="or-login">Or Create An Account</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Register Form Section End -->