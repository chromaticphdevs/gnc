<?php 
    use Classes\Binary\{
		Computation,
		PairSingleComputation,
        Pair1020Computation
	};
	require_once CLASSES.DS.'Binary/Computation.php';
	require_once CLASSES.DS.'Binary/PairSingleComputation.php';
	require_once CLASSES.DS.'Binary/Pair1020Computation.php';

    class BinaryTransactionModel extends Base_model
    {
        public $table_name = 'binary_transactions';
        public $table = 'binary_transactions';


        public $pairing_treshold;
        public $classCalculator;

        public function __construct()
        {
            parent::__construct();
            $this->pairCounter = model('BinaryPairCounterModel');
            $this->pairing_treshold = Pair1020Computation::PAIR_TRESHOLD;
        }
        public function add($param = [])
        {   
            $computation = new Computation($param['userid']);	
			$computation->setPoint($param['point']);
			$computation->setPosition($param['position']);
			$computation->preCompute();
			$computation->setPairingCondition(new Pair1020Computation($computation->getCarry($computation::LEFT_POSITION)));
			$computation->getCarry($computation::RIGHT_POSITION);
            $computation->save();
            return $computation->retVal();
        }
        
        public function getBinary($userId)
        {
            $this->db->query(
                "SELECT * FROM {$this->table_name}
                    WHERE userid = '{$userId}'
                    ORDER BY id desc "
            );
            
            return $this->db->single();
        }

        public function addComission($userId, $amount, $description, $purchaserId = null) {

            $totalCounter = $this->pairCounter->getTotal($userId);

            $res = CommissionTransactionModel::make_commission(...[
                $userId,
                $purchaserId,
                'BINARY',
                $amount,
                $description
            ]);

            /**
             * disable flush
             */
            // if ($totalCounter < 3) {
            //     $this->pairCounter->add($userId);
            //     $res = CommissionTransactionModel::make_commission(...[
            //         $userId,
            //         $purchaserId,
            //         'BINARY',
            //         $amount,
            //         $description
            //     ]);
            // } else {
            //     $res = CommissionTransactionModel::make_commission(...[
            //         $userId,
            //         $purchaserId,
            //         'BINARY',
            //         0,
            //         "THIRD PAIR SAFETY NET"
            //     ]);
            //     $this->pairCounter->clear($userId);
            // }
            return $res;
        }
    }