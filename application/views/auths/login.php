<div class="login-box">

  <div class="login-box-header">
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
  </div>

  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="" method="post" id="form-sign-in" enctype="multipart/form-data">
      <div class="form-group has-feedback">
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" value="<?php echo set_value('email'); ?>" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="help-block"><?php echo form_error('email') ?></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="help-block"><?php echo form_error('password') ?></span>
      </div>

      <div class="form-group has-feedback">
        <div class="d-flex justify-content-center">
          <p id="captImg" class="captcha-img mr-1"></p>

          <!-- <a href="#" onclick="parent.window.location.reload(true)">[perbarui gambar]</a> -->
          <a href="javascript:void(0)" style="text-decoration: none" id="btn-reload-captcha" title="refresh captcha"><i class="fa fa-refresh"></i></a>
        </div>
      </div>

      <div class="form-group has-feedback">
        <input type="text" name="captcha" id="captcha" class="form-control" placeholder="Enter captcha">
        <span class="help-block"><?php echo form_error('captcha') ?></span>
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <a href="javascript:void(0)" class="btn btn-primary btn-block btn-flat" id="btnSignIn">Sign In</a>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="<?php echo base_url(); ?>auth/forgotpassword">I forgot my password</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

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

    var $validator = $("#form-sign-in").validate({
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
        url: "<?php echo base_url() ?>Auth/createCaptcha",
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

      var $valid = $("#form-sign-in").valid();

      if (!$valid) {
        $("#btnSignIn").text("Sign In"); //change button text
        $("#btnSignIn").attr("disabled", false); //set button enable
        return false;
      } else {
        // ajax adding data to database
        $.ajax({
          url: '<?php echo base_url(); ?>auth/signin',
          type: "POST",
          data: $('#form-sign-in').serialize(),
          dataType: "JSON",
          success: function(data) {
            if (data.status == true) //if success close modal and reload ajax table
            {
              let timerInterval;
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
                  window.location.href = "<?php echo base_url() ?>admin";
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