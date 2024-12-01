<?php
	require_once(APPROOT.DS.'classes/UserBinaryPV.php');
	
	class Binarypv_model extends Base_model{

		
		public function get_bpv($user_id)
		{
			return new UserBinaryPV($user_id);
		}


		public function point_tracker($user_id)
		{
			$this->db->query("SELECT * FROM binary_pvs where c_id = :user_id");

			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}

		public function pair_tracker($user_id)
		{
			/*fields that starts wth c needs are required because it is compulsery to commission model on for the sponsor commissions*/
			$this->db->query("SELECT bpvc.* , o.id as order_id , 
				'binary commission' as c_type , 
				bpvc.amount as c_amount,
				u.username as username,
				u.username as u_username
				FROM binary_pv_commissions as bpvc

				left join binary_pvs as bpv 
				on bpv.id = bpvc.binary_pvs_id

				left join orders as o
				on o.id = bpv.order_id

				left join users as u

				on o.user_id = u.id

				where bpvc.user_id = :user_id

				order by order_id desc");

			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}

		public function pair_tracker_by_date($user_id, $number_of_days)
		{
			/*fields that starts wth c needs are required because it is compulsery to commission model on for the sponsor commissions*/
			extract($number_of_days);

			if($number_of_days<=0){

				$number_of_days=1;
			}

			if($number_of_days==1){

				$today=date("Y-m-d");

				$this->db->query("SELECT bpvc.* , o.id as order_id , 
				'binary commission' as c_type , 
				bpvc.amount as c_amount,
				u.username as username,
				u.username as u_username
				FROM binary_pv_commissions as bpvc

				left join binary_pvs as bpv 
				on bpv.id = bpvc.binary_pvs_id

				left join orders as o
				on o.id = bpv.order_id

				left join users as u

				on o.user_id = u.id

				where bpvc.user_id = :user_id AND date(bpvc.dt)='$today'

				order by order_id desc");

				$this->db->bind(':user_id' , $user_id);

			}else{

				$to_date=date("Y-m-d");
				$number_of_days-=1;

				$date = new DateTime($to_date);
				$date->sub(new DateInterval('P'.$number_of_days.'D'));
				
				$from_date=$date->format('Y-m-d');

				$this->db->query(
					"SELECT bpvc.* , o.id as order_id , 
				'binary commission' as c_type , 
				bpvc.amount as c_amount,
				u.username as username,
				u.username as u_username
				FROM binary_pv_commissions as bpvc

				left join binary_pvs as bpv 
				on bpv.id = bpvc.binary_pvs_id

				left join orders as o
				on o.id = bpv.order_id

				left join users as u

				on o.user_id = u.id

				where bpvc.user_id = :user_id AND (date(bpvc.dt) <= '$to_date' AND date(bpvc.dt) >= '$from_date')

				order by order_id desc"
				);
				$this->db->bind(':user_id' , $user_id);

			}
			return $this->db->resultSet();
		}
		/**
		*@param
		*start and end both refer to the date
		*/
		public function getCommissionDate($start , $end , $user_id)
		{
			$this->db->query("SELECT * FROM binary_pv_commissions where user_id = :user_id 
				and date(dt) between cast('$start' as DATE) and cast('$end' as DATE)");

			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}

		public function last_tracker()
		{
			$this->db->query("SELECT * FROM binary_pv_commissions where user_id = :user_id order by id desc limit 1");

			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}
	}