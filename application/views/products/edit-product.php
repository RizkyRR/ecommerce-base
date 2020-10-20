<!-- how to edit multiple image in codeigniter -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-md-6 col-md-offset-3 align-center">
      <!-- Content Header (Page header) -->
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

      <section class="content-header">
        <div class="row">
          <div class="col-lg-12 msg-alert"></div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">

          <!-- form start -->
          <form role="form" action="<?php echo base_url(); ?>product/updateProduct" method="POST" id="form-edit-product" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="id">Product ID</label>
                <input type="text" class="form-control" name="id" id="id" value="<?php echo $data['id_product']; ?>" readonly>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="name">Product name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" value="<?php echo $data['product_name']; ?>">
                <span class="help-block"><?php echo form_error('name') ?></span>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="category">Product category</label>
                    <select class="form-control select-category" name="category" id="category">

                    </select>
                    <span class="help-block"><?php echo form_error('category') ?></span>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="supplier">Product supplier</label>
                    <select class="form-control select-supplier" name="supplier" id="supplier">

                    </select>
                    <span class="help-block"><?php echo form_error('supplier') ?></span>
                  </div>
                </div>
              </div>
            </div>

            <!-- https://stackoverflow.com/questions/43245778/how-to-deleteactually-edit-images-from-edit-page-in-code-igniter -->
            <div class="box-body">
              <div class="form-group">
                <label for="image">Add new product image</label>
                <div class="dropzone">

                  <div class="dz-message">
                    <h3> Klik atau Drop gambar disini</h3>
                  </div>

                </div>
                <h6>Recommended using and max file upload 1Mb or 1024Kb and total max upload 5 images</h6>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="editor1">Product description</label>
                <textarea class="form-control" id="description" name="description" rows="10" cols="10"><?php echo $data['description']; ?></textarea>
                <span class="help-block"><?php echo form_error('description') ?></span>
              </div>
            </div>

            <div class="box-body" id="stock-product">
              <div class="form-group">
                <label for="stock">Stock product</label>
                <input type="text" class="form-control" name="stock" id="stock" value="<?php echo $data['qty']; ?>" onkeyup="numberFormat(this)" required>
                <span class="help-block"><?php echo form_error('stock') ?></span>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="weight">Product weight</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="weight" id="weight" placeholder="Enter product weight" value="<?php echo $data['weight']; ?>" onkeyup="numberFormat(this)">
                      <span class="input-group-addon">Gram</span>
                    </div>
                    <span class="help-block"><?php echo form_error('weight') ?></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="price">Product price</label>
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" class="form-control" name="price" id="price" placeholder="Enter product price" value="<?php echo number_format($data['price'], 0, ',', '.'); ?>">
                    </div>
                    <span class="help-block"><?php echo form_error('price') ?></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <a href="<?php echo base_url(); ?>product" class="btn btn-default">Back</a>
              <input type="submit" name="save" id="submitFile" value="Update" class="btn btn-primary">
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
  $(document).ready(function() {
    getSelectedOptionCategory();
    getSelectedOptionSupplier();

    /* $('.select-category').select2();
    $('.select-supplier').select2(); */

    // https://www.malasngoding.com/membuat-format-rupiah-dengan-javascript/
    var angka = document.getElementById("price");
    // var angka = $(".price").val();

    angka.addEventListener("keyup", function(e) {
      angka.value = formatUang(this.value, "");
    });

    function formatUang(nilai, format) {
      var string_angka = nilai.replace(/[^,\d]/g, "").toString(),
        split = string_angka.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

      if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
      }

      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
      return format == undefined ? rupiah : rupiah ? rupiah : "";
    }

    $(".select-category").select2({
      ajax: {
        url: "<?php echo base_url(); ?>product/getCategory",
        type: "POST",
        dataType: 'JSON',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      },
      placeholder: 'Select for a category',
    });

    // Untuk menghilangkan pesan validasi jika sudah terisi
    $('.select-category').on('change', function() {
      $(this).valid();
    });

    $(".select-supplier").select2({
      ajax: {
        url: "<?php echo base_url(); ?>product/getSupplier",
        type: "POST",
        dataType: 'JSON',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      },
      placeholder: 'Select for a supplier',
    });

    // Untuk menghilangkan pesan validasi jika sudah terisi
    $('.select-supplier').on('change', function() {
      $(this).valid();
    });
  });

  function getSelectedOptionCategory() {
    var product_id = $('#id').val();

    $.ajax({
      url: '<?php echo base_url(); ?>product/getSelectedOptionCategory',
      type: 'POST',
      data: {
        product_id: product_id
      },
      dataType: 'JSON',
      success: function(response) {
        var $newOption = $("<option selected='selected'></option>").val(response.category_id).text(response.category_name)
        $("#category").append($newOption).trigger('change');
      }
    });
  }

  function getSelectedOptionSupplier() {
    var product_id = $('#id').val();

    $.ajax({
      url: '<?php echo base_url(); ?>product/getSelectedOptionSupplier',
      type: 'POST',
      data: {
        product_id: product_id
      },
      dataType: 'JSON',
      success: function(response) {
        $("#supplier").append("<option value='" + response.supplier_id + "' selected>" + response.supplier_name + "</option>");
        $('#supplier').trigger('change');
      }
    });
  }

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

  var $validator = $("#form-edit-product").validate({
    rules: {
      name: {
        required: true,
        minlength: 10
      },
      category: {
        required: true
      },
      supplier: {
        required: true
      },
      stock: {
        required: true,
        number: true
      },
      weight: {
        required: true,
        number: true
      },
      price: {
        required: true,
        number: true
      }
    }
  });

  function numberFormat(element) {
    element.value = element.value.replace(/[^0-9]+/g, "");
  }

  Dropzone.autoDiscover = false;
  var currentFile = null;
  var product_id = $('#id').val();
  var fileList = new Array;
  var fileListCounter = 0;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>product/insertResizeImages",
    autoProcessQueue: false,
    accepted: true,
    parallelUploads: 10,
    maxFilesize: 2,
    maxFiles: 5,
    method: "post",
    acceptedFiles: "image/*",
    paramName: "image",
    dictMaxFilesExceeded: "You can only upload upto 5 images",
    dictRemoveFile: "Delete",
    dictInvalidFileType: "Type file ini tidak dizinkan",
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
            url: "<?php echo base_url() ?>product/removeImage",
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
            }
          });

          var _ref;
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
      });
    },
    success: function(file, response) {
      console.log(response);
    },
    init: function() { //https://makitweb.com/how-to-display-existing-files-on-server-in-dropzone-php/
      myDropzone = this;

      /* this.on('removedfile', function(file) {
        // this.removeFile(file);
        // this.addFile(file);
        var rmvFile = "";
        for (f = 0; f < fileList.length; f++) {

          if (fileList[f].fileName == file.name) {
            rmvFile = fileList[f].serverFileName;
            fileListCounter--;
          }

        }

        // https://www.google.com/search?q=remove+file+dropzone+already+store+in+server&oq=remove+file+dropzone+already+store+in+server&aqs=chrome..69i57j33i22i29i30.10045j0j7&sourceid=chrome&ie=UTF-8
        // https://stackoverflow.com/questions/17452662/dropzone-js-how-to-delete-files-from-server
        // https://stackoverflow.com/questions/33728943/how-to-add-removefile-option-in-dropzone-plugin
        // https://stackoverflow.com/questions/46293232/how-to-show-remove-button-and-remove-uploaded-file
        // https://stackoverflow.com/questions/33842555/remove-previews-from-dropzone-after-success
        // https://www.itsolutionstuff.com/post/how-to-delete-uploaded-file-in-dropzone-jsexample.html

        if (rmvFile) {
          $.ajax({
            url: "<?php echo base_url() ?>product/removeImage",
            type: "POST",
            data: {
              fileList: rmvFile
            }
          });
        }
      }); */

      $.ajax({
        url: '<?php echo base_url() ?>product/getDataProductImage',
        type: 'post',
        data: {
          product_id: product_id
        },
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
            foto_upload.emit("thumbnail", mockFile, "http://" + window.location.hostname + '/ecommerce-base' + '/image/product/' + value.name);
            foto_upload.emit("complete", mockFile);
            foto_upload.files.push(mockFile);

            /*  // remove files - NOW OK
             foto_upload.removeAllFiles(true); */
          });

        }
      });
    }
  });

  $('#submitFile').click(function() {
    $('#submitFile').text('Submitting...'); //change button text
    $('#submitFile').attr('disabled', true); //set button disable 

    var $valid = $("#form-edit-product").valid();

    if (!$valid) {
      $("#submitFile").text("Submit"); //change button text
      $("#submitFile").attr("disabled", false); //set button enable
      return false;
    } else {
      foto_upload.processQueue();
      $('#submitFile').text('Submit'); //change button text
      $('#submitFile').attr('disabled', false); //set button enable 
    }
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    a.product_id = $('#id').val();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", a.product_id);
  });
</script>