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
  <section class="content">

    <div class="row">
      <div class="col-md-6">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() ?>image/profile/<?php echo $user['image'] ?>" alt="User profile picture">

            <h3 class="profile-username text-center"><?php echo $user['name'] ?></h3>

            <p class="text-muted text-center"><?php echo $user['role'] ?></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Email</b>
                <p class="pull-right"><?php echo $user['email'] ?></p>
              </li>
              <li class="list-group-item">
                <b>Joined since</b>
                <p class="pull-right"><?php echo date('d F Y', $user['created_at']) ?></p>
              </li>
            </ul>

            <a href="<?php echo base_url() ?>user/edit/<?php echo $user['id']; ?>" class="btn btn-primary btn-block"><b>Edit User</b></a>
            <a href="<?php echo base_url(); ?>user/changepassword" class="btn btn-warning btn-block"><b>Edit Password</b></a>
            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->