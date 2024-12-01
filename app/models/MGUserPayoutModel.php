<?php   

    class MGUserPayoutModel extends Base_model
    {
        private $table_name = 'mg_payout_items';

        public function getRecent($userid) 
        {
            $data = [
                $this->table_name , 
                [
                    'amount' , 
                    'created_at'
                ],
                " userid = '$userid'" ,
                'id desc' ,
                '1'
            ];

            return $this->dbHelper->single(...$data);
        }

        public function getTotal($userid) 
        {
            $this->db->query(
				"SELECT sum(amount) as total_amount from mg_payout_items 
					where userid = '$userid' "
			);

            return $this->db->single()->total_amount ?? 0;
		}
    }