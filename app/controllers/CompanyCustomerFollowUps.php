<?php   

    /**
     * ROUTE NAME
     * company-customers-follow-ups
     */
    class CompanyCustomerFollowUps extends Controller
    {
        
        public $endpoint = 'company-customers-follow-ups';

        public function __construct()
        {
            $this->followUp = model('CompanyCustomerFollowUpModel');
            $this->user_model = model('User_model');
            $this->callModel = model('UserCallModel');
            $this->profiling = model('UserProfilingModel');

            $this->userAddresses = model('UserAddressesModel');
            
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
                
                $clients = $this->followUp->getCompanyCustomers();
            }
            
            $data = [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels(),
                'endpoint' => $this->endpoint
            ];


            $linksAndButtons = [
                'previewLink' => '/company-customers-follow-ups/show',
                'updateController' => '/company-customers-follow-ups/update',
            ];

            $data['linksAndButtons'] = $linksAndButtons;

            return $this->view('user_customer_followup/index' , $data);
        }

        public function show($userIdSealed)
        {
            $userId = unseal($userIdSealed);

            $user = $this->followUp->getUser($userId);
            
            $userNotes = $this->followUp->getUserNotes($userId);

            $yourCustomer = $this->customerPreviewValidate($userId);
            
            if(!$yourCustomer)
                return redirect('company-customers-follow-ups/');

            $data = [
                'user' => $user,
                'userNotes' =>  $userNotes,
                'userIdSealed' => $userIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'total_direct' =>$this->user_model->get_direct_sponsor_total($userId),
                'endpoint' => $this->endpoint,
                'currentCustomer' => $this->callModel->getCustomer(whoIs()['id']),
                'user_profiling_info' => $this->profiling->get_user_profiling_info($userId),
                'addresses' => [
                    'cop' => $this->userAddresses->getCOP($userId)
                ]
            ];  

            $linksAndButtons = [
                'updateController' => '/CompanyCustomerFollowUps/update',
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

            if(isset($_POST['save_profile']))
            {
                $this->saveProfiling();
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

            return redirect("company-customers-follow-ups/index?level={$level}");
        }



       
        public function saveProfiling()
        {
            $q = request()->inputs();

            $customerIdSealed = $q['user_id'];

            $customerId = unseal($customerIdSealed);

            $note = $_POST['note'];

            $whoIs = whoIs();

            $isCalled = $this->callModel->getAndDropCall($customerId , $whoIs['id'] , $whoIs['whoIs']);

            $info = $this->profiling->save_user_profiling($_POST, $customerId);

            if($info) {
                Flash::set("Info saved");
            }

            return request()->return();
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

            $info = $this->profiling->save_user_profiling($_POST, $userId);

            $whoIs = whoIs();

            /*
            *i set to para sa follow
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
            $result = $this->followUp->moveNextLevelWithTimeSheet($userId , $note);

            if($result) {
                Flash::set("User moved to next level");
            }else{
                Flash::set($this->followUp->errString , 'danger');
                return request()->return();
            }
            //get users last level
            $level = $this->followUp->lastLevel;

            return redirect("company-customers-follow-ups/index?level={$level}");
        }


        public function archives()
        {
            $data = [
                'clients' => $this->followUp->getByTag('dont-follow-up'),
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

            return $this->view('user_customer_followup/index' , $data);
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