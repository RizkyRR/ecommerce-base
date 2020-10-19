<div class="login-box">
  <!-- /.login-logo -->

  <div class="login-box-header">
    <div class="row">
      <div class="col-lg-12">
        <?php if ($this->session->flashdata('success')) { ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php } else if ($this->session->flashdata('error')) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="login-box-body">
    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo set_value('email') ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="help-block"><?php echo form_error('email') ?></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Request New Password</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="<?php echo base_url(); ?>auth">Already have an account? Login!</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->