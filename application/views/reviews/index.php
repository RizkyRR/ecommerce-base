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

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12 msg-alert"></div>
    </div>
  </section>

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12">
        <div class="callout callout-info">
          <h4><i class="fa fa-bullhorn"></i> Attention.</h4>

          <p>Read a review by clicking the button <button class="btn btn-info btn-xs"><i class="fa fa-search" aria-hidden="true"></i> Detail</button> and <button class="btn btn-success btn-xs"><i class="fa fa-reply" aria-hidden="true"></i> Reply</button></p>
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
        <table class="table table-hover" id="table-data-review">
          <thead>
            <tr>
              <th class="no-sort">No</th>
              <th>Product</th>
              <th>Customer Name</th>
              <th>Customer Email</th>
              <th>Customer Rating</th>
              <th>Message</th>
              <th>Status</th>
              <th>Comment Date</th>
              <th class="no-sort">Actions</th>
            </tr>
          </thead>
          <tbody id="show_data_review">
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

<script>
  var table_review;

  $(document).ready(function() {
    table_review = $("#table-data-review").DataTable({
      processing: true,
      serverSide: true,
      bLengthChange: false,
      ajax: {
        url: "<?php echo base_url() ?>review/showAjaxReview",
        type: "POST",
      },
      order: [],
      columnDefs: [{
        targets: "no-sort",
        orderable: false,
      }, ],
    });

    $('.btnCloseDetailReview').click(function() {
      table_review.ajax.reload(null, false);
    })
  });

  function detail_review(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('review/getDetailCustomerReview') ?>",
      data: {
        comment_id: id,
      },
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('#show-detail-review-image').html(data.review_image);
        $('#show-detail-review-message').html(data.review_message);
        $('#show-detail-review-reply-message').html(data.reply_message);
        $('#show-detail-review-reply-image').html(data.reply_image);

        $('#modal-detail-review').modal('show');
        $('.modal-title').text('Detail Review ' + data.customer_name + ' to product ' + data.product_name); // Set title to Bootstrap modal title
      },
    });
  }

  function delete_review(id) {
    Swal.fire({
      icon: 'warning',
      title: 'Are you sure you want to delete review data?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?php echo base_url('review/deleteReviewData') ?>',
          data: {
            comment_id: id
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

            table_review.ajax.reload(null, false);
          }
        });
      }
    });
  }

  function delete_reply(id) {
    Swal.fire({
      icon: 'warning',
      title: 'Are you sure you want to delete review reply data?',
      text: "You won't be able to revert this!",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?php echo base_url('review/deleteReviewReplyData') ?>',
          data: {
            reply_id: id
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

            table_review.ajax.reload(null, false);
          }
        });
      }
    });
  }
</script>