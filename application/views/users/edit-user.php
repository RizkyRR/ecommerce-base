<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content col-lg-6">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="hidden" name="id" id="id" class="form-control">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email address" value="<?php echo $user['email'] ?>" readonly>
          </div>
          <div class="form-group">
            <label for="name">User full name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Full name" value="<?php echo $user['name'] ?>">
            <span class="help-block"><?php echo form_error('name') ?></span>
          </div>
          <div class="form-group">
            <label for="image">Choose image</label>
            <input type="file" name="image" id="image">
            <input type="hidden" name="old_image" id="old_image" value="<?php echo $user['image'] ?>">

            <span class="help-block"><?php echo form_error('image') ?></span>
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