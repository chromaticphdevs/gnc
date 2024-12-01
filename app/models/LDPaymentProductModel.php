<?php 	

	class LDPaymentProductModel extends Base_model
	{

		private $table_view = 'ld_product_payments_view';
		/*
		*Model View
		*
		*/

		public function __construct()
		{
			$this->db = Database::getInstance();
		}
		/*no dot call on methods this is a sql command*/
		private function init_view()
		{

			$sql = "
				create view ld_product_payments_view as SELECT pay.id as paymentid , pay.payer_id , 
				concat(userpayer.firstname ,  ' ' , userpayer.lastname) as payer_name ,
				concat(adminpayer.firstname , ' ' , adminpayer.lastname) as admin_name,
				amount , 
				case 
					when is_approved = false then  'pending'
					else 'approved' end as approved_status,  
				is_approved , pay.created_on , note , location

				from ld_product_payments as pay 

				left join ld_users as userpayer 
				on pay.payer_id = userpayer.id

				left join ld_users as adminpayer
				on pay.admin_id = adminpayer.id ";
		}


		public function get_total_today($branchId)
		{
			$today = date("Y-m-d H:i:s");

			$this->db->query(
				"SELECT ifnull(sum(amount),0) as total from ld_product_payments 
				where is_approved = true and date(created_on) = date('$today') and branch_id='$branchId'"
			);

			return $this->db->single()->total;
		}

		public function make_payment($payerid , $paymentDetails , $note , $image)
		{

			if(empty($paymentDetails->loanid)) {

				return true;
			}

			$image = $this->renderPhoto($image);

			$loanList   = $paymentDetails->loanid;

			$amountList = $paymentDetails->total;

			$newNote =filter_var($note, FILTER_SANITIZE_STRING);
			$today = date("Y-m-d H:i:s");

			$query_maker  = '';

			foreach($loanList as $key => $loanid)  
			{	

				$branch_id = Session::get('user')['branch_id'];
				$admin_id  = Session::get('user')['id'];

				$this->db->query("SELECT balance as prev_balance,(SELECT amount FROM ld_product_advances WHERE id='$loanid') as loan_amount,(ld_branch_vault.balance-(SELECT amount FROM ld_product_advances WHERE id='$loanid'))as balance FROM `ld_branch_vault` WHERE branch_id='$branch_id'");

				$result = $this->db->single();


				if($result) {
					$new_balance = $result->prev_balance+$amountList[$key];

					$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `transaction_id`, `type`, `prev_balance`, `new_balance`, `approved_by`) VALUES ('$branch_id','$loanid','product','$result->prev_balance','$new_balance','$admin_id')");

					$this->db->execute();
				}
				

				$this->db->query("UPDATE ld_branch_vault SET `balance`='$new_balance' WHERE branch_id='$branch_id'");
				$this->db->execute();


				$query_maker .= "
					INSERT INTO ld_product_payments(payer_id , loan_id , created_on , 
					amount , is_approved , note , faceimage, branch_id, admin_id)
					VALUES('$payerid' , '{$loanList[$key]}' , '$today','{$amountList[$key]}' , 
					true , '$newNote' , '$image', (SELECT branch_id FROM `ld_users` WHERE id='$payerid'), '$admin_id')
				";
			}


			try{

				$this->db->query($query_maker);

				$this->db->execute();

				/*UPDATE YUNG MGA BINAYARAN KUNG PAID NA OH HINDI*/
				$updatePurchases = $this->get_by_user($payerid);

				$paidloan = $this->get_fully_paid($payerid);


				if($paidloan) 
				{
					$product = $this->productModel->getProduct($paidloan->productid);

					$commissions = array(
						'unilevelAmount'   => $product->unilvl_amount,
						'drcAmount'        => $product->drc_amount , 
						'binaryPoints'     => $product->binary_pb_amount
					);

					$purchaser = $loan->user_id;
					$orderid   = '1';
					$distribution = $product->distribution;

					$origin = 'dbbi';
					
					$distributeCommission = $this->commissionTriggerModel->submit_commissions($purchaser , $commissions , $orderid , $distribution , $origin);

					return true;
				}else{

				}
				

			}catch(Exception $e) {
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


		public function get_recent($payerid)
		{	
			$params =  " where payer_id = '$payerid' order by paymentid desc limit 1";

			return $this->get_single($params);
		}


		public function get_payment($id)
		{
			$params =  " WHERE pay.id = '$id' ";

			return $this->get_single($params);
		}

		public function get_history($payerid)
		{
			$params = " WHERE payer_id = '$payerid'";

			return $this->get_list($params);
		}
		public function get_list($params = null)
		{
			$this->db->query(
				"SELECT * FROM $this->table_view $params"
			);

			return $this->db->resultSet();
		}

		public function get_single($params)
		{
			$this->db->query("SELECT * FROM $this->table_view $params");

			return $this->db->single();
		}

		private function get_fully_paid($userid)
		{

			$this->db->query(
				"SELECT * FROM ld_product_advances where status ='Paid' and userid = '$userid' order by id desc limit 1"
			);

			return $this->db->single();
		}

		public function get_by_user($userid)
		{	
			$this->db->query(
				"SELECT * FROM ld_product_advances where userid = '$userid' 
				and status = 'Approved'"
			);

			$res = $this->db->resultSet();


			$resultSet = [];

			if(!empty($res))
			{
				foreach($res as $key => $row) {

					$productlonObj = new LDProductLoanObj();

					$productlonObj->id = $row->id;
					$productlonObj->userid = $row->userid;
					$productlonObj->amount = $row->amount;
					$productlonObj->date = $row->date;
					$productlonObj->created_on = $row->created_on;

					$this->db->query(
						"SELECT ifnull(sum(amount) , 0) as total from ld_product_payments where loan_id = '{$row->id}'"
					);

					$productlonObj->total_payment = $this->db->single()->total;

					$balance = $row->amount - $productlonObj->total_payment;
					if($balance <= 0 )
					{

						$this->db->query(
							"UPDATE `ld_product_advances` SET `status`='Paid' WHERE id='{$row->id}'"
						);
							$this->db->execute();

					}
					$resultSet[] = $productlonObj;
				}
			}
			return $resultSet;
		}
	}