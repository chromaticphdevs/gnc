<?php 

    class CashAdvancePaymentController extends Controller
    {
        public $fnCashAdvanceModel,
        $cashAdvancePaymentModel,
        $userBankModel,
        $userModel,
        $globalMetaModel;
        
        public function __construct()
        {
            parent::__construct();
            $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            $this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
            $this->userBankModel = model('UserBankModel');
            $this->userModel = model('User_model');
            $this->globalMetaModel = model('GlobalMetaModel');
            authRequired();
        }

        
        public function index() {
            $req = request()->inputs();
            $itemsPerPage = 10;
			$curPage = $req['page'] ?? 1;
			$offset = ($curPage - 1) * $itemsPerPage;

            if(!empty($req['btn_filter'])) {
                if(!empty($req['display'])) {
                    $limit = isEqual($req['display'], 'show_all') ? '' : "{$offset}, {$itemsPerPage}";
                } else {
                    $limit = '';
                }

                $status = !empty($req['status']) ? $req['status'] : '';
                $conditions = [
                    'payment.entry_date' => [
                        'condition' => 'between',
                        'value' => [$req['start_date'], $req['end_date']]
                    ],
                    'payment.payment_status' => $status,
                    'cd.code' => $req['loan_reference']
                ];

                foreach($conditions as $key => $val) {
                    if(empty($val)) {
                        unset($conditions[$key]);
                    }
                }
                
                $payments = $this->cashAdvancePaymentModel->getAll([
                    'where' => $conditions,
                    'order' => 'payment.id desc',
                    'limit' => $limit
                ]);

                if(!empty($payments)) {
                    $paymentTotalCount = count($this->cashAdvancePaymentModel->getAll([
                        'where' => $conditions
                    ]));
                } else {
                    $paymentTotalCount = 0;
                }
            }else {
                if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) {
                    $payments = $this->cashAdvancePaymentModel->getAll([
                        'order' => 'payment.id desc',
                        'limit' => "{$offset}, {$itemsPerPage}"
                    ]);

                    $paymentTotalCount = $this->cashAdvancePaymentModel->count();
                } else {
                    $payments = $this->cashAdvancePaymentModel->getAll([
                        'order' => 'payment.id desc',
                        'limit' => "{$offset}, {$itemsPerPage}",
                        'where' => [
                            'payer_id' => whoIs('id')
                        ]
                    ]);

                    $paymentTotalCount = $this->cashAdvancePaymentModel->count([
                        'where' => [
                            'payer_id' => whoIs('id')
                        ]
                    ]);
                }
            }
            
            $data = [
                'payments' => $payments,
                'pagination' => [
                    'itemsPerPage' => $itemsPerPage,
                    'totalPaymentCount' => $paymentTotalCount,
                ],
                'req' => $req,
                'navigationHelper' => $this->navigationHelper,
                'paymentTotalCount' => $paymentTotalCount
            ];
            return $this->view('cash_advance_payment/index', $data);
        }

        /**
         * loan reference
         */
        public function ledger($loanId) {
            $loanId = unseal($loanId);
            $loan = $this->fnCashAdvanceModel->getLoan($loanId);
            $cashAdvancePayments = $this->cashAdvancePaymentModel->getAll([
                'where' => [
                    'ca_id' => $loanId,
                    'payment_status' => 'approved'
                ],
                'order' => 'payment.id desc'
            ]);

            $data   = [
                'cash_advance_payments' => $cashAdvancePayments,
                'loan' => $loan
            ];

            return $this->view('cash_advance_payment/ledger', $data);
        }

        public function api_fetch_all() {
            $req = request()->inputs();

            $keyword = $req['keyword'] ?? '';

            $groupedCondition =  $this->cashAdvancePaymentModel->convertWhere([
                'GROUP_CONDITION' => [
                    'user.lastname' => [
                        'condition' => 'like',
                        'value'     => "%{$keyword}%",
                        'concatinator' => 'OR'
                    ],

                    'user.firstname' => [
                        'condition' => 'like',
                        'value'     => "%{$keyword}%",
                        'concatinator' => 'OR'
                    ],
                ]
            ]);

            $groupedConditionB =  $this->cashAdvancePaymentModel->convertWhere([
                'cd.code' => $keyword
            ]);

            $groupedConditionC =  $this->cashAdvancePaymentModel->convertWhere([
                'payment.payment_reference' => $keyword
            ]);

            $groupedConditionD =  $this->cashAdvancePaymentModel->convertWhere([
                'payment.external_reference' => $keyword
            ]);
            
            $payments = $this->cashAdvancePaymentModel->getAll([
                'order' => 'cd.id desc',
                'limit' => "10",
                'where' => "{$groupedCondition} OR {$groupedConditionB} OR {$groupedConditionC} OR {$groupedConditionD}"
            ]);

            if($payments) {
                foreach($payments as $key => $row) {
                    $row->amount_text = ui_html_amount($row->amount);
                    $row->id_sealed = seal($row->id);
                }
            }
            
            echo api_response([
                'payments' => $payments
            ]);
            return;
        }

        public function search() {
            $req = request()->inputs();

            if(isSubmitted()) {
                $userId = null;
                /**
                 * search by gotyme account / username
                 *  check if there is active loan
                 *  if there is loan go to payment
                 */
                $post = request()->posts();
                /**
                 * search by username first then bank
                 */

                //search user
                $foundSearch = $this->userModel->getSingle([
                    'where' => [
                        'user.username' => $post['keyword']
                    ]
                ]);

                if(!$foundSearch) {
                    //check by bank
                    $foundSearch = $this->fnCashAdvanceModel->fetchOne([
                        'where' => [
                            'cd.code' => $post['keyword']
                        ]
                    ]);

                    if($foundSearch) {
                        $userId = $foundSearch->user_id;
                        return redirect('CashAdvancePaymentController/create/'.seal($foundSearch->ca_id));
                    }
                } else {
                    $userId = $foundSearch->id;
                }

                if(is_null($userId)) {
                    Flash::set('User not found', 'danger');
                    return request()->return();
                }

                $cashAdvance = $this->fnCashAdvanceModel->fetchOne([
                    'where' => [
                        'cd.userid' => $userId
                    ],
                    'order' => 'cd.id desc'
                ]);

                if(!$cashAdvance) {
                    Flash::set("User has no loan", 'danger');
                    return request()->return();
                }

                return redirect('CashAdvancePaymentController/create/'.seal($cashAdvance->ca_id));
            }
            
            $data = [
                'recentPayments' => $this->cashAdvancePaymentModel->getRecentPayments(),
                'navigationHelper' => $this->navigationHelper
            ];
            
            return $this->view('cash_advance_payment/search', $data);
        }

        /**
         * loan is required to create 
         * a loan payment
         */
        public function create($loanId) {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                $post['userType'] = whoIs('type');
                $resp = $this->cashAdvancePaymentModel->addNew($post, unseal($loanId));

                if(!$resp) {
                    Flash::set($this->cashAdvancePaymentModel->getErrorString(), 'danger');
                    return request()->return();
                } else {
                    Flash::set("Payment posted, add image proof here.");
                    return redirect('CashAdvancePaymentController/imageproof/'.seal($this->cashAdvancePaymentModel->_getRetval('paymentId')));
                }
            }

            $banks = $this->globalMetaModel->all([
                'where' => [
                    'category' => 'BANK_NAME'
                ]
            ]);

            $loan = $this->fnCashAdvanceModel->getLoan(unseal($loanId));

            $data = [
                'loanId' => $loanId,
                'banks'  => $banks,
                'loan'  => $loan,
                'gotymeBankId' => $this->userBankModel::GOTYME_ID
            ];

            return $this->view('cash_advance_payment/create', $data);
        }

        public function imageproof($paymentId) {
            $req = request()->inputs();
            $showReceipt = !empty($req['action_show_receipt']);

            $data = [
                'payment' => $this->cashAdvancePaymentModel->get([
                    'where' => [
                        'payment.id' => unseal($paymentId)
                    ]
                    ]),
                'paymentId' => $paymentId,
                'whoIs' => whoIs(),
                'showReceipt' => $showReceipt
            ];

            return $this->view('cash_advance_payment/imageproof', $data);
        }

        public function show($id) {
            $payment = $this->cashAdvancePaymentModel->get([
                'where' => [
                    'payment.id' => unseal($id)
                ]
            ]);

            $data = [
                'payment' => $payment,
                'loan' => $this->fnCashAdvanceModel->getLoan($payment->ca_id),
                'paymentId' => $id,
                'whoIs' => whoIs(),
                'token' => csrf(),
                'payerData' => $this->userModel->get_user($payment->payer_id)
            ];

            if(isEqual(request()->input('type'), 'receipt') || isEqual(whoIs('type'), USER_TYPES['MEMBER'])) {
                return $this->receiptView($data);
            }
            
            return $this->view('cash_advance_payment/show', $data);
        }

        /**
         * this function is just a design loader
         * all datas that will be passed from this method
         * will come from ::show
         */
        private function receiptView($data) {
            return $this->view('cash_advance_payment/receipt', $data);
        }

        public function approve($id) {
            $req = request()->inputs();
            $token = $req['token'];
            $message = '';

            if(!csrfValidate($token)) {
                echo die('token unmatched');
            }

            $resp = $this->cashAdvancePaymentModel->approve(unseal($id));

            if(!$resp) {
                Flash::set($this->cashAdvancePaymentModel->getErrorString(), 'danger');
                return request()->return();
            } else {
                $message = $this->cashAdvancePaymentModel->getMessageString();
                $forApproval = $this->cashAdvancePaymentModel->getPaymentForApproval();

                if($forApproval) {
                    $message .= ", found 1 payment for processing";
                    Flash::set($message);
                    return redirect('/CashAdvancePaymentController/show/'.seal($forApproval->id));
                }
                $message .= ", All payments has been processed";
                Flash::set($message);
                return redirect('/CashAdvancePaymentController/index');
            }
        }

        public function decline($id) {
            $req = request()->inputs();
            $token = $req['token'];
            $message = '';

            if(!csrfValidate($token)) {
                echo die('token unmatched');
            }

            $resp = $this->cashAdvancePaymentModel->decline(unseal($id));

            if(!$resp) {
                Flash::set($this->cashAdvancePaymentModel->getErrorString(), 'danger');
                return request()->return();
            } else {
                $message = $this->cashAdvancePaymentModel->getMessageString();
                $forApproval = $this->cashAdvancePaymentModel->getPaymentForApproval();

                if($forApproval) {
                    $message .= ", found 1 payment for processing";
                    Flash::set($message);
                    return redirect('/CashAdvancePaymentController/show/'.seal($forApproval->id));
                }
                $message .= ", All payments has been processed";
                Flash::set($message);
                return redirect('/CashAdvancePaymentController/index');
            }
        }

        public function approveAll() {
            $req = request()->inputs();
            
            if(!empty($req['q'])) {
                $req = unseal($req['q']);

                $status = !empty($req['status']) ? $req['status'] : '';
                $conditions = [
                    'payment.entry_date' => [
                        'condition' => 'between',
                        'value' => [$req['start_date'], $req['end_date']]
                    ],
                    'payment.payment_status' => $status,
                    'cd.code' => $req['loan_reference']
                ];

                foreach($conditions as $key => $val) {
                    if(empty($val)) {
                        unset($conditions[$key]);
                    }
                }
                
                $paymentsToApprove = $this->cashAdvancePaymentModel->getAll([
                    'where' => $conditions,
                    'order' => 'payment.id desc'
                ]);
            } else {
                $paymentsToApprove = $this->cashAdvancePaymentModel->getAll([
                    'where' => [
                        'payment.payment_status' => 'for approval'
                    ]
                ]);
            }

            $approvedPaymentCount = 0;
            foreach($paymentsToApprove as $key => $row) {
               $resp =  $this->cashAdvancePaymentModel->approve($row->id);

               if(!$resp) {
                _unitTest(FALSE, $row->payment_reference . ' - ' . $this->cashAdvancePaymentModel->getErrorString());
               } else {
                    $approvedPaymentCount++;
                _unitTest(TRUE, $row->payment_reference . " has been approved");
               }
            }

            if($approvedPaymentCount > 0) {
                Flash::set("Payment Approved");
                return request()->return();
            } else {
                Flash::set("No payments to approved", 'warning');
                return request()->return();
            }
        }
    }