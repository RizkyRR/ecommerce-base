<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="product-show-option">
    <div class="row msg-alert">
    </div>

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
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Attention</h5>
          <p class="card-text">You can insert you're proof of bank transfer with a file type of image like JPG, JPEG, and PNG.</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="card mb-3 shadow" style="width: 100%;">

        <form action="" id="form-order-pay-report" method="POST" enctype="multipart/form-data">
          <div class="row no-gutters">
            <div class="col-md-12">
              <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Confirmation datetime</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="pay_report_datetime" id="pay_report_datetime" readonly>
                    <input type="hidden" name="pay_report_id" id="pay_report_id" readonly>
                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $data_order['id_order']; ?>" readonly>
                  </div>

                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Attach an image</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control-file" name="image" id="image">
                    <h6>Type file only JPG, JPEG, or PNG. Recommended max file upload 2Mb</h6>

                    <div id="image_message_error"></div>

                    <img id="image_previewing" style="width: auto; height: auto">
                  </div>

                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Message</label>
                  <div class="col-sm-10">
                    <textarea class="form-control message_report" name="message_report" id="message_report" cols="5" rows="5" placeholder="Enter a message for us... "></textarea>
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-success btn-sm float-right" id="btnSend"><i class="fa fa-floppy-o"></i> Send</button>
                  </div>
                </div>
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
    getDateTime();
    getPayReportCustomId();

    function getDateTime() {
      $.ajax({
        url: '<?php echo base_url(); ?>customer-pay-report-datetime',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
          $('#pay_report_datetime').val(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: 'Sorry, can not get datetime for pay report. Please refresh the page!',
            showConfirmButton: false,
            timer: 5000,
          });
        },
      });
    }

    function getPayReportCustomId() {
      $.ajax({
        url: '<?php echo base_url(); ?>customer-pay-report-customid',
        type: 'GET',
        dataType: 'JSON',
        success: function(response) {
          $('#pay_report_id').val(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: 'Sorry, can not get custom id for pay report. Please refresh the page!',
            showConfirmButton: false,
            timer: 5000,
          });
        },
      });
    }

    // http://www.kang-cahya.com/2018/01/membuat-preview-upload-image-sederhana.html
    $("#image").change(function() {
      $("#image_message_error").empty(); // To remove the previous error message
      var file = this.files[0];
      var imagefile = file.type;
      var match = ["image/jpeg", "image/png", "image/jpg"];

      if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
        $("#image").css("color", "red");
        $('#image_previewing').attr('src', '');
        $("#image_message_error").html("<p class=text-danger'>Please select a valid image file, Only jpeg, jpg and png Images type allowed</p>");
        return false;
      } else {
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);

        // for validate image size
        var limit = 2097152; //2MB ==> 1048576 bytes = 1MB;
        if (this.files[0].size > limit) {
          $("#image_message_error").html('<p class="text-warning">Image size is large, max size 2MB!</p>');
          $("#image").css("color", "red");
        }
      }
    });

    function imageIsLoaded(e) {
      $("#image").css("color", "green");
      $('#image_preview').css("display", "block");
      $('#image_previewing').attr('src', e.target.result);
      $('#image_previewing').attr('data-action', 'zoom');

      // $('#image_previewing').zoom(); //https://www.jqueryscript.net/blog/Best-Image-Zoom-jQuery-Plugins.html
    };

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

    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param)
    }, 'File size must be less than {0}');

    var $validator = $("#form-order-pay-report").validate({
      rules: {
        image: {
          required: true,
          accept: "image/jpeg,image/jpg,image/png",
          filesize: 1000 * 2048,
        }
      }
    });

    $('#btnSend').click(function(e) {
      $('#btnSend').text('Sending...'); //change button text
      $('#btnSend').attr('disabled', true); //set button disable

      var order_id = $('#order_id').val();
      var formData = new FormData($("#form-order-pay-report")[0]);
      var $valid = $("#form-order-pay-report").valid();

      if (!$valid) {
        $("#btnSend").text("Send"); //change button text
        $("#btnSend").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url(); ?>set-customer-pay-report',
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
                title: data.message,
                showConfirmButton: false,
                timer: 3000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 3000,
              });
            }

            window.location.href = "<?php echo base_url(); ?>get-detail-customer-purchase/" + order_id;

            $('#btnSend').text('Send'); //change button text
            $('#btnSend').attr('disabled', false); //set button enable 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: textStatus,
              showConfirmButton: false,
              timer: 3000,
            });

            $('#btnSend').text('Send'); //change button text
            $('#btnSend').attr('disabled', false); //set button enable 
          }
        });
      }
    });
  });
</script>