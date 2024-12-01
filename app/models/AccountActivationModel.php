<?php 	

	class AccountActivationModel extends Base_model
	{

		public function update_account($userid , $activationCode)
		{
			$userModel = new User_model();

			$max_pair = $activationCode->max_pair;
			$level    = $activationCode->level;


			$this->db->query(
				"UPDATE users set max_pair = '$max_pair' , 
				status = '$level' 
				WHERE id = '$userid'"
			);


			$this->db->execute();

			$user = $userModel->get_user($userid);

			$user_session = [
				'id' => $user->id ,
				'type' => $user->user_type,
				'selfie' => $user->selfie,
				'firstname' => $user->firstname,
				'lastname'  => $user->lastname,
				'username'  => $user->username,
				'status'    => $activationCode->level,
				'is_activated' => $user->is_activated,
				'branchId'     => $user->branchId,
				'account_tag'   => $user->account_tag
			];

			Cookie::set('USERSESSION' , $user_session);

			Session::set('USERSESSION' , $user_session);

			return true;
		}

		// product paid auto acivation
		public function update_account_product_paid($userid , $activationCode)
		{
			$userModel = new User_model();

			$max_pair = $activationCode->max_pair;
			$level    = $activationCode->level;


			$this->db->query(
				"UPDATE users set max_pair = '$max_pair' , 
				status = '$level' 
				WHERE id = '$userid'"
			);

			$this->db->execute();

			return true;
		}
	}