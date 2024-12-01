<?php 
    namespace Classes\Binary;
    use Classes\Binary\IComputation;
    require_once CLASSES.DS.'Binary/IComputation.php';

    class PairSingleComputation implements IComputation
    {     
        const PAIR_TRESHOLD = 1;
        const PAIR_AMOUNT = 1000;
        private $_isPassed = false;

        public function __construct($leftPoint, $rightPoint)
        {
            if ($leftPoint >= self::PAIR_TRESHOLD && $rightPoint >=self::PAIR_TRESHOLD) {
                $this->_isPassed = true;
            }
        }

        public function isPassed() {
            return $this->_isPassed;
        }

        public function pairAmount() {
            return self::PAIR_AMOUNT;
        }
        
        public function pairTreshold() {
            return self::PAIR_TRESHOLD;
        }
    }