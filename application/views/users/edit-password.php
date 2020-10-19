<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-6">
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
  </section>

  <!-- Main content -->
  <section class="content col-lg-6">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="oldpass">Current password</label>
            <input type="password" class="form-control" id="oldpass" name="oldpass" placeholder="Current password">
            <span class="help-block"><?php echo form_error('oldpass') ?></span>
          </div>
          <div class="form-group">
            <label for="newpass">New password</label>
            <input type="password" class="form-control" name="newpass" id="newpass" placeholder="New password">
            <span class="help-block"><?php echo form_error('newpass') ?></span>
          </div>
          <div class="form-group">
            <label for="repass">Confirm new password</label>
            <input type="password" class="form-control" name="repass" id="repass" placeholder="Confirm new password">
            <span class="help-block"><?php echo form_error('repass') ?></span>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <a href="<?php echo base_url(); ?>user" class="btn btn-default">Back</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->