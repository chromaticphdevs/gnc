<?php
    use Services\CashAdvanceService;
    load(['CashAdvanceService'], APPROOT.DS.'services');

    class CashAdvanceReleaseController extends Controller
    {
        public $serviceCashAdvance;

        public function __construct()
        {
            parent::__construct();
            $this->cashAdvanceReleaseModel = model('CashAdvanceReleaseModel');
            $this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
            $this->fnCashAdvance = model('FNCashAdvanceModel');
            $this->userModel = model('User_model');
            $this->loanlogModel = model('LoanlogModel');

            $this->serviceCashAdvance = new CashAdvanceService();

            authRequired();
        }
        
        public function index() {
            $req = request()->inputs();

            $itemsPerPage = 10;
			$curPage = $req['page'] ?? 1;
			$offset = ($curPage - 1) * $itemsPerPage;
            $hasLimit = false;

            $condition = [];

            if(!empty($req['btn_filter'])) 
            {
                
                if(!empty($req['status'])) {
                    $condition['fca.status'] = isEqual($req['status'], 'paid') ? 'Paid' : $req['status'];
                }
                if(!empty($req['username'])) {
                    $userUsernames = trim($req['username']);
                    $userUsernames = explode(',', $userUsernames);
                    $users = $this->userModel->getAll([
                        'where' => [
                            'user.username' => [
                                'condition' => 'in',
                                'value' => $userUsernames
                            ]
                        ]
                    ]);

                    if(!empty($users)) {
                        $userIds = [];
                        foreach($users as $key => $row) {
                            $userIds[] = $row->id;
                        }

                        $condition['fca.userid'] = [
                            'condition' => 'in',
                            'value' => $userIds
                        ];
                    }
                }

                if(!empty($req['start_date']) && !empty($req['end_date'])) {
                    $condition['date(entry_date)'] = [
                        'condition' => 'between',
                        'value' => [$req['start_date'], $req['end_date']]
                    ];
                }

                if(!empty($req['display']) && isEqual($req['display'], 'limit')) {
                    $hasLimit = true;
                }

            } elseif(!empty($req)) {
                if(!empty($req['status'])) {
                    $condition['fca.status'] = $req['status'];
                } else {
                    $condition['fca.status'] = [
                        'condition' => 'in',
                        'value' => ['released']
                    ];
                }
            }

            $cash_advance_releases = $this->cashAdvanceReleaseModel->getAll([
                'where' => $condition,
                'order' => 'cdr.id desc'
            ]);
            
            if($hasLimit) {
                $cash_advance_releases_count = $this->cashAdvanceReleaseModel->getCount([
                    'where' => $condition
                ]);
            } else {
                $cash_advance_releases_count = count($cash_advance_releases);
            }
            
            $data = [
                'cash_advance_releases' => $cash_advance_releases,
                'pagination' => [
                    'itemsPerPage' => $itemsPerPage,
                    'curPage'      => $curPage,
                    'totalItemCount' => $cash_advance_releases_count
                ],
                'navigationHelper' => $this->navigationHelper,
                'req' => $req,
                'navigationHelper' => $this->navigationHelper
            ];

            return $this->view('cash_advance_release/index', $data);
        }

        public function pastdue() {
            $req = request()->inputs();
            $data  = [
                'pastdueList' => $this->cashAdvanceReleaseModel->getAll([
                    'where' => [
                        'cdr.due_date' >= date('Y-m-d'),
                        'fca.status' => 'released'
                    ]
                ]),
                'navigationHelper' => $this->navigationHelper
            ];
            return $this->view('cash_advance_release/pastdue', $data);
        }

        public function penalty() {
            $req = request()->inputs();
            $condition = [];

            if(!empty($req['contentType'])) {
                switch($req['contentType']) {
                    case '':
                        
                    break;
                }
            }

            if(!empty($req['loan_reference'])) {
                $condition['fca.code'] = $req['loan_reference'];
            }

            $data = [
                'penalties' => $this->loanlogModel->getAll([
                    'where' => $condition,
                    'order' => 'loan_log.id desc'
                ])
            ];
            
            return $this->view('cash_advance_release/penalty', $data);
        }

        public function api_fetch_all() {
            $req = request()->inputs();
            $keyword = $req['keyword'] ?? '';

            if(empty($keyword)) {
                $releases = $this->cashAdvanceReleaseModel->getAll([
                    'order' => 'cdr.id desc',
                    'limit' => 10
                ]);
            } else {
                $groupedCondition =  $this->cashAdvanceReleaseModel->convertWhere([
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

                        'user.username' => [
                            'condition' => 'like',
                            'value'     => "%{$keyword}%",
                            'concatinator' => 'OR'
                        ],
                    ]
                ]);
    
                $groupedConditionB =  $this->cashAdvanceReleaseModel->convertWhere([
                    'fca.code' => $keyword
                ]);

                $groupedConditionC =  $this->cashAdvanceReleaseModel->convertWhere([
                    'cdr.release_reference' => $keyword
                ]);
    
                $releases = $this->cashAdvanceReleaseModel->getAll([
                    'order' => 'cdr.id desc',
                    'limit' => 10,
                    'where' => "{$groupedCondition} OR {$groupedConditionB} OR {$groupedConditionC}"
                ]);
            }

            echo api_response([
                'releases' => $releases
            ]);

            return;
        }

        public function show($id) {
            if(!isEqual(whoIs('type'), [USER_TYPES['ADMIN'], USER_TYPES['ENCODER_A']])) {
                return redirect('/FNCashAdvance');
            }
            $cashAdvanceRelease = $this->cashAdvanceReleaseModel->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);

            if(!$cashAdvanceRelease) {
                Flash::set('Cash advance did not found', 'danger');
                return false;
            }

            $totalPayment = $this->cashAdvancePaymentModel->getTotalPayment($cashAdvanceRelease->ca_id);

            $data = [
                'cashAdvanceRelease' => $cashAdvanceRelease,
                'totalPayment' => $totalPayment,
                'penalties' => $this->loanlogModel->getLoanPenalties($cashAdvanceRelease->ca_id),
                'id' => $id
            ];

            return $this->view('cash_advance_release/show', $data);
        }

        public function edit($id) {
            $cashAdvanceRelease = $this->cashAdvanceReleaseModel->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);

            if(!$cashAdvanceRelease) {
                Flash::set('Cash advance did not found', 'danger');
                return false;
            }

            $totalPayment = $this->cashAdvancePaymentModel->getTotalPayment($cashAdvanceRelease->ca_id);

            if(isSubmitted()) {
                $post = request()->posts();

                $amount = convert_to_number($post['loan_amount']);
                $serviceFeeAmount = convert_to_number($post['service_fee']);
                $attorneeFeeAmount = convert_to_number($post['attornees_fee']);
                $interestRateFeeAmount = convert_to_number($post['interest_rate_amount']);

                if(!is_numeric($amount) || $amount < 1) {
                    Flash::set("Invalid Amount", 'danger');
                    return request()->return();
                }

                if(!empty($serviceFeeAmount) && !is_numeric($serviceFeeAmount)) {
                    Flash::set("Invalid Service Fee Amount", 'danger');
                    return request()->return();
                }

                if(!empty($attorneeFeeAmount) && !is_numeric($attorneeFeeAmount)) {
                    Flash::set("Invalid Attornee Fee Amount", 'danger');
                    return request()->return();
                }

                if(!empty($interestRateFeeAmount) && !is_numeric($interestRateFeeAmount)) {
                    Flash::set("Invalid Loan Interest Fee", 'danger');
                    return request()->return();
                }

                $resp = $this->cashAdvanceReleaseModel->modifyLoan($id, [
                    'loan_amount' => $amount,
                    'service_fee' => $serviceFeeAmount,
                    'attornees_fee' => $attorneeFeeAmount,
                    'interest_rate_amount' => $interestRateFeeAmount,
                    'entry_date' => $post['entry_date'],
                    'due_date_no_of_days' => $post['due_date_no_of_days'],
                ]);

                if($resp) {
                    Flash::set($this->cashAdvanceReleaseModel->getMessageString());
                    return redirect("/CashAdvanceReleaseController/show/".$id);
                } else {
                    Flash::set($this->cashAdvanceReleaseModel->getErrorString(), 'danger');
                    return redirect("/CashAdvanceReleaseController/edit/".$id);
                }
            }

            $loan = $this->fnCashAdvance->fetchOne([
                'where' => [
                    'cd.id' => $cashAdvanceRelease->ca_id
                ]
            ]);

            $data = [
                'cashAdvanceRelease' => $cashAdvanceRelease,
                'totalPayment' => $totalPayment,
                'loan' => $loan,
                'navigationHelper' => $this->navigationHelper
            ];
            return $this->view('cash_advance_release/edit', $data);
        }

        /**
         * loan id to terminate
         */
        public function terminate($id) {
            $this->_loadModels();
            //fetch loan

            $cashAdvanceRelease = $this->cashAdvanceReleaseModel->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);

            if(isSubmitted()) {
                $post = request()->posts();
                $isCreateNewLoan = isEqual($post['re_create_loan'], 'yes');
                $isOkay = $this->fnCashAdvance->terminate($cashAdvanceRelease->ca_id, $isCreateNewLoan, $post['attornees_fee']);
                if($isOkay) {
                    $loanId = $this->fnCashAdvance->_getRetval('loanId');
                    if($isCreateNewLoan) {
                        $isReleased = $this->cashAdvanceReleaseModel->release($loanId, 'AUTO-'.random_number(8));
                        $releaseId = $this->cashAdvanceReleaseModel->_getRetval('releaseId');
                        Flash::set('loan terminated and new loan created');

                        return redirect('CashAdvanceReleaseController/show/'.$releaseId);
                    } else {
                        Flash::set("Loan terminated", 'danger');
                        return redirect('CashAdvanceReleaseController/show/'.$cashAdvanceRelease->id);
                    }
                } else {
                    Flash::set($this->fnCashAdvance->getErrorString(), 'danger');
                    return request()->return();
                }
            }

            if(!$cashAdvanceRelease) {
                Flash::set('Cash advance did not found', 'danger');
                return false;
            }
            $totalPayment = $this->cashAdvancePaymentModel->getTotalPayment($cashAdvanceRelease->ca_id);
            /**
             * get payments starting from release date
             */
            $entry_date = date('Y-m-d', strtotime($cashAdvanceRelease->entry_date));
            $releaseDatePlusDay = get_date($entry_date . ' +1 day ');
            $dateToday = date('Y-m-d');

            $payments = $this->cashAdvancePaymentModel->getAll([
                'where' => [
                    'ca_id' => $cashAdvanceRelease->ca_id,
                    'entry_date' => [
                        'condition' => 'between',
                        'value' => [$releaseDatePlusDay, $dateToday]
                    ],
                    'payment_status' => 'approved'
                ]
            ]);

            $loan = $this->fnCashAdvanceModel->getLoan($cashAdvanceRelease->ca_id);

            if(strtotime(get_date($entry_date)) != strtotime($dateToday)) {
                $accuiredPenalties = $this->serviceCashAdvance->searchForNoPaymentDates($releaseDatePlusDay, $payments);
                $accuiredPenaltyTotal = $this->serviceCashAdvance->calculateAccuiredPenalties($releaseDatePlusDay, $payments, $loan);
            } else {
                $accuiredPenalties = [];
                $accuiredPenaltyTotal = 0;
            }
            
            
            $data = [
                'cashAdvanceRelease' => $cashAdvanceRelease,
                'totalPayment' => $totalPayment,
                'penalties' => $this->loanlogModel->getLoanPenalties($cashAdvanceRelease->ca_id),

                'penaltySummary' => [
                    'accuiredPenaltyTotal' => $accuiredPenaltyTotal,
                    'accuiredPenalties'    => $accuiredPenalties
                ]
            ];
            
            return $this->view('cash_advance_release/terminate', $data);
        }

        /**
         * used by admin 
         * creates autolon bypassing all requirements
         * and realease the loan
         */
        public function byPassLoanAndRelease() {
            // return $this->view('page/maintenance');
            $this->_loadModels();

            $req = request()->inputs();
            $data = [];

            if(isSubmitted()) {
                $post = request()->posts();
                
                $user = $this->userModel->getSingle([
                    'where' => [
                        'user.username' => $post['username']
                    ]
                ]);

                $this->fnCashAdvanceModel->setLoanOptions([
                    $this->fnCashAdvanceModel::SKIP_COBORROWER_VALIDATION => true
                ]);

				$response = $this->fnCashAdvanceModel->addNewLoan([
					'userid' => $user->id,
					'amount' => 5000,
					'date' => today(),
					'interest_rate' => '10%',
					'is_agreement_check' => true
				]);

                $loanId = $this->fnCashAdvanceModel->_getRetval('loanId');

                if(!$response) {
                    Flash::set($this->fnCashAdvanceModel->getErrorString(),'danger');
                    return redirect('/CashAdvanceReleaseController/byPassLoanAndRelease');
                } else {
                    $this->cashAdvanceReleaseModel->setOptions([
                        'bypass' => true
                    ]);
                    $releases = $this->cashAdvanceReleaseModel->release($loanId, 'AUTO-'.random_number(8));
                    $releaseId = $this->cashAdvanceReleaseModel->_getRetval('releaseId');

                    Flash::set("Loan Created, And Released");
                    return redirect('CashAdvanceReleaseController/show/'.$releaseId);
                }

            }

            if(!empty($req['username'])) {
                $username = $req['username'];

                $user = $this->userModel->getSingle([
                    'where' => [
                        'user.username' => $username
                    ]
                ]);   

                if(!$user) {
                    Flash::set("User not found");
                    return request()->return();
                }

                $data['user'] = $user;
            }

            return $this->view('cash_advance_release/bypass_release', $data);
        }

        private function _loadModels() {
            if(!isset($this->userModel)) {
                $this->userModel = model('User_model');
            }

            if(!isset($this->fnCashAdvanceModel)) {
                $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            }

            if(!isset($this->cashAdvancePaymentModel)) {
                $this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
            }
        }

        /*
        *get loan summary
        */
        public function activeSummaryLoan() {
            $this->_loadModels();
            $loanSumarries = $this->fnCashAdvanceModel->getActiveLoanSummary();
            $loanSummaryArray = [];

            foreach($loanSumarries as $key => $row) {

                $lastPayment = $this->cashAdvancePaymentModel->get([
                    'where' => [
                        'ca_id' => $row->loan_id,
                        'payment_status' => 'approved'
                    ],
                    'order'=> 'id desc',
                    'limit' => '1'
                ]);

                $row->total_payment = $this->cashAdvancePaymentModel->getTotalPayment($row->loan_id);
                $row->last_payment_id = $lastPayment->id ?? false;
                $row->last_payment_date   = $lastPayment->entry_date ?? false;
                $row->last_payment_amount = $lastPayment->amount ?? 0;
                $row->external_reference = $lastPayment->external_reference ?? 0;
                array_push($loanSummaryArray, $row);
            }

            $data = [
                'loanSummaryArray' => $loanSummaryArray
            ];
            return $this->view('cash_advance_release/active_summary_loan', $data);
        }
    }