<?php


	class LDActivationModel extends Base_model
	{


		public function __construct()
		{
			parent::__construct();

		}


		public function get_user_activation($userid)
		{
			$this->db->query("SELECT * FROM ld_activation_code where user_id = '{$userid}'");

			return $this->db->single();
		}

		public function username_verify($code)
		{
			extract($code);

			$this->db->query(
					"SELECT * FROM `users` WHERE username='$username'"
				);

			$result=$this->db->single();

			if(empty($result)){
				return true;
			}else{

				Flash::set("Username Already Used");
				redirect("/LDActivation/form_activation/?activation_code={$activation_code}");
		}


		}
		public function code_verify($code)
		{
			extract($code);

			$this->db->query(
					"SELECT activation_code
					FROM `ld_activation_code`
					WHERE activation_code ='$activation_code' AND status='Unused'"
				);

			$result=$this->db->single();

			if($result->activation_code==null){
				Flash::set("Invalid Activation Code ");
				redirect('/LDActivation/form_activation');
			}else{

				redirect("/LDActivation/form_activation/?activation_code={$result->activation_code}");
			}


		}


		public function get_activation($activation_code){

			$this->db->query(
					"SELECT * FROM `ld_activation_code` WHERE activation_code='$activation_code' AND status='Unused'"
				);

			return $this->db->single();
		}


		public function activation_level_branch($branch_id){

			$this->db->query(
					"SELECT ANY_VALUE(activation_level) as activation_level FROM `ld_activation_code` WHERE branch_id='$branch_id' and status='Unused' and status2='Unsold' GROUP BY activation_level"
				);

			return $this->db->resultSet();
		}


		public function activation_count_branch($branch_id){

			$this->db->query(
					"SELECT count(activation_code) as activation_count FROM `ld_activation_code` WHERE branch_id='$branch_id' and status='Unused' and status2='Unsold'"
			);
				return $this->db->single();
		}




		public function purchase_code_branch($branch_id, $activation_lvl , $userid)
		{


			$this->db->query(
					"SELECT * FROM `ld_activation_code` WHERE branch_id='$branch_id' and activation_level='$activation_lvl' and status='Unused' and status2='Unsold' LIMIT 1 "
				);

			$result = $this->db->single();
			$productID = $result->product_id;
			$productQTY = $result->package_quantity;
			$activation_code = $result->activation_code;
			$product_price = $result->price;

			//update and record stock branch inventory
			$this->db->query("SELECT stock as prev_stock FROM `ld_branch_inventory` WHERE branch_id='$branch_id' AND product_id='$productID'");

			$result=$this->db->single();

			if(!empty($result))
			{

				$this->db->query("INSERT INTO `ld_branch_inventory_history`(`product_id`,`branch_id`, `prev_stock`, `new_stock`, `note`,`approved_by`) VALUES ('$productID','$branch_id','$result->prev_stock',($result->prev_stock - $productQTY ),'generated activation code admin sold','$userid')");
				$this->db->execute();

				$this->db->query("UPDATE ld_branch_inventory SET `stock`=($result->prev_stock - $productQTY) WHERE branch_id='$branch_id' AND product_id='$productID'");
				$this->db->execute();

			}else
			{
					$this->db->query("INSERT INTO `ld_branch_inventory`(`product_id`,`admin_id`, `branch_id`, `stock`, `note`, `created_by`) VALUES ('$productID','0','$branch_id','0','generated activation code admin sold','0')");
					$this->db->execute();

					$this->db->query("INSERT INTO `ld_branch_inventory_history`(`product_id`,`branch_id`, `prev_stock`, `new_stock`, `note`) VALUES ('$productID','$branch_id','$productQTY','0','generated activation code admin sold')");
					$this->db->execute();


			}

			//update and record vault branch
			$this->db->query("SELECT balance as vault_balance FROM `ld_branch_vault` WHERE branch_id='$branch_id'");

			$result2=$this->db->single();
			if(!empty($result2))
			{

					$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `transaction_id`, `type`, `prev_balance`, `new_balance`, `approved_by`, `note`) VALUES ('$branch_id',null,'activation','$result2->vault_balance',($result2->vault_balance + $product_price ),'$userid','generated activation code admin sold')");
					$this->db->execute();
					$this->db->query("UPDATE ld_branch_vault SET `balance`=($result2->vault_balance + $product_price ) WHERE branch_id='$branch_id'");
					$this->db->execute();

			}else
			{
					$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `transaction_id`, `type`, `prev_balance`, `new_balance`, `approved_by`, `note`) VALUES ('$branch_id',null,'activation','0','$product_price','$userid','generated activation code admin sold')");
					$this->db->execute();
					$this->db->query("INSERT INTO `ld_branch_vault`(`branch_id`, `balance`, `admin_id`, `note`, `created_by`) VALUE ('$branch_id','$product_price','$userid','generated activation code admin sold',null)");
					$this->db->execute();

			}

			$this->add_expiration_date($activation_code);

			$this->db->query(
				"UPDATE ld_activation_code SET status2='sold' WHERE activation_code = '$activation_code'"
			);
			$this->db->execute();

			echo $activation_code;
		}


		public function register($customerInfo)
		{
				extract($customerInfo);

				 $this->db->query(
				 	"SELECT  `username` FROM `users` WHERE  `username`='$username'"
				);

				// //check duplicated email
				 $result=$this->db->resultSet();
				$address="";

				if($result == null )
				{

					if(strlen($cp_number)>=13){
							Flash::set('Phone Number is too long ');
							redirect('/LDUser/register');
							return false;
					}
					date_default_timezone_set("Asia/Manila");

					$groupId=date("N", strtotime(date("l")))-1;

					//$email    = filter_var(uniqid() , FILTER_SANITIZE_STRING);
					//$username = filter_var(uniqid() , FILTER_SANITIZE_STRING);

					/*$sql_ld_users = "INSERT INTO ld_users (`firstname`, `middlename`, `lastname`, `email`, `password`, `phone` ,`referral_id`, `user_type`,`address`,`branch_id`)
					VALUES ('$first_name',' ','$last_name','$username','123','$cp_number','$refer','customer','$address','$branch')";
					$this->db->query($sql_ld_users);*/

					$upline = $this->binaryModel->outDownline( $refer, $position);

					/*if($lastid = $this->db->insert())
					{*/

						//insert to social nigga
						$props  = [
								//'dbbi_id'        => $lastid,
								'firstname'      => $first_name ,
								'lastname'       => $last_name,
								'username'       => $username,
								'password'       => password_hash('123456', PASSWORD_DEFAULT),
								'direct_sponsor' => $refer,
								'upline'         => $upline,
								'L_R'            => $position,
								'new_upline'     => $refer,
								'user_type'      => '2',
								'email'          => $email,
								'address'        => $address,
								'mobile'         => $cp_number
						];


						$socianetwork_account_id = $this->insert_user_to_socialnetwork($props);

						return [
							$activation_code ,
							$socianetwork_account_id
						];

				}else{

						Flash::set('Username Already Used ');
						redirect("/LDActivation/form_activation/?activation_code={$activation_code}");
				}
		}


		private function insert_user_to_socialnetwork($props)
		{

			$keys = array_keys($props);

			$values = array_values($props);

			$this->db->query("
					INSERT INTO users(".implode(' , ', $keys).")
						VALUES('".implode("','", $values)."')");
			try{
				$insertid = $this->db->insert();
				return $insertid;
			}catch(Exception $e) {
				die($e->getMessage());
			}

		}

		/*to activate account and change its status to specifed level*/
		public function update_account($userid , $maxpair , $accountlevel)
		{
			$sql = "UPDATE users
				set max_pair = '$maxpair' ,
				status = '$accountlevel' ,
				is_activated = true
				where id = '$userid'";

			$this->db->query($sql);

			try{
				$this->db->execute();
				return true;
			}catch(Exception $e) {
				die($e->getMessage());
				return false;
			}
		}


		public function update_status($userid, $activation_code)
		{

				date_default_timezone_set('Asia/Manila');
				$date= date('Y-m-d') ;
				$time=date("H:i:s");

				$this->db->query(
					"UPDATE ld_activation_code SET user_id='$userid', activated_date='$date', activated_time='$time', status='Used' WHERE activation_code='$activation_code'"
				);
				$this->db->execute();

		}

		public function add_expiration_date($activation_code)
		{
				//get date today
				date_default_timezone_set('Asia/Manila');
				$date = date('Y-m-d') ;

				//add 2 days at date today
				$date = date_create($date);
				date_add($date,date_interval_create_from_date_string("2 days"));
				$date = date_format($date,"Y-m-d");

				$this->db->query(
					"UPDATE `ld_activation_code` SET `expiration_date`='$date' WHERE activation_code = '$activation_code' "
				);
				$this->db->execute();

		}

		public function update_expiration_status()
		{

				date_default_timezone_set('Asia/Manila');
				$date = date('Y-m-d') ;

				$this->db->query(
					"UPDATE `ld_activation_code` SET `status`='Expired' WHERE expiration_date <= '$date' and status2='Sold'"
				);
				$this->db->execute();

		}

		public function activation_code_history()
		{

			$this->db->query(
				"SELECT activation_code, branch_id,user_id as userID, (SELECT concat(firstname , ' ' , lastname) FROM users WHERE id=userID) as fullname, expiration_date, status, status2, activated_date, activated_time FROM `ld_activation_code`
				ORDER BY `ld_activation_code`.`created_on` DESC"
			);

			return $this->db->resultSet();
		}

	}


?>
