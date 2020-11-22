<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- BASE PROFILE -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Base Profile</h3>
          </div>
          <!-- /.box-header -->

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="base-profile">
            <div class="box-body">
              <div class="form-group">
                <label for="name">Company name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter company name">
                <span class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="email">Business email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter business email">
                <span class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="phone">Company phone (it must be available for WhatsApp)</label>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter company phone">
                <span class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="logo">Company logo</label>
                <input type="file" class="form-control" name="logo" id="logo">
                <input type="hidden" name="old_logo" id="old_logo" readonly>

                <div id="image-container"></div>
                <h6>Recommended using 128x64 pixel and max file upload 1Mb</h6>

                <span class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="editor1">About company profile</label>
                <textarea id="editor1" name="about" rows="10" cols="80" placeholder="Tell to everyone about your company in here"><?php echo $company['about'] ?></textarea>
                <span class="help-block"></span>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-baseprofile">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.box -->

        <!-- COMPANY ADDRESS -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Company Address</h3>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="company-address">
            <div class="box-body">
              <div class="form-group">
                <label for="province">Select province</label>
                <select class="form-control" style="width: 100%;" name="province" id="province">

                </select>
                <input type="hidden" name="province_name" id="province_name" readonly>

                <span class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="regency">City / Regency</label>
                <select class="form-control" style="width: 100%;" name="regency" id="regency">

                </select>
                <input type="hidden" name="regency_name" id="regency_name" readonly>

                <span class="help-block"></span>
              </div>

              <div class="form-group">
                <label for="street_name">Street name</label>
                <textarea class="form-control street_name" name="street_name" id="street_name" cols="5" rows="5" placeholder="Example: Jalan Abc No. 1 RT 001 / RW 002"></textarea>

                <span class="help-block"></span>
              </div>

              <div class="form-group" id="company-full-address">
                <label for="street_name">Full address</label>
                <div id="show-full-address"></div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-companyaddress">Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- SOCIAL MEDIAS -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Social Media</h3>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="social-media">
            <div class="box-body">
              <div class="table-responsive no-padding">
                <table class="table table-hover" id="link_info_table">
                  <thead>
                    <tr>
                      <th>Social Link</th>
                      <th>Url</th>
                      <th>
                        <button type="button" id="add_row_sosmed" name="add_row_sosmed" class="btn btn-success btn-sm add_row_sosmed"> <i class="fa fa-plus"></i></i> </button>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="show-data-social">

                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-socialmedia">Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- SET CHARGE VALUE -->
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Set Charge Value</h3>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="set-charge-value">
            <div class="box-body">
              <!-- <div class="row" style="display: none;">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="service_charge_value">Service charge value %</label>

                    <div class="input-group">
                      <input type="text" class="form-control" name="service_charge_value" id="service_charge_value" placeholder="Enter service charge value" onkeyup="numberFormat(this)">
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>

                    <span class="help-block"></span>
                  </div>
                </div>
              </div> -->

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="vat_charge_value">VAT charge value or PPn %</label>

                    <div class="input-group">
                      <input type="text" class="form-control" name="vat_charge_value" id="vat_charge_value" placeholder="Enter VAT charge value" onkeyup="numberFormat(this)">
                      <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                    </div>

                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-chargevalue">Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (left) -->

      <!-- right column -->
      <div class="col-md-6">
        <!-- BANK ACCOUNTS -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Bank Accounts</h3>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="bank-account">
            <div class="box-body">
              <div class="table-responsive no-padding">
                <table class="table table-hover" id="bankaccount_info_table">
                  <thead>
                    <tr>
                      <th>Bank</th>
                      <th>Account</th>
                      <th>Account Holder Name</th>
                      <th>
                        <button type="button" id="add_row_bankaccount" name="add_row_bankaccount" class="btn btn-success btn-sm add_row_bankaccount"> <i class="fa fa-plus"></i></i> </button>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="show-data-bankaccount">

                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-bankaccount">Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- SET EMAIL  -->
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Set Email</h3>
            <h5 style="color: red;">This email will be used for payment reminders that are sent automatically to customers.</h5>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="set-email">
            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="email_registry">Email*</label>

                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                      <input type="text" class="form-control" name="email_registry" id="email_registry" placeholder="Enter email">
                    </div>

                    <span class="help-block"></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="password_registry">Password*</label>

                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="password" class="form-control" name="password_registry" id="password_registry" placeholder="Enter password">
                    </div>

                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-email">Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- SET ALERT -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Set Alert</h3>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="form-set-alert">
            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="min_stock_product_val">Set alert minimum product stocks</label>
                    <input type="text" class="form-control" name="min_stock_product_val" id="min_stock_product_val" placeholder="Enter minimum alert stock product value" onkeyup="numberFormat(this)">

                    <span class="help-block"></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-submit-setalert">Submit</button>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (right) -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url(); ?>back-assets/plugins/main-project/manage-company.js"></script>