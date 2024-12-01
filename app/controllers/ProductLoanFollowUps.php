<?php   
    
    class ProductLoanFollowUps extends Controller
    {

        public function __construct()
        {
            $this->followUp = model('ProductLoanFollowUpModel');
            $this->profiling = model('UserProfilingModel');
            Authorization::setAccess(['admin' , 'customer-service-representative']);
        }

        public function index()
        {
            $clients  = [];
            $level = 1;
            
            $branchId = check_session();
            $status ='Approved';

            if(isset($_GET['level']) && intval($_GET['level']) > 1)
            {
                $level = $_GET['level'];
                $clients = $this->followUp->getByLevel($_GET['level'], $branchId,  $status);
            }else{
                
                $clients = $this->followUp->getFirstLevel($branchId,  $status);
            }
            
            $data = [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

            // $data = $this->filterData($clients , $level);

            return $this->view('product_loan_followup/index' , $data);
        }

        private function filterData($clients , $level)
        {
            $maxData = 100;
            $offset  = $_GET['offset'] ?? 0;

            $clients = array_splice($clients , intval($offset) , intval($offset + $maxData));

            return [
                'clients' => $clients,
                'level'   => $level,
                'activeLevels'  => $this->followUp->getAllLevels('7'),
                'maxData'  => $maxData,
                'offset'  => $offset
            ];
        }

        public function show()
        {
            $loanIdSealed = $_GET['loanId'];
            $userIdSealed = $_GET['userid'];
            $userId = unseal($userIdSealed);

            $user = $this->followUp->getUser($userId);
            $loaninfo = $this->followUp->get_loan_info(unseal($loanIdSealed));
            $userNotes = $this->followUp->getUserNotes(unseal($loanIdSealed));

            $data = [
                'user' => $user,
                'userNotes' =>  $userNotes,
                'loaninfo' => $loaninfo,
                'userIdSealed' => $userIdSealed,
                'loanIdSealed' => $loanIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'user_profiling_info' => $this->profiling->get_user_profiling_info($userId)
            ];

            return $this->view('product_loan_followup/show' , $data);
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
            $loanId = unseal($_POST['loan_id']);


            $tagUpdate = $this->followUp->updateTag($userId , $loanId, $tag , $note);

            if($tagUpdate) {
                Flash::set('Tag Updated' , 'danger');
            }

            $level = $this->followUp->lastLevel;

            return redirect("ProductLoanFollowUps/index?level={$level}");
        }

        public function moveNextLevel()
        {
            $userId = $_POST['user_id'] ?? 0;

            $note = $_POST['note'];
            $loanId = unseal($_POST['loan_id']);

            if(!$loanId) {
                Flash::set("Invalid" , 'danger');
                return request()->return();
            }

            $userId = unseal($userId);
            
            $info = $this->profiling->save_user_profiling($_POST, $userId);

            $result = $this->followUp->moveNextLevel($userId , $loanId , $note);

            if($result) {
                Flash::set("User moved to next level");
            }else{
                Flash::set($this->followUp->errString , 'danger');
                return request()->return();
            }
            //get users last level
            $level = $this->followUp->lastLevel;

            return redirect("ProductLoanFollowUps/index?level={$level}");
        }


        public function archives()
        {
            $data = [
                'clients' => $this->followUp->getByTag('dont-follow-up', 8,  'Approved'),
                'activeLevels'  => $this->followUp->getAllLevels()
            ];

            return $this->view('product_loan_followup/index' , $data);
        }
    }