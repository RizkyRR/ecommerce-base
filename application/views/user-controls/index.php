<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <!-- <section class="content-header">
    <button onclick="add_user()" class="btn btn-primary"><i class="fa fa-plus"></i> User</button>
  </section> -->

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
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="show_data_user">

          </tbody>

          <!-- <?php
                if ($usercontrol) :
                  foreach ($usercontrol as $uc) : ?>
              <tr>
                <td><?php echo ++$start; ?></td>
                <td><?php echo $uc['name']; ?></td>
                <td><?php echo $uc['email']; ?></td>
                <td><?php echo $uc['role']; ?></td>
                <td>
                  <?php
                    if ($uc['is_active'] == 1) {
                      echo "<p class='label label-success'>Active</p>";
                    } else {
                      echo "<p class='label label-danger'>Inactive</p>";
                    }
                  ?>
                </td>
                <td><?php echo date('d F Y', $uc['created_at']); ?></td>
                <td>
                  <a href="<?php echo base_url() ?>usercontrol/deleteusercontrol/<?php echo $uc['user_id'] ?>" class="btn btn-sm btn-danger button-delete">Delete</a>
                  <a href="<?php echo base_url() ?>usercontrol/editusercontrol/<?php echo $uc['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="7" style="text-align: center">Data not found !</td>
            </tr>
          <?php endif; ?> -->
        </table>
      </div>
      <!-- /.box-body -->
      <!-- <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
          <?php echo $pagination; ?>
        </ul>
      </div> -->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var save_method; //for save method string
  var table;
  // show_data_user();
  // select_role();

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>usercontrol/show_ajax_user",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [6],
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

  /* function select_role() {
    $.ajax({
      url: "<?php echo base_url('usercontrol/data_role') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        html = '<option value=""></option>';
        var j;
        for (j = 0; j < data.length; j++) {
          html += '<option value=' + data[j].id + '>' + data[j].role + '</option>';
        }
        $('#role').html(html);
      }
    })
  } */

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 3000);
  }

  function add_user() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal-user').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
  }

  function edit_user(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('usercontrol/edit_user/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="status"]').each(function() {
          //alert(arr[i]);
          if (data.is_active == 1) {
            $('[name="status"]').val(data.is_active).prop('checked', true);
          } else {
            $('[name="status"]').val(data.is_active).prop('checked', false);
          }
        })

        // $('[name="role"]').each(function() {
        //   //alert(arr[i]);
        //   if (data.role == $('#role').val()) {
        //     $(this).prop('selected', true);
        //   } else {
        //     $(this).prop('selected', false);
        //   }
        // })

        $('[name="id"]').val(data.id);
        $('[name="name"]').val(data.name).prop("readonly", true);
        $('[name="email"]').val(data.email).prop("readonly", true);
        $('[name="date"]').val(moment(data.created_at).format('DD MMMM YYYY')).prop("readonly", true);
        $('[name="role"]').val(data.role_id);
        // $('[name="status"]').val(data.is_active);
        $('#modal-user').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit User Control'); // Set title to Bootstrap modal title

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
      url = "<?php echo base_url('usercontrol/add_user') ?>";
    } else {
      url = "<?php echo base_url('usercontrol/update_user') ?>";
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
          $('#modal-user').modal('hide');

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
          $("#msg_role_error").parent().parent().addClass('has-error');
          // $("#msg_role_error").next().text(data.role);
          $("#msg_role_error").html(data.role);
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

  function delete_user(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('usercontrol/deleteUserControl') ?>",
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