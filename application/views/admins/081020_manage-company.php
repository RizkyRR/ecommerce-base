<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
        <li><a href="#dashboard" data-toggle="tab">Dashboard</a></li>
      </ul>

      <div class="tab-content">
        <div class="active tab-pane" id="profile">

          <!-- form start -->
          <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="name">Company name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter company name" value="<?php echo $company['company_name'] ?>">
              <span class="help-block"><?php echo form_error('name') ?></span>
            </div>

            <div class="form-group">
              <label for="email">Business email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="Enter business email" value="<?php echo $company['business_email'] ?>">
              <span class="help-block"><?php echo form_error('email') ?></span>
            </div>

            <div class="form-group">
              <label for="phone">Company phone</label>
              <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter company phone" value="<?php echo $company['phone'] ?>">
              <span class="help-block"><?php echo form_error('phone') ?></span>
            </div>

            <div class="form-group">
              <label for="address">Company address</label>
              <input type="text" class="form-control" name="address" id="address" placeholder="Enter company address" value="<?php echo $company['address'] ?>">
              <span class="help-block"><?php echo form_error('address') ?></span>
            </div>

            <div class="form-group">
              <label for="editor1">About company profile</label>
              <textarea id="editor1" name="about" rows="10" cols="80"><?php echo $company['about'] ?></textarea>
              <span class="help-block"><?php echo form_error('address') ?></span>
            </div>

            <div class="table-responsive no-padding">
              <table class="table table-hover" id="link_info_table">
                <tr>
                  <th>Social Link</th>
                  <th>Url</th>
                  <th>
                    <button type="button" id="add_row_sosmed" name="add_row_sosmed" class="btn btn-success btn-sm add_row_sosmed"> <i class="fa fa-plus"></i></i> </button>
                  </th>
                </tr>
                <?php if (isset($profile_detail)) : ?>
                  <?php $i = 1; ?>
                  <?php foreach ($profile_detail as $val) : ?>

                    <tr id="row_<?php echo $i; ?>">
                      <td>
                        <select name="link[]" id="link_<?php echo $i; ?>" class="form-control select_group link" data-row-id="row_<?php echo $i; ?>" style="width: 100%;">
                          <option value=""></option>

                          <?php foreach ($link as $key) : ?>
                            <?php if ($val['link_id'] == $key['id']) : ?>
                              <option value="<?php echo $key['id'] ?>" selected><?php echo $key['link_name'] ?></option>
                            <?php else : ?>
                              <option value="<?php echo $key['id'] ?>"><?php echo $key['link_name'] ?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>

                        </select>
                      </td>

                      <td>
                        <input type="text" name="url[]" id="url_<?php echo $i; ?>" class="form-control" required value="<?php echo $val['url']; ?>">
                      </td>

                      <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow('<?php echo $i; ?>')"><i class="fa fa-close"></i></button>
                      </td>
                    </tr>

                    <?php $i++; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              </table>
            </div>

            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label for="service_charge_value">Service charge value %</label>

                  <div class="input-group">
                    <input type="text" class="form-control" name="service_charge_value" id="service_charge_value" placeholder="Enter service charge value" value="<?php echo $company['service_charge_value'] ?>">
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>

                  <span class="help-block"><?php echo form_error('service_charge_value') ?></span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label for="vat_charge_value">VAT charge value %</label>

                  <div class="input-group">
                    <input type="text" class="form-control" name="vat_charge_value" id="vat_charge_value" placeholder="Enter VAT charge value" value="<?php echo $company['vat_charge_value'] ?>">
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>

                  <span class="help-block"><?php echo form_error('vat_charge_value') ?></span>
                </div>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>


        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane" id="dashboard">
          <section class="content-header">
            <button onclick="add_dashboard()" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Dashboard</button>
          </section>

          <section class="content-header">
            <div class="row">
              <div class="col-lg-12 msg-alert"></div>
            </div>
          </section>

          <section class="content">
            <div class="row">
              <div id="box-dashboard"></div>
            </div>
          </section>
        </div>
        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(document).ready(function(e) {
    show_select_title();
    show_select_icon();
    show_select_color();
    show_box_dashboard();

    $(".select_group").select2();

    $.validator.setDefaults({
      highlight: function(element) {
        $(element).closest(".form-group").addClass("has-error");
      },
      unhighlight: function(element) {
        $(element).closest(".form-group").removeClass("has-error");
        $(element).next().empty();
      },
      errorElement: "span",
      errorClass: "error-message",
      errorPlacement: function(error, element) {
        if (element.parent(".form-group").length) {
          error.insertAfter(element.parent());
        } else {
          error.insertAfter(element);
        }
      },
    });

    var $validator = $("#form-dash").validate({
      focusInvalid: false,
      rules: {
        title: {
          required: true,
        },
      },
      messages: {
        title: {
          required: "Dashboard's title is required!",
        },
      },
    });

    // Add Row Sosmed Table
    $("#add_row_sosmed").click(function(e) {
      var table = $("#link_info_table");
      var count_table_tbody_tr = $("#link_info_table tbody tr").length;
      // console.log(count_table_tbody_tr);
      var row_id = count_table_tbody_tr + 1;
      var html = "";

      $.ajax({
        url: "<?php echo base_url('company/getTableLinkRow'); ?>",
        type: "POST",
        dataType: "JSON",
        success: function(response) {
          html =
            '<tr id="row_' +
            row_id +
            '">' +
            "<td>" +
            '<select class="form-control select_group link" data-row-id="' +
            row_id +
            '" id="link_' +
            row_id +
            '" name="link[]" style="width:100%;">' +
            '<option value=""></option>';
          $.each(response, function(index, value) {
            html +=
              '<option value="' +
              value.link_id +
              '">' +
              value.link_name +
              "</option>";
          });

          html += "</select></td>";

          html +=
            '<td><input type="text" name="url[]" id="url_' +
            row_id +
            '" class="form-control url" required></td>';

          html +=
            '<td><button type="button" name="remove" id="remove" class="btn btn-danger btn-sm"  onclick="removeRow(\'' +
            row_id +
            '\')"><i class="fa fa-close"></i></button></td>';

          html += "</tr>";

          if (count_table_tbody_tr >= 1) {
            $("#link_info_table tbody tr:last").after(html);
          } else {
            $("#link_info_table tbody").html(html);
          }

          $(".select_group").select2();
        },
      });
      return false;
    });

    function show_select_title() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAllDashRow",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option class="form-control" value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option class="form-control" value="' + data[i].id + '">' + data[i].title + '</option>';
          }
          $('#title').html(html);
          $('#title').select2();
        }
      })
    }

    function show_select_icon() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAllIconRow",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option class="form-control" value="' + data[i].id + '">' + data[i].unicodename + '</option>';
          }
          $('#icon').html(html);
          $('#icon').select2();
        }
      })
    }

    function show_select_color() {
      $.ajax({
        url: "<?php echo base_url(); ?>company/getAllColorRow",
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
          var html = '<option value=""></option>';
          var i;

          for (i = 0; i < data.length; i++) {
            html += '<option class="form-control" style="color:' + data[i].color_code + ';" value="' + data[i].id + '">' + data[i].color_code + '</option>';
          }
          $('#color').html(html);

          // $('#color').select2();
        }
      })
    }
  }); // /document

  function removeRow(tr_id) {
    $("#link_info_table tbody tr#row_" + tr_id).remove();
  }


  function show_box_dashboard() {
    $.ajax({
      type: 'GET',
      url: '<?php echo base_url('company/getAllDashDetail') ?>',
      async: true,
      dataType: 'JSON',
      success: function(data) {
        var html = '';
        var i;
        for (i = 0; i < data.length; i++) {
          html +=
            '<div class="col-md-4">' +
            '<div class="box box-default">' +
            '<div class="box-header with-border">' +
            '<h3 class="box-title">' + data[i].title + '</h3>' +

            '<div class="box-tools pull-right">' +
            '<button type="button" class="btn btn-box-tool" onclick="delete_dashboard(' + data[i].dashboard_detail_id + ')">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>' +
            '<div class="box-body">' +
            '<i class="' + data[i].value + '"></i> ' +
            '<span style="color: ' + data[i].color_code + '">Color Code ' + data[i].color_code + '</span>' +
            '</div>' +
            '</div>' +
            '</div>';
        }

        $('#box-dashboard').html(html);
      }
    })
  }


  function add_dashboard() {
    $('#form-dash')[0].reset(); // reset form on modals

    // optional if using select2
    $('#title').select2();
    $('#icon').select2();
    // end of optional if using select2

    $('#modal-dash-control').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Dashboard'); // Set Title to Bootstrap modal title
  }

  function save() {
    $('#btnSave').text('Saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 

    var $valid = $("#form-dash").valid();
    if (!$valid) {
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      // ajax adding data to database
      $.ajax({
        url: "<?php echo base_url() ?>company/add_dashboard",
        type: "POST",
        data: $('#form-dash').serialize(),
        dataType: "JSON",
        success: function(data) {

          if (data.status == true) {
            $('#modal-dash-control').modal('hide');

            $('.msg-alert').html(
              '<div class="alert alert-success alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-check"></i> Alert!</h4>' +
              data.notif +
              "</div>"
            );

            show_box_dashboard();

            effect_msg();
          } else {
            $('.msg-alert').html(
              '<div class="alert alert-danger alert-dismissible">' +
              '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
              data.notif +
              "</div>"
            );

            effect_msg();
          }

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible">' +
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
            '<h4><i class="icon fa fa-exclamation"></i> Alert!</h4>' +
            "There is something wrong, please try again!" +
            "</div>"
          );

          effect_msg();

          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

        }
      });
      return false;
    }

  }

  function delete_dashboard(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this data?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('company/delete_dashboard') ?>",
        data: {
          id: id
        },
        success: function(data) {
          $('#modal-delete').modal('hide');

          show_box_dashboard();

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
            'Error deleting data, please try again !' +
            '</div>'
          );
          effect_msg();
        }
      })
    })
  }

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 2000);
  }

  $(function() {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace("editor1");
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>