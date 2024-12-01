<?php 

    class UserBankController extends Controller
    {
        private $globalMetaModel;
        private $model, $userModel;

        public $whoIs;

        public function __construct()
        {
            if(empty(whoIs())) {
                return redirect('users/login');
            }
            parent::__construct();
            $this->globalMetaModel = model('GlobalMetaModel');
            $this->model = model('UserBankModel');
            $this->userModel = model('User_model');
            $this->whoIs = whoIs();
            authRequired();
        }

        public function index() {
            $data = [
                'userBanks' => $this->model->getAll([
                    'where' => [
                        'ub.user_id' => $this->whoIs['id']
                    ]
                ]),
                'navigationHelper' => $this->navigationHelper
            ];

            return $this->view('user_bank/index', $data);
        }

        public function create() {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                $resp = $this->model->addNew($post);

                if(!$resp) {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                }

                $user = $this->userModel->get_user($post['user_id']);
                
                if(isEqual($user->page_auto_focus, [PAGE_AUTO_FOCUS['BANK_DETAIL_PAGE']])) {
					$this->userModel->dbupdate([
						'page_auto_focus' => PAGE_AUTO_FOCUS['CASH_ADVANCE_PAGE']
					], $user->id);
				}

                
                Flash::set('bank added');
                return redirect('UserBankController/index');
            }

            $data = [
                'banks' => $this->globalMetaModel->all([
                    'where' => [
                        'category' => 'BANK_NAME'
                    ],

                    'order' => 'id'
                ]),
                'navigationHelper' => $this->navigationHelper
            ];

            return $this->view('user_bank/create', $data);
        }

        public function edit($id) {
            if(isSubmitted()) {
                $post = request()->posts();
                $isOkay = $this->model->updateAccountDetails([
                    'account_number' => $post['account_number'],
                    'account_name' => $post['account_name'],
                    'organization_id' => $post['organization_id'],
                ], $post['id']);

                if(!$isOkay) {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                } else {
                    Flash::set("Bank Updated");
                    return redirect('UserBankController/index');
                }
            }

            $userBank = $this->model->get([
                'where' => [
                    'ub.id' => $id
                ]
            ]);
            
            $data = [
                'userBank' => $userBank,
                'banks' => $this->globalMetaModel->all([
                    'where' => [
                        'category' => 'BANK_NAME'
                    ],

                    'order' => 'id'
                ]),
                'navigationHelper' => $this->navigationHelper
            ];

            return $this->view('user_bank/edit', $data);
        }

        public function show() {

        }

        public function delete($id) {
            /**
             * delete bank info
             */
            $userBank = $this->model->get([
                'where' => [
                    'ub.id' => $id
                ]
            ]);

            if(!$userBank) {
                Flash::set("Bank not found");
                return request()->return();
            }

            $resp = $this->model->dbdelete([
                'id' => $id
            ]);

            if($resp) {
                Flash::set("Account {$userBank->org_name} {$userBank->account_number} has been deleted");
                return redirect('UserBankController/index');
            } else {
                Flash::set("Unable to delete bank", 'danger');
                return request()->return();
            }
        }
    }