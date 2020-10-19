<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content col-md-6">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="name">Role name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter email" value="<?php echo set_value('name'); ?>">
            <span class="help-block"><?php echo form_error('name') ?></span>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <a href="<?php echo base_url(); ?>role" class="btn btn-default">Back</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->