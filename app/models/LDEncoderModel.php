<?php 	

	class LDEncoderModel extends Base_model
	{
		public function do_encode($userInformations)
		{
			extract($userInformations);
			
			$userID_encoder=Session::get('user')['id'];

			$this->db->query("SELECT stock as prev_stock,(SELECT package_quantity FROM `products` WHERE`id`='66' ) as loan_product_qty,(ld_branch_inventory.stock-(SELECT package_quantity FROM `products` WHERE`id`='66')) as new_stock FROM `ld_branch_inventory` WHERE branch_id='1' AND product_id='66'");
			
			$result=$this->db->single();
			$loan_product_qty=$result->loan_product_qty;

			if($result->new_stock<0)
			{
					Flash::set("Insufficient Stock");
					redirect("LDEncoder/register_account/");
			}else
			{	
				// decrease product stock on order
				$this->db->query("INSERT INTO `ld_branch_inventory_history`(`product_id`,`branch_id`, `prev_stock`, `new_stock`, `note`,`approved_by`) VALUES ('66','1','$result->prev_stock','$result->new_stock','social network order items','$userID_encoder')");
				$this->db->execute();
				$this->db->query("UPDATE ld_branch_inventory SET `stock`='$result->new_stock' WHERE branch_id='1' AND product_id='66'");
				$this->db->execute();


				// add balance on branch vault
				$this->db->query("SELECT balance as prev_balance FROM `ld_branch_vault` WHERE branch_id='1'");
				$result=$this->db->single();

				//product 66 price
				$product_price=1000;

				$new_balance=$result->prev_balance+$product_price;

				$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `type`, `prev_balance`, `new_balance`,`note`,`approved_by`) VALUES ('1','product','$result->prev_balance','$new_balance','social network order items','$userID_encoder')");
				$this->db->execute();

				$this->db->query("UPDATE ld_branch_vault SET `balance`='$new_balance' WHERE branch_id='1'");
				$this->db->execute();
			}	


			$data = [
				'firstname' => $firstname , 
				'lastname'  => $lastname,
				'middlename' => 'N/A',
				'email'  => uniqid().'@email.com',
				'password' => '1111',
				'phone' => '1111',
				'address' => 'autoaddress',
				'referral_id' => $direct_sponsor,
			];

			$create_user_dbbi_id= $this->create_user_dbbi($data);

			if($create_user_dbbi_id) {
				//create social network

				$username = "{$lastname}_".$this->get_dbbi_last_userid();
				$email    = "{$username}@dbbi.com";

				$data = [
					'dbbi_id'   => $create_user_dbbi_id,
					'firstname' => $firstname , 
					'lastname'  => $lastname,
					'username'  => $username , 
					'password'  => password_hash('1111', PASSWORD_DEFAULT),
					'email'     => $email ,
					'direct_sponsor' => $direct_sponsor,
					'upline'   => 0,
					'user_type' => '2'
 				];

				$create_user_social_id = $this->create_user_social($data);

				if($create_user_social_id) {

					$track_no = $this->orderReference();

					$data = [
						'user_id'  => $create_user_social_id,
						'o_status' => 'accepted' ,
						'track_no' => $track_no ,
						'payment_method' => 'ewallet' ,
						'address'   => 'Dbbi purchase'
					];

					$create_order_id = $this->create_order($data);

					if($create_order_id) 
					{
						$starterid = 1;

						$add_order_item = $this->create_order_item($create_order_id , $starterid);

						if($add_order_item) {

							return $create_order_id;
						}
					}

				}
			}

			return false;

		}



		private function get_dbbi_last_userid()
		{
			$this->db->query(
				"SELECT ifnull(max(id) , 0) as lastid from ld_users"
			);

			return $this->db->single()->lastid;
		}
		private function create_user_dbbi($props)
		{

			$keys = array_keys($props);

			$values = array_values($props);

			$this->db->query("
					INSERT INTO ld_users(".implode(' , ', $keys).") 
						VALUES('".implode("','", $values)."')");
			try{
				$insertid = $this->db->insert();

				return $insertid;
			}catch(Exception $e) {

				// Flash::set($e->getMessage() , 'danger');

				die($e->getMessage());

				return false;
			}
		}


		private function create_user_social($props)
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

				// Flash::set($e->getMessage() , 'danger');
				die($e->getMessage());
				return false;
			}
		}


		private function create_order($props)
		{
			$keys = array_keys($props);

			$values = array_values($props);

			$this->db->query("
					INSERT INTO orders(".implode(' , ', $keys).") 
						VALUES('".implode("','", $values)."')");
			try{
				$insertid = $this->db->insert();

				return $insertid;
			}catch(Exception $e) {

				// Flash::set($e->getMessage() , 'danger');
				die($e->getMessage());
				return false;
			}
		}

		private function create_order_item($orderid , $productid)
		{

			$this->db->query(
				"INSERT INTO order_items(order_id, product_id, price , unilvl_total , quantity ,
				total , binary_total , drc_total)

				SELECT '$orderid', id, price , unilvl_amount , 1 , 
				(price * 1) , binary_pb_amount , drc_amount 

				FROM products where id = '$productid'"
			);

			try{
				$this->db->execute();
				return true;
			}catch(Exception $e) {
				// Flash::set($e->getMessage() , 'danger');
				die($e->getMessage());
				return false;
			}
		}

		private function orderReference()
		{
			$prefix = substr(date('Ym'), 2);
			$between = date('d').random_number(3);
			$suffx = $this->referenceSuffix();

			return "{$prefix}-{$between}-{$suffx}";
		}
		
		private function referenceSuffix()
		{
			$this->db->query("SELECT max(id) as maxid from orders");

			$res = $this->db->single();

			$maxid = $res->maxid + 1;

				if(strlen($res->maxid) < 2)
					return "00{$maxid}";

				if(strlen($res->maxid) < 3)
					return "0{$maxid}";

				if(strlen($res->maxid) < 4)
					return "{$maxid}";
		}
	}