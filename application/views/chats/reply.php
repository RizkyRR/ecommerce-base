<div class="modal fade" id="modal-chat">
  <div class="modal-dialog">
    <!-- DIRECT CHAT PRIMARY -->
    <div class="box box-primary direct-chat direct-chat-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Direct Chat</h3>

        <div class="box-tools pull-right">
          <!-- <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button> -->
          <button type="button" class="btn btn-box-tool" id="closeModal" onclick="closeModal(this)" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">

        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages" id="content">

          <div id="message-content"></div>

          <!-- /.direct-chat-msg -->
        </div>
        <!--/.direct-chat-messages-->

      </div>
      <!-- /.box-body -->
      <div class="box-footer form">
        <form action="" id="chat-form" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <div class="input-group">
              <!-- <input type="hidden" class="form-control" name="sender_id" id="sender_id"> -->
              <input type="hidden" class="form-control" name="receiver_id" id="receiver_id">
              <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control message" required>
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-flat" id="btnSend" onclick="send()">Send</button>
                <!-- <button type="submit" class="btn btn-primary btn-flat" id="btnSend">Send</button> -->
              </span>
            </div>

            <span id=" msg_message_error" class="help-block"></span>
          </div>
        </form>
      </div>
      <!-- /.box-footer-->
    </div>
    <!--/.direct-chat -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->