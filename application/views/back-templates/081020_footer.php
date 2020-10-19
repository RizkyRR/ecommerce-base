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


<!-- SCRIPT NOTIF MESSAGES -->
<script>
  $(document).ready(function() {
    setInterval(function() {
      incomingChatUnread();
      showCountIncomingLabel();
      showCountIncomingHeader();
    }, 2000); //request every x seconds
  });

  // to show all chat coming
  function incomingChatUnread() {
    var html = "";
    // to get count chat coming or not yet ready
    $.ajax({
      url: "<?php echo base_url('chat/chat_count_unread'); ?>",
      type: "ajax",
      dataType: "JSON",
      success: function(data) {
        if (data > 0) {
          html =
            '<a href="#">' +
            '<i class="fa fa-comments text-yellow"></i><span id="count-chat"></span> Chat</a>';
        }

        $("#show-count-chat").html(html);
        $("#count-chat").html(data);
      },
    });
  }

  // to show all comment coming

  // to count all messages
  function showCountIncomingLabel() {
    var jumlah;

    var getCountChat = Number($("#count-chat").val());
    var getCountComment = Number($("#count-comment").val());

    jumlah = getCountChat + getCountComment;

    if (jumlah > 0) {
      $(".show-count-incoming-label").val(jumlah);
    } else {
      $(".show-count-incoming-label").val(0);
    }
  }

  function showCountIncomingHeader() {
    var jumlah;
    var header = "";

    var getCountChat = Number($("#count-chat").val());
    var getCountComment = Number($("#count-comment").val());

    jumlah = getCountChat + getCountComment;

    if (jumlah > 0) {
      header = "You have " + jumlah + " messages";
      $("#show-count-incoming-header").val(header);
    } else {
      header = "You have 0 message";
      $("#show-count-incoming-header").val(header);
    }
  }
</script>

<!-- SCRIPT STOCK ALERTS -->
<script>
  $(document).ready(function() {
    setInterval(function() {
      incomingStockLimitInfo();
      incomingStockLimitCount();
    }, 2000); //request every x seconds
  });

  var base_url = "<?php echo base_url() ?>";

  // to show all stock coming
  function incomingStockLimitInfo() {
    var html = "";
    var i;
    // to get count stock coming or not yet ready
    $.ajax({
      url: "<?php echo base_url('product/getProductLessStockInfo') ?>",
      type: "ajax",
      dataType: "JSON",
      success: function(data) {
        for (i = 0; i < data.length; i++) {
          // TOLONG DICEK LAGI KARENA ADA MASALAH KETIKA DITAMBAHKAN DENGAN MODAL
          html +=
            '<a href="#" title="' +
            data[i].id +
            '">' +
            '<i class="fa fa-exclamation-circle text-red"></i>' +
            data[i].product_name +
            "'s" +
            " Stock in Limit!</a>";
        }

        $("#show-count-stock-limit").html(html);
      },
    });
  }

  function incomingStockLimitCount() {
    var html = "";
    // to get count stock coming or not yet ready
    $.ajax({
      url: "<?php echo base_url('product/getProductLessStockCount'); ?>",
      type: "ajax",
      dataType: "JSON",
      success: function(data) {
        if (data > 0) {
          $("#show-count-stock-limit-label").html(data);
          $("#show-count-stock-limit-header").html(
            "Anda memiliki " + data + " pemberitahuan"
          );
        } else {
          $("#show-count-stock-limit-label").html(0);
          $("#show-count-stock-limit-header").html(
            "Anda tidak memiliki pemberitahuan apapun"
          );
        }

        if (data > 5) {
          html = '<a href="product">View all</a>';
        }

        $(".show-view-all-stock").html(html);
      },
    });
  }

  /* function showCountStockLimitHeader() {
  	var jumlah;
  	var header = "";

  	var getCountChat = Number($("#count-chat").val());
  	var getCountComment = Number($("#count-comment").val());

  	jumlah = getCountChat + getCountComment;

  	if (jumlah > 0) {
  		header = "You have " + jumlah + " messages";
  		$("#show-count-stock-limit-header").val(header);
  	} else {
  		header = "You have 0 message";
  		$("#show-count-stock-limit-header").val(header);
  	}
  } */
</script>

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