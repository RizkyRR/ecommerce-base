<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <button onclick="add_role()" class="btn btn-primary"><i class="fa fa-plus"></i> Role</button>
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
        <table class="table table-hover" id="table-data">
          <thead>
            <tr>
              <th>No</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="show_data_role">

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
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>role/show_ajax_role",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [2],
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
  });

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 3000);
  }

  function add_role() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal-role').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Role'); // Set Title to Bootstrap modal title
  }

  function edit_role(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('role/edit_role/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="name"]').val(data.role);
        $('#modal-role').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Role'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
      url = "<?php echo base_url('role/add_role') ?>";
    } else {
      url = "<?php echo base_url('role/update_role') ?>";
    }

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {

        if (data == 'success') //if success close modal and reload ajax table
        {
          $('#modal-role').modal('hide');
          table.ajax.reload(null, false);
          $('.msg-alert').html(
            '<div class="alert alert-success alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
            'Data has been ' + save_method + ' !' +
            '</div>'
          );
          effect_msg();
        } else {
          /* if (data.error) {
            if (data.name_error != '') {
              var show_error = '';
              show_error += ''
              $('#msg_error').html(data.name_error);
            } else {
              $('#msg_error').html('');
            }
          } */

          /* for (var i = 0; i < data.length; i++) {
            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
          } */
          $("#msg_name_error").parent().parent().addClass('has-error');
          // $("#msg_name_error").next().text(data.name);
          $("#msg_name_error").html(data.name);
        }

        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('.msg-alert').html(
          '<div class="alert alert-danger alert-dismissible">' +
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
          '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
          'Error ' + save_method + ' data !' +
          '</div>'
        );
        effect_msg();
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      }
    });
  }

  function delete_role(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('role/deleterole') ?>",
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
          effect_msg();
        },
        error: function(jqXHR, textStatus, errorThrown) {
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