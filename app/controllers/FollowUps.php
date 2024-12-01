<?php   
    
    class FollowUps extends Controller
    {

        public function __construct()
        {
            $this->followUp = model('FollowUpModel');
            $this->profiling = model('UserProfilingModel');

            $this->userAddresses = model('UserAddressesModel');
             $this->callModel = model('UserCallModel');

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
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

            // $data = $this->filterData($clients , $level);

            return $this->view('followup/index' , $data);
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
           
            $yourCustomer = $this->customerPreviewValidate($userId);

            if(!$yourCustomer)
                return redirect('users-for-follow-up/');

            $data = [
                'user' => $user,
                'userIdSealed' => $userIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'user_profiling_info' => $this->profiling->get_user_profiling_info($userId),
                'currentCustomer' => $this->callModel->getCustomer(whoIs()['id']),
                'addresses' => [
                    'cop' => $this->userAddresses->getCOP($userId)
                ]
            ];

            return $this->view('followup/show' , $data);
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

            $tagUpdate = $this->followUp->updateTag($userId , $tag);

            if($tagUpdate) {
                Flash::set('Tag Updated' , 'danger');
            }

            $level = $this->followUp->lastLevel;

            return redirect("users-for-follow-up/index?level={$level}");
        }

        public function moveNextLevel()
        {
            $userId = $_POST['user_id'] ?? 0;

            if(!$userId) {
                Flash::set("Invalid User" , 'danger');
                return request()->return();
            }

            $userId = unseal($userId);

            $whoIs = whoIs();

            /*i set to para sa follow
            *ginagamit para makuha data ni caller
            */
            $this->followUp->setCaller([
                'callerId' => $whoIs['id'],
                'type'     => $whoIs['whoIs']
            ]);

            /*
            *Pinag isa na move to next level
            *saka timesheet saving
            */
            
            
            $result = $this->followUp->moveNextLevelWithTimeSheet($userId);
            
          
            $info = $this->profiling->save_user_profiling($_POST, $userId);

        
            if($result) {
                Flash::set("User moved to next level");
            }else{

                Flash::set($this->followUp->errString , 'danger');
                return request()->return();
            }
            //get users last level
            $level = $this->followUp->lastLevel;

            return redirect("users-for-follow-up/index?level={$level}");
        }


        public function archives()
        {
            $data = [
                'clients' => $this->followUp->getByTag('dont-follow-up'),
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

            return $this->view('followup/index' , $data);
        }

         public function customerPreviewValidate($userId)
        {
            $customer = $this->callModel->getStatus($userId);
            
            if($customer){
                if(! isEqual($customer->handled_by, whoIs()['id']))
                    return false;
            }
            return true;
        }
    }