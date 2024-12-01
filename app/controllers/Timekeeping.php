<?php   

    class Timekeeping extends Controller
    {

        public function __construct()
        {

            /*
            *Check if cookie is set
            *Check if session is set
            */
            $this->endpoint = 'https://app.breakthrough-e.com';
            // die("TIMEKEEPING IS UNDER MAINTENANCE THIS WONT TAKE A WHILE.. THANK YOU");
            // $this->endpoint = 'http://dev.bktktool';

            $this->tkapp = model('TimekeepingAppModel');
        }

        public function login($userToken)
        {
            $endpoint = $this->endpoint;

            $data = [
                'domain' => 1,
                'userToken' => $userToken
            ];
            
            $requestAccess = api_call('POST' , "{$endpoint}/api/RequestAccess" , $data);

            $response = json_decode($requestAccess);

            if($response->status)
            {
                $responseData = $response->data;
                header("Location:{$endpoint}/api/RequestAccess/login/?token={$responseData->token}");
            }else{
                Flash::set($response->data , 'danger');
                return request()->return();
            }
        }
        public function index()
        {


            $users = $this->tkapp->getRegisteredAppAccounts();

        	$auth = Session::get('USERSESSION');

            if(empty($auth))
                $auth = Session::get('BRANCH_MANAGERS');

        	if(empty($auth))
        	{
        		Flash::set("Account must be logged in");
        		return redirect('users');
        	}

            $auth = (array) $auth;
            
            //check if user exists
            $userAppData = $this->tkapp->getByUserId($auth['id']);
            
            $hasAccount = FALSE;

            if($userAppData)
                $hasAccount = TRUE;

            $data = [
                'hasAccount' => $hasAccount,
                'userToken'  => $userAppData->access_key ?? '',
                'auth'       => $auth
            ];

            if($hasAccount)
            {
                Session::set('USERTOKEN' , $userAppData->access_key);
            }

            return $this->view('timekeeping/index' , $data);
        }


        public function requestAccess()
        {
        	$inputs = request()->inputs();

            //check if user is already registered
        	$endpoint = $this->endpoint;

            $userToken = $inputs['userToken'];

            $hasAccountOnTkApp = $this->tkapp->getByAccess($userToken);

            if($hasAccountOnTkApp) {
                Flash::set("already registered" , 'warning');
                return request()->return();
            }

            $this->tkapp->store([
                'user_id' => $inputs['user_id'],
                'access_key' => $userToken
            ]);

            $postData = [
                'firstname' => $inputs['firstname'],
                'lastname' => $inputs['lastname'],
                'domain' => $inputs['domain'],
                'userToken' => $userToken,
                'ratePerDay' => $inputs['ratePerDay'],
                'workHours' => $inputs['workHours'],
            ];

            $postData['ratePerHour'] = $postData['ratePerDay'] / $postData['workHours'];

        	$requestAccess = api_call('POST' , "{$endpoint}/api/RequestAccess" , $postData);

        	$response = json_decode($requestAccess);

        	if($response->status)
        	{
        		$responseData = $response->data;
        		header("Location:{$endpoint}/api/RequestAccess/login/?token={$responseData->token}");
        	}else{
        		Flash::set($response->data , 'danger');
        		return request()->return();
        	}
        }


        public function timesheets()
        {
           $timesheets = [];

           $status = $_GET['status'] ?? 'all';


           $timesheetCall =  $this->tkapp->bktk['timesheet']->getAll([
            'status' => $status
           ]);


           if($timesheetCall->status)
            $timesheets = $timesheetCall->data;

            $tkAppSession = $this->tkapp->session;

            return $this->view('timekeeping/timesheets' , compact(['timesheets' , 'tkAppSession']));
        }


        public function timesheetShow($id)
        {
            $timesheetMeta = $this->tkapp->getTimesheet($id);

            if(!$timesheetMeta->status){
                $timesheetMeta = [];
            }else{
                $timesheetMeta = (array) $timesheetMeta->data;
            }

            return $this->view('timekeeping/timesheet_show' , $timesheetMeta);
        }

        public function getUsers()
        {
            $userStatus = 'with_accounts';

            if(isset($_GET['user_status'])) 
                $userStatus = $_GET['user_status'];
            
            $users = [];

            switch(strtolower($userStatus))
            {
                case 'with_accounts':
                    $users = $this->tkapp->getManagerWithAccounts();
                break;
                case 'without_accounts':
                    $users = $this->tkapp->getManagerWithoutAccounts();
                break;
            }

            $tkAppSession = $this->tkapp->session;

            return $this->view('timekeeping/users' , compact(['users' , 'userStatus' , 'tkAppSession']));
        }

        public function getUser($userToken)
        {
            $appUserData = $this->tkapp->apiGetByTokenComplete($userToken);

            $timesheets = $appUserData->timesheets;

            $wallets = $appUserData->wallets;
            
            $data = [
                'account' => $appUserData,
                'timesheets'  => $timesheets,
                'wallets'   => $wallets
            ];

            return $this->view('timekeeping/getuser' , $data);
        }

        public function register($fnAccountId)
        {
            $fnaccountModel = model('FNAccountModel');

            $fnaccount = $fnaccountModel->get_account($fnAccountId);

            $userToken = get_token_random_char(50);

            return $this->view('timekeeping/register' , compact(['fnaccount' , 'userToken']));
        }


        public function submitRegistration()
        {
            $inputs = request()->inputs();

            //check if user is already registered
            $endpoint = $this->endpoint;

            $userToken = $inputs['userToken'];

            $hasAccountOnTkApp = $this->tkapp->getByAccess($userToken);

            if($hasAccountOnTkApp) {
                Flash::set("already registered" , 'warning');
                return request()->return();
            }

            $tkAppUserId = $this->tkapp->store([
                'user_id' => $inputs['user_id'],
                'access_key' => $userToken
            ]);

            $postData = [
                'firstname' => $inputs['firstname'],
                'lastname' => $inputs['lastname'],
                'domain' => $inputs['domain'],
                'userToken' => $userToken,
                'ratePerDay' => $inputs['ratePerDay'],
                'workHours' => $inputs['workHours'],
                'maxWorkHours' => $inputs['maxWorkHours'],
                'username' => $inputs['username']
            ];

            $postData['ratePerHour'] = $postData['ratePerDay'] / $postData['workHours'];

            $requestAccess = api_call('POST' , "{$endpoint}/api/user/register" , $postData);

            if(is_null($requestAccess))
            {
                
            }else{
               $response = json_decode($requestAccess);

               $responseStatus = $response->status ?? false;
               //fatal errror occured
               if($responseStatus) 
               {
                    Flash::set("Account {$inputs['firstname']} has been registered to tkapp");
                    return redirect('timekeeping/getUsers?user_status=with_accounts');
               }else
               {
                    $this->tkapp->dbdelete($tkAppUserId);
                    Flash::set("Something went wrong" , 'danger');
                    return request()->return();
               }
            }
            
        }

        /*
        *EDIT USER DATA
        */
        public function edit($token)
        {
            $appUserData = $this->tkapp->apiGetByToken($token);

            $data = [
                'appUserData' => $appUserData
            ];

            return $this->view('timekeeping/edit' , $data);
        }

        public function deleteTimesheet($id)
        {
            if(!isset($_GET['token'])) {
                Flash::set("Invalid Request");
                return request()->return();
            }

            $token = $_GET['token'];

            if(!isEqual($token , $this->tkapp->session))
            {
                Flash::set("Invalid token request failed!");
                return request()->return();
            }

            $deleteTimesheeet = $this->tkapp->deleteTimesheet($id);

            if($deleteTimesheet) {
                Flash::set("Timesheet deleted");
            }else{
                Flash::set("Timesheet delete failed" , 'danger');
            }

            return request()->return();
        }


        public function updateAppData()
        {
            $post = request()->inputs();

            $token = $post['userToken'];

            $postData = [
                'ratePerDay' => $post['ratePerDay'],
                'workHours'  => $post['workHours'],
                'maxWorkHours'  => $post['maxWorkHours'],
                'username'  => $post['username']
            ];

            $postData['ratePerHour'] = $postData['ratePerDay'] / $postData['workHours'];

            $result = $this->tkapp->apiUpdate($postData, $token);

            if($result->status) {
                Flash::set("Account updated!");
            }else{
                Flash::set($result->data , 'danger');
            }

            return redirect('timekeeping/edit/'.$token);
        }

        public function deleteAppData($userToken)
        {
            //tkapptoken
            $tkAppToken = request()->input('token');

            //check if token matched

            if(!isEqual($tkAppToken , $this->tkapp->session))
            {
                Flash::set("Invalid token request failed");
                return request()->return();
            }

            $deleted = $this->tkapp->deleteByToken($userToken);

            Flash::set("User Deleted");

            if(!$deleted) {
                Flash::set("Something went wrong");
            }

            return redirect('timekeeping/getUsers');
        }

        /**
         * Bulk Action
         */

        public function bulkAction()
        {
            $requestMethod = $this->request();

            if(! isEqual($requestMethod , 'post')) {
                Flash::set("Invalid request" , 'danger');
                return redirect()->return();
            }

            $result = false;
            $post = request()->inputs();

            $timesheetIds = $post['timesheetIds'];
            $bulkAction = $post['action'];

            $apiParameters = [
                'timesheetIds' => $timesheetIds
            ];

            if(isEqual($bulkAction , 'approve')) 
            {
                $result = $this->tkapp->approveBulk($apiParameters);
            }


            if(isEqual($bulkAction , 'delete'))
            {
                $result = $this->tkapp->deleteBulk($apiParameters);
            }

            if($result) {
                Flash::set( intval( count($timesheetIds) ) . ' Has been updated to ' . $bulkAction) ;
            }

            return redirect("timekeeping/timesheets");
        }
    }