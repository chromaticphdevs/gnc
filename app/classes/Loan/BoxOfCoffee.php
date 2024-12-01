<?php 
    namespace Classes\Loan;

    use Classes\Loan\LoanService;
    require_once CLASSES.DS.'Loan/LoanService.php';

    class BoxOfCoffee
    {
        private $_userId;
        private $_quantity;
        private $_branchId;
        private $_date;

        private $_amount;
        private $_messages = [];
        
        public function __construct()
        {
            $this->_loanModel = model('LoanModel');
        }

        public function setUser($userId){
            $this->_userId = $userId;
            return $this;
        }

        public function setQuantity($quantity){
            $this->_quantity = $quantity;
            return $this;
        }

        public function setBranch($branchId)
        {
            $this->_branchId = $branchId;
            return $this;
        }

        public function setDate($date)
        {
            $this->_date = $date;
            return $this;
        }

        public function loan()
        {
            if ($this->_loanModel->getUserLoanBalance($this->_userId) >= 0) {
                //has loan
                $this->_messages[] = "User has existing loan.";
                return false;
            }

            if ($this->checkUserCreditLimit()) {
                if ($this->checkBranchAvailability()) {
                    $this->_amount = $this->_quantity * LoanService::BOX_OF_COFEE_PRICE;
                    $loanId = $this->_loanModel->save([
                        'amount' => $this->_amount,
                        'remaining_balance' => $this->_amount,
                        'initial_amount' => $this->_amount,
                        'entry_date' => $this->_date,
                        'entry_type' => LoanService::ENTRY_TYPE_LOAN,
                        'user_id' => $this->_userId,
                        'source_id' => $this->_branchId
                    ]);

                    if($loanId) {
                        //add loan record
                        $isRecordUpdated = $this->_loanModel->addRecord([
                            'loan_id' => $loanId,
                            'user_id' => $this->_userId,
                            'type_of_loan' => LoanService::LOAN_TYPE_BOX_OF_COFFEE,
                            'quantity' => $this->_quantity,
                            'individual_amount' => LoanService::BOX_OF_COFEE_PRICE,
                            'total_amount' => $this->_amount,
                            'total_payment' => 0,
                            'remaining_balance' => $this->_amount,
                            'remarks' => "Box Of Coffee Loan ({$this->_quantity}) piece/s"
                        ]);

                        $this->recordId = $this->_loanModel->recordId;
                    }

                    $this->loanId = $loanId;
                    $this->_messages[] = "Loan Successful";
                    return true;
                }
            } else {
                $this->_messages[] = "Insuficient Credit limit";
            }

            return false;
        }

        public function checkUserCreditLimit()
        {
            if($this->_loanModel->getUserCreditLimit($this->_userId,LoanService::LOAN_TYPE_BOX_OF_COFFEE) >= $this->_quantity) {
                return true;
            }
            return false;
        }

        public function checkBranchAvailability()
        {
            return true;
        }

        public function getMessage()
        {
            if(!empty($this->_messages))
                return implode(',', $this->_messages);
            return '';
        }
    }