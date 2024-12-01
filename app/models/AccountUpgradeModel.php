<?php 	

	class AccountUpgradeModel extends Base_model
	{
		public function upgrade_by_code($user, $code)
		{
			if($user->max_pair <= $code->max_pair) 
			{
				$max_pair = $code->max_pair;
				$level    = $this->product_level($code->binary_pb_amount);

				try{

					//check if uuser is activated

					if($user->is_activated)
					{
						$this->db->query(
							"UPDATE users set max_pair = '$max_pair' , status = '$level'
								WHERE id = '$user->id'"
						);

						$this->db->execute();

					}else{
						$this->db->query(
							"UPDATE users set max_pair = '$max_pair' , status = '$level' ,
							activated_by = 'code'
							
							WHERE id = '$user->id'"
						);

						$this->db->execute();
					}
					

					$user_session = [
						'id' => $user->id ,
						'type' => $user->user_type,
						'selfie' => $user->selfie,
						'firstname' => $user->firstname,
						'lastname'  => $user->lastname,
						'username'  => $user->username,
						'status'    => $level,
						'is_activated'    => $user->is_activated
					];

					Cookie::set('USERSESSION' , $user_session);

					Session::set('USERSESSION' , $user_session);

					return true;

				}catch(Exception $e) 
				{
					die($e->getMessage());
				}
			}
		}

		public function upgrade_by_product($user , $product)
		{
			if($user->max_pair <= $product->max_pair) 
			{
				$max_pair = $product->max_pair;
				$level    = $this->product_level($product->binary_pb_amount);

				try{

					$this->db->query(
						"UPDATE users set max_pair = '$max_pair' , status = '$level' 
							WHERE id = '$user->id'"
					);

					$this->db->execute();
					
					return true;

				}catch(Exception $e) 
				{
					die($e->getMessage());
				}
			}
		}

		private function product_level($binary_amount)
		{

			if($binary_amount >= 16600) 
			{
				return 'diamond';
			}

			if($binary_amount >= 8000) 
			{
				return 'platinum';
			}

			if($binary_amount >= 3100) 
			{
				return 'gold';
			}

			if($binary_amount >= 1500) 
			{
				return 'silver';
			}

			if($binary_amount >= 700) 
			{
				return 'bronze';
			}

			if($binary_amount >= 100) {
				return 'starter';
			}
		}

	}