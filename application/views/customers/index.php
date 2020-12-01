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

    <!-- Default box -->
    <div class="box">

      <div class="box-header">
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-hover" id="table-data-customer">
          <thead>
            <tr>
              <th class="no-sort">No</th>
              <th>Customer ID</th>
              <th>Customer Name</th>
              <th>Birth Date</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Joined At</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody id="show_data_customer">
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
  // var save_method; //for save method string
  var table_customer;

  // https://adminlte.io/themes/dev/AdminLTE/pages/examples/invoice.html

  $(document).ready(function() {
    table_customer = $('#table-data-customer').DataTable({
      "processing": true,
      "serverSide": true,
      "bLengthChange": false,
      "ajax": {
        "url": "<?php echo base_url(); ?>customer/show_ajax_customer",
        "type": "POST"
      },
      'order': [],
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }]
    });
  });

  function detailCustomer(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url() ?>customer/getDetailCustomer",
      data: {
        customer_id: id
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        var full_address = data.street_name + ', ' + data.city_name + ', ' + data.province;

        $('[name="customer_id"]').val(data.id_customer).attr('readonly', true);
        $('[name="customer_name"]').val(data.customer_name);
        $('[name="customer_gender"]').val(data.gender_name);
        $('[name="birth_date"]').val(moment(data.birth_date).format('DD MMMM YYYY')).prop("readonly", true);
        $('[name="customer_email"]').val(data.customer_email);
        $('[name="customer_phone"]').val(data.customer_phone);
        $('[name="customer_address"]').val(full_address);
        $('[name="created_at"]').val(moment(data.created_at).format('DD MMMM YYYY HH:mm:ss')).prop("readonly", true);

        $('#image-container').html('<img class="img-responsive" style="width: auto; height: auto;" src="' + '<?php echo base_url(); ?>image/customer_profile/' + '' + data.customer_image + '" />'); // tambahan

        // ZoomImage ZoomMaster
        $('#image-container').zoom({
          on: 'mouseover'
        });

        $('#modal-customer').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Customer'); // Set title to Bootstrap modal title
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

  /* function deleteCustomer(id) {
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
          url: '<?php echo base_url() ?>customer/deleteCustomer',
          data: {
            customer_id: id
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
  } */
</script>