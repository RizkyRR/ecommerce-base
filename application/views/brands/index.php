<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <button onclick="add_brand()" class="btn btn-primary"><i class="fa fa-plus"></i> Brand</button>
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
      <div class="box-body table-responsive">
        <table class="table table-hover" id="table-brand-data">
          <thead>
            <tr>
              <th>No</th>
              <th>Brand</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="show_data_brand">

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
  var save_method; //for save method string
  var table;

  $(document).ready(function() {
    table = $('#table-brand-data').DataTable({
      "processing": true,
      "serverSide": true,
      "bLengthChange": false,
      "ajax": {
        "url": "<?= base_url(); ?>brand/show_ajax_brand",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0, 2],
        "orderable": false,
        "searchable": false
      }],
      'order': []
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("textarea").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("select").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
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

    var $validator = $("#form-brand").validate({
      focusInvalid: false,
      rules: {
        name_brand: {
          required: true
        }
      },
      messages: {
        name_brand: {
          required: "Brand name can not be empty!"
        }
      }
    });
  });

  function add_brand() {
    save_method = 'add';

    $('#form-brand')[0].reset(); // reset form on modals
    $("#form-brand").valid();

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $('#modal-brand').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Brand'); // Set Title to Bootstrap modal title
  }

  function edit_brand(id) {
    save_method = 'update';

    $('#form-brand')[0].reset(); // reset form on modals
    $("#form-brand").valid();

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url() ?>brand/getEditBrand",
      data: {
        brand_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('[name="id_brand"]').val(data.id);
        $('[name="name_brand"]').val(data.brand_name);

        $('#modal-brand').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Brand'); // Set title to Bootstrap modal title
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Error get edit data from ajax',
          showConfirmButton: false,
          timer: 5000,
        });
      }
    });
  }

  function save() {
    $('#btnSave').text('Saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 

    var url;

    if (save_method == 'add') {
      url = "<?php echo base_url() ?>brand/setAddBrand";
    } else {
      url = "<?php echo base_url() ?>brand/setUpdateBrand";
    }

    var $valid = $("#form-brand").valid();

    if (!$valid) {
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#form-brand').serialize(),
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
          } else {
            Swal.fire({
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 5000,
            });
          }

          $('#modal-brand').modal('hide');
          table.ajax.reload(null, false);

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: 'Error update brand, please try again!',
            showConfirmButton: false,
            timer: 5000,
          });

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        }
      });
    }

  }

  function delete_brand(id) {
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
          url: '<?php echo base_url() ?>brand/setDeleteBrand',
          data: {
            brand_id: id
          },
          type: 'POST',
          dataType: 'JSON',
          success: function(data) {
            if (data.status == true) {
              Swal.fire({
                icon: "success",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: data.message,
                showConfirmButton: false,
                timer: 5000,
              });
            }

            table.ajax.reload(null, false);
          }
        });
      }
    });
  }
</script>