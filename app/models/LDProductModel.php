<?php 	


	class LDProductModel extends Base_model
	{

		private $table_name = 'ld_product_advances';


		public function __construct()
		{
			parent::__construct();
		
			
		
		}
		
		public function create_activation_code($productID)
		{
			extract($productID);
			$product_quantity=0;
			for($i=1; $i<=$numbers_of_code; $i++)
			{

				$code1=random_number();
				$code2=random_number();
				$code3=random_number();
				$activation_code=substr($code1,0,3).'-'.substr($code2,0,3).'-'.substr($code3,0,1);

				$this->db->query(
						"SELECT * FROM `products` WHERE id='$productID'"
					);
				
				$product_info = $this->db->single();


				$activation_level  = $this->get_activation_level($product_info->binary_pb_amount);

				$activation_code=strtoupper($activation_level[0].''.$activation_level[1]).'-'.$activation_code;

				$this->db->query("INSERT INTO `ld_activation_code`( `activation_code`, `product_id`,`activation_level`,`package_quantity`, `price`, `drc_amount`, `unilvl_amount`, `binary_pb_amount`, `com_distribution`, `max_pair`, `status`, `branch_id`, `status2`, `company`) 
					VALUES ('$activation_code','$productID', '$activation_level', '$product_info->package_quantity','$product_info->price','$product_info->drc_amount','$product_info->unilvl_amount','$product_info->binary_pb_amount','$product_info->com_distribution','$product_info->max_pair','Unused','$branch','Unsold','$company')");
		
				$this->db->execute();
				
				$product_quantity = $product_quantity + $product_info->package_quantity;
				if($i==$numbers_of_code){
				
					$this->db->query(
							"SELECT * FROM `ld_branch_inventory` WHERE branch_id='$branch' AND product_id='$productID'"
					);
					
					$branch_inventory_info = $this->db->single();

					if(!empty($branch_inventory_info))
					{		
							$this->db->query("SELECT stock as prev_stock FROM `ld_branch_inventory` WHERE branch_id='$branch' AND product_id='$productID'");
			
							$result=$this->db->single();

							$this->db->query("INSERT INTO `ld_branch_inventory_history`(`product_id`,`branch_id`, `prev_stock`, `new_stock`, `note`) VALUES ('$productID','$branch','$result->prev_stock',($result->prev_stock + $product_quantity),'generated activation code')");
							$this->db->execute();

							$this->db->query("UPDATE ld_branch_inventory SET `stock`=($result->prev_stock + $product_quantity) WHERE branch_id='$branch' AND product_id='$productID'");
							$this->db->execute();
					}else
					{		
							$this->db->query("INSERT INTO `ld_branch_inventory`(`product_id`,`admin_id`, `branch_id`, `stock`, `note`, `created_by`) VALUES ('$productID','0','$branch','$product_quantity','generated activation code','0')");
							$this->db->execute();	

							$this->db->query("INSERT INTO `ld_branch_inventory_history`(`product_id`,`branch_id`, `prev_stock`, `new_stock`, `note`) VALUES ('$productID','$branch','0','$product_quantity','generated activation code')");
							$this->db->execute();		
					}
				

					Flash::set("Activation Code created");
					redirect('/LDProductAdvance/create_activation_code');
				}

			}

			
		}


		private function get_activation_level($binary_points)
		{

			if($binary_points >= 16600) {
				return 'diamond';
			}

			if($binary_points >= 8000) {
				return 'platinum';
			}

			if($binary_points >= 3100) {
				return 'gold';
			}

			if($binary_points >= 1500) {
				return 'silver';
			}

			if($binary_points >= 700) {
				return 'bronze';		
			}

			if($binary_points >= 100) {
				return 'starter';
			}
		}

		###

		public function activation_code_list_unused()
		{

			$this->db->query(
				"SELECT * FROM `ld_activation_code` WHERE status='Unused' ORDER BY `ld_activation_code`.`created_on` DESC"
			);

			return $this->db->resultSet();
		}

		public function activation_code_list_used()
		{

			$this->db->query(
				"SELECT * FROM `ld_activation_code` WHERE status='Used' ORDER BY `ld_activation_code`.`created_on` DESC"
			);

			return $this->db->resultSet();
		}


		public function create($productAdvanceInfo)
		{
			extract($productAdvanceInfo);

			$newNote=filter_var($note, FILTER_SANITIZE_STRING);
			
			date_default_timezone_set('Asia/Manila');
			$date= date('Y-m-d') ;
			$time=date("H:i");
			if($productID!="two_products")
			{
				$this->db->query(
					"SELECT price FROM `products` WHERE id=$productID"
				);
			
				$price=$this->db->single();

				$this->db->query(
				"INSERT INTO $this->table_name( `date`, `time`,`userid`, `groupid`, `productid`,`amount`, `notes`) VALUES ('$date','$time','$userid',(SELECT groupid From ld_groups_attendees WHERE userid=$userid),'$productID','$price->price','$newNote' )");	
			}else{


				$this->db->query(
				"INSERT INTO $this->table_name( `date`, `time`,`userid`, `groupid`, `productid`,`amount`, `notes`) VALUES 
				('$date','$time','$userid',(SELECT groupid From ld_groups_attendees WHERE userid=$userid),'33','1600','$newNote' ),('$date','$time','$userid',(SELECT groupid From ld_groups_attendees WHERE userid=$userid),'66','1000','$newNote' )");


			}
		
			$userType = Session::get('user')['type'];
			if($this->db->execute()){
				Flash::set("Lenders group created");
				if($this->userType=="admin")
				{
					redirect('/LDProductAdvance/list');
				}else
				{
					redirect('/LDUser/Profile');
				}
			}else{
				Flash::set("Lenders not created");
			}
		}


		public function call_create($productAdvanceInfo)
		{
			extract($productAdvanceInfo);
			
			$newNote=filter_var($note, FILTER_SANITIZE_STRING);
			date_default_timezone_set("Asia/Manila");
			$date=date("Y-m-d");
			$time=date("H:i:s");
			$this->db->query(
				"INSERT INTO $this->table_name( `date`, `time`,`userid`, `groupid`, `productid`,`amount`, `notes`, `branch_id`)
				VALUES('$date' , '$time' , '$userid' , 
				(SELECT groupid From ld_groups_attendees WHERE userid=$userid) ,
				'$productid' , '$amount' , '$newNote', '$branch_id')"
			);

			try{
				$this->db->execute();

				return true;
			}catch(Exception $e)
			{
				Session::get('Fatal:'.$e->getMessage());
				return false;
			}

		}


		public function productList()
		{

			$this->db->query(
				"SELECT id, name,price FROM `products`"
			);

			return $this->db->resultSet();
		}

		public function list()
		{

			$this->db->query(
	  		"SELECT `userid` as userID,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=userID)as name, `groupid` as groupID,(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=groupID) as groupName, `productid` as productID,(SELECT name FROM `products` WHERE products.id=productID) as productName, `date`, `time`, `approved_by` as adminID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `notes`,`status`,`id`,`amount`,`collateral_img` FROM $this->table_name WHERE `status`='pending' ORDER BY `ld_product_advances`.`created_on` DESC  LIMIT 120"
			);

			return $this->db->resultSet();
		}

			public function latestLoan($userid)
		{

			$this->db->query(
				"SELECT `userid` as userID,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=userID)as name, `groupid` as groupID,(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=groupID) as groupName,(SELECT name FROM `products` WHERE products.id=productID) as productName, `date`, `time`, `approved_by` as adminID,(SELECT 	CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `notes`,`created_on`,`status`,`amount` FROM  ld_product_advances WHERE ld_product_advances.`userid`='$userid' ORDER BY `ld_product_advances`.`created_on` DESC LIMIT 1"
			);
			return $this->db->single();
		}

		public function history($userid)
		{

			$this->db->query(
				"SELECT `userid` as userID,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=userID)as name, `groupid` as groupID,(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=groupID) as groupName, `productid` as productID,(SELECT name FROM `products` WHERE products.id=productID) as productName, `date`, `time`, `approved_by` as adminID,(SELECT 	CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by,id as loanID,(SELECT sum(amount) FROM `ld_product_payments` WHERE payer_id='$userid' and loan_id=loanID) payment, `notes`,`created_on`,`status`,`amount`,`collateral_img` FROM  ld_product_advances WHERE ld_product_advances.`userid`='$userid' ORDER BY `ld_product_advances`.`created_on` DESC"
			);
			return $this->db->resultSet();
		}

		public function loan_info($userid)
		{

			$this->db->query(
				"SELECT id,amount,`productid` as productID,(SELECT name FROM `products` WHERE products.id=productID) as productName, date FROM `ld_product_advances` WHERE userid='$userid' AND status='Approved' ORDER BY date DESC"
			);
			return $this->db->resultSet();
		}

		public function total_product_Advance($userid)
		{

			$this->db->query(
				"SELECT SUM(amount)as balance FROM `ld_product_advances` WHERE userid='$userid' AND (status='Approved' OR status='Paid')"
			);
			return $this->db->single();
		}


		public function total_productPayment($userid)
		{

			$this->db->query(
				"SELECT SUM(amount)as balance FROM `ld_product_payments` WHERE payer_id='$userid' AND is_approved='1'"
			);
			return $this->db->single();
		}


		public function status_approve($LoanInfo)
		{
			extract($LoanInfo);
			$loan_product_qty=0;
			$branch_id=Session::get('user')['branch_id'];
			$userType=Session::get('user')['type'];
			$this->db->query("SELECT stock as prev_stock,(SELECT package_quantity FROM `products` WHERE`id`='$productID' ) as loan_product_qty,(ld_branch_inventory.stock-(SELECT package_quantity FROM `products` WHERE`id`='$productID')) as new_stock FROM `ld_branch_inventory` WHERE branch_id='$branch_id' AND product_id='$productID'");
			
			$result=$this->db->single();
			$loan_product_qty=$result->loan_product_qty;

			if($result->new_stock<0)
			{
				if(!empty($payer_id)){
					Flash::set("Insufficient Stock");
					redirect("/LDUser/preview/{$payer_id}");
				}
				else{

					Flash::set("Insufficient Stock");
					redirect("/LDUser/profile/");
				}

			}else
			{	
				$this->db->query("INSERT INTO `ld_branch_inventory_history`(`product_id`,`branch_id`, `transaction_id`, `prev_stock`, `new_stock`, `approved_by`) VALUES ('$productID','$branch_id','$loanId','$result->prev_stock','$result->new_stock','$userId')");
				$this->db->execute();
				$this->db->query("UPDATE ld_branch_inventory SET `stock`='$result->new_stock' WHERE branch_id='$branch_id' AND product_id='$productID'");
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
				redirect('/LDProductAdvance/list');
			}else{
				Flash::set("Status not updated");
			}
		}


		public function pay($productAdvanceInfo)
		{
			extract($productAdvanceInfo);
			$newNote=filter_var($note, FILTER_SANITIZE_STRING);
			$this->db->query(
				"INSERT INTO `ld_product_payments`(`payer_id`, `amount`, `note`) VALUES ('$userId','$amount','$newNote')");
			if($this->db->execute()){
				Flash::set("Payment sent");
				$userType = Session::get('user')['type'];
				if($this->userType=="admin")
				{
					redirect("/LDProductAdvance/history/{$userId}");
				}else
				{
					redirect('/LDUser/Profile');
				}
			}else{
				Flash::set("Payment not sent");
			}
		}


			public function payment_status_approve($id)
		{
			extract($id);
			$admin=Session::get('user')['id'];
			$this->db->query("UPDATE ld_product_payments SET `is_approved`=1,`admin_id`='$admin' WHERE id='$paymentId'");

			if($this->db->execute()){
				Flash::set("Status Updated");
				redirect("/LDProductAdvance/payment_history/{$userId}");
			}else{
				Flash::set("Status not updated");
			}
		}

		public function payment_history($userid){

			$this->db->query(
				"SELECT `payer_id` as payer_id,(Select CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM ld_users WHERE id=payer_id)as name, `admin_id` as adminID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname)  as name FROM `ld_users` WHERE ld_users.id=adminID) as approved_by, `note`,`created_on`,`is_approved`,`amount`,`id`,`faceimage` FROM  ld_product_payments WHERE ld_product_payments.`payer_id`='$userid' ORDER BY `ld_product_payments`.`created_on` DESC"
			);
			return $this->db->resultSet();
		}

		public function upload_collateral($collateral_info)
		{
			
			extract($collateral_info);

			$renderedImage = $this->renderPhoto($image);
			$this->db->query("INSERT INTO `ld_collateral_img`( `image`, `loan_id`, `loan_type`) VALUES ('$renderedImage','$loanID','product')");
			$this->db->execute();

		}


			public function collateral_img_list($loanId)
		{

			$this->db->query(
				"SELECT * FROM `ld_collateral_img` WHERE loan_id='$loanId' AND loan_type='product'"
			);

			return $this->db->resultSet();
		}



		private function renderPhoto($image)
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