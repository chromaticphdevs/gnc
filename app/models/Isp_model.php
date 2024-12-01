<?php

	class Isp_model extends Base_model
	{

		private $table_name = 'omg_commissions';

		public function get_info($user_id = null)
		{
			if($user_id === null)
			{
				$this->db->query(
					"SELECT transaction , count(*) as instance ,
					sum(amount) as total_amount 
					from $this->table_name group by transaction"
				);

				return $this->db->resultSet();
			}else{

				$this->db->query(
					"SELECT transaction , count(*) as instance ,
					sum(amount) as total_amount 
					from $this->table_name where user_id = '$user_id' group by transaction"
				);

				return $this->db->resultSet();
			}
		}

		public function get_user_isp($userid)
		{
			$this->db->query(
				"SELECT omg.transaction , count(*) as instance , sum(amount) as 
				total_amount from omg_commissions as omg
				 where user_id = '$userid' 
				group by omg.transaction"
			);
			// $this->db->query(
			// 	"SELECT transaction , count(*) as instance , sum(amount) as total_amount 
			// 	from $this->table_name where user_id = '$userid' group by transaction"
			// );

			return $this->db->resultSet();
		}

		public function get_user_volume($user_id)
		{
			$this->db->query(
				"SELECT sum(isp_binary.left_volume) as total_left  , sum(isp_binary.right_volume) as total_right from isp_volumes_binary as isp_binary where user_id = '$user_id'"
			);

			return $this->db->single();
		}

		public function get_commissions($userid)
		{
			$this->db->query(
				"SELECT sum(amount) as total_amount , transaction , 
				(SELECT sum(amount) from omg_commissions 
				where user_id = '$userid' group by user_id) as total
				from omg_commissions where user_id = '$userid' and amount != 0 
				group by transaction , user_id"
			);

			return $this->db->resultSet();
		}

		public function get_user_total_desc($limit = 100)
		{
			$this->db->query("SELECT user_id , sum(amount) as total_amount 
			 from omg_commissions
			 group by user_id
			 order by total_amount desc limit $limit");

			$res = $this->db->resultSet();


			if($res)
			{
				foreach($res as $row)
				{
					$binary = new stdClass();
					$binary->transaction = 'binary';
					$binary->amount = 0;

					$referral = new stdClass();
					$referral->transaction = 'referral';
					$referral->amount = 0;

					$unilevel = new stdClass();
					$unilevel->transaction = 'unilevel';
					$unilevel->amount = 0;


					$mentor = new stdClass();
					$mentor->transaction = 'mentor';
					$mentor->amount = 0;

					$this->db->query("SELECT transaction , sum(amount) as amount from
					omg_commissions where user_id = '$row->user_id' group by transaction");
					
					$transaction = $this->db->resultSet();
					
					foreach($transaction as $key => $trans)
					{
						if($trans->transaction == 'binary')
						{
							$binary->transaction = 'binary';
							$binary->amount = $trans->amount;
						}
						if($trans->transaction == 'referral')
						{
							$referral->transaction = 'referral';
							$referral->amount = $trans->amount;
						}
						if($trans->transaction == 'unilevel')
						{
							$unilevel->transaction = 'unilevel';
							$unilevel->amount = $trans->amount;
						}

						if($trans->transaction == 'mentor') {
							$mentor->transaction = 'mentor';
							$mentor->amount = $trans->amount;
						}
					}
					$row->commission = array($binary , $referral , $unilevel);	
				}
				
			}

			return $res;
		}

		public function get_users_total($userid)
		{
			$this->db->query(
				"SELECT user_id , username , concat(firstname , ' ' , lastname) as fullname , 
				omg_com.transaction as trans , sum(amount) as total_amount 
                from omg_commissions as omg_com

                left join users as u 

                on omg_com.user_id = u.id 

                where omg_com.transaction = 'referral'
                group by omg_com.user_id

                order by total_amount desc"
			);


			$this->db->query(
				"SELECT user_id , username , concat(firstname , ' ' , lastname) as fullname , 
				omg_com.transaction as trans , count(*) as instance , sum(amount) as total_amount 
                from omg_commissions as omg_com

                left join users as u 

                on omg_com.user_id = u.id 

                group by omg_com.user_id , omg_com.transaction order by user_id asc"
			);
			return $this->db->resultSet();
		}
		public function get_user_list($userid)
		{
			$this->db->query(
				"SELECT user_id , transaction , count(*) as instance , sum(amount) as total_amount 
				from $this->table_name where user_id = '$userid' group by user_id , transaction "
			);

			return $this->db->resultSet();
		}

		//volume computation

		public function get_binary($userid)
		{
			//total point , total carry
			$left  = new stdClass();
			$right = new stdClass();

			$left->point = $this->get_point($userid , 'left');
			$left->carry = $this->get_carry($userid , 'left');

			$right->point = $this->get_point($userid ,'right');
			$right->carry = $this->get_carry($userid ,'right');


			return array(
				'left'  => $left ,
				'right' => $right,
				'pair'  => $this->get_total_pair($left->point, $right->point),
				'amount' => $this->get_total_amount($left->point, $right->point)
			);
		}

		public function get_total_pair($left , $right)
		{
			if($left != 0 || $right != 0)
			{
				$total_pair = $left > $right ? floor($right / 100): floor($left / 100); 

				return $total_pair;
			}else{
				return 0;
			}
			
		}

		public function get_total_amount($left , $right)
		{
			$pair = $this->get_total_pair($left , $right);

			if($pair > 0)
				return $pair * 100;
			return 0;
		}
		public function get_point($userid , $position)
		{
			//getting all points
			$this->db->query(
				"SELECT ifnull(sum(isp.$position) ,0) as total FROM isp_volumes_binary as isp where user_id = '$userid' and isp.$position > 0 group by user_id"
			);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		public function get_carry($userid , $position)
		{
			$this->db->query(
				"SELECT ifnull(sum(isp.$position) ,0) as total FROM isp_volumes_binary as isp where user_id = '$userid' group by user_id"
			);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}
	}