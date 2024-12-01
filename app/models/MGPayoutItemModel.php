<?php

	class MGPayoutItemModel extends Base_model
	{

		public $table = 'mg_payout_items';
		
		public function get_list($payoutid)
		{
			$this->db->query(
				"SELECT mgi.id as itemid , u.id as userid , username , concat(u.firstname , ' ' , u.lastname) as fullname ,
				amount , cheque

				from mg_payout_items as mgi

				left join users as u on mgi.userid = u.id

				where mgi.payoutid = '$payoutid'"
			);

			return $this->db->resultSet();
		}

		public function get_user_total_payout($userid)
		{
			$this->db->query(
				"SELECT sum(amount) as total_amount from mg_payout_items
					where userid = '$userid' "
			);

			/*changed from if else to single notation*/
			return $this->db->single()->total_amount ?? 0;
		}
	}
