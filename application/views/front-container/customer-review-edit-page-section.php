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

        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="<?php echo base_url() ?>image/product/<?php echo $data['image'] ?>" class="card-img">
            <input type="hidden" name="comment_id" id="comment_id" value="<?php echo $data['id_comment'] ?>" readonly>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title" style="font-weight: bold;"><a href="<?php echo base_url(); ?>product-detail/<?php echo $data['id_product'] ?>" style="color: orange;"><?php echo $data['product_name'] ?>

                </a></h5>

              <div id="rating-detail"></div>

              <p class="card-text">
                <div id="reviewed-date"></div>
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="card mb-3 shadow" style="width: 100%;">

        <div class="row no-gutters">
          <div class="col-md-12">
            <div class="card-body">
              <h5 class="card-title">Edit Review</h5>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Your rating</label>
                <div class="col-sm-10">
                  <div class="star-rating rateYo" id="rateYo"></div>
                  <input type="hidden" name="rate_val" id="rate_val" readonly>
                </div>
                <span class="help-block"></span>
              </div>

              <form action="" method="POST" id="form-edit-comment" enctype="multipart/form-data">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Review message</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="message" id="message" cols="5" rows="5" placeholder="Edit your review for this product"><?php echo set_value('message') ?></textarea>
                  </div>
                  <span class="help-block"><?php echo form_error('message') ?></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <span>File size: <span>Maximum 1 Megabytes</span></span>
                    <br>
                    <span>Number of files: <span>Maximum 5 images</span></span>
                    <br>
                    <span>Extensions allowed: <span>JPG, JPEG, GIF, PNG</span></span>
                    <div class="dropzone mt-1 mb-3">
                      <div class="dz-message">
                        <h4> Attach file in here</h4>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-10">
                    <a href="<?php echo base_url() ?>customer-review" class="btn btn-secondary btn-sm" id="btnCancel"><i class="fa fa-undo"></i> Back</a>
                    <button type="submit" class="btn btn-success btn-sm" id="btnUpdate"><i class="fa fa-floppy-o"></i> Update</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>

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
    getCommentReview();

    // rating star
    $("#rateYo").rateYo({
      // rating: $('#rate_val').val(),
      starWidth: '25px',
      fullStar: true
    });

    $("#rateYo").rateYo().on("rateyo.change", function(e, data) {
      var rating = data.rating;
      $('#rate_val').val(rating);
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

        Swal.fire({
          icon: "error",
          title: error,
          showConfirmButton: false,
          timer: 5000,
        });
      },
    });

    var $validator = $("#form-edit-comment").validate({
      rules: {
        message: {
          required: true,
          minlength: 20
        },
      },
      messages: {
        message: {
          required: "Comment message is required!",
          minlength: "Minimum of 20 characters"
        },
      },
    });

    $("#btnUpdate").click(function() {
      // e.preventDefault();
      $("#btnUpdate").attr("disabled", true); //set button disable

      var $valid = $("#form-edit-comment").valid();
      if (!$valid) {
        $("#btnUpdate").attr("disabled", false); //set button enable
        return false;
      } else {
        $.ajax({
          url: '<?php echo base_url() ?>update-comment-review',
          type: 'POST',
          dataType: 'JSON',
          data: {
            comment_id: $('#comment_id').val(),
            rate: $('#rate_val').val(),
            message: $('#message').val()
          },
          success: function() {

            Swal.fire({
              icon: "success",
              title: "Successfully updating your comment!",
              showConfirmButton: false,
              timer: 5000,
            });

            getCommentReview();

            $("#btnUpdate").attr("disabled", false); //set button enable
          }
        })
      }
    })

    function getCommentReview() {
      var comment_id = $('#comment_id').val();

      $.ajax({
        url: '<?php echo base_url() ?>customer_review/getCommentReviewByID',
        data: {
          comment_id: comment_id
        },
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {
          if (response.status == true) {
            $('#rating-detail').html(response.rating_detail);
            $('#reviewed-date').html(response.review_date);

            $("#rateYo").rateYo("option", "rating", response.rating);
            $('#rate_val').val(response.rating);

            /* $("#rateYo").rateYo({
              rating: response.rating,
              starWidth: '25px',
              fullStar: true
            }); */


            $('#message').val(response.message);
          } else {
            Swal.fire({
              icon: "error",
              title: 'Something wrong, please refresh the page!',
              showConfirmButton: false,
              timer: 5000,
            });
          }
        }
      })
    }
  })


  // IMAGE BY DROPZONE
  Dropzone.autoDiscover = false;
  var currentFile = null;
  var comment_id = $('#comment_id').val();
  var fileList = new Array;
  var fileListCounter = 0;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>insert-comment-image",
    autoProcessQueue: false,
    parallelUploads: 10,
    maxFilesize: 1,
    maxFiles: 5,
    method: "post",
    acceptedFiles: "image/*", // application/pdf,.psd
    paramName: "image",
    dictInvalidFileType: "This file type is not allowed",
    addRemoveLinks: true,
    removedfile: function(file) {
      var fileName = file.name;

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
            url: "<?php echo base_url() ?>delete-comment-detail-review",
            type: "POST",
            data: {
              name: fileName,
              request: 'delete'
            },
            sucess: function(data) {
              console.log('success: ' + data);

              Swal.fire({
                icon: "success",
                title: "Successfully deleted your image!",
                showConfirmButton: false,
                timer: 5000,
              });

              getCommentReview();
            }
          });

          var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
      });
    },
    init: function() { //https://makitweb.com/how-to-display-existing-files-on-server-in-dropzone-php/
      myDropzone = this;

      $.ajax({
        url: '<?php echo base_url() ?>get-detail-comment-review',
        data: {
          comment_id: comment_id
        },
        type: 'post',
        dataType: 'json',
        success: function(response) {

          $.each(response, function(key, value) {
            var mockFile = {
              name: value.name,
              size: value.size,
              accepted: true,
            };

            foto_upload.emit("addedfile", mockFile);
            // foto_upload.emit("thumbnail", mockFile, value.path);
            foto_upload.emit("thumbnail", mockFile, "http://" + window.location.hostname + '/ecommerce-base' + '/image/comment_review/' + value.name);
            foto_upload.emit("complete", mockFile);
            foto_upload.files.push(mockFile);

            /*  // remove files - NOW OK
             foto_upload.removeAllFiles(true); */
          });

        }
      });
    },
    success: function(file, response) {
      console.log(response);
    }
  });

  $('#btnUpdate').click(function() {
    $('#btnUpdate').text('Updating...'); //change button text
    $('#btnUpdate').attr('disabled', true); //set button disable 

    var $valid = $("#form-edit-comment").valid();

    if (!$valid) {
      $("#btnUpdate").text("Update"); //change button text
      $("#btnUpdate").attr("disabled", false); //set button enable
      return false;
    } else {
      foto_upload.processQueue();
      $('#btnUpdate').text('Update'); //change button text
      $('#btnUpdate').attr('disabled', false); //set button enable 
    }
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", $('#comment_id').val());
  });

  //Event ketika foto dihapus
  /* foto_upload.on("removedfile", function(file) {
    var fileName = file.name;

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
          url: "<?php echo base_url() ?>delete-comment-detail-review",
          type: "POST",
          data: {
            name: fileName,
            request: 'delete'
          },
          sucess: function(data) {
            console.log('success: ' + data);

            Swal.fire({
              icon: "success",
              title: "Successfully deleted your image!",
              showConfirmButton: false,
              timer: 5000,
            });

            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

            getCommentReview();
          }
        });
      }
    });
  }); */
</script>