<?php 
    namespace Classes\Binary;
    use Database;

    class Computation
    {
        private $_userId;
        private $_userBinaryModel;
        private $_point;
        private $_position;

        //return Values
        private $_rightCarry;
        private $_leftCarry;
        private $_left;
        private $_right;
        private $_pair;
        private $_amount;
        private $_binaryId = null;
        private $_description = '';

        const LEFT_POSITION = 'LEFT';
        const RIGHT_POSITION = 'RIGHT';

        //computation interface
        private $_computation;

        public function __construct($userId)
        {
            $this->_userId = $userId;
            $this->fetchCurrentBinary();  
        }


        public function fetchCurrentBinary()
        {
            $this->_userBinaryModel = model('UserBinaryModel',[$this->_userId]);
            $this->_leftCarry = $this->_userBinaryModel->get_left_carry();
            $this->_rightCarry = $this->_userBinaryModel->get_right_carry();

        }
        
        public function setPoint($point)
        {
            $this->_point = $point;
            return $this;
        }

        public function setPosition($position)
        {
            $this->_position = $position;
            $this->_description .= "Binary points($this->_point) added on {$position} position";
            return $this;
        }

        public function preCompute()
        {  
            if ($this->_position == self::LEFT_POSITION) {
                $this->_leftCarry += $this->_point;
            }else{
                $this->_rightCarry += $this->_point;
            }
        }

        public function getCarry($position)
        {
            if($position == self::LEFT_POSITION){
                return $this->_leftCarry;
            }else{
                return $this->_rightCarry;
            }
        }

        public function getPoint($position)
        {
            if($position == self::LEFT_POSITION){
                return $this->_left;
            }else{
                return $this->_right;
            }
        }

        public function setPairingCondition(IComputation $computation)
        {
            $this->_computation = $computation;
        }

        public function computeByPairingCondition()
        {
            /**
             * assign to left and right point
             * to hold history value
             */
            $this->_left = $this->_leftCarry;
            $this->_right = $this->_rightCarry;

            //get lowest value
            $lowest = $this->_left > $this->_right ? $this->_right : $this->_left;
            //get how many pairs can be created 
            $pair = floor($lowest / $this->_computation::PAIR_TRESHOLD);

            if($pair) {
                $this->_amount = $pair * $this->_computation::PAIR_AMOUNT;
                $this->_pair = $pair;
                //deduct on carry
                $pointDeduction = ($pair * $this->_computation::PAIR_TRESHOLD);                
                $this->_leftCarry  = $this->_leftCarry - $pointDeduction;
                $this->_rightCarry = $this->_rightCarry - $pointDeduction;
                
                $amountFormatted = number_format($this->_amount, 2);
                $this->_description .= ",PAIR({$pair}) FOUND AMOUNTING TO {$amountFormatted}";
            }else{
                $this->_amount = 0;
                $this->_pair = 0;
            }
        }

        public function retVal()
        {
            return [
                'LEFT_CARRY' => $this->_leftCarry,
                'RIGHT_CARRY' => $this->_rightCarry,
                'LEFT' => $this->_left,
                'RIGHT' => $this->_right,
                'PAIR' => $this->_pair,
                'AMOUNT' => $this->_amount,
                'DESCRIPTION' => $this->_description,
                'USERID' => $this->_userId,
                'BINARY_ID' => $this->_binaryId
            ];
        }

        public function save()
        {
            if (isset($this->_computation) && $this->_computation->isPassed()) {
                $this->computeByPairingCondition();
            } else {
                /**
                 * assign to left and right point
                 * to hold history value
                 */
                $this->_left = $this->_leftCarry;
                $this->_right = $this->_rightCarry;
                $this->_amount = 0;
                $this->_pair = 0;
            }
            $data = $this->retVal();
            
            $res = $this->_userBinaryModel->store([
                'userid' => $data['USERID'],
                'left_vol' => $data['LEFT'],
                'right_vol' => $data['RIGHT'],
                'left_carry' => $data['LEFT_CARRY'],
                'right_carry' => $data['RIGHT_CARRY'],
                'pair' => $data['PAIR'],
                'amount' => $data['AMOUNT'],
                'description' => $data['DESCRIPTION'],
            ]);
            $this->_binaryId = $res;
            return $res;
        }
    }