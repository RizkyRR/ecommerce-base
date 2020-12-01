<!-- Register Section Begin -->
<div class="register-login-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="login-form">
          <h2>Sign Up</h2>

          <?php if ($this->session->flashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong>
              <br>
              <?php echo $this->session->flashdata('success'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php elseif ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
              <br>
              <?php echo $this->session->flashdata('error'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php endif; ?>

          <form id="form-signup-store" action="" method="POST" enctype="multipart/form-data">

            <div class="group-input">
              <label for="name">Customer Name *</label>
              <input type="text" id="name" name="name" value="<?php echo set_value('name') ?>">
              <span class="help-block"><?php echo form_error('name') ?></span>
            </div>

            <div class="group-input">
              <label for="phone">Customer Phone *</label>
              <input type="text" id="phone" name="phone" value="<?php echo set_value('phone') ?>">
              <span class="help-block"><?php echo form_error('phone') ?></span>
            </div>

            <div class="group-input">
              <label for="email">Email address *</label>
              <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>">
              <span class="help-block"><?php echo form_error('email') ?></span>
            </div>

            <div class="group-input">
              <label for="pass">Password *</label>
              <input type="password" id="pass" name="pass" value="<?php echo set_value('pass') ?>">
              <span class="help-block"><?php echo form_error('pass') ?></span>
            </div>

            <div class="group-input">
              <label for="con-pass">Confirm Password *</label>
              <input type="password" id="con_pass" name="con_pass" value="<?php echo set_value('con_pass') ?>">
              <span class="help-block"><?php echo form_error('con_pass') ?></span>
            </div>

            <div class="group-input gi-check">
              <div class="gi-more">
                <a href="<?php echo base_url(); ?>forgot-password" class="forget-pass">Forget your Password</a>
              </div>
            </div>

            <button type="button" class="site-btn register-btn" id="btnRegister">REGISTER</button>
          </form>
          <div class="switch-login">
            <a href="<?php echo base_url(); ?>sign-in" class="or-login">Or Sign In</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Register Form Section End -->

<script>
  $(document).ready(function() {
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
        if (element.parent(".input-group").length) {
          error.insertAfter(element.parent()); // radio/checkbox?
        } else if (element.hasClass("select2-hidden-accessible")) {
          /* else if (element.hasClass('select2')) {
             error.insertAfter(element.next('span')); // select2
           } */
          error.insertAfter(element.next("span.select2")); // select2 new ver
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
        } else if (regexp.global) regexp.lastIndex = 0;

        /* Check whether the argument is global and, if so set its last index to 0. */

        /* Return whether the element is optional or the result of the validation. */
        return this.optional(element) || regexp.test(value);
      }
    );

    var $validator = $("#form-signup-store").validate({
      focusInvalid: false,
      rules: {
        name: {
          required: true,
        },
        phone: {
          required: true,
          number: true,
          minlength: 10
        },
        email: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
        },
        pass: {
          required: true,
          minlength: 6
        },
        con_pass: {
          required: true,
          minlength: 6,
          equalTo: '#pass'
        },
      },
      messages: {
        email: {
          required: 'Email can not be empty!',
        },
        pass: {
          required: 'Password can not be empty!',
        },
        con_pass: {
          required: 'Confirm password can not be empty!',
          equalTo: 'The two passwords must match!'
        },
      }
    });

    $('#btnRegister').click(function() {
      $('#btnRegister').text('Registering...'); //change button text
      $('#btnRegister').attr('disabled', true); //set button disable 

      var $valid = $("#form-signup-store").valid();

      if (!$valid) {
        $("#btnRegister").text("Register"); //change button text
        $("#btnRegister").attr("disabled", false); //set button enable
        return false;
      } else {
        // ajax adding data to database
        $.ajax({
          url: '<?php echo base_url(); ?>set-register',
          type: "POST",
          data: $('#form-signup-store').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) //if success close modal and reload ajax table
            {
              Swal.fire({
                icon: "success",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            }

            $('#form-signup-store')[0].reset(); // reset form on modals

            $('#btnRegister').text('Register'); //change button text
            $('#btnRegister').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: 'Error Register, please try again!',
              showConfirmButton: false,
              timer: 5000,
            });

            $('#btnRegister').text('Register'); //change button text
            $('#btnRegister').attr('disabled', false); //set button enable 

          }
        });
      }
    })
  })
</script>