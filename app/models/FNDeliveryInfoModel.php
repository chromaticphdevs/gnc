<?php 	

	class FNDeliveryInfoModel extends Base_model
	{

		public $table = 'fn_delivery_info';
		
		public function getByControlNumber($controlNumber)
		{

			$userModel = model('User_model');
			$releaseModel = model('FNProductReleaseModel');


			$controlNumber = trim($controlNumber);
			
			$this->db->query(
				"SELECT * FROM $this->table 
					WHERE control_number like '%{$controlNumber}%'"
			);

			$delivery = $this->db->single();


			if($delivery) 
			{

				$delivery->loan = $releaseModel->dbget( $delivery->loanId );

				$delivery->user = $userModel->get_user( $delivery->userid );
			}

			return $delivery;
		}
		
	}