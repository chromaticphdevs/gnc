<?php
    use Services\CashAdvanceService;

    load(['CashAdvanceService'], APPROOT.DS.'services');

    class CashAdvanceReleaseModel extends Base_model
    {
        public $table = 'cash_advance_releases';
        public $_fillables = [
            'release_reference ',
            'ca_id',
            'user_id',
            'amount',
            'entry_date',
            'external_reference',
            'account_no',
            'account_name',
            'org_id',
            'image_proof',
            'created_by',
        ];

        public function setOptions($options) {
            $this->options = $options;
        }

        public function release($cashAdvanceId, $externalReference) {
            //load models
            $this->loadModels();
            $loan = $this->fnCashAdvanceModel->getLoan($cashAdvanceId);
            $userBank = $this->userBankModel->getGotyme($loan->userid);
            //add if there is an exising loan for this user then invalidate release
            $token = get_token_random_char(8, 'REL');

            if($loan->is_released) {
                $this->addError("Loan is already released");
                return false;
            }
            $releaseDate = today();
            $this->fnCashAdvanceModel->dbupdate([
                'is_released' => true,
                'release_date' => $releaseDate,
                'status'   => 'released'
            ], $loan->id);

            $cashadvanceService = new CashAdvanceService();

            $storeData = [
                'release_reference' =>$token,
                'ca_id' => $loan->id,
                'user_id' => $loan->userid,
                'amount' => $loan->amount,
                'entry_date' => $releaseDate,
                'external_reference' => $externalReference,
                'due_date_no_of_days' => CashAdvanceService::DUE_DATE_NO_OF_DAYS_DEFAULT,
                'due_date' => $cashadvanceService->calculateDueDate(CashAdvanceService::DUE_DATE_NO_OF_DAYS_DEFAULT, $releaseDate)
            ];

            if(!isset($this->options['bypass'])) {
                if($userBank) {
                    $storeData = array_merge($storeData, [
                        'account_no' => $userBank->account_number,
                        'account_name' => $userBank->account_name,
                        'org_id' => $userBank->organization_id
                    ]);
                }
            }
            /**
             * ledger model
             */
            if(!isset($this->ledgerModel)) {
                $this->ledgerModel = model('LedgerModel');
            }

            $description = "CASH ADVANCE RELEASE DATE {$releaseDate} REFERENCE : {$loan->code}";
            $ledgerEntryData = [
                'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
                'ledger_source_id' => $loan->id,
                'ledger_user_id' => $loan->userid,
                'ledger_entry_amount' => $loan->amount,
                'ledger_entry_type' => 'addition',
                'description' => $description,
                'entry_dt' => $releaseDate,
                'status'   => 'approved',
                'created_by' => whoIs('id'),
                'updated_by' => null,
                'category' => LEDGER_CATEGORIES['CASH_ADVANCE'],
            ];

            $ledgerEntryData = array_values($ledgerEntryData);
            $this->ledgerModel->addLedgerEntry(...$ledgerEntryData);

            $resp = parent::store($storeData);
            $this->_addRetval('releaseId', $resp);
            return $resp;
        }

        private function loadModels() {
            if(!isset($this->fnCashAdvanceModel)) {
                $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            }

            if(!isset($this->userModel)) {
                $this->userModel = model('User_model');
            }

            if(!isset($this->userBankModel)) {
                $this->userBankModel = model('UserBankModel');
            }
        }

        public function getAll($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE " . parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']} ";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']} ";
            }

            $this->db->query(
                "SELECT cdr.* ,
                    DATEDIFF(now(),cdr.entry_date) as release_date_span,
                    fca.code as loan_reference,
                    fca.balance as loan_balance,
                    fca.net as loan_net,
                    fca.status as loan_status,
                    fca.service_fee as loan_service_fee,
                    fca.attornees_fee as loan_attornees_fee,
                    fca.interest_rate_amount as loan_interest_rate_amount,
                    global_meta.meta_value as bank_org_name,
                    concat(user.firstname, ' ', user.lastname) as member_name,
                    user.username
                    
                    FROM {$this->table} as cdr
                    LEFT JOIN users as user 
                        ON user.id = cdr.user_id
                    LEFT JOIN fn_cash_advances as fca
                        ON fca.id = cdr.ca_id
                    LEFT JOIN global_meta
                        ON cdr.org_id = global_meta.id
                        
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function getCount($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE " . parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']} ";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']} ";
            }

            $this->db->query(
                "SELECT count(*) as total
                    FROM {$this->table} as cdr
                    LEFT JOIN users as user 
                        ON user.id = cdr.user_id
                    LEFT JOIN fn_cash_advances as fca
                        ON fca.id = cdr.ca_id
                    LEFT JOIN global_meta
                        ON cdr.org_id = global_meta.id
                        
                    {$where} {$order} {$limit}"
            );

            return $this->db->single()->total ?? 0;
        }

        public function get($params = []) {
            return $this->getAll($params)[0] ?? false;
        }

        /**
         * loanData = [loan_amount,service_fee,attorees_fee]
         * loadData = [release_date, due_date_no_of_days] // optional
         */
        public function modifyLoan($id, $loanData = []) {
            $this->loanModel();
            
            $totalPaymentAmount = 0;
            $releasedLoan = $this->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);

            if(!$releasedLoan) {
                $this->addError("Released loan not found.");
                return false;
            }

            $loanId = $releasedLoan->ca_id;
            
            $loan = $this->fnCashAdvanceModel->fetchOne([
                'where' => [
                    'cd.id' => $loanId
                ]
            ]);
            
            if(!$loan) {
                $this->addError("Loan not found.");
                return false;
            }

            $payments = $this->cashAdvancePaymentModel->getAll([
                'where' => [
                    'ca_id' => $loanId,
                    'payment.payment_status' => 'approved'
                ]
            ]);

            foreach($payments as $key => $row) {
                $totalPaymentAmount += $row->amount;
            }
            $totalBalance = 
                $loanData['loan_amount'] + 
                $loanData['service_fee'] + 
                $loanData['attornees_fee'] + 
                $loanData['interest_rate_amount'];

            if($totalPaymentAmount > $totalBalance) {
                $this->addError("User payment total is more than the new amount, invalid entry");
                return false;
            }

            $remainingBalance = ($totalBalance - $totalPaymentAmount);
            $status = $remainingBalance == 0 ? 'Paid' : 'Released';

            $caOkay = $this->fnCashAdvanceModel->dbupdate([
                'amount' => $loanData['loan_amount'],
                'net' => $totalBalance,
                'service_fee' => $loanData['service_fee'],
                'balance' => $remainingBalance,
                'interest_rate_amount' => $loanData['interest_rate_amount'],
                'attornees_fee' => $loanData['attornees_fee'],
                'status' => $status,
            ], $loan->ca_id);
            
            if($caOkay) {
                $isOkay = parent::dbupdate([
                    'amount' => $loanData['loan_amount']
                ], $id);
            }

            //due date observer
            if(isset($loanData['entry_date'], $loanData['due_date_no_of_days'])) {
                $this->updateDueDate($releasedLoan->entry_date, $releasedLoan->due_date_no_of_days, $loanData['entry_date'], $loanData['due_date_no_of_days'], $id);
            }

            $releasedLoan = $this->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);
            
            if($isOkay && isset($caOkay) && $isOkay == true) {
                $this->addMessage("Loan amount has been updated");
                return true;
            } else {
                $this->addError("Something went wrong");
                return false;
            }

        }
        
        /**
         * will be deprecated
         * marc 8 2024
         */
        public function updateLoanAmount($id, $amount) {
            $this->loanModel();
            /**
             * fetch the released loan
             * fetch the loan data
             * change net,loan_amount to amount,
             * change service_fee to 0
             * change balance set to deduct amount - total payments
             * ********VALIDATIONS*****
             * check if balance is lesser than new amount
             */

            $totalPaymentAmount = 0;
            $releasedLoan = $this->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);
            
            if(!$releasedLoan) {
                $this->addError("Released loan not found.");
                return false;
            }

            $loanId = $releasedLoan->ca_id;
            
            $loan = $this->fnCashAdvanceModel->fetchOne([
                'where' => [
                    'cd.id' => $loanId
                ]
            ]);
            
            if(!$loan) {
                $this->addError("Loan not found.");
                return false;
            }

            $payments = $this->cashAdvancePaymentModel->getAll([
                'where' => [
                    'ca_id' => $loanId
                ]
            ]);

            foreach($payments as $key => $row) {
                $totalPaymentAmount += $row->amount;
            }

            if($totalPaymentAmount > $amount) {
                $this->addError("User payment total is more than the new amount, invalid entry");
                return false;
            }

            if($loan->ca_balance == $amount) {
                $this->addError("No changes found, invalid loan update");
                return false;
            }

            $caOkay = $this->fnCashAdvanceModel->dbupdate([
                'amount' => $amount,
                'net' => $amount,
                'service_fee' => 0,
                'balance' => ($amount - $totalPaymentAmount)
            ], $loan->ca_id);
            
            if($caOkay) {
                $isOkay = parent::dbupdate([
                    'amount' => $amount
                ], $id);
            }

            $releasedLoan = $this->get([
                'where' => [
                    'cdr.id' => $id
                ]
            ]);
            
            if($isOkay && isset($caOkay) && $isOkay == true) {
                $this->addMessage("Loan amount has been updated");
                return true;
            } else {
                $this->addError("Something went wrong");
                return false;
            }
        }
        
        /**
         * observer
         */
        public function updateDueDate($oldReleaseDate, $oldDueDateNoOfDays, $newReleaseDate, $newDueDateNoOfDays, $releaseId) {
            $hasChanged = false;

            $releaseDate = date('Y-m-d', strtotime($oldReleaseDate));
            if($releaseDate != $newReleaseDate) {
                $hasChanged = true;
            }

            if($oldDueDateNoOfDays != $newDueDateNoOfDays) {
                $hasChanged = true;
            }

            if($hasChanged) {
                //update due date
               $cashadvanceService = new CashAdvanceService();
               $dueDate = $cashadvanceService->calculateDueDate($newDueDateNoOfDays, $newReleaseDate);

               return $this->dbupdate([
                'entry_date' => $newReleaseDate,
                'due_date_no_of_days' => $newDueDateNoOfDays,
                'due_date' => $dueDate
               ], $releaseId);

               //create a log here.
            }
        }

        private function loanModel() {
            if(!isset($this->fnCashAdvanceModel)) {
                $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            }
            if(!isset($this->cashAdvancePaymentModel)) {
                $this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
            }
        }
    }