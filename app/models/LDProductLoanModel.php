<?php 	

	class LDProductLoanModel extends Base_model
	{


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
		
		public function get_list_total_today()
		{
			$sql = "SELECT SUM(amount) as total from ld_product_advances where date(date) = date(now())";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		public function get_list_today()
		{	
			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			$sql = "SELECT concat(user.firstname , ' ' , user.lastname) as borrower_name , amount, status
			from ld_product_advances as prod_advances

			left join ld_users as user 

			on user.id = prod_advances.userid

			where date(date) = '$today'";

			$this->db->query($sql);


			return $this->db->resultSet();
		}

			public function payment_list_today()
		{
			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			$this->db->query(
				"SELECT`payer_id` as payer_id,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=payer_id)as name, (SELECT SUM(amount)as balance FROM `ld_product_advances` WHERE userid=payer_id AND status='Approved')as balance,  `admin_id` as adminID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `note`,`created_on`,`is_approved`,`amount`,`id`,`faceimage` FROM  ld_product_payments  WHERE date(`ld_product_payments`.`created_on`)='$today' ORDER BY `ld_product_payments`.`created_on` DESC
"
			);
			return $this->db->resultSet();
		}

			public function payment_list_today_cashier($cashier_id)
		{
			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			$this->db->query(
				"SELECT`payer_id` as payer_id,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=payer_id)as name, (SELECT SUM(amount)as balance FROM `ld_product_advances` WHERE userid=payer_id AND status='Approved')as balance,  `admin_id` as adminID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `note`,`created_on`,`is_approved`,`amount`,`id`,`faceimage` FROM  ld_product_payments 
					 WHERE date(`ld_product_payments`.`created_on`)='$today'  AND admin_id='$cashier_id' 
					 ORDER BY `ld_product_payments`.`created_on` DESC
"
			);
			return $this->db->resultSet();
		}
	}