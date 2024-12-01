<?php   
    namespace Business;
    
    class AmountValidator extends Core
    {
        public function validate($amount)
        {
            if( !is_numeric( $amount ) ){
                $this->addError(" Invalid amount , not numeric Data");
                return false;
            }
            $amount = doubleval($amount);

            if( $amount < 1) {
                $this->addError("Invalid Entered Amount , amount must not be zero or lesser zero");
                return false;
            }

            return true;
        }
    }