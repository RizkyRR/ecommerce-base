<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <section class="content-header">
    <button onclick="add_user()" class="btn btn-primary"><i class="fa fa-plus"></i> User</button>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12 msg-alert"></div>
    </div>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12">
        <div class="callout callout-warning">
          <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention.</h4>

          <p>After creating a new user, the user must reset the password which is directed to "forgot password" on the login page.!</p>
        </div>
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
  // show_data_user();
  // select_role();

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "bLengthChange": false,
      "ajax": {
        "url": "<?= base_url(); ?>usercontrol/show_ajax_user",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": [0, 6],
        "orderable": false,
        "searchable": false
      }],
      'order': []
    });

    $('.created_date').hide();

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
        if (element.parent(".input-group").length) {
          error.insertAfter(element.parent()); // radio/checkbox?
        } else if (element.hasClass("select2-hidden-accessible")) {
          /* else if (element.hasClass('select2')) {
             error.insertAfter(element.next('span')); // select2
           } */
          error.insertAfter(element.next("span.select2")); // select2 new ver
        } else {
          error.insertAfter(element); // default
        }
      },
    });

    // https://stackoverflow.com/questions/37606285/how-to-validate-email-using-jquery-validate/37606312
    $.validator.addMethod(
      /* The value you can use inside the email object in the validator. */
      "regex",

      /* The function that tests a given string against a given regEx. */
      function(value, element, regexp) {
        /* Check if the value is truthy (avoid null.constructor) & if it's not a RegEx. (Edited: regex --> regexp)*/

        if (regexp && regexp.constructor != RegExp) {
          /* Create a new regular expression using the regex argument. */
          regexp = new RegExp(regexp);
        } else if (regexp.global) regexp.lastIndex = 0;

        /* Check whether the argument is global and, if so set its last index to 0. */

        /* Return whether the element is optional or the result of the validation. */
        return this.optional(element) || regexp.test(value);
      }, 'Format email harus valid!');

    var $validator = $("#form").validate({
      focusInvalid: false,
      rules: {
        name: {
          required: true
        },
        email: {
          required: true,
          email: true,
          regex: /^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i,
        },
        role: {
          required: true,
        }
      },
      messages: {
        name: {
          required: 'Name can not be empty!',
        },
        email: {
          required: 'Email can not be empty!',
        },
        role: {
          required: 'Role can not be empty!',
        }
      }
    });

    /* $(".select-role").select2({
      ajax: {
        url: "<?php echo base_url(); ?>usercontrol/getRoleSelect2",
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
      placeholder: 'Select for a role',
    }); */

    // Untuk menghilangkan pesan validasi jika sudah terisi
    $('.select-role').on('change', function() {
      $(this).valid();
    });
  });

  getSelectOptionRole();
  getSelectedOptionRole();
  create_code();

  function getSelectOptionRole() {
    $.ajax({
      url: '<?php echo base_url(); ?>usercontrol/getRoleSelect',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value="">-- Select a role --</option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id + '">' + data[i].role + '</option>';
        }

        $('.select-role').html(html);
      }
    })
  }

  function getSelectedOptionRole() {
    var user_id = $('#user_id').val();

    $.ajax({
      url: '<?php echo base_url(); ?>usercontrol/getSelectedOptionRole',
      type: 'POST',
      data: {
        user_id: user_id
      },
      dataType: 'JSON',
      success: function(response) {
        var $newOption = $('.select-role').val(response.id).text(response.role)
        $("#role").append($newOption).trigger('change');
      }
    });
  }

  function create_code() {
    $.ajax({
      url: '<?php echo base_url() ?>usercontrol/createCode',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#user_id').val(data).prop("readonly", true);
      }
    })
  }

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

    $('.created_date').hide();

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $("#form").valid();

    create_code();

    $('[name="name"]').attr("readonly", false);
    $('[name="email"]').attr("readonly", false);

    $('#modal-user').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
  }

  function edit_user(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals

    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    $("#form").valid();

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url() ?>usercontrol/edit_user",
      type: "POST",
      data: {
        user_id: id
      },
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

        $('.created_date').show();

        $('[name="user_id"]').val(data.user_id);
        $('[name="name"]').val(data.name).prop("readonly", true);
        $('[name="email"]').val(data.email).prop("readonly", true);
        $('[name="date"]').val(moment(data.created_at).format('DD MMMM YYYY HH:mm:ss')).prop("readonly", true);
        $('[name="role"]').val(data.role_id);

        $('#modal-user').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit User Control'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal.fire({
          icon: "error",
          title: 'Error get data from ajax',
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
      url = "<?php echo base_url() ?>usercontrol/add_user";
    } else {
      url = "<?php echo base_url() ?>usercontrol/update_user";
    }

    var $valid = $("#form").valid();

    if (!$valid) {
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
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

            create_code();
            $('#form')[0].reset(); // reset form on modals
          } else {
            Swal.fire({
              icon: "error",
              title: data.message,
              showConfirmButton: false,
              timer: 5000,
            });
          }

          $('#modal-user').modal('hide');
          table.ajax.reload(null, false);

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: "error",
            title: 'Something is wrong when you want to save or change data. Please try again!',
            showConfirmButton: false,
            timer: 5000,
          });

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        }
      });
    }
  }

  function delete_user(id) {
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
          url: '<?php echo base_url() ?>usercontrol/deleteUserControl',
          data: {
            user_id: id
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