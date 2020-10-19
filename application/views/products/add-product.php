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
          <form role="form" action="<?php echo base_url(); ?>product/insertProduct" method="POST" id="form-add-product" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label for="id">Product ID</label>
                <input type="text" class="form-control" name="id" id="id">
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="name">Product name*</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name (Size/Color)" value="<?php echo set_value('name'); ?>" required>
                <span class="help-block"><?php echo form_error('name') ?></span>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="category">Product category*</label>
                    <select class="form-control select-category" style="width: 100%;" name="category" id="category">
                    </select>
                    <span class="help-block"><?php echo form_error('category') ?></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="supplier">Product supplier*</label>
                    <select class="form-control select-supplier" style="width: 100%;" name="supplier" id="supplier">
                    </select>
                    <span class="help-block"><?php echo form_error('supplier') ?></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="box-body">
              <div class="form-group">
                <label for="image">Product image</label>
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
                <label for="editor1">Product description*</label>
                <textarea class="form-control" id="description" name="description" rows="10" cols="10"><?php echo set_value('description'); ?></textarea>
                <span class="help-block"><?php echo form_error('description') ?></span>
              </div>
            </div>

            <!-- VARIAN Product -->
            <div class="box-body" id="stock-product">
              <div class="form-group">
                <label for="stock">Stock product*</label>
                <input type="text" class="form-control" name="stock" id="stock" onkeyup="numberFormat(this)" required>
                <span class="help-block"><?php echo form_error('stock') ?></span>
              </div>
            </div>

            <div class="box-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="weight">Product weight*</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="weight" id="weight" placeholder="Enter product weight" value="<?php echo set_value('weight'); ?>" onkeyup="numberFormat(this)">
                      <span class="input-group-addon">Gram</span>
                    </div>
                    <span class="help-block"><?php echo form_error('weight') ?></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="price">Product price*</label>
                    <div class="input-group">
                      <span class="input-group-addon">Rp</span>
                      <input type="text" class="form-control" name="price" id="price" placeholder="Enter product price" value="<?php echo set_value('price'); ?>">
                    </div>
                    <span class="help-block"><?php echo form_error('price') ?></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <a href="<?php echo base_url(); ?>product" class="btn btn-default">Back</a>
              <input type="submit" name="save" id="submitFile" value="Submit" class="btn btn-primary">
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
  create_code();

  $(document).ready(function() {
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

  var $validator = $("#form-add-product").validate({
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

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('product/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id').val(data).prop("readonly", true);
      }
    })
  }

  // update image with dropzone
  Dropzone.autoDiscover = false;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>product/insertResizeImages",
    autoProcessQueue: false,
    parallelUploads: 10,
    maxFilesize: 1,
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
  $('#submitFile').click(function() {
    $('#submitFile').text('Submitting...'); //change button text
    $('#submitFile').attr('disabled', true); //set button disable 

    var $valid = $("#form-add-product").valid();

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
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", $('#id').val());
  });
</script>