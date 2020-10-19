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
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">City / Regency</label>
                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="regency" id="regency">

                    </select>
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">District</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="district" id="district">

                    </select>
                  </div>
                  <span class="help-block"></span>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Sub-district</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="subdistrict" id="subdistrict">

                    </select>
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
      theme: "bootstrap"
    });

    $("#regency").select2({
      placeholder: 'Select for a regency',
      theme: "bootstrap"
    });

    $("#district").select2({
      placeholder: 'Select for a district',
      theme: "bootstrap"
    });

    $("#subdistrict").select2({
      placeholder: 'Select for a sub-district',
      theme: "bootstrap"
    });

    $("#province").select2({
      ajax: {
        url: "<?php echo base_url(); ?>get-province-data",
        type: "post",
        dataType: 'json',
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
      placeholder: 'Select for a province',
      theme: "bootstrap"
    });

    // PROVINCE ONCHANGE
    $('#province').on('change', function() {
      var province_id = $("#province option:selected").val();

      $("#regency").select2({
        ajax: {
          url: "<?php echo base_url(); ?>get-regency-data",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term, // search term,
              province_id: province_id
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        },
        placeholder: 'Select for a regency',
        theme: "bootstrap"
      });
    });

    // REGENCY ONCHANGE
    $('#regency').on('change', function() {
      var regency_id = $("#regency option:selected").val();

      $("#district").select2({
        ajax: {
          url: "<?php echo base_url(); ?>get-district-data",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term, // search term,
              regency_id: regency_id
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        },
        placeholder: 'Select for a district',
        theme: "bootstrap"
      });
    });

    // DISTRICT ONCHANGE
    $('#district').on('change', function() {
      var district_id = $("#district option:selected").val();

      $("#subdistrict").select2({
        ajax: {
          url: "<?php echo base_url(); ?>get-subdistrict-data",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              searchTerm: params.term, // search term,
              district_id: district_id
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        },
        placeholder: 'Select for a district',
        theme: "bootstrap"
      });
    });
  });

  // show_data_province();
  show_full_address();

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
      if (element.parent(".input-group").length) {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
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
      district: {
        required: true
      },
      subdistrict: {
        required: true
      },
      street: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      province: {
        required: "Province is required!",
      },
      regency: {
        required: "Regency is required!"
      },
      district: {
        required: "District is required!"
      },
      subdistrict: {
        required: "Sub-district is required!"
      },
      street: {
        required: "Street name is required!",
        minlength: "Your street name too short!"
      }
    },
  });

  /* function show_data_province() {
    $.ajax({
      url: "<?php echo base_url(); ?>get-province-data",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option value="' + data[i].id_prov + '">' + data[i].nama + '</option>';
        }
        $('#province').html(html);
        $("#province").select2({
          placeholder: 'Select for a province',
          theme: "bootstrap"
        });
      }
    })
  } */

  function show_full_address() {
    $.ajax({
      url: "<?php echo base_url(); ?>get-address-data",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#show_full_address').html(data);
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
          if (data.status == true) //if success close modal and reload ajax table
          {
            show_full_address();

            $('#form-address')[0].reset(); // reset form on modals
            $('#province').val(null).trigger("change");
            $('#regency').val(null).trigger("change");
            $('#district').val(null).trigger("change");
            $('#subdistrict').val(null).trigger("change");

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
              '<strong>Alert <i class="fa fa-exclamation" aria-hidden="true"></i></strong><br>' +
              data.notif +
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            );

            $('#form-address')[0].reset(); // reset form on modals
            $('#province').val(null).trigger("change");
            $('#regency').val(null).trigger("change");
            $('#district').val(null).trigger("change");
            $('#subdistrict').val(null).trigger("change");

            effect_msg();
          }

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

          $('#form-address')[0].reset(); // reset form on modals
          $('#province').val(null).trigger("change");
          $('#regency').val(null).trigger("change");
          $('#district').val(null).trigger("change");
          $('#subdistrict').val(null).trigger("change");

          $('#btnSave').text('Save'); //change button text
          $('#btnSave').attr('disabled', false); //set button enable 

          effect_msg();
        }
      })
    }
  });
</script>