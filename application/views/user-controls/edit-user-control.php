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
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="<?= base_url() ?>usercontrol/updateusercontrol" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="name">User Name</label>
            <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $usercontrol['id']; ?>">
            <input type="text" class="form-control" readonly value="<?php echo $usercontrol['name']; ?>">
          </div>
          <div class="form-group">
            <label for="email">User Email</label>
            <input type="text" class="form-control" readonly value="<?php echo $usercontrol['email']; ?>">
          </div>
          <div class="form-group">
            <label for="date">Created At</label>
            <input type="text" class="form-control" readonly value="<?php echo date('d F Y', $usercontrol['created_at']); ?>">
          </div>
          <div class="form-group">
            <label for="role">Role User</label>
            <select class="form-control" name="role" id="role">

              <?php foreach ($userrole as $ur) : ?>
                <?php if ($ur['id'] == $usercontrol['role_id']) : ?>
                  <option value="<?php echo $ur['id'] ?>" selected><?php echo $ur['role'] ?></option>
                <?php else : ?>
                  <option value="<?php echo $ur['id'] ?>"><?php echo $ur['role'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>

            </select>
            <small class="form-text text-danger"><?= form_error('role'); ?></small>
          </div>
          <div class="checkbox">
            <label>
              <?php if ($usercontrol['is_active'] == 1) : ?>
                <input type="checkbox" name="status" id="status" value="<?php echo $usercontrol['is_active'] ?>" checked>
                Is active ?
              <?php else : ?>
                <input type="checkbox" name="status" id="status" value="<?php echo $usercontrol['is_active'] ?>">
                Is active ?
              <?php endif; ?>
            </label>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <a href="<?php echo base_url(); ?>usercontrol" class="btn btn-default">Back</a>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->