<!-- Register Section Begin -->
<div class="register-login-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="login-form">
          <h2>Sign Up</h2>

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
              <label for="name">Customer Name *</label>
              <input type="text" id="name" name="name" value="<?php echo set_value('name') ?>">
              <span class="help-block"><?php echo form_error('name') ?></span>
            </div>

            <div class="group-input">
              <label for="phone">Customer Phone *</label>
              <input type="text" id="phone" name="phone" value="<?php echo set_value('phone') ?>">
              <span class="help-block"><?php echo form_error('phone') ?></span>
            </div>

            <div class="group-input">
              <label for="email">Email address *</label>
              <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>">
              <span class="help-block"><?php echo form_error('email') ?></span>
            </div>

            <div class="group-input">
              <label for="pass">Password *</label>
              <input type="password" id="pass" name="pass" value="<?php echo set_value('pass') ?>">
              <span class="help-block"><?php echo form_error('pass') ?></span>
            </div>

            <div class="group-input">
              <label for="con-pass">Confirm Password *</label>
              <input type="password" id="con_pass" name="con_pass" value="<?php echo set_value('con_pass') ?>">
              <span class="help-block"><?php echo form_error('con_pass') ?></span>
            </div>

            <div class="group-input gi-check">
              <div class="gi-more">
                <a href="<?php echo base_url(); ?>forgot-password" class="forget-pass">Forget your Password</a>
              </div>
            </div>

            <button type="submit" class="site-btn register-btn">REGISTER</button>
          </form>
          <div class="switch-login">
            <a href="<?php echo base_url(); ?>sign-in" class="or-login">Or Sign In</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Register Form Section End -->