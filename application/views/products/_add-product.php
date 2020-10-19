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
    <div class="box box-solid">

      <!-- form start -->
      <form role="form" action="" method="POST" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="id">Product ID</label>
            <input type="text" class="form-control" name="id" id="id">
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="name">Product name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" value="<?php echo set_value('name'); ?>">
            <span class="help-block"><?php echo form_error('name') ?></span>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="category">Product category</label>
            <select class="form-control select-category" name="category" id="category">
            </select>
            <span class="help-block"><?php echo form_error('category') ?></span>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="supplier">Product supplier</label>
            <select class="form-control select-supplier" name="supplier" id="supplier">
            </select>
            <span class="help-block"><?php echo form_error('supplier') ?></span>
          </div>
        </div>

        <!-- <div class="box-body">
          <div class="form-group">
            <label for="image">Product image</label>
            <input type="file" class="form-control" name="image[]" multiple>
          </div>
        </div> -->

        <!-- For Table -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="image_info_table" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th style="width:50%">File Image</th>
                <th style="width:40%">Image</th>
                <th style="width:10%;">
                  <button type="button" id="add_row" class="btn btn-primary btn-xs"> <i class="fa fa-plus"></i></i> </button>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr id="row_1">
                <td>
                  <!-- select2 with image  -->
                  <!-- https://codepen.io/ndmtg/pen/rdwQza?__cf_chl_captcha_tk__=fe44f4889a640b05c1379721e755debc4ee3ae7e-1584436181-0-Abq-Dzzw1tVVZdxuMJ8FUiWPZK6sLQgq7NHIBTOxmQ0Mg8LHjI9v9p8G3PGJKH9-RfBBGEEXGhSNVQwCeF_1qOJogiEVvFfIemvyB9OZNIn66xE-n4Zl7_VpnSoNi-7uWjhrMETwACsYYgRb6-NX3S9hW9-it4NOLtp3YS31xNYWP8LmMnl_lFvCowWgvfsWLatkNtpZisaDIsClZU71iyNdf_fuSRrBs8OOxD5HgjGAfTevvy6r4etbZLAkuxrsMJJVhLzlE2jCeZS8CszrvpaNGS8RcDQ9hlQ8JwwtHxqv40Qp8o8Dq1LhAA2gGHYbgGTm0LWrnKPe_9nXeBpuYOW6W_SA51IVdut3teQ8MUOS-VsVqeF8onH2pSpYDmAhagp69rjbwKTQvBdcw1fLhuRo5g3Dw5LFzHUYT0nTdk34o9ZIEF2XsNargjy3--AIed9_4rQd5GLS0SYRuQDpjnI -->
                  <!-- https://stackoverflow.com/questions/29290389/select2-add-image-icon-to-option-dynamically -->
                  <!-- https://codepen.io/ndmtg/pen/rdwQza -->
                  <!-- https://jsfiddle.net/fr0z3nfyr/uxa6h1jy/ -->
                  <select name="image[]" id="image_1" class="form-control select_group image" data-row-id="row_1" onchange="getImageData(1)" required>
                  </select>
                </td>
                <td>
                  <img class="img-responsive" id="detailimage_1" src="" style="width: 25%">
                </td>
                <td>
                  <button type="button" class="btn btn-danger btn-xs" onclick="removeRow('1')"><i class="fa fa-times"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- For Table -->-

        <div class="box-body">
          <div class="form-group">
            <label for="editor1">Product description</label>
            <textarea class="form-control" id="description" name="description" rows="10" cols="10"><?php echo set_value('description'); ?></textarea>
            <span class="help-block"><?php echo form_error('description') ?></span>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group">
            <label for="price">Product price</label>
            <div class="input-group">
              <span class="input-group-addon">Rp</span>
              <input type="text" class="form-control" name="price" id="price" placeholder="Enter product price" value="<?php echo set_value('price'); ?>">
            </div>
            <span class="help-block"><?php echo form_error('price') ?></span>
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <a href="<?php echo base_url(); ?>product" class="btn btn-default">Back</a>
          <input type="submit" name="save" value="Submit" class="btn btn-primary">
        </div>
      </form>

    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  create_code();
  show_data_category();
  show_data_supplier();
  show_data_image();
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
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

    // FOR TABLE NEW ORDER
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    // Add new row in the table
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#image_info_table");
      var count_table_tbody_tr = $("#image_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;

      $.ajax({
        url: '<?php echo base_url(); ?>' + 'product/getTableImageRow/',
        type: 'POST',
        dataType: 'JSON',
        success: function(response) {

          // console.log(reponse.x);
          var html = '<tr id="row_' + row_id + '">' +
            '<td>' +
            '<select class="form-control select_group image" data-row-id="' + row_id + '" id="image_' + row_id + '" name="image[]" onchange="getImageData(' + row_id + ')">' +
            '<option value=""></option>';

          $.each(response, function(index, value) {
            html += '<option value="' + value.id + '">' + value.image + '</option>';
          });

          html += '</select>' +
            '</td>' +
            '<td><img class="img-responsive" id="detailimage_' + row_id + '" src="" style="width: 25%"></td>' +

            '<td><button type="button" class="btn btn-danger btn-xs" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-times"></i></button></td>' +
            '</tr>';

          if (count_table_tbody_tr >= 1) {
            $("#image_info_table tbody tr:last").after(html);
          } else {
            $("#image_info_table tbody").html(html);
          }

          $(".select_group").select2();

        }
      });

      return false;
    });
    // FOR TABLE NEW ORDER
  });

  function show_data_image() {
    $.ajax({
      url: "<?php echo base_url(); ?>product/getTableImageRow",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].id + '"><img src="' + base_url + 'image/gallery/' + data[i].image + '" height="42" width="42">' + data[i].image + '</option>';
        }
        $('.select_group').html(html);
      }
    })
  }

  // get the image information from the server
  function getImageData(row_id) {
    var image_id = $("#image_" + row_id).val();
    if (image_id == "") {
      $("#detailimage_" + row_id).val("");

    } else {
      $.ajax({
        url: '<?php echo base_url(); ?>' + 'product/getImageValueById',
        type: 'POST',
        data: {
          image_id: image_id
        },
        dataType: 'JSON',
        success: function(response) {
          // setting the price value into the price input field
          $('#detailimage_' + row_id).attr('src', base_url + 'image/gallery/' + response.image);
        } // /success
      }); // /ajax function to fetch the product data
    }
  }

  function removeRow(tr_id) {
    $("#image_info_table tbody tr#row_" + tr_id).remove();
  }

  function create_code() {
    $.ajax({
      url: '<?php echo base_url('product/create_code') ?>',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('#id').val(data).prop("readonly", true);
      }
    })
  }

  function show_data_category() {
    $('.select-category').select2();

    $.ajax({
      url: "<?php echo base_url(); ?>product/getProduct",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].id + '">' + data[i].category_name + '</option>';
        }
        $('.select-category').html(html);
      }
    })
  }

  function show_data_supplier() {
    $('.select-supplier').select2();

    $.ajax({
      url: "<?php echo base_url(); ?>product/getSupplier",
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        var html = '<option value=""></option>';
        var i;

        for (i = 0; i < data.length; i++) {
          html += '<option class="form-control" value="' + data[i].id + '">' + data[i].supplier_name + '</option>';
        }
        $('.select-supplier').html(html);
      }
    })
  }
</script>