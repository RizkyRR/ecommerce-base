<!-- Contact Section Begin -->
<section class="contact-section spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="contact-title">
          <h4>Contacts Us</h4>
          <p>Get in touch.</p>
        </div>
        <div class="contact-widget">
          <div class="cw-item">
            <div class="ci-icon">
              <i class="ti-location-pin"></i>
            </div>
            <div class="ci-text">
              <span>Address:</span>
              <p><?php echo $company_address['street_name'] ?>, <?php echo $company_address['city_name'] ?>, <?php echo $company_address['province'] ?></p>
            </div>
          </div>
          <div class="cw-item">
            <div class="ci-icon">
              <i class="ti-mobile"></i>
            </div>
            <div class="ci-text">
              <span>Phone:</span>
              <p><?php echo $company['phone'] ?></p>
            </div>
          </div>
          <div class="cw-item">
            <div class="ci-icon">
              <i class="ti-email"></i>
            </div>
            <div class="ci-text">
              <span>Email:</span>
              <p><?php echo $company['business_email'] ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 offset-lg-1">
        <div class="contact-form">
          <div class="leave-comment">
            <h4>Leave A Message</h4>
            <p>Our staff will call back later and answer your questions.</p>
            <form action="#" class="comment-form" method="POST" id="form-contact">
              <div class="row">
                <div class="col-lg-6">
                  <input type="text" placeholder="Your name" name="g_name" id="g_name">
                </div>
                <div class="col-lg-6">
                  <input type="text" placeholder="Your email" name="g_email" id="g_email">
                </div>
                <div class="col-lg-12">
                  <textarea placeholder="Your message" name="g_message" id="g_message"></textarea>
                  <button type="button" class="site-btn" id="btnSendMessage">Send message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Contact Section End -->

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

    var $validator = $("#form-contact").validate({
      focusInvalid: false,
      rules: {
        g_name: {
          required: true
        },
        g_email: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
        },
        g_message: {
          required: true,
        }
      },
      messages: {
        g_name: {
          required: 'Name can not be empty!',
        },
        g_email: {
          required: 'Email can not be empty!',
        },
        g_message: {
          required: 'Message can not be empty!',
        }
      }
    });

    $('#btnSendMessage').click(function() {
      $('#btnSendMessage').text('Sending...'); //change button text
      $('#btnSendMessage').attr('disabled', true); //set button disable 

      var $valid = $("#form-contact").valid();

      if (!$valid) {
        $("#btnSendMessage").text("Send message"); //change button text
        $("#btnSendMessage").attr("disabled", false); //set button enable
        return false;
      } else {
        // ajax adding data to database
        $.ajax({
          url: '<?php echo base_url(); ?>send-message',
          type: "POST",
          data: $('#form-contact').serialize(),
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

              $('#form-contact')[0].reset(); // reset form on modals
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            }

            $('#btnSendMessage').text('Send message'); //change button text
            $('#btnSendMessage').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: 'Error send message, please try again!',
              showConfirmButton: false,
              timer: 5000,
            });

            $('#btnSendMessage').text('Send message'); //change button text
            $('#btnSendMessage').attr('disabled', false); //set button enable 

          }
        });
      }
    })
  });
</script>