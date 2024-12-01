<?php 
    use Classes\Loan\BoxOfCoffee;
    use Classes\Loan\LoanService;

    require_once CLASSES.DS.'Loan/BoxOfCoffee.php';
    require_once CLASSES.DS.'Loan/LoanService.php';

    class LoanController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->userModel = model('User_model');
            $this->model = model('LoanModel');
            $this->cashAdvanceModel = model('FNCashAdvanceModel');
            $this->userIdVerificationModel = $this->model('UserIdVerificationModel');
            authRequired();
        }

        /**
         * after successfull logging in
         * user will be redirected to this page
         * if user account is not yet verified
         */
        public function requirements() {
            $authUser = whoIs();

            $loans = $this->cashAdvanceModel->get_list_by_user($authUser['id']);
            $loans = $this->cashAdvanceModel->fetchAll([
                'where' => [
                    'cd.userid' => $authUser['id']
                ]
            ]);

            if(!empty($loans)) {
                foreach($loans as $key => $row) {
                    if(isEqual($row->ca_status, ['pending','approved','released'])){
                        return redirect('CashAdvance/loan/'.seal($row->ca_id));
                    }
                }
                return redirect('FNCashAdvance');
            }

            $userUploadIds = $this->userIdVerificationModel->get_user_uploaded_id($authUser['id']);
            $referrals = $this->userModel->getDirects($authUser['id']);
            $approvedRefferals = $this->userModel->getDirectsVerifiedAccounts($authUser['id']);
            $arrangeUploadIds = [];

            foreach($userUploadIds as $key => $row) {
                if(!isset($arrangeUploadIds[$row->type])) {
                    $arrangeUploadIds[$row->type] = $row;
                }
            }

            $data = [
                'userUploadIds' => $userUploadIds,
                'listOfValidIds' => listOfValidIds(),
                'arrangeUploadIds' => $arrangeUploadIds,
                'referrals' => $referrals,
                'approvedRefferals' => $approvedRefferals,
                'totalVerifiedIds' => $this->userIdVerificationModel->countUserVerifiedIds($authUser['id'])
            ];

            return $this->view('loan/requirements', $data);
        }
        /**
         * loan logs
         */
        public function index()
        {
            if(isset($_GET['user_id'])){
                $loans = $this->model->getAll([
                    'where' => [
                        'user_id' => $_GET['user_id'],
                        'entry_type' => LoanService::ENTRY_TYPE_LOAN
                    ]
                ]);
            }else{
                $loans = $this->model->getAll([
                    'where' => [
                        'entry_type' => LoanService::ENTRY_TYPE_LOAN,
                        'loan.remaining_balance' => [
                            'condition' => '>',
                            'value'  => 0
                        ]
                    ]
                ]);
            }
            
            $data = [
                'loans' => $loans,
                'navigationHelper' => $this->navigationHelper
            ];

            return $this->view('loan/index', $data);
        }

        /**
         * total debt
         */
        public function debtors()
        {
            $data = [
                'debtors' => []
            ];
            if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) {
                $data = [
                    'debtors' => $this->model->getDebtors([
                        'where' => [
                            'user.account_tag' => 'main_account',
                            'user.mobile_verify' => 'verified',
                            'user.firstname' => [
                                'condition' => 'not equal',
                                'value'     => 'Breakthrough'
                            ],
                            'user.is_user_verified' => true
                        ],
                        'order' => "firstname asc"
                    ])
                ];
            }

            
            return $this->view('loan/debtors', $data);
        }


        public function create()
        {
            return $this->view('loan/create');
        }


        public function boxOfCoffee()
        {
            return redirect('LoanController');

            if (request()->isPost()) {
                $post = request()->inputs();
                $boxOfCoffeeLoan = new BoxOfCoffee();
                $boxOfCoffeeLoan->setUser($post['user_id'])
                ->setQuantity($post['quantity'])
                ->setBranch($post['branch_id'])
                ->setDate($post['date']);

                $isOK = $boxOfCoffeeLoan->loan();

                if ($isOK) {
                    Flash::set($boxOfCoffeeLoan->getMessage());
                    return redirect('LoanController/index');
                } else{ 
                    Flash::set($boxOfCoffeeLoan->getMessage(), 'warning');
                    return redirect('LoanController/boxOfCoffee');
                }
            }

            $data = $this->initialDatas();
            
            
            $data['boxOfCofeePrice'] = LoanService::BOX_OF_COFEE_PRICE;
            return $this->view('loan/box_of_coffee',$data);
        }

        public function payment()
        {
            return redirect('/LoanController/debtors');
            
            if (request()->isPost()) {
                $post = request()->inputs();
                $res = $this->model->addPayment([
                    'user_id' => $post['user_id'],
                    'parent_id' => $post['branch_id'],
                    'amount'  => $post['amount'],
                    'entry_date' => $post['date']
                ]);
            }

            $data = $this->initialDatas();
            $data['payments'] = $this->model->getAll([
                'where' => [
                    'entry_type' => LoanService::ENTRY_TYPE_PAYMENT
                ],
                'order' => 'id desc'
            ]);

            $data['navigationHelper'] = $this->navigationHelper;
            return $this->view('loan/payment', $data);
        }

        private function initialDatas()
        {
            return [
                'title' => 'Loan',
                'branches' => LoanService::BRANCHES,
                'users'    => $this->userModel->get_list(" WHERE is_user_verified = 1 ORDER BY firstname asc ")
            ];
        }
    }