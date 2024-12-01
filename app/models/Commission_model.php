<?php 	

	class Commission_model extends Base_model
	{

		public function getSponsorCommission($user_id)
		{
			$this->db->query("
				SELECT dt , order_id , c.type as c_type , c.c_id as c_com ,c.fu_id as c_purchaser ,
				c.amount as c_amount , u.username as u_username , concat(firstname , ' ' , lastname) as c_fullname

				from commissions as c left join
				users as u on c.fu_id = u.id
				where c.c_id = :user_id
				order by dt desc"
				);
			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}

		public function getSponsorCommission_by_date($user_id,  $number_of_days)
		{

			extract($number_of_days);

			if($number_of_days<=0){

				$number_of_days=1;
			}

			if($number_of_days==1){

				$today=date("Y-m-d");

				$this->db->query(
				"SELECT dt , order_id , c.type as c_type , c.c_id as c_com ,c.fu_id as c_purchaser ,
				c.amount as c_amount , u.username as u_username , concat(firstname , ' ' , lastname) as c_fullname

				from commissions as c left join
				users as u on c.fu_id = u.id
				where date(c.dt) = '$today'
				order by dt desc"
				);
				$this->db->bind(':user_id' , $user_id);

			}else{

				$to_date=date("Y-m-d");
				$number_of_days-=1;

				$date = new DateTime($to_date);
				$date->sub(new DateInterval('P'.$number_of_days.'D'));

				$from_date=$date->format('Y-m-d');

				$this->db->query(
				"SELECT dt , order_id , c.type as c_type , c.c_id as c_com ,c.fu_id as c_purchaser ,
				c.amount as c_amount , u.username as u_username , concat(firstname , ' ' , lastname) as c_fullname

				from commissions as c left join
				users as u on c.fu_id = u.id
				where date(c.dt) <= '$to_date' AND date(c.dt) >= '$from_date'
				order by dt desc"
				);

				$this->db->bind(':user_id' , $user_id);

			}

			return $this->db->resultSet();
		}

		public function getBinaryPoints($user_id)
		{
			$this->db->query("SELECT dt , order_id , c.type as c_type , c.c_id as c_com , c.pos_lr as c_position ,
				c.fu_id as c_purchaser , c.points as c_points ,  u.username as u_username ,
				concat(firstname , ' ' , lastname) as c_fullname

				FROM binary_pvs as c left join
				users as u on c.fu_id = u.id
				where c.c_id = :user_id");

			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}

	}
