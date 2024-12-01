<?php 

    class ChatGroupController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->chatModel = model('ChatModel');
            $this->userModel = model('User_model');
            authRequired();
        }
        public function index() {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                $this->chatModel->addNewGroupMessage($post['gc_id'], $post['user_id'], $post['chat']);
                return redirect('ChatGroupController/?groupId=' . $post['gc_id']);
            }
            $data = [
                'groups' => $this->chatModel->getUserGroups(whoIs('id')),
                'req' => $req
            ];
            
            if(!empty($req['groupId'])) {
                $data['members'] = $this->chatModel->getMembers($req['groupId']);
                $data['messages'] = $this->chatModel->getGroupChatMessages($req['groupId']);
                $data['group']  = $this->chatModel->getGroup($req['groupId']);
            }
            return $this->view('chat_group/index', $data);
        }

        public function show() {

        }

        public function create() {
            if(isSubmitted()) {
                $post = request()->posts();
                $chatId = $this->chatModel->addNewGroup(whoIs('id'), $post['group_title']);

                if(!$chatId) {
                    Flash::set("Something went wrong", 'danger');
                    return request()->return();
                }

                if(!empty($post['users_username'])) {
                    $this->addMembers($post['users_username']);
                }
                return redirect('/ChatGroupController/index?groupId=' . $chatId);
            }
        }

        public function addGroupMember() {
            if(isSubmitted()) {
                $post = request()->posts();

                if(!empty($post['users_username'])) {
                    $members = $this->addMembers($post['users_username']);
                    if($members) {
                        foreach($members as $key => $row) {
                            $this->chatModel->addGroupMember($post['gc_id'], $row->id, whoIs('id'));
                        }
                    } else {
                        Flash::set("No members found", 'danger');
                    }
                    return redirect('/ChatGroupController/index?groupId=' . $post['gc_id']);
                } else {
                    Flash::set("members username not found", 'danger');
                    return request()->return();
                }
            }
        }

        public function removeMember($id) {
            $this->chatModel->removeGroupMember($id);
            return request()->return();
        }

        private function addMembers($membersUsername) {
            $userNameArray = explode(',', $membersUsername);
            $userNameArray = array_map('trim', $userNameArray);

            $users = [];

            if(!empty($userNameArray)) {
                foreach($userNameArray as $key => $row) {
                    if($user = $this->userModel->getSingle([
                        'where' => [
                            'user.username' => $row
                        ]
                    ])) {
                        $users [] = $user;
                    }
                }
            }
            return $users;
        }
    }