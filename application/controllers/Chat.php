<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->helper(['template', 'authaccess', 'sidebar']);
    checkSessionLog();
  }

  public function index()
  {
    $data['title'] = "Data Chat";

    $data['user'] = $this->auth_m->getUserSession();
    $data['company'] = $this->company_m->getCompanyById(1);
    // $data['chat'] = $this->chat_m->getAllChat();

    $this->load->view('back-templates/header', $data);
    $this->load->view('back-templates/topbar', $data);
    $this->load->view('back-templates/navbar', $data);
    // $this->load->view('chats/reply', $data);
    $this->load->view('chats/reply');
    $this->load->view('modals/modal-delete');
    $this->load->view('chats/index', $data);
    $this->load->view('back-templates/footer', $data);
  }

  // DataTables Controller Setup
  function show_ajax_chat()
  {
    $list = $this->chat_m->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($list as $item) {
      $no++;
      $id = htmlspecialchars(json_encode($item->sender_id));
      $row = array();
      $row[] = $no . ".";
      $row[] = $item->name;
      $row[] = $item->email;
      $row[] = $item->lastchathistory;

      if ($item->laststatus == "UNREAD") {
        $row[] = '<span class="label bg-yellow" alt="unread"><i class="fa fa-envelope"></i></span>';
      } else {
        $row[] = '<span class="label bg-green" alt="read"><i class="fa fa-envelope-open"></i></span>';
      }

      // add html for action
      $row[] =
        '
        <a href="javascript:void(0)" data-target="#modal" class="btn btn-primary btn-xs" onclick="readMessage(' . $item->sender_id . ', ' . $item->receiver_id . '), getReplyChat(' . $item->user_id . ')" title="reply chat"><i class="fa fa-reply"></i> Reply</a>

        <!-- <a href="javascript:void(0)" onclick="delete_chat(' . $item->receiver_id . ')" class="btn btn-danger btn-xs" title="delete chat"><i class="fa fa-trash-o"></i> Delete</a> -->
      ';
      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->chat_m->count_all(),
      "recordsFiltered" => $this->chat_m->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }

  // DataTables Cntroller End Setup

  public function updateReadMessage($sender_id, $receiver_id)
  {
    $data = [
      'status' => "READ"
    ];

    $this->chat_m->update($sender_id, $receiver_id, $data);
  }

  // first attempt and always fuck me up
  public function reply_chat($receiver_id)
  {
    $getSessionID = $this->session->userdata('id');
    $replyHistory = $this->chat_m->getChatByID($receiver_id);

    $data = array();

    foreach ($replyHistory as $value) {
      $sender = $value['sender_id'];
      // $getReceiverID = $value['receiver_id'];

      // $user = $this->user_m->getUserById($id);

      $message = $value['content'];
      $receiveTime = date('d M H:i A', strtotime($value['time']));

      $messageView = '';

      if ($getSessionID != $sender) {
        $messageView = '
        
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left">' . $value['name'] . '</span>
              <span class="direct-chat-timestamp pull-right">' . $receiveTime . '</span>
            </div>
            
            <img class="direct-chat-img" src="' . base_url() . 'image/profile/' . $value['image'] . '" alt="' . $value['name'] . '">
            
            <div class="direct-chat-text">
              ' . $message . '
            </div>

          </div>
        ';
        $data[] = $messageView;
      } else {
        $messageView = '
        
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right">' . $value['name'] . '</span>
              <span class="direct-chat-timestamp pull-left">' . $receiveTime . '</span>
            </div>
            
            <img class="direct-chat-img" src="' . base_url() . 'image/profile/' . $value['image'] . '" alt="' . $value['name'] . '">
            
            <div class="direct-chat-text">
            ' . $message . '
              
            </div>
            
          </div>
        ';
        $data[] = $messageView;
      }
    }

    $output = array(
      "messageView" => $data,
      // "sender_id" => $sender_id,
      "receiver_id" => $receiver_id
    );

    echo json_encode($output);
  }

  public function send_chat()
  {
    date_default_timezone_set('Asia/Jakarta');

    $data = array(
      'sender_id' => $this->session->userdata('id'),
      'receiver_id' => $this->input->post('receiver_id', true),
      'content' => $this->input->post('message', true),
      'time' => date('Y-m-d H:i:s')
    );

    $this->chat_m->createMessage($data);
    echo json_encode('success');
  }

  public function chat_count_unread()
  {
    $data = $this->chat_m->getUnreadMessageCount();

    echo json_encode($data);
  }

  public function delete_chat()
  {
    $this->chat_m->delete($this->input->post('id'));

    $this->session->set_flashdata('success', 'Deleted !');
  }
}
  
  /* End of file Chat.php */
