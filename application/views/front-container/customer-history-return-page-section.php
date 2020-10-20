<!-- Main content from side menu customer section -->
<div class="col-lg-9 order-1 order-lg-2">
  <div class="product-show-option">
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

      <div class="table-responsive">
        <table class="table" id="table-data-purchase-return">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice Return</th>
              <th>Return Date</th>
              <th>Total Products</th>
              <th>Total Amount</th>
              <th>Status Return</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="show-data-purchase-return">

          </tbody>
        </table>
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
    table = $('#table-data-purchase-return').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>get-data-customer-return",
        "type": "POST"
      },
      dom: 'Bfrtip',
      "columnDefs": [{
        "targets": [0, 3, 4, 6],
        "orderable": false,
        "searchable": false
      }],
      'order': []
    });
  });

  function deleteReview(id) {
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
          url: '<?php echo base_url() ?>delete-comment-review/' + id,
          type: 'POST',
          dataType: 'JSON',
          success: function(data) {
            if (data.status == true) {
              Swal.fire({
                icon: "success",
                title: "Successfully deleted your comment!",
                showConfirmButton: false,
                timer: 5000,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Failed deleted your comment, please try again!",
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