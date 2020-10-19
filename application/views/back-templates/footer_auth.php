<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>back-assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>back-assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function() {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(3000, 500).slideUp(500, function() {
      $(this).remove();
    });
  })
</script>
</body>

</html>