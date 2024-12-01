<?php

	class CommissionTransactionModel extends Base_model
	{
		public $table = 'commission_transactions';
		
		public $BANK_TRANSFER = 'BANK_TRANSFER';
		
		public function __construct()
		{
			parent::__construct();

			$this->user = new LDUserModel();

			$this->levelSetting = model('LevelSettingModel');
		}

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
	   		$this->db->execute();
		}
		

		public static function make_commission($userid, $purchaserid, $type, $amount, $origin)
		{
			$db = Database::getInstance();
			$date = date('Y-m-d');

			if(is_numeric($amount))
			{
				$token = get_token_random_char(12);
				$db->query(
					"INSERT INTO commission_transactions(userid, purchaserid ,type , amount, date , origin, reference_id)
					VALUES('$userid' , '$purchaserid', '$type' , '$amount' , '$date' , '$origin', '{$token}')"
				);
				try{

					$db->execute();
					return true;
				}catch(Exception $e) {
					return false;
				}
			}else{
				writeLog('unilevel.txt' , " UNILEVEL {$amount} amount has been skipped");
				return false;
			}
		}

		/*
		*Used ON
		*Commissiontrigger_model::submitcommission
		*/

		public static function new_drc_rule($sponsorid , $purchaserid, $type , $amount , $origin, $level)
		{
			/*GET PURCHASED CODE LEVEL SETTINGS*/
			$user = new LDUserModel();

			/*GET PURCHASED CODE LEVEL SETTINGS*/
			$purchasedLevel = LevelSettingModel::getByLevel($level);

			$searchSponsor = true;
			$distributeAmount = $amount;
			/*
			*Store here all levels that has been given piece of commission
			*this levels are below purchased level position.
			*/
			$passedLevels = [];
			/*loop on sponsors to check if level is matched or higher*/


			$date = today();
			
			while($searchSponsor) 
			{
				/*GET SPONSOR INFORMATIONS*/
				$sponsor = $user->getChooseField([
					'id' , 'username' ,'direct_sponsor' , 'status'
				] , $sponsorid);

				/*If no more sponsors found break the loop*/
				if(!$sponsor)
					break;
				$userid = $sponsor->id;
				$sponsorid = $sponsor->direct_sponsor;

				/*get sponsors current status level settings*/
				$sponsorStatus = LevelSettingModel::getByLevel($sponsor->status);

				/*if sponsor status is nither on starter to diamond skip sponsor*/
				if(!$sponsorStatus)
					continue;

				/*check if sponsors level already saved on passed levels then skipped*/
				if(in_array($sponsor->status , $passedLevels)) 
					continue;

				/*
				*if sponsor status is lesser than purchased level
				*deduct to DRC TOTAL AMOUNT
				*/
				if( $sponsorStatus->hierarchy < $purchasedLevel->hierarchy)
				{
					$distributeAmount = $sponsorStatus->amount;
					$amount -= $sponsorStatus->amount;

					array_push($passedLevels , $sponsor->status);

				}else{
					$distributeAmount = $amount;
					$searchSponsor = false;
				}
				
				$saved = CommissionTransactionModel::make_commission(...[
					$userid, $purchaserid, $type , $distributeAmount , $date, $origin
				]);

				if($saved) {	
					writeLog('logfile.txt' ," USER {$userid} has recieved $distributeAmount");
				}
			}
		}

		public function getFiltered($commissionType , $username = '' , $startDate = null , $endDate = null)
		{
			$WHERE = '';

			if(strtoupper($commissionType) != 'ALL')
				$WHERE .= "WHERE com.type = '$commissionType'";
			/*SET USERID*/
			if(!empty($username))
				$WHERE .= " and comuser.username = '$username'";

			if(!empty($startDate) && !empty($endDate))
				$WHERE .= " and com.date between '$startDate' and '$endDate'";

			if(strtoupper($commissionType) == 'ALL')
			{
				$WHERE = " WHERE com.userid != '' " . $WHERE;
			}
			return $this->getWithParam($WHERE);
		}


		/**
		 * sum of all commissions
		 * including payouts : balance
		 */
		public function getAvailableEarning($userId)
		{
			$where = null;

			$whereCondition = [
				'userid' => $userId
			];

			$where = " WHERE ".parent::dbParamsToCondition($whereCondition);

			$this->db->query(
				"SELECT sum(amount) as total_amount
					FROM {$this->table}
					{$where} GROUP BY userid"
			);

			return $this->db->single()->total_amount ?? 00;
		}

		/**
		 * get earnigns only
		 */
		public function getTotalEarning($userId, $commissionType = null)
		{
			$where = null;

			$whereCondition = [
				'amount' => [
					'condition' => '>',
					'value' => 0
				],
				'userid' => $userId
			];
			
			if (!is_null($commissionType)) {
				$whereCondition['type'] = $commissionType;
			}

			$where = " WHERE ".parent::dbParamsToCondition($whereCondition);

			$this->db->query(
				"SELECT sum(amount) as total_amount
					FROM {$this->table}
					{$where}
					GROUP BY userid"
			);

			return $this->db->single()->total_amount ?? 00;
		}

		public function getAll($params = []) {
			$where = null;
			$order = null;
			$limit = null;

			if(isset($params['where'])) {
				$where = " WHERE ".parent::convertWhere($params['where']);
			}

			if(isset($params['order'])) {
				$order = " ORDER BY ".parent::convertWhere($params['where']);
			}

			if(isset($params['limit'])) {
				$limit = " LIMIT ".parent::convertWhere($params['limit']);
			}

			$this->db->query(
				"SELECT userid , comuser.username as username ,
				comuser.firstname as beneficiary_firstname , comuser.lastname as beneficiary_lastname,
				concat(comuser.firstname, ' ',comuser.lastname) as beneficiary_fullname,

				purchaser.firstname as purchaser_firstname , purchaser.lastname as purchaser_lastname,
				concat(purchaser.firstname, ' ',purchaser.lastname) as purchaser_fullname,

				ifnull(purchaser.username  , 'not-available on previous version') as purchasername,
				type,  origin , date , amount, com.reference_id, com.created_at
				from commission_transactions  as com

				left join users as comuser on
				com.userid = comuser.id

				left join users as purchaser on
				com.purchaserid = purchaser.id
				
				{$where} {$order} {$limit}"
			);

			return $this->db->resultSet();
		}
		public function getWithParam($WHERE , $ORDERBY = null , $LIMIT = null)
		{
			$sql = "
				SELECT userid , comuser.username as username ,
				ifnull(purchaser.username  , 'not-available on previous version') as purchasername,
				type,  origin , date , amount, com.created_at
				from commission_transactions  as com

				left join users as comuser on
				com.userid = comuser.id

				left join users as purchaser on
				com.purchaserid = purchaser.id
				$WHERE
				order by date desc";
				
			try{
				$this->db->query($sql);

				return $this->db->resultSet();

			}catch(Exception $e)
			{
				die($e->getMessage());
			}
		}
		public function get_commissions_by_type($userid , $type)
		{
			$sql = " SELECT userid , username , type,  origin , date , amount from
				commission_transactions  as com
				left join users as u on com.userid = u.id
				where com.type = '$type' and u.id = '$userid'
				order by date desc";
			try{
				$this->db->query($sql);
				return $this->db->resultSet();
			}catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

		public function get_commissions($userid = null)
		{
			$this->set_time_zone();
			/*admin*/

			$sql = "SELECT userid , comuser.username as username ,
					ifnull(purchaser.username  , 'not-available on previous version') as purchasername,
					type,  origin , date , amount, com.created_at
					from commission_transactions  as com

					left join users as comuser on
					com.userid = comuser.id

					left join users as purchaser on
					com.purchaserid = purchaser.id";

			if(!is_null($userid)) {
				$sql .= " WHERE com.userid = '$userid' ";
				$sql .= " AND amount != 0 ";
			}else{
				$sql .= " WHERE amount != 0 ";
			}

			$sql .= " order by date desc ";

			$this->db->query($sql);

			$results = $this->db->resultSet();

			try{
				$this->db->query($sql);
				return $this->db->resultSet();
			}catch(Exception $e){
				die($e->getMessage());
			}
		}

		/*FOR API TESTING*/


		public function get_commissions_limit($limit = 50) {

			$this->db->query(
				"select created_at , userid , type , amount from commission_transactions order by id desc limit 50;"
			);

			return $this->db->resultSet();
		}
		//send earning to other person
		public function expressSend($recipientUsername,$senderId,$amount,$notes) {
			//get username
			$userModel = model('User_model');
			$recipient = $userModel->get_by_username($recipientUsername);

			if($amount <=0 ) {
				$this->addError("Invalid Amount");
				return false;
			}
			if(!$recipient) {
				$this->addError("Username not found.");
				return false;
			}
			
			if($recipient->id == $senderId) {
				$this->addError("You cannot sent wallet to your self.");
				return false;
			}
			//check balance
			$availableEarning = $this->getAvailableEarning($senderId);
			
			if($availableEarning < $amount) {
				$this->addError("Insufficient wallet amount.");
				return false;
			}
			//add money
			$origin = 'EXPRESS_SEND';
			$origin .= "\n{$notes}";

			//deduct money
			$isDeducted = self::make_commission($senderId, $recipient->id, 'WALLET', ($amount * -1), $origin);

			$isAdded = self::make_commission($recipient->id, $senderId, 'WALLET',$amount, $origin);

			if($isDeducted && $isAdded) {
				$this->addMessage("Wallet Sent");
				return true;
			}
			$this->addError("Unable to complete your request");
			return false;
		}
	}
