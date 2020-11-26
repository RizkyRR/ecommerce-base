<!-- Register Section Begin -->
<div class="register-login-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="register-form">
          <h2>Forgot Password</h2>

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

          <form action="" method="POST" id="form-forgot-password-store" enctype="multipart/form-data">
            <div class="group-input">
              <label for="username">Email address *</label>
              <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>">
              <span class="help-block"><?php echo form_error('email') ?></span>
            </div>

            <button type="button" class="site-btn register-btn" id="btnResetPassword">Reset Password</button>
          </form>
          <div class="switch-login">
            <a href="<?php echo base_url(); ?>sign-up" class="or-login">Or Sign Up</a>
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

    var $validator = $("#form-forgot-password-store").validate({
      focusInvalid: false,
      rules: {
        email: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
        },
      },
      messages: {
        email: {
          required: 'Email can not be empty!',
        },
      }
    });

    $('#btnResetPassword').click(function() {
      $('#btnResetPassword').text('Reseting...'); //change button text
      $('#btnResetPassword').attr('disabled', true); //set button disable 

      var $valid = $("#form-forgot-password-store").valid();

      if (!$valid) {
        $("#btnResetPassword").text("Reset Password"); //change button text
        $("#btnResetPassword").attr("disabled", false); //set button enable
        return false;
      } else {
        // ajax adding data to database
        $.ajax({
          url: '<?php echo base_url(); ?>set-forgot-password',
          type: "POST",
          data: $('#form-forgot-password-store').serialize(),
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

            $('#form-forgot-password-store')[0].reset(); // reset form on modals

            $('#btnResetPassword').text('Reset Password'); //change button text
            $('#btnResetPassword').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: 'Error Reset Password, please try again!',
              showConfirmButton: false,
              timer: 5000,
            });

            $('#btnResetPassword').text('Reset Password'); //change button text
            $('#btnResetPassword').attr('disabled', false); //set button enable 

          }
        });
      }
    })
  })
</script>