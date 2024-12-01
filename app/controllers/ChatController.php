<?php 

    class ChatController extends Controller
    {
        public $chatModel;

        public function __construct()
        {
            parent::__construct();    
            $this->chatModel = model('ChatModel');
            $this->userModel = model('User_model');
        }

        public function index() {
            $data = [];
            return $this->view('chat/index', $data);
        }

        /**
         * chat with new user
         */
        public function new() {
            $req = request()->inputs();

            $user = $this->userModel->getSingle([
                'where' => [
                    'user.id' => $req['recipientId']
                ]
            ]);

            $data = [
                'user' => $user
            ];
            
            return $this->view('chat/new', $data);
        }

        public function api_send_message() {
            if(isSubmitted()) {
                $post = request()->posts();
                $this->chatModel->addNewOneToOneMessaage($post['senderId'], $post['recipientId'], $post['message']);
            }
        }

        /**
         * parameter
         * recipientId, senderId
         */
        public function api_fetch_one_on_one_message() {
            $req = request()->inputs();
            $chats = $this->chatModel->getOneOnOneMessage($req['senderId'], $req['recipientId']);
            echo api_response(['chats' => $chats]);
        }

        public function api_get_senderId() {
            echo api_response(whoIs('id'));
        }
    }