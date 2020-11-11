<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3 align-center">
      <section class="content-header">
        <h1>
          <?php echo $title; ?>
        </h1>
      </section>

      <section class="content-header">
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
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box box-solid">

          <!-- form start -->
          <form role="form" action="" method="POST" id="form-reply" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="customer_name">Customer name</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" readonly>
                <input type="hidden" class="form-control" name="id_comment" id="id_comment" value="<?php echo ($review_data != null) ? $review_data['id_comment'] : ''; ?>" readonly>
                <input type="hidden" class="form-control" name="comment_id" id="comment_id" readonly>

                <span class="help-block"></span>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="image_review">Image review</label>
                <div class="col-sm">
                  <div id="show-review-image"></div>
                </div>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="review_message">Review message</label>
                <textarea class="form-control" name="review_message" id="review_message" rows="10" readonly></textarea>
              </div>

              <span class="help-block"></span>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="reply_message">Reply message</label>
                <textarea class="form-control" name="reply_message" id="reply_message" rows="10"></textarea>
                <input type="hidden" class="form-control" name="reply_id" id="reply_id" readonly>

                <span class="help-block"></span>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="image">Attach image</label>
                <div class="dropzone">

                  <div class="dz-message">
                    <h3> click or drop a picture here</h3>
                  </div>

                </div>
                <h6>Recommended max file upload 2Mb</h6>

                <span class="help-block"></span>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <a href="<?php echo base_url(); ?>review" class="btn btn-default">Back</a>
              <input type="submit" class="btn btn-primary" name="save" id="btnReply" value="Reply">
            </div>
          </form>

        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>
  </div>
</div>
<!-- /.content-wrapper -->

<script>
  generateCodeReply();
  getReviewData();
  getReviewImageData();

  $(document).ready(function() {

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

  var $validator = $("#form-reply").validate({
    rules: {
      customer_name: {
        required: true,
      },
      review_message: {
        required: true,
      },
      reply_message: {
        required: true,
      }
    }
  });

  function generateCodeReply() {
    $.ajax({
      url: '<?php echo base_url() ?>review/createCodeCommentReply',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#reply_id').val(data).prop("readonly", true);
      }
    })
  }

  function getReviewData() {
    var comment_id = $('#id_comment').val();

    $.ajax({
      url: "<?php echo base_url() ?>review/getReviewData",
      data: {
        comment_id: comment_id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('#customer_name').val(data.customer_name);
        $('#comment_id').val(data.id_comment);
        $('#review_message').val(data.message);

        // IMAGE 

      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Error get review reply data from ajax',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    });
  }

  function getReviewImageData() {
    var comment_id = $('#id_comment').val();

    $.ajax({
      url: "<?php echo base_url() ?>review/getReviewImageData",
      data: {
        comment_id: comment_id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('#show-review-image').html(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Error get review image data from ajax',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    });
  }

  // update image with dropzone
  Dropzone.autoDiscover = false;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>review/insertImageReply",
    autoProcessQueue: false,
    parallelUploads: 10,
    maxFilesize: 2,
    maxFiles: 5,
    method: "post",
    acceptedFiles: "image/*",
    paramName: "image",
    dictInvalidFileType: "Type file ini tidak dizinkan",
    addRemoveLinks: true,
    success: function(file, response) {
      console.log(response);
    }
  });

  // Submit new product 
  $('#btnReply').click(function() {
    $('#btnReply').text('Replying...'); //change button text
    $('#btnReply').attr('disabled', true); //set button disable 

    var $valid = $("#form-reply").valid();

    if (!$valid) {
      $("#btnReply").text("Reply"); //change button text
      $("#btnReply").attr("disabled", false); //set button enable
      return false;
    } else {
      foto_upload.processQueue();
      $('#btnReply').text('Reply'); //change button text
      $('#btnReply').attr('disabled', false); //set button enable 
    }
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", $('#reply_id').val());
  });
</script>