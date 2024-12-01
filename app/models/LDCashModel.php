<?php 	


	class LDCashModel extends Base_model
	{

		private $table_name = 'ld_cash_advances';
		private $userType;


		public function __construct()
		{
			parent::__construct();
			
			$this->userType = Session::get('user')['type'];
		}

		public function create($LoanInfo)
		{
			extract($LoanInfo);

			$newNote=filter_var($note, FILTER_SANITIZE_STRING);
			date_default_timezone_set("Asia/Manila");
			$date=date("Y-m-d");
			$time=date("H:i:s");

			$this->db->query(
				"INSERT INTO $this->table_name( `date`, `time`,`userid`, `groupid`, `amount`, `notes`) 
				VALUES ('$date','$time','$userid',
				(SELECT groupid From ld_groups_attendees WHERE userid=$userid),
				'$amount','$newNote' )");

			if($this->db->execute()){
				Flash::set("Lenders group created");

				if($this->userType=="admin")
				{
					redirect('/LDCashAdvance/list');
				}else
				{
				    redirect('/LDUser/Profile');
				}

			}else{
				Flash::set("Lenders not created");
			}
		}


		public function call_create($LoanInfo)
		{
			extract($LoanInfo);

			$newNote =filter_var($note, FILTER_SANITIZE_STRING);
			date_default_timezone_set("Asia/Manila");
			$date=date("Y-m-d");
			$time=date("H:i:s");
			$this->db->query(
				"INSERT INTO $this->table_name( `date`, `time`,`userid`, `groupid`, `amount`, `notes`, `branch_id`) 
				VALUES ('$date','$time','$userid',
				(SELECT groupid From ld_groups_attendees WHERE userid=$userid),
				'$amount','$newNote' ,'$branch_id')");
	
			try{
				$this->db->execute();
				return true;
			}catch(Exception $e)
			{
				Session::get('Fatal:'.$e->getMessage());
				return false;
			}
			
		}



		public function list()
		{

			$this->db->query(
				"SELECT `userid` as userID,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=userID)as name, `groupid` as groupID,(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=groupID) as groupName, `amount`, `date`, `time`, `approved_by` as adminID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname) 	 as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `notes`,`created_on`,`status`,`id` ,`collateral_img` FROM  $this->table_name WHERE `status`='pending' ORDER BY `ld_cash_advances`.`created_on` DESC LIMIT 120"
			);
			return $this->db->resultSet();
		}


			public function collateral_img_list($loanId)
		{

			$this->db->query(
				"SELECT * FROM `ld_collateral_img` WHERE loan_id='$loanId'  AND loan_type='cash'"
			);
			return $this->db->resultSet();
		}



			public function latestLoan($userid)
		{

			$this->db->query(
				"SELECT `userid` as userID,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=userID)as name, `groupid` as groupID,(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=groupID) as groupName, `amount`, `date`, `time`, `approved_by` as adminID,(SELECT 	CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `notes`,`created_on`,`status` FROM  ld_cash_advances WHERE ld_cash_advances.`userid`='$userid' ORDER BY `ld_cash_advances`.`created_on` DESC LIMIT 1"
			);
			return $this->db->single();
		}

		public function loan_info($userid)
		{

			$this->db->query(
				"SELECT id, amount, date FROM `ld_cash_advances` WHERE userid='$userid' AND status='Approved' ORDER BY date DESC"
			);
			return $this->db->resultSet();
		}

		public function total_cashAdvance($userid)
		{

			$this->db->query(
				"SELECT SUM(amount)as balance FROM `ld_cash_advances` WHERE userid='$userid' AND (status='Approved' OR status='Paid')"
			);
			return $this->db->single();
		}


		public function total_cashPayment($userid)
		{

			$this->db->query(
				"SELECT SUM(principal_amount)as balance FROM `ld_cash_payments` WHERE payer_id='$userid' AND is_approved='1'"
			);
			return $this->db->single();
		}

		public function history($userid)
		{

			$this->db->query(
				"SELECT `userid` as userID,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=userID)as name, `groupid` as groupID,(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=groupID) as groupName, `amount`, `date`, `time`, `approved_by` as adminID,(SELECT 	CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by,id as loanID, (SELECT sum(principal_amount) FROM `ld_cash_payments` WHERE payer_id='$userid' AND loan_id=loanID) AS payment, `notes`,`created_on`,`status`
			,`collateral_img` FROM  ld_cash_advances WHERE ld_cash_advances.`userid`='$userid' ORDER BY `ld_cash_advances`.`amount` DESC"
			); 
			return $this->db->resultSet();
		}

		public function status_approve($LoanInfo)
		{
			extract($LoanInfo);
			$loan_amount=0;
			$branch_id=Session::get('user')['branch_id'];
		
			$this->db->query("SELECT balance as prev_balance,(SELECT amount FROM ld_cash_advances WHERE id='$loanId') as loan_amount,(ld_branch_vault.balance-(SELECT amount FROM ld_cash_advances WHERE id='$loanId'))as balance FROM `ld_branch_vault` WHERE branch_id='$branch_id'");

			$result=$this->db->single();
			$loan_amount=$result->loan_amount;

			if($result->balance<0)
			{	
				if(!empty($payer_id)){
					Flash::set("Insufficient Balance");
					redirect("/LDUser/preview/{$payer_id}");
				}
				else{

					Flash::set("Insufficient Balance");
					redirect("/LDUser/profile/");
				}

			}else
			{	
				$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `transaction_id`, `type`, `prev_balance`, `new_balance`, `approved_by`) VALUES ('$branch_id','$loanId','cash','$result->prev_balance','$result->balance','$userId')");
				$this->db->execute();
				$this->db->query("UPDATE ld_branch_vault SET `balance`='$result->balance' WHERE branch_id='$branch_id'");
				$this->db->execute();

				$this->db->query("UPDATE $this->table_name SET `approved_by`='$userId',`status`='Approved' WHERE id='$loanId'");

					if($this->db->execute()){
						if(!empty($payer_id)){
							Flash::set("Status Updated");
							redirect("/LDUser/preview/{$payer_id}");
						}else{

							Flash::set("Status Updated");
							redirect("/LDUser/profile/");
						}
					}else{
						Flash::set("Status not updated");
					}
			}		
		}

			public function status_disapprove($LoanInfo)
		{
			extract($LoanInfo);

			$this->db->query("UPDATE $this->table_name SET `approved_by`='$userId',`status`='Disapprove' WHERE id='$loanId'");

			if($this->db->execute()){
				Flash::set("Status Updated");
				redirect('/LDCashAdvance/list');
			}else{
				Flash::set("Status not updated");
			}
		}


		public function pay($cashAdvanceInfo)
		{
			extract($cashAdvanceInfo);

			$renderedImage = $this->renderPhoto($image);

			$newNote=filter_var($note, FILTER_SANITIZE_STRING);

			date_default_timezone_set("Asia/Manila");
			
			$today=date("Y-m-d H:i:s");

			$this->db->query(
				"INSERT INTO `ld_cash_payments`(`payer_id`, `amount`, `note`, `faceimage` , `created_on`) VALUES ('$userId','$cashAdvance','$newNote','$renderedImage' , '$today')");
			$this->db->execute();
			$this->db->query(
				"INSERT INTO `ld_product_payments`(`payer_id`, `amount`, `note`, `faceimage` , `created_on`) VALUES ('$userId','$productAdvance','$newNote','$renderedImage', '$today')");
			if($this->db->execute()){
				echo 1;
			}else{
				echo 0;
			}

			/*if($this->db->execute()){
				Flash::set("Payment sent");
				if($this->userType=="admin")
				{
					redirect("/LDCashAdvance/history/{$userId}");
				}else
				{
					redirect('/LDUser/Profile');
				}
			}else{
				Flash::set("Payment not Sent");
			
			}*/
		}



		private function renderPhoto($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/';
		  
		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];
		  
		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = uniqid() . '.png';
		  
		    $file = $folderPath . $fileName;
		    file_put_contents($file, $image_base64);

		    return $fileName;
		}



		public function payment_status_approve($id)
		{
			extract($id);
			$admin=Session::get('user')['id'];
			$this->db->query("UPDATE ld_cash_payments SET `is_approved`=1,`admin_id`='$admin' WHERE id='$paymentId'");

			if($this->db->execute()){
				Flash::set("Status Updated");
				redirect("/LDCashAdvance/payment_history/{$userId}");
			}else{
				Flash::set("Status not updated");
			}
		}

		public function payment_history($userid){
			// $this->db->query(
			// 	"SELECT `payer_id` as payer_id,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=payer_id)as name, `admin_id` as adminID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `note`,`created_on`,`is_approved`,`amount`,`id`,`faceimage` FROM  ld_cash_payments WHERE ld_cash_payments.`payer_id`='$userid' ORDER BY `ld_cash_payments`.`created_on` DESC"
			// );

			$this->db->query(
				"SELECT 
					payments.id , payer_id , loan_id , is_approved , 

					faceimage , principal_amount , interest_amount ,

					payments.created_on, advances.amount as loan_amount,

					concat(firstname , ' ' , lastname) as fullname

					FROM ld_cash_payments as payments

					left join ld_cash_advances as advances on payments.loan_id = advances.id
					left join ld_users as users on payments.payer_id = users.id 


					where payments.payer_id = '$userid' 
					order by payments.id desc"
			);
			return $this->db->resultSet();
		}


		public function upload_collateral($collateral_info)
		{
			
			extract($collateral_info);

			$renderedImage = $this->renderPhoto_collateral($image);
			$this->db->query("INSERT INTO `ld_collateral_img`( `image`, `loan_id`, `loan_type`) VALUES ('$renderedImage','$loanID','cash')");
			$this->db->execute();

		}


		private function renderPhoto_collateral($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/collateral/';
		  
		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];
		  
		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = uniqid() . '.png';
		  
		    $file = $folderPath . $fileName;
		    file_put_contents($file, $image_base64);

		    return $fileName;
		}

			
		


	}


?>