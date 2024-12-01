<?php 
    use Services\UserService;
    load(['UserService'],APPROOT.DS.'services');
    class API_UserController extends API_Controller {
        
        protected $bearerToken = 'mobileapptest';

        public function __construct()
        {
            parent::__construct();
            $this->userModel = $this->model('User_model');
            $this->accountModel = $this->model('AccountModel');
            $this->governmentidModel = $this->model('GovernmentIdModel');
            $this->usersUploadedId   = $this->model('UserIdVerificationModel');
            $this->userMeta = model('UsermetaModel');
            $this->userBankModel = model('UserBankModel');
            $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            $this->userCreditLineModel  = model('UserCreditLineModel');
            $this->userService = new UserService;
        }
        //post
        public function authenticate() {
            $req = request()->inputs();

            if(!$res = $this->validateBearerToken()) {
                echo $res;
                return;
            }

            if(!request()->isPost()) {
                echo json_encode([
                    'message' => 'Invalid request method'
                ]);

                return;
            }

            $post = request()->posts();
            $postKeys = array_keys($post);
            $requiredParams = ['username', 'password'];

            foreach($requiredParams as $key => $row) {
                if(isEqual($row, $postKeys)) {
                    unset($requiredParams[$key]);
                }
            }

            if(count($requiredParams) !== 0) {
                echo json_encode([
                    'message' => 'missing payload/parameters',
                    'data' => [count($requiredParams), $requiredParams],
                ]);
                return;
            }
            $user = $this->userModel->get_by_username($post['username']);

            if(!$user || isEqual($user->username ?? '', 'admin')) {
                echo json_encode([
                    'message' => 'User not found',
                ]);

                return;
            }

            if(!password_verify($post['password'], $user->password)) {
                echo json_encode([
                    'message' => 'Invalid Password',
                ]);

                return;
            }   
            $this->jsonResponse($user);
        }

        //get
        public function user() {
            $req = request()->inputs();

            if(!$res = $this->validateBearerToken()) {
                echo $res;
                return;
            }
            $this->jsonResponse($this->fetch($req['user_id']), [
                'guideList' => [
                    'user_credit_line use current_credit_line for any creditline output',
                    'current_loan use ca_balance for any balance output',
                ]
            ]);
        }
        private function fetch($userId = null) {
            
            $user = $this->userModel->get_user($userId);
            if(!$user) {
                return false;
            }
            $cashFlow = [
                'incomes' => [],
                'expenses' => []
            ];

            $loan = $this->fnCashAdvanceModel->fetchOne([
                'where' => [
                    'cd.userid' => $userId,
                    'cd.status' => [
                        'condition' => 'in',
                        'value' => ['pending','released','approved']
                    ]
                ]
            ]); 
            $directs = $this->userModel->getDirects($userId);
            $userCreditLine = $this->userCreditLineModel->getUserCreditLine($userId);

            $sponsor = $this->userModel->get_user($user->direct_sponsor);
            $upline = $this->userModel->get_user($user->upline);
            $userMeta = $this->userMeta->getByUser($userId);
            $directs = $this->userModel->getDirects($userId);

            $loan = $this->fnCashAdvanceModel->fetchOne([
                'where' => [
                    'cd.userid' => $userId,
                    'cd.status' => [
                        'condition' => 'in',
                        'value' => ['pending','released','approved']
                    ]
                ]
            ]); 


            foreach($userMeta as $uMeta => $uMetaRow) {
                $isExpenses = false;
                    if(isEqual($uMetaRow->meta_key, $this->userService::expensesKeys())){
                        $isExpenses = true;
                        $cashFlow['expenses'][] = [
                            'name' => $uMetaRow->meta_key,
                            'amount' => $uMetaRow->meta_value
                        ];
                    } elseif(isEqual($uMetaRow->meta_key, $this->userService::incomeKeys())) {
                        $cashFlow['incomes'][] = [
                            'name' => $uMetaRow->meta_key,
                            'amount' => $uMetaRow->meta_value
                        ];
                    }
            }
            $retVal = [
                'user_data' => $user,
                'direct_sponsor' => $sponsor,
                'upline' => $upline,
                'referrals' => $directs,
                'current_loan' => $loan,
                'cash_flow' => $cashFlow,
                'user_credit_line' => $userCreditLine,
            ];

            return $retVal;
        }

        public function loan() {
            $userid = request()->input('user_id');
            $loan = $this->fnCashAdvanceModel->fetchOne([
                'where' => [
                    'cd.userid' => $userid,
                    'cd.status' => [
                        'condition' => 'in',
                        'value' => ['pending','released','approved']
                    ]
                ]
            ]); 

            $this->jsonResponse($loan);
        }

        /**
         * set mpin or update mpin
         * params userId, MPIN
         */
        public function setMPIN() {
            $req = request()->posts();
            if(!isset($req['user_id'], $req['mpin'])) {
               $this->jsonResponse([
                'data' => false,
                'error' => 'user_id and mpin paramaters are both required'
               ]);
               return;
            }
            $userId = $req['user_id'];
            $mpin = $req['mpin'];
            
            $response = $this->userModel->setMPIN($userId, $mpin);

            if(!$response) {
                $this->jsonResponse([
                    'data' => false,
                    'error' => 'unable to set MPIN'
                   ], [
                    'guideList' => [
                        'MPIN must be 4 characters long'
                    ]
                   ]);
                return;
            }

            $user = $this->userModel->getUserByMPIN($userId, $mpin);

            $this->jsonResponse([
                'user' => $user,
                'message' => 'MPIN saved'
               ]);
            return;
        }

        public function getMPIN() {
            $req = request()->inputs();
            if(!isset($req['user_id'], $req['mpin'])) {
               $this->jsonResponse([
                'data' => false,
                'error' => 'user_id and mpin paramaters are both required'
               ], [
                'message' => 'user_id and mpin paramaters are both required to set user mpin'
               ]);
               return;
            }
            $userId = $req['user_id'];
            $mpin = $req['mpin'];

            $user = $this->userModel->getUserByMPIN($userId, $mpin);

            if(!$user) {
                $this->jsonResponse([
                    'data' => false,
                    'error' => 'user not found'
                ], [
                    'message' => 'user not found',
                    'guideList' => [
                        'to get user by mpin pass user_id and mpin parameter'
                    ]
                ]);
                return;
            }
            $this->jsonResponse([
                'user' => $user,
                'message' => 'user found'
            ], [
                'message' => 'user found'
            ]);
            return;
        }
    }