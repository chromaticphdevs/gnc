<?php   
    
    class UserCustomerFollowUps extends Controller
    {   
        
        public $endpoint = 'UserCustomerFollowUps';

        public function __construct()
        {
            $this->followUp = model('UserCustomerFollowUpModel');
            $this->user_model = model('User_model');
            $this->userOnCall = model('UserCallModel');

            Authorization::setAccess(['admin' , 'customer-service-representative']);
        }

        public function index()
        {
            $clients  = [];
            $level = 1;
 
            if(isset($_GET['level']) && intval($_GET['level']) > 1)
            {
                $level = $_GET['level'];
                $clients = $this->followUp->getByLevel($_GET['level']);
            }else{
                
                $clients = $this->followUp->getFirstLevel();
            }
            
            $data = [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels(),
                'endpoint' => $this->endpoint
            ];

            $linksAndButtons = [
                'previewLink' => '/UserCustomerFollowUps/show',
                'updateController' => '/UserCustomerFollowUps/update',
            ];

            $data['linksAndButtons'] = $linksAndButtons;


            return $this->view('user_customer_followup/index' , $data);
        }

        private function filterData($clients , $level)
        {
            $maxData = 100;
            $offset  = $_GET['offset'] ?? 0;

            $clients = array_splice($clients , intval($offset) , intval($offset + $maxData));

            return [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels(),
                'maxData'  => $maxData,
                'offset'  => $offset
            ];
        }

        public function show($userIdSealed)
        {
            $userId = unseal($userIdSealed);

            $user = $this->followUp->getUser($userId);
            $userNotes = $this->followUp->getUserNotes($userId);
            $data = [
                'user' => $user,
                'userNotes' =>  $userNotes,
                'userIdSealed' => $userIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'total_direct' =>$this->user_model->get_direct_sponsor_total($userId),
                'endpoint' => $this->endpoint,
                'currentCustomer' => false
            ];  

            $linksAndButtons = [
                'previewLink' => '/UserCustomerFollowUps/show',
                'updateController' => '/UserCustomerFollowUps/update',
            ];

            $data['linksAndButtons'] = $linksAndButtons;
            

            return $this->view('user_customer_followup/show' , $data);
        }


        public function update()
        {

            if(isset($_POST['move_next_level']))
            {
                $this->moveNextLevel();
            }

            if(isset($_POST['do_not_follow_up']))
            {
                $this->tagUpdate('dont-follow-up');
            }

        }

        public function tagUpdate($tag)
        {
            $userId = $_POST['user_id'] ?? 0;

            $userId = unseal($userId);
            $note = $_POST['note'];

            $tagUpdate = $this->followUp->updateTag($userId , $tag , $note);

            if($tagUpdate) {
                Flash::set('Tag Updated' , 'danger');
            }

            $level = $this->followUp->lastLevel;

            return redirect("UserCustomerFollowUps/index?level={$level}");
        }

        public function moveNextLevel()
        {
            $userId = $_POST['user_id'] ?? 0;

            $note = $_POST['note'];

            if(!$userId) {
                Flash::set("Invalid User" , 'danger');
                return request()->return();
            }

            $userId = unseal($userId);
            
            $whoIs = whoIs();
            
            $this->followUp->setCaller([
                'callerId' => $whoIs['id'],
                'type'     => $whoIs['whoIs']
            ]);

            $result = $this->followUp->moveNextLevelWithTimeSheet($userId , $note);

            if($result) {
                Flash::set("User moved to next level");
            }else{
                Flash::set($this->followUp->errString , 'danger');
                return request()->return();
            }
            //get users last level
            $level = $this->followUp->lastLevel;

            return redirect("UserCustomerFollowUps/index?level={$level}");
        }


        public function archives()
        {
            $data = [
                'clients' => $this->followUp->getByTag('dont-follow-up'),
                'activeLevels'  => $this->followUp->getAllLevels(),
                'endpoint' => $this->endpoint
            ];

            return $this->view('user_customer_followup/index' , $data);
        }
    }