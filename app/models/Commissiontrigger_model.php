<?php

	require_once(APPROOT.DS.'classes/UserBinaryPV.php');
	require_once(FNCTNS.DS.'crawler.php');
	/*
		truncate binary_pv_commissions;
		truncate binary_pvs;
		truncate binary_pv_pair_counter;;
		truncate binary_pv_pair_deduction;
	*/
	class Commissiontrigger_model extends Base_model
	{

		private $binary_pv = 'binary_pvs' ,
		$binary_pv_counter = 'binary_pv_counter',
		$binary_pv_pair_commission = 'binary_pv_commissions',
		$binary_pv_pair_deduction  = 'binary_pv_pair_deduction';


		public function __construct()
		{
			parent::__construct();
 
			$this->mentorModel = new MentorCommissionModel();

			$this->binaryFlushoutModel = new BinaryFlushoutModel();
		}
		//$user_id , $commissions , $order_id
		public function submit_commissions($purchaser , $commission ,
			$order_id , $distribution , $origin)
		{

			/*start switch*/
			$this->sponsors  = crawler_drc($purchaser);
			$this->uplines   = crawler_upline($purchaser);
			
			$directSponsorParameters = [
				$purchaser ,$order_id ,
				$commission['unilevelAmount'] ,
				$commission['drcAmount'] ,
				$distribution , $origin,
				$commission['level']
			];

			$binaryCommissionParameters = [
				$order_id , $purchaser ,
				$commission['binaryPoints'] ,$origin
			];

			$res1 = $this->add_direct_sponsors_commissions(...$directSponsorParameters);
			$res2 = $this->add_binary_commissions(...$binaryCommissionParameters);



			/*
			OFF ON : 10/02/2020
			$uplineSwitch = new UplineSwitchModel();

			$purchaserUpline = $uplineSwitch->get_upline($purchaser);

			if(!$uplineSwitch->upline_activated($purchaserUpline))
				$uplineSwitch->make_switch($purchaserUpline->id , $purchaser);*/
			
			if($res1 && $res2) {
				return true;
			}else{
				return false;
			}
		}

		private function add_direct_sponsors_commissions($purchaser,
		$order_id, $unilvl , $drc , $distribution , $origin, $level)
		{

			$sponsors = $this->sponsors;
			$instance = 0;


			try{
				foreach($sponsors as $key => $sponsor)
				{
					$sponsorid = $sponsor->id;
					$maxpair   = $sponsor->max_pair;

					
					/*FIRST SPONSOR*/
					if($key === 0 )
					{
							$mentorAmount = $drc + $unilvl;

							if($drc > 0)
							{
								
								$data = [
									$sponsorid ,
									$purchaser,
									'DRC',
									$drc,
									$origin,
									$level
								];

								CommissionTransactionModel::new_drc_rule(...$data);
							}


							/*END DRC ADD COMMISSION*/

							/*UNILEVEL ADD COMMISSION*/
							if($unilvl > 0)
							{
								$data = [
									$sponsorid ,
									$purchaser,
									'UNILEVEL',
									$unilvl,
									$origin
								];
								/*DEDUCT UNILEVEL BY 10*/
								CommissionTransactionModel::make_commission(...$data);
							}
							/*END UNILEVEL ADD COMMISSION*/

							/*MENTOR ADD COMMISSION*/
							if( $mentorAmount > 0)
							{
								$mentor = [
									$order_id ,
									$purchaser,
									$sponsorid ,
									($drc + $unilvl),
									$origin
								];

								$this->mentorModel->make_commission(...$mentor);
							}
					}

					if($key > 0)
					{
						/*UNILEVEL INSERT FOR NON-DIRECT-SPONSOR*/
						if($distribution > $key)
						{
							$data = [
								$sponsorid ,
								$purchaser,
								'UNILEVEL',
								$unilvl,
								$origin
							];
							CommissionTransactionModel::make_commission(...$data);
						}
					}
				}
			
				return true;
			}catch(Exception $e) {

				die($e->getMessage());
				return false;
			}
		}
		
		
		/**
		 * 
		 */
		public function add_binary_points($purchaser_id , $is_top_up = false)
		{
			$uplines = crawler_upline($purchaser_id);

			$points = 1;//temporary
			/**
			 * stop the loop
			 */
			if(empty($uplines))
				return true;

			foreach( $uplines as $key => $upline )
			{	
				$user_id = $upline->id;
				$position = $upline->downlinePosition;

				//skip
				if(isEqual($upline->rank , 'pre-activated'))
					continue;
				
				
				$binary60PairCommission = new Binary60PairCommission();
				$binary60PairCommission->computeAndSave(
					$user_id , $position , $points
				);

				if($binary60PairCommission->amount > 0)
				{
					$commission = [
						$user_id,
						$purchaser_id,
						'BINARY' ,
						$binary60PairCommission->amount,
						'60 pair'
					];
					CommissionTransactionModel::make_commission(...$commission);
				}
				
			}
		}

		public function add_sponsor_commission($purchaser_id)
		{
			$user_model = model('User_model');
			$is_finished = false; 

			while(!$is_finished)
			{
				$purchaser_sponsor = $user_model->user_get_sponsor($purchaser_id);

				if(!isEqual($purchaser_sponsor->status, 'pre-activated'))
				{
					$commission_data = [
						$purchaser_sponsor->id,
						$purchaser_id,
						'DRC',
						1000,
						'breakthrough-e'
					];
					CommissionTransactionModel::make_commission(...$commission_data);
					$is_finished = true;
				}else
				{
					$purchaser_id = $user_model->user_get_sponsor($purchaser_sponsor->id );

					//no more sponsor found
					if(is_null($purchaser_id))
						$is_finished = true;
				}
			}

		}

		/*
		*@param
		*purchaser
		*IP incomming-points
		*/
		public function add_binary_commissions($orderid , $purchaser , $points , $origin)
		{
			$uplines = crawler_upline($purchaser);

			$loop_counter = 0;

			try{

				if(!empty($uplines))
				{
					foreach($uplines as $upline)
					{

						if($upline->max_pair <= 0) {
							continue;
						}

						if(!$upline->id)
							continue;

						$userid        = $upline->id;
						$position      = $upline->downlinePosition;
						$maxpair       = $upline->max_pair;

						$binaryPointObj  = new BinaryPointObj($points , $position);

						$userBinaryModel = new UserBinaryModel($userid);

						$recentTransaction = $userBinaryModel->get_recent_transaction();

						/*check if reached maxpair*/
						if($maxpair >= $userBinaryModel->get_pair()) 
						{
							//getUsersPrevious-Transactions
							if($recentTransaction) {

								$newTransaction = $userBinaryModel->save_transactions(
									$binaryPointObj,
									$maxpair
								);

								/*transaction has commission*/
								if($newTransaction['amount']) {
									$commission = [
										$userid,
										$purchaser,
										'BINARY' ,
										$newTransaction['amount'] ,
										$origin
									];

									CommissionTransactionModel::make_commission(...$commission);

									/*insert pair counter*/
									$this->insert_pair_counter(0, $newTransaction['pair'] , $userid);
								}
							}else{

								$data = [
									$leftVol  = strtolower($position) == 'left'  ? $points : 0 ,
									$rightVol = strtolower($position) == 'right' ? $points : 0 ,
									$amount   = 0,
									$pair     = 0
								];

								$userBinaryModel->first_transaction(
									... $data
								);

							}

						}else{
							if($recentTransaction) {
								if($recentTransaction->pair != 0) {
									$userBinaryModel->save_flushout();
								}/*do nothing kase na flush out na*/
								/*throw flush out*/
							}

						}
					}// end for loop
				}// end upline empty check
				return true;
			}catch(Exception $e) {

				die(var_dump($e->getMessage()));
				return false;
			}
		}

		private function insert_pair_counter($binary_pv_com_id , $pair , $user_id)
		{
			if( $pair != 0)
			{
				$this->db->query(
					"INSERT INTO binary_pv_pair_counter(pair , binary_pv_com_id , user_id)
					 VALUES(:pair , :binary_pv_com_id , :user_id)"
				);

				$this->db->bind(':pair' , $pair);
				$this->db->bind(':binary_pv_com_id' , $binary_pv_com_id);
				$this->db->bind(':user_id' , $user_id);

				$this->db->execute();
			}

		}
	}
