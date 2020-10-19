<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="product-show-option">
    <div class="row">
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('success'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php elseif ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('error'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
    </div>

    <div class="row">
      <div class="card mb-3 shadow" style="width: 100%;">

        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row no-gutters">
            <div class="col-md-3 col-mb-3 col-mt-3 col-xs-6">

              <img src="<?php echo base_url(); ?>image/customer_profile/<?php echo $customer['customer_image'] ?>" class="card-img" alt="photo">

            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Personal bio</h5>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $customer['customer_email']; ?>" readonly>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Customer name" value="<?php echo $customer['customer_name']; ?>">
                  </div>
                  <span class="help-block"><?php echo form_error('name') ?></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Date of Birth</label>
                  <div class="col-sm-10">

                    <?php if ($customer['customer_birth_date'] > 0 || $customer['customer_birth_date'] != null) : ?>
                      <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="yyyy-mm-dd" value="<?php echo date('Y-m-d', strtotime($customer['customer_birth_date'])); ?>" readonly>
                    <?php else : ?>
                      <input type="text" class="form-control" id="birthdate" name="birthdate" placeholder="yyyy-mm-dd" readonly>
                    <?php endif; ?>

                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Gender</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="gender" name="gender">
                      <option value="">Select your gender</option>

                      <?php foreach ($gender as $val) : ?>
                        <?php if ($customer['gender_id'] == $val['id']) : ?>
                          <option value="<?php echo $val['id'] ?>" selected><?php echo $val['gender_name'] ?></option>
                        <?php else : ?>
                          <option value="<?php echo $val['id'] ?>"><?php echo $val['gender_name'] ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>

                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Mobile phone</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Customer phone" value="<?php echo $customer['customer_phone']; ?>" onkeyup="numberFormat(this)">
                  </div>
                  <span class="help-block"><?php echo form_error('phone') ?></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Photo</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control-file" id="photo" name="photo">
                    <input type="hidden" name="old_photo" id="old_photo" value="<?php echo $customer['customer_image']; ?>" readonly>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Update</button>
                  </div>
                </div>

                <p class="card-text"><small class="text-muted">Joined as a member on <?php echo date('d M Y H:i:s', strtotime($customer['created_at'])) ?></small></p>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</section>
<!-- Main content from side menu customer section end -->

<script>
  $(document).ready(function() {
    $('#birthdate').datepicker({
      todayBtn: "linked",
      format: "yyyy-mm-dd",
      autoclose: true
    })
  })

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }
</script>