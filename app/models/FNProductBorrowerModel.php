<?php
	class FNProductBorrowerModel extends Base_model
	{	

		public $table = 'fn_product_release';
		
		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

		public function get_date_today()
		{
			date_default_timezone_set("Asia/Manila");
			return date("Y-m-d");
		}

		public function update_loan_status($loan_id)
		{
			$this->db->query("UPDATE `fn_product_release` 
							  SET `status`='Paid' 
							  WHERE id = '$loan_id' ");
			$this->db->execute();
		}

		public function count_users_purchase($branchid)
		{
			$table_name = 'fn_product_release';

			$this->db->query(
				"SELECT userid, (SELECT COUNT(*) FROM {$table_name} as pr WHERE pr.userid =pr3.userid AND pr.status = 'PAID') as user_paid_item, (SELECT COUNT(*) FROM {$table_name} as pr2 WHERE pr2.userid =pr3.userid ) user_all_item, (SELECT username From users WHERE id =pr3.userid ) as username, (SELECT CONCAT(firstname,' ', lastname) From users WHERE id =pr3.userid ) as name FROM {$table_name} as pr3 WHERE branchId = $branchid GROUP BY pr3.userid"
            );

            return $this->db->resultSet();
		}
		public function check_users_pending_loan($userid)
		{
			$this->db->query(
				"SELECT COUNT(*) as loans FROM `fn_product_release` 
				 WHERE userid='$userid' AND status='Approved'"
            );
            return $this->db->single()->loans;
		}	
		public function get_user_loans($userid)
		{

			$this->db->query(
				"SELECT *,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = $userid) as fullname,
				 (SELECT name FROM `in_code_libraries` WHERE id= pr.code_id) as package,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment
				 FROM `fn_product_release` AS pr
				 WHERE userid = '$userid' ORDER BY date_time DESC"
            );


            return $this->db->resultSet();
		}

		public function get_user_unpaid_loans($userid)
		{

			$this->db->query(
				"SELECT *,
				 (SELECT name FROM `in_code_libraries` WHERE id= pr.code_id) as package,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment
				 FROM `fn_product_release` AS pr
				 WHERE userid = '$userid' AND pr.status='Approved' ORDER BY date_time DESC"
            );


            return $this->db->resultSet();
		}


		public function get_released_product_user($userId)
		{
			$this->set_time_zone();

			$this->db->query(
				"SELECT pr.*,
				 CONCAT(u.firstname,' ',u.lastname) as fullname,u.username,u.email,u.mobile,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment,
				 ifnull((SELECT link FROM user_social_media WHERE userid = u.id AND status='verified' AND type='Facebook' LIMIT 1),'no_link') as valid_link
				 FROM `fn_product_release` AS pr INNER JOIN users as u
				 WHERE u.id = '{$userId}' and pr.status = 'approved'"
            );


			$row = $this->db->single();

			if(!$row)
				return false;

			$amount = $row->amount ?? 0;
			$deliveryFee = $row->delivery_fee;
			$payment = $row->payment;
			
			$row->total_amount = ( $amount + $deliveryFee );
			$row->balance = ($amount + $deliveryFee) - $payment;

            return $row;
		}

		public function get_released_product_users($branchId, $status)
		{
			$this->set_time_zone();

			$this->db->query(
				"SELECT pr.*,
				 CONCAT(u.firstname,' ',u.lastname) as fullname,u.username,u.email,u.mobile,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment,
				 ifnull((SELECT link FROM user_social_media WHERE userid = u.id AND status='verified' AND type='Facebook' LIMIT 1),'no_link') as valid_link
				 FROM `fn_product_release` AS pr INNER JOIN users as u
				 WHERE u.id=pr.userid AND pr.branchId = '$branchId' and pr.status = '$status'

				 ORDER BY pr.id desc"
            );


			$results = $this->db->resultSet();

			if(!$results)
				return [];

			foreach($results as $key => $row)
			{
				$amount = $row->amount ?? 0;
				$deliveryFee = $row->delivery_fee;
				$payment = $row->payment;

				$row->total_amount = ( $amount + $deliveryFee );
				$row->balance = ($amount + $deliveryFee) - $payment;
			}

            return $results;
		}

		//makecollectors notes
		public function make_notes($note_info, $branchid)
		{
			extract($note_info);

			$this->db->query("
					INSERT INTO `fn_product_release_notes`( `loanid`, `note`, `noted_by`, `branch_id`) 
					VALUES ('$loanid', '$note', '$userid', '$branchid')");
			$this->db->execute();
		}

		public function get_collector_notes($branchId, $userid)
		{
			$this->set_time_zone();

			$this->db->query(
				"SELECT pr.*,note.note,
				 CONCAT(u.firstname,' ',u.lastname) as fullname,u.username,u.email,u.mobile,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment
				 FROM ((fn_product_release as pr INNER JOIN users as u ON pr.userid = u.id)
				 INNER JOIN fn_product_release_notes as note ON note.loanid = pr.id)
                 WHERE note.branch_id = '$branchId' AND note.noted_by='$userid' GROUP BY pr.userid"
            );

            return $this->db->resultSet();
		}


		public function get_user_all_notes( $loanid)
		{
			$this->set_time_zone();

			$this->db->query(
				"SELECT * 
				 FROM `fn_product_release_notes` 
				 WHERE loanid = '$loanid'"
            );

            return $this->db->resultSet();
		}

		public function get_released_rice($branchId, $status)
		{
			$this->set_time_zone();

			$this->db->query(
				"SELECT pr.*,
				 CONCAT(u.firstname,' ',u.lastname) as fullname,u.username,u.email,u.mobile,
				 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment,
				 ifnull((SELECT link FROM user_social_media WHERE userid = u.id AND status='verified' AND type='Facebook' LIMIT 1),'no_link') as valid_link
				 FROM `fn_product_release` AS pr INNER JOIN users as u
				 WHERE u.id=pr.userid AND pr.branchId = '$branchId' 
				 	   AND pr.status = '$status' AND product_name = 'Rice'

				 ORDER BY pr.id desc"
            );

            return $this->db->resultSet();
		}



		public function get_released_product_all($branchId, $days)
		{	
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query(
				"SELECT pr.id,pr.code,pr.userid,pr.amount,pr.status,pr.date_time,
				 CONCAT(u.firstname,' ',u.lastname) as fullname,u.username,u.email,u.mobile
				 FROM `fn_product_release` AS pr INNER JOIN users as u
				 WHERE u.id=pr.userid AND pr.branchId = '$branchId' 
				 AND DATEDIFF('$today', DATE(pr.date_time)) <= {$days}
				 AND pr.amount >= '1500'
				 ORDER BY pr.date_time "
            );



            return $this->db->resultSet();
		}

		public function group_by_amount_paid($branchId, $days)
		{	
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query(
				"SELECT amount,count(amount) as count
				 FROM `fn_product_release`
				 WHERE `branchId` = '$branchId' 
				 AND DATEDIFF('$today', DATE(date_time)) <= {$days}
				 AND status ='PAID'
				 AND amount >= '1500'
				 GROUP BY amount ORDER BY amount "
            );



            return $this->db->resultSet();
		}


		// for unpaid products
		public function group_by_amount($branchId, $days)
		{	
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query(
				"SELECT amount,count(amount) as count
				 FROM `fn_product_release`
				 WHERE `branchId` = '$branchId' 
				 AND DATEDIFF('$today', DATE(date_time)) <= {$days}
				 AND status ='Approved'
				 AND amount >= '1500'
				 GROUP BY amount ORDER BY amount "
            );



            return $this->db->resultSet();
		}


		public function get_product_borrower($branchId)
		{
	
			$this->db->query(
					   "SELECT users_uploaded_id.*,COUNT(users_uploaded_id.id) as total_valid_id,
						users.username as username,
						CONCAT(users.firstname,' ',users.lastname)as fullname,
						users.email as email,
						users.mobile as mobile,
						users.address as address,
						users_uploaded_id.id as uploaded_id_id,userid,
						users_uploaded_id.date_time as date_time
						FROM `users_uploaded_id` INNER JOIN `users`
						WHERE users.id = users_uploaded_id.userid AND
						users_uploaded_id.status = 'verified' AND
						users.branchId = '$branchId' group by userid ORDER BY users_uploaded_id.date_time DESC"
					);

	    	$data = $this->db->resultSet();
				
			$UserList = [];

			foreach ($data as $key => $value) 
			{

				//check if there is a product release
				$this->db->query(
				   "SELECT COUNT(*) as total FROM fn_product_release WHERE userid = {$value->userid}"
				);
    			$total_product_release = $this->db->single()->total;

    			if($total_product_release)
    				continue;
    			
				// check if there is as social media
				$this->db->query(
					   "SELECT (SELECT COUNT(*) FROM user_social_media WHERE userid = {$value->userid} AND status='verified') as total_valid_link , link as valid_link FROM user_social_media WHERE userid = {$value->userid} AND status='verified' AND type='Facebook'"
				);
	    		$social_link_info = $this->db->single();

	    		//check if there is a valid social link
	    		if(!isset($social_link_info->total_valid_link))
	    			continue;

	    		$reason = '';




	    		// get total direct sponsor
				$this->db->query(
					   "SELECT COUNT(*) as total FROM users WHERE direct_sponsor = {$value->userid}"
					);
	    		$total_direct_ref = $this->db->single()->total;

	    		if($total_direct_ref >= 2)
	    		{
	    			$reason = "  {$total_direct_ref} direct sponsors ";

	    			$userObject = (object) [
	    			 	'uploaded_id_id'=> $value->uploaded_id_id,
	    			 	'userid' => $value->userid,
	    				'username' => $value->username,
	    				'fullname' => $value->fullname,
	    				'email' =>$value->email,
	    				'mobile' =>$value->mobile,
	    				'address' =>$value->address,
						'total_valid_id' =>$value->total_valid_id,
						'date_time' =>$value->date_time,
						'valid_link' =>$social_link_info->valid_link,
						'total_valid_link' =>$social_link_info->total_valid_link,
						'reason' => $reason,
						'id_card' => $value->id_card,
						'id_card_back' => $value->id_card_back,
						'type' => $value->type
	    			];

	    			array_unshift($UserList, $userObject);
	    			

		    		continue;
	    		}


	    		$this->db->query(
				   "SELECT COUNT(*)  as total FROM users WHERE upline = {$value->userid}"
				);


    			$downlines = $this->db->single()->total;

	    		if($downlines >= 2)
	    		{
	    			$reason = "  {$downlines} downlines ";

	    			$UserList [] = (object) [
	    				'uploaded_id_id'=> $value->uploaded_id_id,
	    				'userid' => $value->userid,
	    				'username' => $value->username,
	    				'fullname' => $value->fullname,
	    				'email' =>$value->email,
	    				'mobile' =>$value->mobile,
	    				'address' =>$value->address,
						'total_valid_id' =>$value->total_valid_id,
						'date_time' =>$value->date_time,
						'valid_link' =>$social_link_info->valid_link,
						'total_valid_link' =>$social_link_info->total_valid_link,
						'reason' => $reason,
						'id_card' => $value->id_card,
						'id_card_back' => $value->id_card_back,
						'type' => $value->type

	    			];

		    		continue;
	    		}



	    		//check if has atlesat 1 upline or 1 direct


	    		if($total_direct_ref && $downlines)
	    		{
	    			$reason = "  {$total_direct_ref} direct sponsors and {$downlines} downlines ";

	    			$UserList [] = (object) [
	    				'uploaded_id_id'=> $value->uploaded_id_id,
	    				'userid' => $value->userid,
	    				'username' => $value->username,
	    				'fullname' => $value->fullname,
	    				'email' =>$value->email,
	    				'mobile' =>$value->mobile,
	    				'address' =>$value->address,
						'total_valid_id' =>$value->total_valid_id,
						'date_time' =>$value->date_time,
						'valid_link' =>$social_link_info->valid_link,
						'total_valid_link' =>$social_link_info->total_valid_link,
						'reason' => $reason,
						'id_card' => $value->id_card,
						'id_card_back' => $value->id_card_back,
						'type' => $value->type

	    			];

		    		continue;
	    		}
	    
			}

			return $UserList;

		}


		public function get_product_borrower_old($branchId)
		{
			$this->db->query(
                "SELECT *,(SELECT COUNT(*) FROM users WHERE direct_sponsor = users_uploaded_id.userid ) as total_direct_ref,
                 (SELECT COUNT(*) FROM users_uploaded_id WHERE userid = users.id AND status ='verified') as total_valid_id,
                 (SELECT COUNT(*) FROM user_social_media WHERE userid = users.id AND status='verified') as total_valid_link,
                 (SELECT link FROM user_social_media WHERE userid = users.id AND status='verified' AND type='Facebook' LIMIT 1) as valid_link,
                 users_uploaded_id.id as uploaded_id_id
                 FROM `users_uploaded_id` INNER JOIN `users`
                 WHERE users.id = users_uploaded_id.userid AND
                 (SELECT COUNT(*) FROM users WHERE direct_sponsor = users_uploaded_id.userid ) >= 2 AND
                 (SELECT COUNT(*) FROM fn_product_release WHERE userid = users_uploaded_id.userid ) < 1 AND
                 (SELECT COUNT(*) FROM user_social_media WHERE userid = users_uploaded_id.userid AND status='verified') >= 1 AND
                 (SELECT COUNT(*) FROM cancel_qualification_product WHERE userid = users_uploaded_id.userid) <= 0 AND
                 users_uploaded_id.status = 'verified' AND
                 users.branchId = '8' group by userid ORDER BY total_direct_ref DESC"
            );

            return $this->db->resultSet();
		}

		public function release_product($branchId, $userid, $Quantity, $stock_manager)
		{
			$this->db->query(
                "SELECT SUM(quantity) as stock FROM `fn_item_inventories` WHERE branchid = '$branchId'"
            );

            $stock=$this->db->single()->stock;

			if($stock >= $Quantity)
			{
				$packageAmount = 0;
				if($Quantity == 4)
				{
					$packageAmount = 2100.00;
				}else if($Quantity == 60)
				{
					$packageAmount = 16000.00;
				}else if($Quantity == 124)
				{
					$packageAmount = 46500.00;
				}else{
					$packageAmount = 2100.00;
				}

				$packageQuantity = $Quantity;
				$code = $this->make_code();

				$release_product = "INSERT INTO `fn_product_release`( `userid`, `code`, `amount`, `quantity`, `branchid`, `stock_manager`, `product_name`)
						VALUES ('$userid','$code','$packageAmount','$packageQuantity','$branchId', '$stock_manager', 'coffee')";

				$packageQuantity = ($packageQuantity * -1);
				$deduct_product = "INSERT INTO `fn_item_inventories`(`branchid`, `quantity`, `description`, `product_id`)
						VALUES ('$branchId','$packageQuantity','Product release, Product Loan Number $code', '1')";


				try{

					$this->db->query($release_product);
					$this->db->execute();

					$this->db->query($deduct_product);
					$this->db->execute();

					if($packageAmount != 2100 AND $Quantity != 10)
					{
						$this->db->query("UPDATE `users`
										SET `status` = 'approved_loan'
										WHERE `users`.`id` = '$userid';");
						$this->db->execute();
					}


					Flash::set("Product Advance Released");
					redirect('/FNProductBorrower/get_product_borrower');

					return true;

				}catch(Exception $e)
				{
					Flash::set("Error Please Try Again");
					redirect('/FNProductBorrower/get_product_borrower');
					return true;
				}

				
			}else
			{
				Flash::set("Insufficient Product Stock!!");
				redirect('/FNProductBorrower/get_product_borrower');
			}
		}

		public function search_user($userId)
		{
			$this->db->query(

                "SELECT id, CONCAT(firstname,' ',lastname)as fullname, email ,mobile,status,
				 (SELECT COUNT(*) FROM users WHERE direct_sponsor = '$userId' ) as total_direct_ref,
				 (SELECT COUNT(*) FROM users_uploaded_id WHERE userid ='$userId' and status ='verified') as valid_id,
				 (SELECT SUM(quantity) FROM fn_product_release WHERE userid = $userId) as product_release
				 FROM `users` WHERE id='$userId'"
            );

            return $this->db->single();

		}


		public function loanInfo($loan_id)
		{
			$this->db->query(
                "SELECT *, amount as total,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id =  pr.userid) as fullname,
                 (SELECT email FROM users WHERE id =  pr.userid) as email,
                 (SELECT name FROM `in_code_libraries` WHERE id= pr.code_id) as package,
                 (SELECT mobile FROM users WHERE id =  pr.userid) as mobile
				 FROM `fn_product_release` AS pr
				 WHERE id = '$loan_id' "
            );

            return $this->db->single();

		}

		

		public function make_payment($loanId, $amount, $branchid, $userId, $loanNumber, $filename, $cashier_id)
		{
			$this->db->query("INSERT INTO `fn_product_release_payment`(`userId`, `loanId`, `amount`, `branchId`, `image`, `cashier_id`)
							  VALUES ('$userId','$loanId','$amount','$branchid', '$filename',  $cashier_id)");

			if($this->db->execute())
			{
				/*
				*Moved to FNProductBorrower make_payment method
				*So we can log different description
				*/
				// $this->db->query("INSERT INTO `fn_cash_inventories`(`branchid`, `amount`, `description`)
				// 			  VALUES ('$branchid','$amount','Loan Payment for loan #$loanNumber')");
				// $this->db->execute();

			    $this->db->query(
	            "UPDATE `fn_product_release` SET `status`='Paid' WHERE (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = $loanId AND status='Approved') >= (SELECT amount FROM fn_product_release WHERE id = $loanId) AND id = $loanId"
	        	);
	       		$this->db->execute();

	       		$this->db->query(
	            "SELECT status, quantity
				 FROM `fn_product_release`
				 WHERE id = '$loanId'"
	       		 );

	       		 $status =  $this->db->single()->status;
	       		 $box_quantity =  $this->db->single()->quantity;

	       		 if($status == "Paid")
	       		 {
	       		 		$this->db->query(
		                "SELECT id, code
						 FROM `fn_code_inventories`
						 WHERE branchid=$branchid AND box_eq='$box_quantity' AND status='available'
						 LIMIT 1"
		           		 );



		           		 $activationCodeID =  $this->db->single()->id;
		           		 $activationCode =  $this->db->single()->code;

		           		 if(!empty($activationCodeID))
		           		 {
		           		 	$this->db->query("UPDATE `fn_code_inventories` SET `status`='released' WHERE id = '$activationCodeID'");
							$this->db->execute();
		           		 	$this->db->query("INSERT INTO `fn_off_code_inventories`( `codeid`, `userid`, `status`)
		           		 					  VALUES ('$activationCodeID', '$userId', 'released')");
							$this->db->execute();

							//Flash::set("Your Loan is now Paid Activation Code has been sent");
							return $activationCode;
		           		 }
			     }else{

			     	return 'ok';
			     }
			}


		}

		public function get_payment_list_pending($branchId)
		{
			$this->db->query(
                "SELECT *,(SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = prp.userId) as fullname,
                 (SELECT mobile FROM users WHERE id = prp.userId) as mobile,
				 (SELECT `code` FROM fn_product_release WHERE id = prp.loanId) as code
                 FROM `fn_product_release_payment`  as prp
                 WHERE status='Pending' AND branchId='$branchId'"
            );

            return $this->db->resultSet();
		}

		public function get_payment_list_approved($branchId)
		{
			$this->db->query(
                "SELECT *,(SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = prp.userId) as fullname,
                 (SELECT mobile FROM users WHERE id = prp.userId) as mobile,
				 (SELECT `code` FROM fn_product_release WHERE id = prp.loanId) as code
                 FROM `fn_product_release_payment`  as prp
                 WHERE status='Approved' AND branchId='$branchId'
                 ORDER BY `prp`.`date_time` DESC"
            );

            return $this->db->resultSet();
		}

		public function approve_payment($loanId, $payment_id, $amount, $branchid, $userId, $loanNumber)
		{
			/*$this->db->query(
            "UPDATE `fn_product_release_payment` SET `status`='Approved' WHERE id=$payment_id "
        	);
       		$this->db->execute();*/

			$this->db->query(
            "UPDATE `fn_product_release` SET `status`='Paid' WHERE (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = $loanId AND status='Approved') >= (SELECT amount FROM fn_product_release WHERE id = $loanId) AND id = $loanId"
        	);
       		$this->db->execute();

       		$this->db->query(
            "SELECT status
			 FROM `fn_product_release`
			 WHERE id = '$loanId'"
       		 );

       		 $status =  $this->db->single()->status;

       		 if($status == "Paid")
       		 {
       		 		$this->db->query(
	                "SELECT id, code
					 FROM `fn_code_inventories`
					 WHERE branchid=$branchid AND box_eq='4' AND status='available'
					 LIMIT 1"
	           		 );

	           		 $activationCodeID =  $this->db->single()->id;
	           		 $activationCode =  $this->db->single()->code;

	           		 if(!empty($activationCodeID))
	           		 {
	           		 	$this->db->query("UPDATE `fn_code_inventories` SET `status`='released' WHERE id = '$activationCodeID'");
						$this->db->execute();
	           		 	$this->db->query("INSERT INTO `fn_off_code_inventories`( `codeid`, `userid`, `status`)
	           		 					  VALUES ('$activationCodeID', '$userId', 'released')");
						$this->db->execute();

						//Flash::set("Your Loan is now Paid Activation Code has been sent");
						return $activationCode;
	           		 }
		     }else{

		     	return 'ok';
		     }

		}


		public function decline_payment($filename, $payment_id)
		{

            $image = PUBLIC_ROOT.DS.'assets/payment_image/'.$filename;

            $this->db->query(
            "UPDATE `fn_product_release_payment` SET `status`='Decline' WHERE id=$payment_id "
        	);

			if($this->db->execute()){
				unlink($image);
        		Flash::set("Payment Declined Successfully ");
        		return true;
        	}else
			{
				return false;
			}

		}


		//advance payment --------------------------------------------------------------------------------------------------------------
		public function make_advance_payment($amount, $Quantity, $branchid, $userId, $filename,
		$cashier_id, $category, $level, $delivery_fee, $product_name)
		{
			//check stock
			$this->db->query(
          "SELECT SUM(quantity) as stock FROM `fn_item_inventories` WHERE branchid = '$branchid'"
      );

      $stock=$this->db->single()->stock;

			//if available
			if($stock >= $Quantity)
			{
				$packageQuantity = $Quantity;

				$code = $this->make_code();

				$this->add_delivery_fee($delivery_fee,$branchid,$code);

				$release_product = "INSERT INTO `fn_product_release`( `userid`, `code`, `amount`, `quantity`, `branchid`, `category`,`product_name`)
						VALUES ('$userId','$code','$amount','$packageQuantity','$branchid' , 'advance-payment', '$product_name')";

				/*Moved to FNProductBorrower
				*method make_advance_payment
				*
				*/
				$packageQuantity = ($packageQuantity * -1);
				$deduct_product = "INSERT INTO `fn_item_inventories`(`branchid`, `quantity`, `description`)
						VALUES ('$branchid','$packageQuantity','Product release, Product Loan Number $code')";

				//make product advance and get loan ID
				$this->db->query($release_product);
				$loanId = $this->db->insert();

				//deduct items in stocks or inventory
				$this->db->query($deduct_product);
				$this->db->execute();


				$this->db->query("INSERT INTO `fn_product_release_payment`(`userId`, `loanId`, `amount`, `branchId`, `image`, `cashier_id`, `category`)
								  VALUES ('$userId','$loanId','$amount','$branchid', '$filename',  '$cashier_id',  'advance-payment')");

				if($this->db->execute())
				{
					$user = new User_model();
					$purchaser = $user->get_user($userId);

					/*Moved to FNProductBorrower
					*method make_advance_payment
					*/
					$description  = str_escape("Loan Payment for loan #{$code} , payment by <b>{$purchaser->fullname}</b>");

					$this->db->query("INSERT INTO `fn_cash_inventories`(`branchid`, `amount`, `description`)
								  VALUES ('$branchid','$amount','$description')");
					$this->db->execute();

						/**
						*WHAT THIS NIGGA DO?
						*/
				    $this->db->query(
		            "UPDATE `fn_product_release` SET `status`='Paid'
								WHERE (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = $loanId AND status='Approved') >=
								(SELECT amount FROM fn_product_release WHERE id = $loanId) AND id = $loanId"
		        	);
		       		$this->db->execute();

		       		$this->db->query(
		            "SELECT status, quantity
					 FROM `fn_product_release`
					 WHERE id = '$loanId'"
		       		 );

		       		 $status =  $this->db->single()->status;
		       		 $box_quantity =  $this->db->single()->quantity;

		       		 if($status == "Paid")
		       		 {
		       		 	if($category == "activation")
		       		 	{

		       		 		$this->db->query(
			                "SELECT id, code
							 FROM `fn_code_inventories`
							 WHERE branchid=$branchid AND box_eq='$box_quantity'
							 AND amount='$amount' AND status='available'
							 LIMIT 1"
			           		 );

			           		 $activationCodeID =  $this->db->single()->id;
			           		 $activationCode =  $this->db->single()->code;

			           		 if(!empty($activationCodeID))
			           		 {
			           		 	$this->db->query("UPDATE `fn_code_inventories` SET `status`='released' WHERE id = '$activationCodeID'");
								$this->db->execute();
			           		 	$this->db->query("INSERT INTO `fn_off_code_inventories`( `codeid`, `userid`, `status`)
			           		 					  VALUES ('$activationCodeID', '$userId', 'released')");
								$this->db->execute();

								//Flash::set("Your Loan is now Paid Activation Code has been sent");
								return $activationCode;
			           		 }

			           	}else{
								$prefix = $this->make_activation_level_prefix($level);
								$code = $this->make_activation_code($prefix);
								return $code;
			           	}
				     }else{

				     	return 'ok';
				     }
				}



			}else
			{
				Flash::set("Insufficient Product Stock!!");
				redirect('/FNProductBorrower/search_user_advance_payment');
			}


		}


		public function get_payment_history($userid)
		{
			$this->db->query(
				"SELECT * FROM `fn_product_release_payment` 
				 WHERE `userid` = '$userid' AND status = 'Approved'
				 ORDER BY `date_time` ASC"
			);

			return $this->db->resultSet();
		}


		//make advance payment ---------------------------------------------------------------------------------------- END

		//add delivery fee
		private function add_delivery_fee($amount, $branchid, $code)
		{
			$this->db->query("INSERT INTO `fn_cash_inventories`(`branchid`, `amount`, `description`)
						  VALUES ('$branchid','$amount','Delivery Fee for loan #$code')");
			$this->db->execute();
		}



		public function cancel_qualification_product($userid)
		{
			$this->db->query("INSERT INTO `cancel_qualification_product`(`userid`)
							  VALUES ('$userid')");
			return $this->db->execute();

		}



		private function make_activation_level_prefix($activationLevel)
		{
			return substr($activationLevel, 0 , 2);
		}

		private function make_activation_code($prefix)
		{
			$center = random_number(5);
			$suffix = random_number(2);

			//return random code;unique
			return strtoupper("{$prefix}-{$center}-{$suffix}");
		}



		public function make_code()
		{
			/*$prefix = random_number(2);
			$middle = random_number(4);
			$suffix = random_number(3);
			return "{$prefix}-{$middle}-{$suffix}";*/

		    $day = date("d");
			$month = date("m");
			$year = date("Y");
			$suffix = random_number(3);

		    return "P{$day}{$month}{$year}-{$suffix}";
		}

		/*public function update_product_release()
	    {
	       $this->db->query(
				"SELECT * FROM `fn_product_release` WHERE date_time LIKE '2020-10-05 01:12%' ORDER BY id"
            );

            $data = $this->db->resultSet();

            foreach ($data as $key => $value) 
            {
    	    		$this->db->query(
						"SELECT * FROM `fn_product_release_old` WHERE id = '$value->id'"
		            );

		            $old = $this->db->single();

		            if($old->date_time)
		            {
		            	 $this->db->query("UPDATE fn_product_release SET date_time='$old->date_time' WHERE id ='$value->id'");
			             $this->db->execute();
		            }
		           
            }	   

        }*/

	}
