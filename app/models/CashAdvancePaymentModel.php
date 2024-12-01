<?php
    load(['CashAdvanceService'], APPROOT.DS.'services');
    use Services\CashAdvanceService;

    class CashAdvancePaymentModel extends Base_model {
        public $table = 'cash_advance_payments';

        public function addNew($paymentDetails, $loanId) {
            $this->loadModels();
            /**
             * fetch loan
             * get remaining balance
             */
            $loan = $this->fnCashAdvanceModel->getLoan($loanId);
            /**
             * once payment is posted
             * update loan details
             */
            $paymentReference = get_token_random_char(8,'CP');

            if(!$this->validation($paymentDetails)) {
                return false;
            }
            if(!$loan) {
                $this->addError("User has no loan");
                return false;
            }

            $paymentAmount = convert_to_number($paymentDetails['amount_paid']);
            $validationCheck = $this->amountValidation($loan->balance, $paymentAmount);

            if(!$validationCheck) {
                return false;
            }
            $endingBalance = $loan->balance - $paymentAmount;

            $paymentStatus = 'for approval';

            $responseId = parent::store([
                'payment_reference' => $paymentReference,
                'ca_id'  => $loan->id,
                'amount' => $paymentAmount,
                'external_reference' => $paymentDetails['external_reference'],
                'running_balance' => $loan->balance,
                'entry_date' => $paymentDetails['entry_date'],
                'ending_balance'  => $endingBalance,
                'payer_id' => $loan->userid,
                'payment_status' => $paymentStatus
            ]);

            if(!$responseId) {
                $this->addError("Unable to post payment");
                return false;
            }
            
            $this->approve($responseId);

            parent::_addRetval('paymentId', $responseId);
            return $responseId;
        }

        /**
         * this will fetch the total loan amount paid by the user
         */
        public function getTotalPayment($loanId) {
            $totalAmount = 0;

            $payments = $this->getAll([
                'where' => [
                    'payment.ca_id' => $loanId,
                    'payment.payment_status' => 'approved'
                ]
            ]);
            
            foreach($payments as $key => $row) {
                $totalAmount += $row->amount;
            }

            return $totalAmount;
        }
        public function getAll($params = []){
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE ".parent::convertWhere($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY {$params['order']} ";
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT {$params['limit']} ";
            }

            $this->db->query(
                "SELECT payment.*, concat(user.firstname, ' ', user.lastname) as payer_fullname,
                    cd.code as loan_reference, global_meta.meta_value as bank_name,
                    user.username as payer_username
                    FROM {$this->table} as payment
                    LEFT JOIN users as user 
                        ON user.id = payment.payer_id
                    LEFT JOIN fn_cash_advances as cd
                        ON cd.id = payment.ca_id

                    LEFT JOIN global_meta
                        on global_meta.id = payment.org_id
                    {$where} {$order} {$limit}"
            );
            return $this->db->resultSet();
        }

        public function get($params = []) {
            return $this->getAll($params)[0] ?? false;
        }

        /**
         * within the day only  
         */
        public function getRecentPayments() {
            return $this->getAll([
                'where' => [
                    'date(payment.created_at)' => get_date(today())
                ],
                'order' => 'payment.id desc'
            ]);
        }

        public function approve($id) {
            $this->loadModels();
            
            $payment = $this->get([
                'where' => [
                    'payment.id' => $id
                ]
            ]);

            if(!$payment) {
                $this->addError("Payment approval failed");
                return false;
            }

            if(!isEqual($payment->payment_status, 'for approval')) {
                $this->addError("This payment has been already processed");
                return false;
            }

            $loan = $this->fnCashAdvanceModel->getLoan($payment->ca_id);

            if(!$loan) {
                $this->addError("Loan not found");
                return false;
            }

            if(!$this->amountValidation($loan->balance, $payment->amount)) {
                return false;
            }

            /**
             * bypass loans
             * auto release
             */
            if(!$loan->is_released) {
                $this->cashAdvanceReleaseModel->release($loan->id, 'SYSTEM_GENERATED_REFERENCE');
            }

            $balance = $loan->balance - $payment->amount;
            $this->fnCashAdvanceModel->dbupdate([
                'balance' => $balance
            ], $loan->id);

            parent::dbupdate([
                'payment_status' => 'approved'
            ], $id);

            /**
             * add to ledger
             */

            if(!isset($this->ledgerModel)) {
                $this->ledgerModel = model('LedgerModel');
            }
            $date = today();

            $description = "PAYMENT CREATED FOR 
                CASH ADVANCE#{$loan->code}, PAYMENT REFERENCE :#{$payment->payment_reference}";
            $ledgerEntryData = [
                'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
                'ledger_source_id' => $loan->id,
                'ledger_user_id' => $loan->userid,
                'ledger_entry_amount' => $payment->amount,
                'ledger_entry_type' => 'deduction',
                'description' => $description,
                'entry_dt' => $date,
                'status'   => 'approved',
                'created_by' => whoIs('id'),
                'updated_by' => null,
                'category' => LEDGER_CATEGORIES['PAYMENT']
            ];

            $ledgerEntryData = array_values($ledgerEntryData);
            $this->ledgerModel->addLedgerEntry(...$ledgerEntryData);

            if($balance <= 0) {
                $this->fnCashAdvanceModel->dbupdate([
                    'status' => 'Paid'
                ], $loan->id);
                
                $user = $this->userModel->get_user($loan->userid);
                /**
                 * use to check if the user
                 * has currently verified referrals
                 * if so make them co-borrowers
                 */
                $referrals = $this->userModel->getDirectsVerifiedAccounts($user->id);
                $coBorrowers = [];
                if(is_array($referrals) && count($referrals) >= 2) {
                    foreach($referrals as $key => $row) {
                        $coBorrowers[] = [
                            'mobile_number' => $row->mobile,
                            'name' => $row->firstname . ' '. $row->lastname
                        ];
                        
                        if(count($coBorrowers) == 2) {
                            break;
                        }
                    }
                }

                if(empty($coBorrowers)) {
                    /**
                     * Bypass coborrower checks
                     */
                    $this->fnCashAdvanceModel->setLoanOptions([
                        $this->fnCashAdvanceModel::SKIP_COBORROWER_VALIDATION => true
                    ]);
                }

                $addLoanResponse = $this->fnCashAdvanceModel->addNewLoan([
                    'amount' => $loan->amount,
                    'userid' => $loan->userid,
                    'date'   => get_date(today()),
                    'is_agreement_check' => true,
                    'coborrower' => $coBorrowers
                ]);
            }
            
            $this->addMessage("Payment Approved");
            return true;
        }

        public function decline($id) {
            $this->loadModels();
            $payment = $this->get([
                'where' => [
                    'payment.id' => $id
                ]
            ]);

            if(!$payment) {
                $this->addError("Payment decline failed");
                return false;
            }

            if(isEqual($payment->payment_status, 'declined')) {
                $this->addError("This payment has been already processed");
                return false;
            }

            $loan = $this->fnCashAdvanceModel->getLoan($payment->ca_id);

            if(!$loan) {
                $this->addError("Loan not found");
                return false;
            }

            /**
             * for approved payment
             * and payment will be decline
             * adjust the balance of the loan
             */
            if(isEqual($payment->payment_status, 'approved')) {
                $balance = $loan->balance + $payment->amount;
                $status = ($balance <= 0) ? 'paid' : 'released';
                $this->fnCashAdvanceModel->dbupdate([
                    'balance' => $balance,
                    'status'  => $status
                ], $loan->id);
            }
            

            parent::dbupdate([
                'payment_status' => 'denied'
            ], $id);

            $this->addMessage("Payment Denied");
            return true;
        }

        public function getPaymentForApproval() {
            return $this->get([
                'where' => [
                    'payment_status' => 'for approval'
                ]
            ]);
        }


        private function loadModels() {
            if(!isset($this->fnCashAdvanceModel)) {
                $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            }
            
            if(!isset($this->cashAdvanceReleaseModel)) {
                $this->cashAdvanceReleaseModel = model('CashAdvanceReleaseModel');
            }

            if(!isset($this->userModel)) {
                $this->userModel = model('User_model');
            }
        }

        private function amountValidation($balance, $amount) {
            if($amount < 0) {
                $this->addError("Invalid amount payment");
                return false;
            }

            /**
             * invalid amount check
             */

            // else if($amount > $balance) {
            //     $this->addError("Unable to complete play, amount is too big for balance");
            //     return false;
            // }

            return true;
        }

        private function validation($paymentData) {
            $duplicateEntry = $this->get([
                'where' => [
                    'external_reference' => trim($paymentData['external_reference']),
                    'payment_status' => [
                        'condition' => 'not equal',
                        'value' => 'denied'
                    ]
                ]
            ]);
            
            if($duplicateEntry) {
                $this->addError("Duplicate entry found payment reference already exists, {$paymentData['external_reference']} Check your payment details");
                return false;
            }
            return true;
        }
    }