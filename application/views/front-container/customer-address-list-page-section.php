<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="product-show-option">
    <div class="row msg-alert">
    </div>

    <div class="row">
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('success'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php elseif ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
          <strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong>
          <br>
          <?php echo $this->session->flashdata('error'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
    </div>

    <div class="row">
      <div class="card mb-3 shadow" style="width: 100%;">

        <form action="" id="form-address" method="POST" enctype="multipart/form-data">
          <div class="row no-gutters">
            <div class="col-md-12">
              <div class="card-body">
                <h5 class="card-title">Address list</h5>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Province</label>
                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="province" id="province">

                    </select>
                    <input type="hidden" name="province_name" id="province_name" readonly>
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">City / Regency</label>
                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="regency" id="regency">

                    </select>
                    <input type="hidden" name="regency_name" id="regency_name" readonly>
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Street name</label>
                  <div class="col-sm-10">
                    <textarea class="form-control street_name" name="street_name" id="street_name" cols="5" rows="5" placeholder="Example: Jalan Abc No. 1 RT 001 / RW 002"></textarea>
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-success btn-sm float-right" id="btnSave"><i class="fa fa-floppy-o"></i> Save</button>
                  </div>
                </div>

                <div class="form-group row" id="show_full_address">

                </div>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
</div>
</div>
</section>
<!-- Main content from side menu customer section end -->

<script>
  $(document).ready(function() {

    $("#province").select2({
      placeholder: 'Select for a province',
      theme: "bootstrap",
      allowClear: true
    });

    $("#regency").select2({
      placeholder: 'Select for a regency',
      theme: "bootstrap",
      allowClear: true
    });

    $('#province').on('change', function() {
      var province_id = $("#province option:selected").val();
      var province_name = $("#province option:selected").text();

      $('#regency').empty();
      $(this).valid();
      $('#province_name').val(province_name);

      if (province_id != null && province_id != 0) {
        $.ajax({
          url: "<?php echo base_url(); ?>get-api-city",
          type: 'GET',
          data: {
            province_id: province_id
          },
          dataType: 'JSON',
          success: function(data) {

            var html = '<option value=""></option>';
            var i;

            for (i = 0; i < data.length; i++) {
              html += '<option value="' + data[i].city_id + '">' + data[i].city_name + ' (' + data[i].type + ')</option>';
            }

            $('#regency').html(html);
          }
        })
      }
    });

    // Untuk menghilangkan pesan validasi jika sudah terisi
    $('#regency').on('change', function() {
      $(this).valid();

      var regency_name = $("#regency option:selected").text();
      $('#regency_name').val(regency_name);
    });
  });

  // show_data_province();
  show_full_address();
  showDataProvince();

  function showDataProvince() {
    $.ajax({
      url: "<?php echo base_url(); ?>get-api-province",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id + '">' + data[i].text + '</option>';
        }
        $('#province').html(html);
      }
    })
  }

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(500);
    setTimeout(function() {
      $('.msg-alert').slideUp(500);
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

  var $validator = $("#form-address").validate({
    rules: {
      province: {
        required: true
      },
      regency: {
        required: true
      },
      street_name: {
        required: true,
        minlength: 30
      }
    },
    messages: {
      province: {
        required: "Province is required!",
      },
      regency: {
        required: "Regency is required!"
      },
      street_name: {
        required: "Street name is required!",
        minlength: "Your street name too short, at least 30 char!"
      }
    },
  });

  function show_full_address() {
    $.ajax({
      url: "<?php echo base_url(); ?>check_out/getAddressDetailProvinceCity",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#show_full_address').html(data.html);
      }
    })
  }

  $('#btnSave').on('click', function(e) {
    e.preventDefault();

    var $valid = $("#form-address").valid();
    if (!$valid) {
      // $validator.focusInvalid();
      $("#btnSave").text("Save"); //change button text
      $("#btnSave").attr("disabled", false); //set button enable
      return false;
    } else {
      $.ajax({
        url: "<?php echo base_url(); ?>update-address-data",
        type: 'POST',
        data: $('#form-address').serialize(),
        dataType: 'JSON',
        success: function(data) {
          if (data.status == "true") //if success close modal and reload ajax table
          {
            $('.msg-alert').html(
              '<div class="alert alert-success alert-dismissible fade show col-lg-12" role="alert">' +
              '<strong>Alert <i class="fa fa-check" aria-hidden="true"></i></strong><br>' +
              data.notif +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );

            effect_msg();
          } else {
            $('.msg-alert').html(
              '<div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">' +
              '<strong>Alert <i class="fa fa-ban" aria-hidden="true"></i></strong><br>' +
              data.notif +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );

            effect_msg();
          }

          show_full_address();

          $("#form-address").validate().resetForm();
          $("#form-address").valid();

          $('#form-address')[0].reset(); // reset form on modals
          $('#province').select2({
            data: [{
              id: '',
              text: ''
            }],
            placeholder: 'Select for a province',
          });
          // $('#province').empty().select2();
          $('#regency').select2({
            data: [{
              id: '',
              text: ''
            }],
            placeholder: 'Select for a regency',
          });
          // $('#regency').val(null).trigger("change");
          // $('#regency').empty().select2();

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('.msg-alert').html(
            '<div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">' +
            '<strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong><br>' +
            'There is something wrong, please contact admin!' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
          );

          $("#form-address").validate().resetForm();
          $("#form-address").valid();

          $('#form-address')[0].reset(); // reset form on modals
          $('#province').select2({
            data: [{
              id: '',
              text: ''
            }],
            placeholder: 'Select for a province',
          });
          // $('#province').empty().select2();
          $('#regency').select2({
            data: [{
              id: '',
              text: ''
            }],
            placeholder: 'Select for a regency',
          });
          // $('#regency').val(null).trigger("change");
          // $('#regency').empty().select2();

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

          effect_msg();
        }
      })
    }
  });
</script>