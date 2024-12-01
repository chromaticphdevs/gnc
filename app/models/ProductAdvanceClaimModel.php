<?php

	class ProductAdvanceClaimModel extends Base_model
	{

		private $table_name = 'single_box_advances';


		public function claim_product($code)
		{
			$getLoan = $this->get_code($code);

			if(empty($getLoan)){

				Flash::set("Code {$code} not found");
				return false;
			}


			if($getLoan->status == 'claimed')
			{
				Flash::set("Code {$code} has already been claimed");
				return false;
			}

			if($getLoan->status == 'paid')
			{
				Flash::set("Code {$code} has already been paid");
				return false;
			}

			$this->db->query(
				"UPDATE $this->table_name set status = 'claimed'
					WHERE id = '{$getLoan->id}'"
			);

			try{
				$this->db->execute();

				$this->release_stock(1 , "Product Claim #{$code}" , $getLoan->branchid);

				return true;

			}catch(Exception $e)
			{
				die($e->getMessage());
			}
			return $search_code;
		}


		public function pay_product($code)
		{
			$getLoan = $this->get_code($code);

			if(empty($getLoan)){

				Flash::set("Code {$code} not found");
				return false;
			}

			if($getLoan->status == 'paid')
			{
				Flash::set("Code {$code} has already been paid");
				return false;
			}

			$this->db->query(
				"UPDATE $this->table_name set status = 'paid'
					WHERE id = '{$getLoan->id}'"
			);

			try
			{
				$this->db->execute();

				/*insert cash to branchvault*/
				$data = [
					$getLoan->branchid,
					$getLoan->amount,
					'A Payment from product assistance with code #'.$getLoan->code
				];

				$this->vault_instance()->add_cash(...$data);

				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());
			}
			return $search_code;
		}

		public function claim_pay_product($code)
		{
			$getLoan = $this->get_code($code);
			
			if(empty($getLoan)){

				Flash::set("Code {$code} not found");
				return false;
			}

			if($getLoan->status == 'paid')
			{
				Flash::set("Code {$code} has already been paid");
				return false;
			}

			$release_stock = $this->release_stock(1 , "Product Claim and Pay #{$code}" , $getLoan->branchid);

			if(!$release_stock) 
			{
				return false;
			}
			
			$this->db->query(
				"UPDATE $this->table_name set status = 'paid'
					WHERE id = '{$getLoan->id}'"
			);

			try
			{
				$this->db->execute();
				/*realase stock sto product inventory*/
				/*insert cash to branchvault*/
				$data = [
					$getLoan->branchid,
					$getLoan->amount,
					'A Payment from product assistance with code #'.$getLoan->code
				];

				$this->vault_instance()->add_cash(...$data);

				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());
			}
			return $search_code;
		}

		public function get_code($code)
		{
			$this->db->query("SELECT * FROM $this->table_name where code = '$code'");

			return $this->db->single();
		}

		public function get_codes()
		{
			$this->db->query("SELECT ps.* , concat(firstname , ' ' , lastname) as fullname 
				FROM $this->table_name as ps 
				LEFT JOIN users as user on ps.userid = user.id
				order by ps.id desc");

			return $this->db->resultSet();
		}
		
		private function release_stock($quantity , $description , $branchid)
		{
			$stockManagerModel = new StockManagerModel();

			return
				$stockManagerModel->release_stock($quantity , $description , $branchid);

		}


		private function vault_instance()
		{
			return new BranchVaultModel();
		}
	}
