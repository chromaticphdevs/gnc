<?php 	

	class UserActivationModel extends Base_model
	{
		/*minimum value to activate account*/
		private $activationMinimum = 100;

		private $tableName = 'activated_users';

		public function isActivated()
		{
			$userid = $this->userid;

			$sql = "SELECT * FROM $this->tableName where userid = '$userid'";

			$this->db->query($sql);

			return $this->db->single();
		}

		public function setPurchaseModel($purchaseModel)
		{
			$this->purchaseModel = $purchaseModel;
		}

		public function setUserId($userid)
		{
			$this->userid = $userid;
		}

		public function activateUser()
		{
			$userid = $this->userid;

			$this->purchaseModel->setUserId($this->userid);

			//now get its total

			$orderTotal = $this->purchaseModel->getOrderTotal();

			//check if order total not empty

			if(!empty($orderTotal))
			{
				$orderTotal = $orderTotal->binary_total;

				if($this->activateForDiamond($orderTotal)){
					$this->updateUserActivation($userid , 'diamond');
				}
				if($this->activateForPlatinum($orderTotal)){
					$this->updateUserActivation($userid , 'platinum');
				}

				if($this->activateForGold($orderTotal)){
					$this->updateUserActivation($userid , 'gold');
				}

				if($this->activateForSilver($orderTotal)){
					$this->updateUserActivation($userid , 'silver');
				}

				if($this->activateForBronze($orderTotal)){
					$this->updateUserActivation($userid , 'bronze');
				}
				if($this->activateForStarter($orderTotal)){
					$this->updateUserActivation($userid , 'starter');
				}
			}

			return true;
		}

		private function activateForStarter($testAmount)
		{
			if($testAmount >= 100)
				return true;
			return false;
		}

		private function activateForBronze($testAmount)
		{
			if($testAmount >= 700)
				return true;
			return false;
		}

		private function activateForSilver($testAmount)
		{
			if($testAmount >= 1500)
				return true;
			return false;
		}

		private function activateForGold($testAmount)
		{
			if($testAmount >= 3100)
				return true;
			return false;
		}

		private function activateForPlatinum($testAmount)
		{
			if($testAmount >= 8000)
				return true;
			return false;
		}	

		private function activateForDiamond($testAmount)
		{
			if($testAmount >= 16600)
				return true;
			return false;
		}

		private function updateUserActivation($userid , $status)
		{

			$errors = false;

			$this->db->instance()->beginTransaction();

			try
			{
				$this->db->query("UPDATE users set status = '$status' 
						where id = '$userid'");

				if(!$this->db->execute()){
					$errors = true;

					throw new Exception("Error on user update", 1);
				}

				$this->db->query("INSERT INTO $this->tableName(userid , status)
					VALUES('$userid' , '$status')");

				if(!$this->db->execute())
				{
					$errors = true;
					throw new Exception("Error Inserting New record", 1);
				}

				$this->db->instance()->commit();

				return true;
			}catch(Exception $e)
			{
				$this->db->instance()->rollBack();
				die($e->getMessage());
			}
		}
	}