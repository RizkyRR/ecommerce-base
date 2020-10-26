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
                <label for="phone">Company phone</label>
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
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Set Charge Value</h3>
          </div>

          <!-- form start -->
          <form role="form" action="" method="POST" enctype="multipart/form-data" id="set-charge-value">
            <div class="box-body">
              <div class="row">
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
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="vat_charge_value">VAT charge value %</label>

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
        <div class="box box-info">
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

        <!-- SET DASHBOARDS -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Set Dashboard</h3>
          </div>
          <!-- /.box-header -->

          <section class="content-header">
            <button onclick="add_dashboard()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Dashboard</button>
          </section>

          <section class="content">
            <div class="row">
              <div id="box-dashboard"></div>
            </div>
          </section>
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (right) -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function(e) {
    // for profile company 
    show_base_profile();
    showDataProvince();
    show_full_address();
    show_social_media();
    show_charge_value();
    show_bank_account();
    show_email();

    // for dashbaord purposes
    show_select_title();
    show_select_icon();
    show_select_color();
    show_box_dashboard();

    $('#company-full-address').hide();
    // $(".select_group").select2();

    // number qty
    $("#service_charge_value").attr({
      "min": 0 // values (or variables) here
    });

    $("#vat_charge_value").attr({
      "min": 0 // values (or variables) here
    });

    $.validator.setDefaults({
      highlight: function(element) {
        $(element).closest(".form-group").addClass("has-error");
      },
      unhighlight: function(element) {
        $(element).closest(".form-group").removeClass("has-error");
      },
      errorElement: "span",
      errorClass: "error-message",
      errorPlacement: function(error, element) {
        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent()); // radio/checkbox?
        }
        /* else if (element.hasClass('select2')) {
               error.insertAfter(element.next('span')); // select2
             } */
        else if (element.hasClass("select2-hidden-accessible")) {
          error.insertAfter(element.next('span.select2')); // select2 new ver
        } else {
          error.insertAfter(element); // default
        }
      },
    });

    // https://stackoverflow.com/questions/37606285/how-to-validate-email-using-jquery-validate/37606312
    $.validator.addMethod(
      /* The value you can use inside the email object in the validator. */
      "regex",

      /* The function that tests a given string against a given regEx. */
      function(value, element, regexp) {
        /* Check if the value is truthy (avoid null.constructor) & if it's not a RegEx. (Edited: regex --> regexp)*/

        if (regexp && regexp.constructor != RegExp) {
          /* Create a new regular expression using the regex argument. */
          regexp = new RegExp(regexp);
        }

        /* Check whether the argument is global and, if so set its last index to 0. */
        else if (regexp.global) regexp.lastIndex = 0;

        /* Return whether the element is optional or the result of the validation. */
        return this.optional(element) || regexp.test(value);
      }
    );

    var $validatorBaseProfile = $("#base-profile").validate({
      focusInvalid: false,
      rules: {
        name: {
          required: true,
        },
        email: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        },
        phone: {
          required: true,
          number: true
        },
        about: {
          required: true,
          minlength: 50
        }
      },
    });

    var $validatorAddress = $("#company-address").validate({
      focusInvalid: false,
      rules: {
        province: {
          required: true
        },
        regency: {
          required: true
        },
        street_name: {
          required: true,
          minlength: 30
        }
      },
      messages: {
        province: {
          required: "Province is required!",
        },
        regency: {
          required: "Regency is required!"
        },
        street_name: {
          required: "Street name is required!",
          minlength: "Your street name too short, at least 30 char!"
        }
      },
    });

    var $validatorChargeValue = $("#set-charge-value").validate({
      focusInvalid: false,
      rules: {
        service_charge_value: {
          number: true
        },
        vat_charge_value: {
          number: true
        }
      }
    });

    var $validatorBankAccount = $("#bank-account").validate({
      focusInvalid: false,
      rules: {
        bank_name: {
          required: true,
        },
        account: {
          required: true,
        },
        bank_account_holder: {
          required: true,
        },
      },
      messages: {
        bank_name: {
          required: "Bank's name is required!",
        },
        account: {
          required: "Account's number is required!",
        },
        bank_account_holder: {
          required: "Bank account holder's name is required!",
        },
      },
    });

    var $validatorSetEmail = $("#set-email").validate({
      focusInvalid: false,
      rules: {
        email_registry: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        },
        password_registry: {
          required: true
        }
      },
    });

    var $validatorDashboard = $("#form-dash").validate({
      focusInvalid: false,
      rules: {
        icon: {
          required: true,
        },
        color: {
          required: true,
        },
        title: {
          required: true,
        },
      },
      messages: {
        title: {
          required: "Dashboard's title is required!",
        },
      },
    });

    // ADDRESS PURPOSES
    $("#province").select2({
      placeholder: 'Select for a province',
      allowClear: true
    });

    $("#regency").select2({
      placeholder: 'Select for a regency',
      allowClear: true
    });

    function showDataProvince() {
      $.ajax({
        url: "<?php echo base_url(); ?>get-api-province",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option value="' + data[i].id + '">' + data[i].text + '</option>';
          }
          $('#province').html(html);
        }
      })
    }

    $('#province').on('change', function() {
      var province_id = $("#province option:selected").val();
      var province_name = $("#province option:selected").text();

      $('#regency').empty();
      $(this).valid();
      $('#province_name').val(province_name);

      if (province_id != null && province_id != 0) {
        $.ajax({
          url: "<?php echo base_url(); ?>get-api-city",
          type: 'GET',
          data: {
            province_id: province_id
          },
          dataType: 'JSON',
          success: function(data) {

            var html = '<option value=""></option>';
            var i;

            for (i = 0; i < data.length; i++) {
              html += '<option value="' + data[i].city_id + '">' + data[i].city_name + ' (' + data[i].type + ')</option>';
            }

            $('#regency').html(html);
          }
        })
      }
    });

    // Untuk menghilangkan pesan validasi jika sudah terisi
    $('#regency').on('change', function() {
      $(this).valid();

      var regency_name = $("#regency option:selected").text();
      $('#regency_name').val(regency_name);
    });

    function show_full_address() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAddressDetailProvinceCity",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var fullAddress = data.street_name + ', ' + data.city_name + ', ' + data.province;

          if (data != null) {
            $('#company-full-address').show();
            $('#show-full-address').html(data.html);
          } else {
            $('#company-full-address').hide();
          }
        }
      })
    }

    $(".btn-submit-companyaddress").click(function(e) {
      $('.btn-submit-companyaddress').text('Submitting...'); //change button text
      $('.btn-submit-companyaddress').attr('disabled', true); //set button disable 

      var $valid = $("#company-address").valid();
      if (!$valid) {
        $(".btn-submit-companyaddress").text("Submit"); //change button text
        $(".btn-submit-companyaddress").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url(); ?>company/updateDataCompanyAddress',
          type: "POST",
          data: $('#company-address').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == "true") //if success close modal and reload ajax table
            {
              Swal.fire({
                icon: "success",
                title: data.notif,
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.notif,
                showConfirmButton: false,
                timer: 3000,
              });
            }

            $("#company-address").validate().resetForm();
            $("#company-address").valid();

            $("#company-address")[0].reset(); // reset form on modals
            $('#province').select2({
              data: [{
                id: '',
                text: ''
              }],
              placeholder: 'Select for a province',
            });
            // $('#province').val(null).trigger("change");
            // $('#province').empty().select2();
            $('#regency').select2({
              data: [{
                id: '',
                text: ''
              }],
              placeholder: 'Select for a regency',
            });
            // $('#regency').val(null).trigger("change");
            // $('#regency').empty().select2();

            show_full_address();

            $('.btn-submit-companyaddress').text('Submit'); //change button text
            $('.btn-submit-companyaddress').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: errorThrown,
              showConfirmButton: false,
              timer: 3000,
            });

            $('.btn-submit-companyaddress').text('Submit'); //change button text
            $('.btn-submit-companyaddress').attr('disabled', false); //set button enable 

          }
        });
      }
    });

    // SHOW DATA BASE PROFILE 
    function show_base_profile() {
      $.ajax({
        url: '<?php echo base_url(); ?>company/getDataBaseProfile',
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          $('[name="name"]').val(data.company_name);
          $('[name="email"]').val(data.business_email);
          $('[name="phone"]').val(data.phone);
          $('[name="old_logo"]').val(data.image).prop('readonly', true);
          $('#image-container').html('<img class="img-responsive" style="width: 128px; height: 64px;" src="' + '<?php echo base_url(); ?>image/logo/' + '' + data.image + '" />');
          $('[name="about"]').val(data.about);
        }
      })
    }

    $(".btn-submit-baseprofile").click(function(e) {
      $('.btn-submit-baseprofile').text('Submitting...'); //change button text
      $('.btn-submit-baseprofile').attr('disabled', true); //set button disable 

      var formData = new FormData($("#base-profile")[0]);

      var $valid = $("#base-profile").valid();
      if (!$valid) {
        $(".btn-submit-baseprofile").text("Submit"); //change button text
        $(".btn-submit-baseprofile").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url(); ?>company/updateDataBaseProfile',
          type: "POST",
          processData: false,
          contentType: false,
          cache: false,
          data: formData,
          enctype: 'multipart/form-data',
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) //if success close modal and reload ajax table
            {
              Swal.fire({
                icon: "success",
                title: data.notif,
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.notif,
                showConfirmButton: false,
                timer: 3000,
              });
            }

            $('[name="logo"]').val('');

            show_base_profile();

            $('.btn-submit-baseprofile').text('Submit'); //change button text
            $('.btn-submit-baseprofile').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: textStatus,
              showConfirmButton: false,
              timer: 3000,
            });

            $('.btn-submit-baseprofile').text('Submit'); //change button text
            $('.btn-submit-baseprofile').attr('disabled', false); //set button enable 

          }
        });
      }
    });

    // SOCIAL MEDIA 
    function show_social_media() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getCompanySocialMedia",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#show-data-social').html(data.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: errorThrown,
            showConfirmButton: false,
            timer: 3000,
          });
        },
      });
    }

    $("#add_row_sosmed").click(function(e) {
      var table = $("#link_info_table");
      var count_table_tbody_tr = $("#link_info_table tbody tr").length;
      // console.log(count_table_tbody_tr);
      var row_id = count_table_tbody_tr + 1;
      var html = "";

      $.ajax({
        url: "<?php echo base_url('company/getTableLinkRow'); ?>",
        type: "POST",
        dataType: "JSON",
        success: function(response) {
          html =
            '<tr id="row_' +
            row_id +
            '">' +
            "<td>" +
            '<select class="form-control select_group link" data-row-id="' +
            row_id +
            '" id="link_' +
            row_id +
            '" name="link[]" style="width:100%;">';
          $.each(response, function(index, value) {
            html +=
              '<option value="' +
              value.id +
              '">' +
              value.link_name +
              "</option>";
          });

          html += "</select></td>";

          html += '<td><input type="text" name="url[]" id="url_' + row_id + '" class="form-control url" required></td>';

          html +=
            '<td><button type="button" name="remove" id="remove" class="btn btn-danger btn-sm"  onclick="removeRow(\'' +
            row_id +
            '\')"><i class="fa fa-close"></i></button></td>';

          html += "</tr>";

          if (count_table_tbody_tr >= 1) {
            $("#link_info_table tbody tr:last").after(html);
          } else {
            $("#link_info_table tbody").html(html);
          }

          // $(".select_group").select2();
        },
      });
      return false;
    });

    $('.btn-submit-socialmedia').click(function(e) {
      $('.btn-submit-socialmedia').text('Submitting...'); //change button text
      $('.btn-submit-socialmedia').attr('disabled', true); //set button disable 

      $.ajax({
        url: '<?php echo base_url(); ?>company/actionCompanySocialMedia',
        type: "POST",
        data: $('#social-media').serialize(),
        dataType: "JSON",
        success: function(data) {
          if (data.status == true) {
            Swal.fire({
              icon: "success",
              title: data.notif,
              showConfirmButton: false,
              timer: 3000,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: data.notif,
              showConfirmButton: false,
              timer: 3000,
            });
          }

          show_social_media();

          $('.btn-submit-socialmedia').text('Submit'); //change button text
          $('.btn-submit-socialmedia').attr('disabled', false); //set button enable 

          /* Swal.fire({
            icon: "success",
            title: 'Social media link has been set!',
            showConfirmButton: false,
            timer: 3000,
          });

          show_social_media();

          $('.btn-submit-socialmedia').text('Submit'); //change button text
          $('.btn-submit-socialmedia').attr('disabled', false); //set button enable  */
        }
      });
    });

    // SET CHARGE VALUE
    function show_charge_value() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getChargeValue",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#service_charge_value').val(data.service_charge_value);
          $('#vat_charge_value').val(data.vat_charge_value);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: textStatus,
            showConfirmButton: false,
            timer: 3000,
          });
        },
      });
    }

    $(".btn-submit-chargevalue").click(function(e) {
      $('.btn-submit-chargevalue').text('Submitting...'); //change button text
      $('.btn-submit-chargevalue').attr('disabled', true); //set button disable 

      var $valid = $("#set-charge-value").valid();
      if (!$valid) {
        $(".btn-submit-chargevalue").text("Submit"); //change button text
        $(".btn-submit-chargevalue").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url(); ?>company/actionChargeValue',
          type: "POST",
          data: $('#set-charge-value').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == 'update') //if success close modal and reload ajax table
            {
              Swal.fire({
                icon: "success",
                title: 'Charge value has been updated!',
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: 'Charge value has been set!',
                showConfirmButton: false,
                timer: 3000,
              });
            }

            show_charge_value();

            $('.btn-submit-chargevalue').text('Submit'); //change button text
            $('.btn-submit-chargevalue').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: textStatus,
              showConfirmButton: false,
              timer: 3000,
            });

            $('.btn-submit-chargevalue').text('Submit'); //change button text
            $('.btn-submit-chargevalue').attr('disabled', false); //set button enable 

          }
        });
      }
    });

    // BANK ACCOUNT 
    function show_bank_account() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getCompanyBankAccount",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#show-data-bankaccount').html(data.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: errorThrown,
            showConfirmButton: false,
            timer: 3000,
          });
        },
      });
    }

    $("#add_row_bankaccount").click(function(e) {
      var table = $("#bankaccount_info_table");
      var count_table_tbody_tr = $("#bankaccount_info_table tbody tr").length;
      // console.log(count_table_tbody_tr);
      var row_id = count_table_tbody_tr + 1;
      var html = '<tr id="row_' + row_id + '">';

      html += '<td><input type="text" name="bank_name[]" id="bank_name_' + row_id + '" class="form-control bank_name" required></td>';

      html += '<td><input type="text" name="account[]" id="account_' + row_id + '" class="form-control account" required></td>';

      html += '<td><input type="text" name="bank_account_holder[]" id="bank_account_holder_' + row_id + '" class="form-control bank_account_holder" required></td>';

      html +=
        '<td><button type="button" name="remove_bank_account_row" id="remove_bank_account_row' + row_id + '" class="btn btn-danger btn-sm"  onclick="removeBankAccountRow(\'' +
        row_id +
        '\')"><i class="fa fa-close"></i></button></td>';

      html += "</tr>";

      if (count_table_tbody_tr >= 1) {
        $("#bankaccount_info_table tbody tr:last").after(html);
      } else {
        $("#bankaccount_info_table tbody").html(html);
      }
    });

    $('.btn-submit-bankaccount').click(function(e) {
      $('.btn-submit-bankaccount').text('Submitting...'); //change button text
      $('.btn-submit-bankaccount').attr('disabled', true); //set button disable 

      e.preventDefault();
      var $valid = $("#bank-account").valid();

      if (!$valid) {
        $(".btn-submit-bankaccount").text("Submit"); //change button text
        $(".btn-submit-bankaccount").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url(); ?>company/actionCompanyBankAccount',
          type: "POST",
          data: $('#bank-account').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) {
              Swal.fire({
                icon: "success",
                title: data.notif,
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.notif,
                showConfirmButton: false,
                timer: 3000,
              });
            }

            show_bank_account();

            $('.btn-submit-bankaccount').text('Submit'); //change button text
            $('.btn-submit-bankaccount').attr('disabled', false); //set button enable 
          }
        });
      }
    });

    // SET EMAIL
    function show_email() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getEmail",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          $('#email_registry').val(data.email);
          $('#password_registry').val(data.password);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: textStatus,
            showConfirmButton: false,
            timer: 3000,
          });
        },
      });
    }

    $(".btn-submit-email").click(function(e) {
      $('.btn-submit-email').text('Submitting...'); //change button text
      $('.btn-submit-email').attr('disabled', true); //set button disable 

      var $valid = $("#set-email").valid();
      if (!$valid) {
        $(".btn-submit-email").text("Submit"); //change button text
        $(".btn-submit-email").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url(); ?>company/actionSetEmail',
          type: "POST",
          data: $('#set-email').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == 'update') //if success close modal and reload ajax table
            {
              Swal.fire({
                icon: "success",
                title: 'Charge value has been updated!',
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: 'Charge value has been set!',
                showConfirmButton: false,
                timer: 3000,
              });
            }

            show_email();

            $('.btn-submit-email').text('Submit'); //change button text
            $('.btn-submit-email').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: textStatus,
              showConfirmButton: false,
              timer: 3000,
            });

            $('.btn-submit-email').text('Submit'); //change button text
            $('.btn-submit-email').attr('disabled', false); //set button enable 

          }
        });
      }
    });

    // DASHBOARD
    function show_select_title() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAllDashRow",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option class="form-control" value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option class="form-control" value="' + data[i].id + '">' + data[i].title + '</option>';
          }
          $('#title').html(html);
          $('#title').select2();
        }
      })
    }

    function show_select_icon() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAllIconRow",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option class="form-control" value="' + data[i].id + '">' + data[i].unicodename + '</option>';
          }
          $('#icon').html(html);
          $('#icon').select2();
        }
      })
    }

    function show_select_color() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAllColorRow",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option class="form-control" style="color:' + data[i].color_code + ';" value="' + data[i].id + '">' + data[i].color_code + '</option>';
          }
          $('#color').html(html);

          // $('#color').select2();
        }
      })
    }
  }); // /document

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  // DELETE ROW TABLE SOCIAL MEDIA
  function removeRow(tr_id) {
    $("#link_info_table tbody tr#row_" + tr_id).remove();
  }

  function removeBankAccountRow(tr_id) {
    $("#bankaccount_info_table tbody tr#row_" + tr_id).remove();
  }

  // DASHBOARD
  function show_box_dashboard() {
    $.ajax({
      type: 'GET',
      url: '<?php echo base_url('company/getAllDashDetail') ?>',
      async: true,
      dataType: 'JSON',
      success: function(data) {
        var html = '';
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            '<div class="col-md-4">' +
            '<div class="box box-default">' +
            '<div class="box-header with-border">' +
            '<h3 class="box-title">' + data[i].title + '</h3>' +

            '<div class="box-tools pull-right">' +
            '<button type="button" class="btn btn-box-tool" onclick="delete_dashboard(' + data[i].dashboard_detail_id + ')">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>' +
            '<div class="box-body">' +
            '<i class="' + data[i].value + '"></i> ' +
            '<span style="color: ' + data[i].color_code + '">Color Code ' + data[i].color_code + '</span>' +
            '</div>' +
            '</div>' +
            '</div>';
        }

        $('#box-dashboard').html(html);
      }
    })
  }

  function add_dashboard() {
    $('#form-dash')[0].reset(); // reset form on modals

    // optional if using select2
    $('#title').select2();
    $('#icon').select2();
    // end of optional if using select2

    $('#modal-dash-control').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Dashboard'); // Set Title to Bootstrap modal title
  }

  function save() {
    $('#btnSave').text('Saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 

    var $valid = $("#form-dash").valid();
    if (!$valid) {
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: "<?php echo base_url() ?>company/add_dashboard",
        type: "POST",
        data: $('#form-dash').serialize(),
        dataType: "JSON",
        success: function(data) {
          if (data.status == true) {
            $('#modal-dash-control').modal('hide');

            Swal.fire({
              icon: "success",
              title: data.notif,
              showConfirmButton: false,
              timer: 2000,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: data.notif,
              showConfirmButton: false,
              timer: 2000,
            });
          }

          show_box_dashboard();

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: "There is something wrong, please try again!",
            showConfirmButton: false,
            timer: 2000,
          });

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        }
      });
      return false;
    }

  }

  function delete_dashboard(id) {
    Swal.fire({
      icon: 'warning',
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?php echo base_url() ?>company/delete_dashboard',
          data: {
            id: id
          },
          type: 'POST',
          dataType: 'JSON',
          success: function(data) {
            if (data.status == true) {
              Swal.fire({
                icon: "success",
                title: "Successfully deleted your dashboard!",
                showConfirmButton: false,
                timer: 2000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "There is something wrong, please try again!",
                showConfirmButton: false,
                timer: 2000,
              });
            }

            show_box_dashboard();
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: "Error deleting data, please try again !",
              showConfirmButton: false,
              timer: 2000,
            });
          }
        });
      }
    });
  }

  $(function() {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace("editor1");
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>