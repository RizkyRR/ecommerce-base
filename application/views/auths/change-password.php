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
    <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="password" name="pass" id="pass" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="help-block"><?php echo form_error('pass') ?></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="repeat_pass" id="repeat_pass" class="form-control" placeholder="Confirm password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        <span class="help-block"><?php echo form_error('repeat_pass') ?></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Change Password</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->