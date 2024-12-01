<?php
    namespace Services;

    class CashAdvanceService {
        //default
        const DUE_DATE_NO_OF_DAYS_DEFAULT = 60;

        /**
         * penalty
         */
        public function calculateAttorneesFeePenalty($loanAmount) {
            $loanAmount = $loanAmount * 0.02;
            return $loanAmount;
        }

        public function calculateDueDate($dueDateNoOfDays, $releaseDate) {
            return date('Y-m-d', strtotime("+{$dueDateNoOfDays} days {$releaseDate}"));
        }
        
        public function calculate($loanAmount) {
            $serviceFee = $loanAmount * LOAN_CHARGES['SERVICE_FEE_RATE'];
            $attorneesFee = $loanAmount * LOAN_CHARGES['ATTORNEES_FEE_RATE'];
            $loanInterestFee = $loanAmount * LOAN_CHARGES['LOAN_INTEREST_FEE_RATE'];
            
            return [
                'serviceFee'      => $serviceFee,
                'attorneesFee'    => $attorneesFee,
                'loanInterestFee' => $loanInterestFee,
                'net' => ($serviceFee + $attorneesFee + $loanInterestFee + $loanAmount)
            ];
        }

        public function calculationForTerminatedLoan($remainingBalance, $attorneesFee) {
            $netAndBalance = $remainingBalance + $attorneesFee;
            return [
                'serviceFee' => 0,
                'attorneesFee' => $attorneesFee,
                'loanInterest' => 0,
                'net' => $netAndBalance,
                'balance' => $netAndBalance,
                'amount' => ($remainingBalance)
            ];
        }

        /**
         * release date of the loan
         * cash_advance_releases:entry_date,
         * payment -> payments are record of payments from the loan
         */
        public function calculateAccuiredPenalties($releaseDate, $payments = [], $loan) {
            $retVal = 0;
            if($loan->amount >= 5000) {
                $dateWithoutPayments = $this->searchForNoPaymentDates($releaseDate, $payments);

                if(!empty($dateWithoutPayments)) {
                    $retVal = count($dateWithoutPayments) * LOAN_CHARGES['LATE_PAYMENT_ATTORNEES_FEE_AMOUNT'];
                }
            }
            return $retVal;
        }

        public function searchForNoPaymentDates($releaseDate, $payments = []) {
            $dateToday = date('Y-m-d');

            $iDate = get_date("+1 day " . $releaseDate);
            $dates = [];
            $paymentDates = [];
            $dateWithoutPayments = [];
            
            //create date range to search for no payment date
            while($iDate != $dateToday) {
                array_push($dates, $iDate);
                $iDate = get_date("+ 1 day " .$iDate);
            }

            foreach($payments as $paymentKey => $paymentRow) {
                array_push($paymentDates, $paymentRow->entry_date);
            }

            if(empty($dates)) {
                return [];
            }


            $dateWithoutPayments = array_values(array_diff($dates, $paymentDates));

            return $dateWithoutPayments;
        }

        /**
         * penalize no payments
         */
        public function penalizeNoDailyPayments() {
            if(!isset($this->fnCashAdvanceModel)) {
                $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            }

            if(!isset($this->cashAdvancePaymentModel)) {
                $this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
            }

            if(!isset($this->loanlogModel)) {
                $this->loanlogModel = model('LoanlogModel');
            }

            if(!isset($this->loanJobModel)) {
                $this->loanJobModel = model('LoanJobModel');
            }

            if(!$this->loanJobModel->dailyCutoffPenalty()) {
                return false;
            }
            
            $cutoffDate = date('Y-m-d');

            $cashAdvancePayments = $this->cashAdvancePaymentModel->getAll([
                'where' => [
                    'date(entry_date)' => $cutoffDate
                ]
            ]);

            $cashAdvancePaymentCashAdvanceIds = [];
            foreach($cashAdvancePayments as $key => $row) {
                array_push($cashAdvancePaymentCashAdvanceIds, $row->ca_id);
            }
            /**
             * fetch catch advances which
             * dont have payment yesterday
             */
            $cashAdvances = $this->fnCashAdvanceModel->fetchAll([
                'where' => [
                    'is_released' => 1,
                    'cd.status' => 'released',
                    'cd.id' => [
                        'condition' => 'not in',
                        'value' => $cashAdvancePaymentCashAdvanceIds
                    ],
                    //skip loans that are released on cutoff date 
                    'cd.release_date' => [
                        'condition' => 'not equal',
                        'value' => $cutoffDate
                    ],
                    'amount' => [
                        'condition' => '>=',
                        'value' => 5000
                    ]
                ]
            ]); 
            
            $message = '';
            $notes = '<ul>';
            $total = 0;

            if(!isset($this->ledgerModel)) {
                $this->ledgerModel = model('LedgerModel');
            }
            $notes .= "
                <li> REFERENCE | BALANCE | NEW BALANCE | NAME</li>
            ";
            foreach($cashAdvances as $key => $loan) {
                $penaltyAmount = $this->calculateAttorneesFeePenalty($loan->ca_amount);
                $this->fnCashAdvanceModel->addAttorneeFeePenalty($loan->ca_id, $penaltyAmount);
                $this->loanlogModel->addNonPaymentPenalty($loan, $cutoffDate, $penaltyAmount);
                $description = "Penalty - attorney's fee applied non-payment on date {$cutoffDate} to cash advance {$loan->ca_reference}";
                $ledgerEntryData = [
                    'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
                    'ledger_source_id' => $loan->ca_id,
                    'ledger_user_id' => $loan->ca_userid,
                    'ledger_entry_amount' => $penaltyAmount,
                    'ledger_entry_type' => 'addition',
                    'description' => $description,
                    'entry_dt' => $cutoffDate,
                    'status'   => 'approved',
                    'created_by' => whoIs('id'),
                    'updated_by' => null,
                    'category'   => LEDGER_CATEGORIES['PENALTY_ATTORNEES_FEE']
                ];

                $ledgerEntryData = array_values($ledgerEntryData);
                $this->ledgerModel->addLedgerEntry(...$ledgerEntryData);
                
                $balance = ui_html_amount($loan->ca_balance);
                $newBalance = $balance + $penaltyAmount;
                //add notes
                $notes .= "<li>{$loan->ca_reference} | {$balance} | {$newBalance} | {$loan->fullname}  </li>";

                $message .= '123123';
                $total += $penaltyAmount;
            }
            $notes .= "</ul>";

            if(empty($message)) {
                $message = " No user's has been penalized today";
            } else {
                $total = ui_html_amount($total);
                $totalUserPenalizedCount = count($cashAdvances);
                $message = "There are {$totalUserPenalizedCount} has been penalized today";
                $message .= "Penalty Amount Total : {$total}";
                $message .= "<div> List of users that's been penaized </div>";
                $message .= $notes;
            }
            // _mail(['edromero1472@gmail.com', 'chromaticsoftwares@gmail.com'], 'USER PENALTIES AS OF ' . $cutoffDate, $message);
        }
    }
                