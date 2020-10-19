<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <button onclick="add_banner()" class="btn btn-primary"><i class="fa fa-plus"></i> Banner</button>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12 msg-alert">

      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">

      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div id="show-banner"></div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  getAllStoreBanner();

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 5000);
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
      if (element.parent(".input-group").length) {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
      }
    },
  });

  var $validator = $("#form").validate({
    rules: {
      image: {
        required: true
      }
    },
    messages: {
      image: {
        required: "Image is required"
      }
    },
  });

  function getAllStoreBanner() {
    $.ajax({
      type: 'GET',
      url: '<?php echo base_url(); ?>store_banner/getAllStoreBanner',
      dataType: 'JSON',
      success: function(data) {
        var html = '';
        var button = '';
        var i;

        for (i = 0; i < data.length; i++) {
          if (data[i].button_link_title != null && data[i].button_link_title != '') {
            button = '<div class="box-footer">' +
              '<a href="' + data[i].button_link_url + '" class="btn btn-primary" target="__balank" title="' + data[i].button_link_url + '">' + data[i].button_link_title + '</a>' +
              '</div>';
          } else {
            button = '';
          }

          html += '<div class="col-md-4">' +
            '<div class="box box-info">' +
            '<div class="box-header with-border">' +
            '<h3 class="box-title">' + data[i].title + '</h3>' +

            '<div class="box-tools pull-right">' +
            '<button type="button" class="btn btn-box-tool" onclick="edit_banner(' + data[i].id + ')">' +
            '<i class="fa fa-pencil"></i>' +
            '</button>' +
            '<button type="button" class="btn btn-box-tool" onclick="delete_banner(' + data[i].id + ')">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>' +
            '<div class="box-body">' +

            '<span">' + data[i].sub_title + '</span>' +
            '<img class="img-responsive" style="width: 320; height: 50;" src="' + '<?php echo base_url(); ?>image/gallery/' + '' + data[i].image + '" />' +


            '</div>' +
            button +

            '</div>' +
            '</div>';
        }

        $('#show-banner').html(html);
      }
    });
  }

  // https://stackoverflow.com/questions/1143517/jquery-resizing-image#:~:text=%24(this).-,width()%3B%20%2F%2F%20Current%20image%20width%20var%20height%20%3D%20%24(this,new%20width%20%24(this).

  function add_banner() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#image-container').html('');
    $('[name="title"]').prop('readonly', false);

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#modal-store-banner').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Banner'); // Set Title to Bootstrap modal title
  }

  function edit_banner(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('#image-container').html('');
    $('[name="image"]').prop('required', false);

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('store_banner/getDataStoreBanner/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="title"]').val(data.title);
        // $('[name="title"]').val(data.title).prop('readonly', true);
        $('[name="sub_title"]').val(data.sub_title);

        $('#image-container').html('<img class="img-responsive" style="width: 320; height: 50;" src="' + '<?php echo base_url(); ?>image/gallery/' + '' + data.image + '" />');
        $('[name="old_image"]').val(data.image);

        $('[name="link_title"]').val(data.button_link_title);
        $('[name="link"]').val(data.button_link_url);

        $('#modal-store-banner').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Banner'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  // upload image ajax codeigniter formdata
  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
      url = "<?php echo base_url('store_banner/insertStoreBanner') ?>";
    } else {
      url = "<?php echo base_url('store_banner/updateStoreBanner') ?>";
    }

    var formData = new FormData($("#form")[0]);

    var $valid = $("#form").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        enctype: 'multipart/form-data',
        dataType: "JSON",
        success: function(data) {
          $('#modal-store-banner').modal('hide');

          if (data.status == true) //if success close modal and reload ajax table
          {
            getAllStoreBanner();

            $('.msg-alert').html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );
            effect_msg();
          } else {
            $('.msg-alert').html(
              '<div class="alert alert-warning alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
              data.notif +
              '</div>'
            );

            effect_msg();
          }

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#modal-store-banner').modal('hide');

          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            'There is something wrong, please contact admin!' +
            '</div>'
          );

          effect_msg();

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        }
      });
    }
  }

  function delete_banner(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('store_banner/deleteStoreBanner') ?>",
        data: {
          id: id
        },
        success: function(data) {
          $('#modal-delete').modal('hide');

          getAllStoreBanner();

          $('.msg-alert').html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            'Data has been deleted !' +
            '</div>'
          );
          effect_msg();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#modal-store-banner').modal('hide');

          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
            'Error deleting data !' +
            '</div>'
          );
          effect_msg();
        }
      })
    })
  }
</script>