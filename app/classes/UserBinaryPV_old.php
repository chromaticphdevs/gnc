<?php 	

	class UserBinaryPV{

		private $db;

		private $_userId;

		private $deductVolume;

		private 
			$binary_pv_pair_counter ='binary_pv_pair_counter' , 
			$binary_pv_pair_deduction ='binary_pv_pair_deduction';

		public function __construct($user_id)
		{

			$this->db = new Database();
			$this->_userId = $user_id;

			$this->deductVolume();
		}

		public function getLeftVolume()
		{
			$this->db->query("SELECT ifnull(total_volume , 0) as total_volume from binary_lvol_total where user_id = :user_id");

			$this->db->bind(':user_id' , $this->_userId);

			
			if($this->db->rowCount())
			{
				$res = $this->db->single();

				return $res->total_volume - $this->deductVolume;

			}else{
				return 0;
			}

		}

		public function getRightVolume()
		{
			$this->db->query("SELECT total_volume from binary_rvol_total where user_id = :user_id");
			$this->db->bind(':user_id' , $this->_userId);

			if($this->db->rowCount())
			{
				$res = $this->db->single();

				return $res->total_volume - $this->deductVolume;

			}else{
				return 0;
			}
		}

		public function getPairToday()
		{
			$this->db->query("SELECT sum(pair) as pair from $this->binary_pv_pair_counter where user_id = :user_id 
				and date(dt) = date(now())");

			$this->db->bind(':user_id' , $this->_userId);

			$res = $this->db->single();

			if($res->pair)
				return $res->pair;
			return 0;
		}

		private function deductVolume()
		{	
			// $this->db->query("SELECT sum(ifnull( points , 0)) as total from $this->binary_pv_pair_deduction where user_id = :user_id");

			$this->db->query("SELECT ifnull(sum(points) , 0) as total from $this->binary_pv_pair_deduction where user_id = :user_id");
			$this->db->bind(':user_id' , $this->_userId);

			$res = $this->db->single();

			if($res){
				$this->deductVolume = $res->total;
			}else{
				$this->deductVolume = 0;
			}
		}
	}