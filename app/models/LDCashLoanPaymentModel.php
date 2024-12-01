<?php 	

	class LDCashLoanPaymentModel extends Base_model
	{
		public function __construct()
		{
			$this->db = Database::getInstance();
		}


		public function get_total_today($branchId)
		{
			$today = date("Y-m-d H:i:s");
			
			$this->db->query(
				"SELECT ifnull(sum(amount),0) as total from ld_cash_payments 
				where is_approved = true and date(created_on) = date('$today')  and branch_id='$branchId'"
			);

			return $this->db->single()->total;
		}


		public function get_total_today_interest($branchId)
		{
			$today = date("Y-m-d H:i:s");
			
			$this->db->query(
				"SELECT ifnull(sum(interest_amount),0) as total from ld_cash_payments 
				where is_approved = true and date(created_on) = date('$today')  and branch_id='$branchId'"
			);

			return $this->db->single()->total;
		}

		public function make_payment($payerid , $paymentDetails , $note ,$image)
		{

			if(empty($paymentDetails->loanid)) {

				return true;
			}

			$image = $this->renderPhoto($image);

			$loanList = $paymentDetails->loanid;

			$interestList = $paymentDetails->interest;

			$principalList = $paymentDetails->principal;

			$totalList = $paymentDetails->total;

			$newNote =filter_var($note, FILTER_SANITIZE_STRING);
			$today = date("Y-m-d H:i:s");

			$query_maker = '';

			foreach($loanList as $key => $loan)
			{

				if($totalList[$key] == 0) {
					continue;
				}else{

					$loanid = $loan;
					$principal_amount = $principalList[$key];
					$interest_amount = $interestList[$key];

					$amount = $principal_amount + $interest_amount;

					$branch_id=Session::get('user')['branch_id'];
					$admin_id=Session::get('user')['id'];
					$this->db->query("SELECT balance as prev_balance,(SELECT amount FROM ld_cash_advances WHERE id='$loanid') as loan_amount,(ld_branch_vault.balance-(SELECT amount FROM ld_cash_advances WHERE id='$loanid'))as balance FROM `ld_branch_vault` WHERE branch_id='$branch_id'");
					$result=$this->db->single();

					$new_balance=$result->prev_balance+$amount;
					$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `transaction_id`, `type`, `prev_balance`, `new_balance`, `approved_by`) VALUES ('$branch_id','$loanid','cash','$result->prev_balance','$new_balance','$admin_id')");
					$this->db->execute();

					$this->db->query("UPDATE ld_branch_vault SET `balance`='$new_balance' WHERE branch_id='$branch_id'");
					$this->db->execute();


					$query_maker .= 
					"INSERT INTO ld_cash_payments(payer_id , loan_id ,created_on, principal_amount , interest_amount , faceimage, amount, note, branch_id, admin_id) 
					VALUES('$payerid' , '$loanid' , '$today','$principal_amount' , '$interest_amount' , '$image' , '$amount', '$newNote', (SELECT branch_id FROM `ld_users` WHERE id='$payerid'), '$admin_id')";
				}
				
			}

			try{

				$this->db->query($query_maker);

				$this->db->execute();

				return true;

			}catch(Exception $e)
			{
				die($e->getMessage());
			}
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
	}