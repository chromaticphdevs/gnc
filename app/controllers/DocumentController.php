<?php

    class DocumentController extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->caCoBorrowerModel = model('CashAdvanceCoBorrowerModel');
            $this->cashAdvanceModel = $this->model('FNCashAdvanceModel');
            $this->userIdVerificationModel = model('UserIdVerificationModel');
            $this->loanProcessorVideoModel = model('LoanProcessorVideoModel');
            $this->userModel = model('User_model');
        }

        public function initialAgreement() {
            return $this->view('_documents/loan_agreement_initial');
        }
        public function loanAgreement(){
            $data = [];
            $req = request()->inputs();
            $q = !empty($req['q']) ? unseal($req['q']) : [];

            $loanId = unseal($req['id']);
            $coBorrowers = $this->caCoBorrowerModel->getAll([
                'where' => [
                    'fn_ca_id' => $loanId
                ]
            ]); 

            $loanMain = $this->cashAdvanceModel->getLoan($loanId);
            
            $selfieWithId = listOfValidIds()[17];
            $borrowerSelfie =  $this->userIdVerificationModel->get([
                'where' => [
                    'upi.status' => 'verified',
                    'upi.type' => $selfieWithId,
                    'upi.userid' => $loanMain->userid
                ]
            ]);
            
            $coBorrowerids = [];
            if(!empty($coBorrowers)) {
                foreach($coBorrowers as $key => $row) {
                    $coBorrowerids[$row->co_borrower_id] = $this->userIdVerificationModel->get([
                        'where' => [
                            'upi.status' => 'verified',
                            'upi.type' => $selfieWithId,
                            'upi.userid' => $row->co_borrower_id
                        ]
                    ]);
                }
            }

            $borrower = $this->userModel->get_user($loanMain->userid);
            $directSponsor = $this->userModel->get_user($borrower->direct_sponsor);
            $loanProcessor = $this->userModel->get_user($borrower->loan_processor_id);

            if($directSponsor) {
                $data['directSponsor'] = $directSponsor;
                $data['direectSponsorUploadId'] = $this->userIdVerificationModel->get([
                    'where' => [
                        'upi.status' => 'verified',
                        'upi.type' => $selfieWithId,
                        'upi.userid' => $directSponsor->id
                    ]
                ]);
            }

            $data['loan'] = [
                'main' => $loanMain,
                'coborrowers' => $coBorrowers
            ];

            $data['loanTerms'] = '60 Days';
            $data['loanPaymentMethod'] = '100 pesos per day or 3,000per month';
            $data['borrowerSelfie'] =  $borrowerSelfie;
            $data['coBorrowerids'] = $coBorrowerids;
            $data['loanProcessor'] = $loanProcessor;

            $data['borrowerIds'] = $this->userIdVerificationModel->getAll([
                'where' => [
                    'upi.userid' => $loanMain->userid,
                    'upi.status' => 'verified',
                    'upi.type'   => [
                        'condition' => 'not equal',
                        'value'     => $selfieWithId
                    ]
                ]
            ]);

            $resources = [
                'cobborrowerResources' => [],
                'financialAdvisorResources' => [],
                'loanProcessorResources' => [],
            ];

            foreach($coBorrowers as $key => $row) {
                $resources['cobborrowerResources'][$row->co_borrower_id] = [
                    'ids' => $this->userIdVerificationModel->getAll([
                        'where' => [
                            'upi.status' => 'verified',
                            'upi.userid' => $row->co_borrower_id,
                            'upi.type'   => [
                                'condition' => 'not equal',
                                'value'     => $selfieWithId
                            ]
                        ]
                    ]),
                    'video' => $this->userModel->get_user($row->co_borrower_id)
                ];
            }
            

            if($directSponsor) {
                $resources['financialAdvisorResources'] = [
                    'ids' => $this->userIdVerificationModel->getAll([
                        'where' => [
                            'upi.status' => 'verified',
                            'upi.userid' => $directSponsor->id,
                            'upi.type'   => [
                                'condition' => 'not equal',
                                'value'     => $selfieWithId
                            ]
                        ]
                    ]),
                    'video' => $this->userModel->get_user($directSponsor->id)
                ];
            }

            if($loanProcessor) {
                $resources['loanProcessorResources'] = [
                    'ids' => $this->userIdVerificationModel->getAll([
                        'where' => [
                            'upi.status' => 'verified',
                            'upi.userid' => $loanProcessor->id,
                            'upi.type'   => [
                                'condition' => 'not equal',
                                'value'     => $selfieWithId
                            ]
                        ]
                    ]),
                    'video' => $this->loanProcessorVideoModel->get([
                        'where' => [
                            'lp_video.loan_processor_id' => $loanProcessor->id
                        ]
                    ])
                ];
            }

            $data['resources'] = $resources;
            $data['borrower'] = $borrower;
            
            $page = !empty($q['page']) ? $q['page'] : '1'; 
            
            switch($page) {
                case '1':
                    return $this->loanAgreement1($data);
                break;

                case '2':
                    return $this->loanAgreement2($data);
                break;
                
                default :
                    return $this->loanAgreement1($data);
            }
        }

        private function loanAgreement1($data) {
            return $this->view('_documents/loan_agreement', $data);
        }
        private function loanAgreement2($data) {
            return $this->view('_documents/loan_agreement_2', $data);
        }
    }