<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
  </section>

  <!-- <section class="content-header">
    <button onclick="new_chat()" class="btn btn-primary"><i class="fa fa-plus"></i> Chat</button>
  </section> -->

  <section class="content-header">
    <div class="row">
      <div class="col-lg-12 msg-alert"></div>
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
        <table class="table table-hover" id="table-data">
          <thead>
            <tr>
              <th class="no-sort">No</th>
              <th>Sender</th>
              <th>Email</th>
              <th>Time</th>
              <th>Status</th>
              <th class="no-sort">Actions</th>
            </tr>
          </thead>
          <tbody id="show_data_chat">
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
  var save_method; //for save method string
  var table;

  $(document).ready(function() {
    table = $('#table-data').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= base_url(); ?>chat/show_ajax_chat",
        "type": "POST"
      },
      "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
      }],
      'order': []
    });

    $('#btnSend').attr('disabled', true);
    $('#message').keyup(function() {
      if ($(this).val().length != 0) {
        $('#btnSend').attr('disabled', false);

        // reply modal controll
        $(".message").keypress(function(event) {
          var keycode = event.keyCode ? event.keyCode : event.which;
          if (keycode == "13") {
            if ($('#message').val() != "") {
              send();
            }
          }
        })
      } else {
        $('#btnSend').attr('disabled', true);
      }
    })
  });

  function effect_msg() {
    // $('.msg-alert').hide();
    $('.msg-alert').show(1000);
    setTimeout(function() {
      $('.msg-alert').fadeOut(1000);
    }, 3000);
  }

  function scrollDown() {
    var elmnt = $('#content').val();
    var h = elmnt.scrollHeight;
    $("#content").animate({
      scrollTop: h
    }, 1000);
  }

  window.onload = scrollDown();

  function closeModal(setTime) {
    $('#modal-chat').modal('hide');
    $('#chat-form')[0].reset();

    clearInterval(setTime);
  }

  function readMessage(sender_id, receiver_id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo base_url('chat/updateReadMessage/') ?>" + sender_id + '/' + receiver_id,
      type: "POST",
      dataType: "JSON",
      success: function() {

        console.log('message read');

      }
    });
  }

  function getReplyChat(receiver_id) {

    //Ajax Load data from ajax
    $.ajax({
      // url: "<?php echo base_url('chat/reply_chat/') ?>" + sender_id + '/' + receiver_id,
      url: "<?php echo base_url('chat/reply_chat/') ?>" + receiver_id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        var i;
        var html = '';
        var messageResult = data.messageView;

        for (i = 0; i < messageResult.length; i++) {
          html += data.messageView[i];
        }

        $("#message-content").html(html);

        // $("#message-content").html(data.messageView);
        console.log(data);
        // $('#sender_id').val(data.sender_id);
        $('#receiver_id').val(data.receiver_id);

        scrollDown();
        $('#modal-chat').modal('show'); // show bootstrap modal when complete loaded
        $('.box-title').text('Reply Chat'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function send() {
    var messageTxt = $('#message').val();

    if (messageTxt != "") {
      // displayMessage(messageTxt);

      $('#btnSend').text('sending...'); //change button text
      $('#btnSend').attr('disabled', true); //set button disable 

      // var sender_id = $("#sender_id").val();
      var receiver_id = $("#receiver_id").val();

      // ajax adding data to database
      $.ajax({
        url: "<?php echo base_url('chat/send_chat') ?>",
        type: "POST",
        data: $('#chat-form').serialize(),
        dataType: "JSON",
        success: function(data) {

          getReplyChat(receiver_id);

          $('#btnSend').text('send'); //change button text
          $('#btnSend').attr('disabled', false); //set button enable 

        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#btnSend').text('send'); //change button text
          $('#btnSend').attr('disabled', false); //set button enable 

        }
      });
      scrollDown();
      $(".message").val("");
      $(".message").focus();
    } else {
      $(".message").focus();
    }
  }

  var setTime = setInterval(function() {
    var receiver_id = $("#receiver_id").val();
    if (receiver_id != "") {
      getReplyChat(receiver_id);
    }
  }, 3000);

  // closeModal(setTime);

  $('#closeModal').click(function() {
    if (this.id == 'closeModal') {
      table.ajax.reload(null, false);
      closeModal(setTime);
    }
  });

  function delete_chat(id) {
    $('#modal-delete').modal('show'); // show bootstrap modal
    $('.modal-title').text('Are you sure to delete this chat?'); // Set Title to Bootstrap modal title

    $(document).on("click", ".delete-data", function() {
      $.ajax({
        method: "POST",
        url: "<?php echo base_url('chat/delete_chat') ?>",
        data: {
          id: id
        },
        success: function(data) {
          $('#modal-delete').modal('hide');

          table.ajax.reload(null, false);

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
            'Error deleting data !' +
            '</div>'
          );
          effect_msg();
        }
      })
    })
  }
</script>