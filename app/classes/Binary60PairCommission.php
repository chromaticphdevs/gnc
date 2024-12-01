<?php 

    class Binary60PairCommission
    {   
        public $pairTreshold = 60;

        public $amount = 0;
        //pair amount equivalent
        public $pair_amount = 1000;

        public $pair  =0;
        private $left_point_carry = 0;
        private $right_point_carry = 0;

        public function computeAndSave($beneficiary_id , $position , $point)
        {
            $userBinaryModel = new UserBinaryModel($beneficiary_id);

            $left_vol = $userBinaryModel->get_left_carry();
            $right_vol = $userBinaryModel->get_right_carry();

            if(isEqual($position , 'right') ){
                $right_vol += $point;
            }else{
                $left_vol += $point;
            }

            //check and compute pair
            $this->calculatePoints($left_vol, $right_vol);

            $userBinaryModel->store([
                'userid' => $beneficiary_id,
                'left_vol' => $left_vol,
                'right_vol' => $right_vol,
                'left_carry' => $this->left_point_carry,
                'right_carry' => $this->right_point_carry,
                'pair' => $this->pair,
                'amount' => $this->amount,
                'description' => "new binary points added on {$position} position"
            ]);
        }

        public function calculatePoints($left_point , $right_point)
        {
            if($left_point != 0 && $right_point != 0)
            {
                /**
                 * if left_point is greater that right point
                 * then deduct right to left
                 */
                if($left_point > $right_point) 
                {
                    $this->pair = $right_point;
                    $this->left_point_carry = $left_point - $right_point;
                    $this->right_point_carry = 0;
                }else
                {
                    $this->pair = $left_point;
                    $this->right_point_carry = $right_point - $left_point;
                    $this->left_point_carry = 0;
                }

                $this->amount = $this->pair * $this->pair_amount;
            }else
            {
                $this->right_point_carry = $right_point;
                $this->left_point_carry = $left_point;
            }
        }

        public function checkFor60Pair()
        {
            if($this->pairTreshold)
        }
    }