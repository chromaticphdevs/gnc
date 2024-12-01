<?php 	

	class UserBinaryPV
	{	
		/*tables to compute user binary information*/
		private
			$binary_pv_points           = 'binary_pvs',
			$binary_pv_commissions      = 'binary_pv_commissions',
			$binary_pv_pair_counter     = 'binary_pv_pair_counter' , 
			$binary_pv_pair_deduction   = 'binary_pv_pair_deduction';

		private $user_id;
		private $db;
		//
		private $deduct_bpv;

		public function __construct($user_id)
		{
			$this->user_id = $user_id;
			$this->db = new Database();

			$this->deduct_bpv();
		}

		//current pair today.
		public function cur_pair()
		{
			$userid = $this->user_id;
			//get from database binary_pv_pair_counter
			$this->db->query("SELECT ifnull(sum(pair) ,0) as pair 
				from $this->binary_pv_pair_counter 
				where date(dt) = date(now()) and user_id = :user_id");
			$this->db->bind(':user_id' , $userid);

			$res = $this->db->single();

			if($this->db->rowCount())
				return $res->pair;
			return 0;
		}

		public function total_pair(){

			$userid = $this->user_id;

			$this->db->query("SELECT ifnull(sum(pair) ,0) as total_pair from 
				$this->binary_pv_pair_counter 
				where user_id = :user_id");
			$this->db->bind(':user_id' , $userid);

			$res = $this->db->single();

			if($this->db->rowCount())
				return $res->total_pair;
			return 0;
		}

		public function getTotalAmount(){
			$userid = $this->user_id;

			$this->db->query("SELECT sum(amount) as total_amount from 
				$this->binary_pv_commissions where user_id = '$userid'");

			$res = $this->db->single();

			if($res)
				return $res->total_amount;
			return 0;
		}
		public function left_volume()
		{
			return $this->get_volume('left');
		}

		public function right_volume()
		{
			return $this->get_volume('right');
		}

		private function get_volume($position)
		{
			$userid = $this->user_id;

			$this->db->query("SELECT ifnull(sum(points) , 0) as total_points 
				from $this->binary_pv_points 
				where c_id = :user_id and type = 'points' 
				and pos_lr = :position");
			
			$this->db->bind(':user_id' , $userid);
			$this->db->bind(':position', $position);

			$res = $this->db->single();
			
			if($this->db->rowCount())
				return $res->total_points - $this->deduct_bpv;
			return 0;
		}

		private function deduct_bpv()
		{
			$userid = $this->user_id;

			$this->db->query("SELECT ifnull(sum(points) , 0)  as total_point 
				from $this->binary_pv_pair_deduction 
				where user_id = :user_id");
			$this->db->bind(':user_id' , $userid);


			$res = $this->db->single();

			if($this->db->rowCount())
			{
				$this->deduct_bpv = $res->total_point;
			}else{
				$this->deduct_bpv = 0;
			}
		}

		public function getLeftCarry()
		{
			$userid = $this->user_id;

			$this->db->query("SELECT left_carry from binary_pv_commissions 
				where user_id = '$userid' 
				order by id desc limit 1");

			$res = $this->db->single();

			if($res)
				return $res->left_carry;
			return 0;
		}

		public function getRightCarry()
		{
			$userid = $this->user_id;

			$this->db->query("SELECT right_carry 
				from binary_pv_commissions 
				where user_id = '$userid' 
				order by id desc limit 1");

			$res = $this->db->single();

			if($res)
				return $res->right_carry;
			return 0;
		}
	}