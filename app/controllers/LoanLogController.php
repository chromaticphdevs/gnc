<?php 

    class LoanLogController extends Controller
    {
        public function __construct()
        {
            $this->loanLogModel = model('LoanlogModel');
        }

        public function loan_log($loanId) {

            $data = [
                'loan_logs' => $this->loanLogModel->getAll([
                    'where' => [
                        'loan_log.loan_id' => $loanId,
                        'entry_type'  => 'penalty'
                    ]
                ])
            ];
            return $this->view('loan_log/loan_log', $data);
        }
    }