<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <button onclick="add_image()" class="btn btn-primary"><i class="fa fa-plus"></i> Image</button>
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

      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover" id="table-data">
          <thead>
            <tr>
              <th>No</th>
              <th>File Name</th>
              <th>Info</th>
              <th class="no-sort">Actions</th>
            </tr>
          </thead>
          <tbody id="show_data_gallery">
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var table;
  var base_url = "<?php echo base_url(); ?>";
  // var dataImage;

  // function getAllImage() {
  //   $.ajax({
  //     url: "<?php echo base_url() ?>gallery/getAllImage",
  //     type: "GET",
  //     dataType: 'json',
  //     success: function(data) {
  //       var i;

  //       dataImage = data[i].image;
  //     }
  //   });
  // }

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>gallery/show_ajax_gallery",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      'order': []
    });
  });

  function add_image() {
    $('#form-upload-gallery')[0].reset(); // reset form on modals
    $('#modal-upload-gallery').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Images'); // Set Title to Bootstrap modal title
  }

  Dropzone.autoDiscover = false;

  var foto_upload = new Dropzone(".dropzone", {
    url: "<?php echo base_url() ?>gallery/insertImages",
    maxFilesize: 2,
    method: "post",
    acceptedFiles: "image/*",
    paramName: "image",
    dictInvalidFileType: "Type file ini tidak dizinkan",
    addRemoveLinks: true,
    success: function(file, response) {
      console.log(response);
      table.ajax.reload();
    }
  });

  //Event ketika Memulai mengupload
  foto_upload.on("sending", function(a, b, c) {
    a.token = Math.random();
    c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
  });

  //Event ketika foto dihapus
  foto_upload.on("removedfile", function(a) {
    var token = a.token;
    $.ajax({
      type: "post",
      data: {
        token: token
      },
      url: "<?php echo base_url() ?>gallery/removeImage",
      cache: false,
      dataType: 'json',
      success: function() {
        console.log("Foto terhapus");
        table.ajax.reload();
      },
      error: function() {
        console.log("Error");
        table.ajax.reload();
      }
    });
  });

  function detail_image(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('gallery/detailImage/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        // $('[name="id"]').val(data.id);

        $('#show-image').attr('src', base_url + 'image/gallery/' + data.image);

        // var img = $('<img id="image_id">');
        // img.attr('src', base_url + 'image/gallery/' + data.image);
        // img.appendTo('#image_div');

        $('.file-name').val(data.image);
        $('#modal-detail-gallery').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Image ' + data.image); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_image(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('gallery/deleteImage') ?>",
        data: {
          id: id
        },
        success: function(data) {
          $('#modal-delete').modal('hide');

          table.ajax.reload(null, false);

          $('.msg-alert').html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            'Data has been deleted !' +
            '</div>'
          );

          $('.msg-alert').show(1000);
          setTimeout(function() {
            $('.msg-alert').fadeOut(1000);
          }, 3000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            'Error deleting data !' +
            '</div>'
          );

          $('.msg-alert').show(1000);
          setTimeout(function() {
            $('.msg-alert').fadeOut(1000);
          }, 3000);
        }
      })
    })
  }
</script>