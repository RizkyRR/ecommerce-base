<!-- how to edit multiple image in codeigniter -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <!-- form start -->
      <form role="form" action="" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="id">Product ID</label>
            <input type="text" class="form-control" name="id" id="id" value="<?php echo $data['product_id']; ?>" readonly>
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
          <div class="form-group">
            <label for="category">Product category</label>
            <select class="form-control select-category" name="category" id="category">

              <?php foreach ($category as $val) : ?>
                <?php if ($val['id'] == $data['category_id']) : ?>
                  <option value="<?php echo $val['id'] ?>" selected><?php echo $val['category_name'] ?></option>
                <?php else : ?>
                  <option value="<?php echo $val['id'] ?>"><?php echo $val['category_name'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>

            </select>
            <span class="help-block"><?php echo form_error('category') ?></span>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="supplier">Product supplier</label>
            <select class="form-control select-supplier" name="supplier" id="supplier">

              <?php foreach ($supplier as $val) : ?>
                <?php if ($val['id'] == $data['supplier_id']) : ?>
                  <option value="<?php echo $val['id'] ?>" selected><?php echo $val['supplier_name'] ?></option>
                <?php else : ?>
                  <option value="<?php echo $val['id'] ?>"><?php echo $val['supplier_name'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>

            </select>
            <span class="help-block"><?php echo form_error('supplier') ?></span>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="image">Previous product image</label>

            <div class="row-prev-img">
              <?php foreach ($image as $val) : ?>

                <!-- <div class="image_preview_boxes">
                <div class="image_preview_boxes_1">
                  <img class="img-responsive" style="width: 25%" src="<?php echo base_url(); ?>image/product/<?php echo $val['product_image'] ?>" alt="Product Image">
                  <span class="users-list-date"><?php echo $val['product_image'] ?></span>
                  <a class="btn btn-sm btn-warning button-delete" href="<?php echo base_url() ?>image/deleteimage/<?php echo $val['product_id'] ?>">Delete</a>
                </div>
              </div> -->

                <div class="column-prev-img">
                  <img class="img-responsive" style="width:75%" src="<?php echo base_url(); ?>image/product/<?php echo $val['product_image'] ?>" alt="Product Image">
                  <br>
                  <!-- <span class="users-list-date"><?php echo $val['product_image'] ?></span> -->
                  <a class="btn btn-sm btn-warning button-delete" href="<?php echo base_url() ?>image/deleteimage/<?php echo $val['product_id'] ?>">Delete</a>
                </div>

              <?php endforeach; ?>
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
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="editor1">Product description</label>
            <textarea class="form-control" id="description" name="description" rows="10" cols="10"><?php echo $data['description']; ?></textarea>
            <span class="help-block"><?php echo form_error('description') ?></span>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="price">Product price</label>
            <div class="input-group">
              <span class="input-group-addon">Rp</span>
              <input type="text" class="form-control" name="price" id="price" placeholder="Enter product price" value="<?php echo number_format($data['price'], 0, ',', '.'); ?>">
            </div>
            <span class="help-block"><?php echo form_error('price') ?></span>
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
<!-- /.content-wrapper -->

<script>
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $('.select-category').select2();
    $('.select-supplier').select2();

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
  });

  Dropzone.autoDiscover = false;
  var currentFile = null;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>product/insertImages",
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
    /* ,
        init: function() {
          var thisDropzone = this;
          var id = $('#id').val();

          $.getJSON('<?php echo base_url() ?>product/showEditImages/' + id, function(data) {

            $.each(data, function(key, value) {

              var mockFile = {
                name: value.image,
                size: value.info,
              };

              // remove each file after store data into dropzone
              // https://stackoverflow.com/questions/17452662/dropzone-js-how-to-delete-files-from-server
              // https://stackoverflow.com/questions/33728943/how-to-add-removefile-option-in-dropzone-plugin
              // https://stackoverflow.com/questions/35862364/how-to-remove-the-existing-file-dropzone
              // https://stackoverflow.com/questions/24791879/clear-dropzone-js-thumbnail-image-after-uploading-an-image

              // Register it
              this.files = [mockFile];

              $('.dz-image img').attr('width', 125)
              $('.dz-image img').attr('height', 125);

              // thisDropzone.options.addedfile.call(thisDropzone, mockFile);
              // thisDropzone.options.thumbnail.call(thisDropzone, mockFile, base_url + "image/product/" + value.image);

              thisDropzone.files.push(mockFile); // add to files array
              thisDropzone.emit("addedfile", mockFile);
              thisDropzone.emit("thumbnail", mockFile, base_url + 'image/product/' + value.image);
              thisDropzone.emit("complete", mockFile);

              thisDropzone.on('success', function(file, message) {
                if (this.files.length > 1) {
                  thisDropzone.removeFile(this.files[0]);
                  var token = file.token;

                  $.ajax({
                    type: "post",
                    data: {
                      token: token
                    },
                    url: "<?php echo base_url() ?>product/removeUpdateImage",
                    cache: false,
                    dataType: 'json',
                    success: function() {
                      console.log("Foto terhapus");
                    },
                    error: function() {
                      console.log("Error");
                    }
                  });
                }
              });

            });

          });
        } */
  });

  $('#submitFile').click(function() {
    foto_upload.processQueue();
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    c.append("id", $('#id').val());
  });

  //Event ketika foto dihapus
  foto_upload.on("removedfile", function(a) {
    var token = a.token;
    $.ajax({
      type: "post",
      data: {
        token: token
      },
      url: "<?php echo base_url() ?>product/removeImage",
      cache: false,
      dataType: 'json',
      success: function() {
        console.log("Foto terhapus");
      },
      error: function() {
        console.log("Error");
      }
    });
  });
</script>