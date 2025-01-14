<!-- Register Section Begin -->
<div class="register-login-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 offset-lg-3">
        <div class="login-form">
          <h2>Sign In</h2>

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

          <form id="form-signin-store" action="" method="POST" enctype="multipart/form-data">
            <div class="group-input">
              <label for="username">Email address *</label>
              <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>">
              <span class="help-block"><?php echo form_error('email') ?></span>
            </div>

            <div class="group-input">
              <label for="pass">Password *</label>
              <input type="password" id="password" name="password">
              <span class="help-block"><?php echo form_error('password') ?></span>
            </div>

            <div class="group-input">
              <div class="d-flex justify-content-center">
                <p id="captImg" class="captcha-img mr-3"></p>

                <!-- <a href="#" onclick="parent.window.location.reload(true)">[perbarui gambar]</a> -->
                <a href="javascript:void(0)" style="text-decoration: none" id="btn-reload-captcha" title="refresh captcha"><i class="fa fa-refresh"></i></a>
              </div>
            </div>

            <div class="group-input">
              <input type="text" name="captcha" id="captcha" placeholder="Enter captcha" required>
              <span class="help-block"><?php echo form_error('captcha') ?></span>
            </div>

            <div class="group-input gi-check">
              <div class="gi-more">
                <a href="<?php echo base_url(); ?>forgot-password" class="forget-pass">Forget your Password</a>
              </div>
            </div>

            <button type="button" class="site-btn login-btn" id="btnSignIn">Sign In</button>

          </form>
          <div class="switch-login">
            <a href="<?php echo base_url(); ?>sign-up" class="or-login">Or Create An Account</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Register Form Section End -->

<script>
  $(document).ready(function() {
    setCaptcha();

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
      }, 'Format email harus valid!');

    var $validator = $("#form-signin-store").validate({
      focusInvalid: false,
      rules: {
        email: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
        },
        password: {
          required: true,
        },
        captcha: {
          required: true,
        }
      },
      messages: {
        email: {
          required: 'Email can not be empty!',
        },
        password: {
          required: 'Password can not be empty!',
        },
        captcha: {
          required: 'Captcha can not be empty!',
        }
      }
    });

    function setCaptcha() {
      $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>Auth_shop/createCaptcha",
        dataType: "JSON",
        success: function(data) {
          $('.captcha-img').html(data);
        }
      });
    }

    $('#btn-reload-captcha').click(function(e) {
      e.preventDefault();
      setCaptcha();
    });

    $('#btnSignIn').click(function() {
      $('#btnSignIn').text('Signing...'); //change button text
      $('#btnSignIn').attr('disabled', true); //set button disable 

      var $valid = $("#form-signin-store").valid();

      if (!$valid) {
        $("#btnSignIn").text("Sign In"); //change button text
        $("#btnSignIn").attr("disabled", false); //set button enable
        return false;
      } else {
        // ajax adding data to database
        $.ajax({
          url: '<?php echo base_url(); ?>set-sign-in',
          type: "POST",
          data: $('#form-signin-store').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) //if success close modal and reload ajax table
            {
              Swal.fire({
                  icon: 'success',
                  title: 'Sign in success!',
                  html: 'You will be directed in <b>3</b> seconds',
                  timer: 3000,
                  showCancelButton: false,
                  showConfirmButton: false,
                  timerProgressBar: true,
                  willOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                      const content = Swal.getContent()
                      if (content) {
                        const b = content.querySelector('b')
                        if (b) {
                          b.textContent = Swal.getTimerLeft()
                        }
                      }
                    }, 100)
                  },
                  willClose: () => {
                    clearInterval(timerInterval)
                  }
                })
                .then(function() {
                  window.location.href = "<?php echo base_url() ?>profile";
                });
            } else {
              var errorMsg = "";
              var i;
              var error = data.message;

              for (i = 0; i < error.length; i++) {
                errorMsg += error[i];
              }

              Swal.fire({
                icon: "error",
                html: "<p>" + errorMsg + "</p><br/>",
                showConfirmButton: false,
                timer: 5000,
              });

              $('#captcha').val("");
              setCaptcha();
            }

            $('#btnSignIn').text('Sign In'); //change button text
            $('#btnSignIn').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: 'Error Sign In, please try again!',
              showConfirmButton: false,
              timer: 3000,
            });

            $('#btnSignIn').text('Sign In'); //change button text
            $('#btnSignIn').attr('disabled', false); //set button enable 

          }
        });
      }
    })
  })
</script>