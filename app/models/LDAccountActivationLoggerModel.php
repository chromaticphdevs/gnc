<?php 	

	class LDAccountActivationLoggerModel extends Base_model
	{

		public function __construct()
		{
			$this->db = Database::getInstance();
		}
		public function make_account_activation_logger($purchaserid , $activation_code , $type , $origin)
		{		
		
			$this->db->query(
				"INSERT INTO ld_account_activations(purchaser , activation_code  , type , origin)
				VALUES('$purchaserid' , '$activation_code' , '$type' , '$origin')"
			);

			try
			{
				$this->db->execute();
				return true;
			}catch(Exception $e) 
			{
				die($e->getMessage());
				return false;
			}
		}


	}