<footer class="main-footer">
  <strong>Copyright &copy; <?php echo date("Y") ?> <a href="<?php echo base_url(); ?>admin"><?php echo $company['company_name'] ?></a>.</strong> All rights
  reserved.
</footer>

</div>
<!-- ./wrapper -->


<!-- FastClick -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>back-assets/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="<?php echo base_url(); ?>back-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>back-assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/chart.js/Chart.js"></script>

<!-- CK Editor -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>back-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- chat notification -->
<!-- <script src="<?php echo base_url(); ?>back-assets/plugins/custom-notification/messages-notif.js"></script> -->

<!-- stock notification -->
<!-- <script src="<?php echo base_url(); ?>back-assets/plugins/custom-notification/stock-notif.js"></script> -->

<!-- main-js -->
<!-- <script src="<?php echo base_url(); ?>back-assets/main-js/event-calendar.js"></script> -->

<!-- Alert auto fade out -->
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(5000, 500).slideUp(500, function() {
      $(this).remove();
    });
  })
</script>

<!-- Sweet Alert -->
<script>
  $('.button-delete').on('click', function(e) {

    e.preventDefault();
    const href = $(this).attr('href');

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Delete'
    }).then((result) => {
      if (result.value) {
        document.location.href = href;
      }
    });
  });
</script>

<!-- check and update access -->
<script>
  //untuk ajax role akses 
  $('.check-access').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?php echo base_url('role/accessupdate') ?>",
      type: "POST",
      data: {
        //object data: variabel(yang diambil dari checkbox)
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        document.location.href = "<?php echo base_url('role/accessrole/'); ?>" + roleId;
      }
    });

  });
</script>

<!-- active menu and submenu adminlte -->
<script type="text/javascript">
  var url = window.location;
  // for sidebar menu but not for treeview submenu
  $('ul.sidebar-menu a').filter(function() {
    return this.href == url;
  }).parent().siblings().removeClass('active').end().addClass('active');
  // for treeview which is like a submenu
  $('ul.treeview-menu a').filter(function() {
    return this.href == url;
  }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
</script>

</body>

</html>