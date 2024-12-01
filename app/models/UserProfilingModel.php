<?php 	
	class UserProfilingModel extends Base_model 
	{
		public $table = 'user_profiling';

        public $id;

        /*override*/
        public function store($params)
        {
            //check if isset source_income
            $hasContent = false;
            foreach($params as $key => $row) 
            {
                $trimed = trim($row);

                if( !empty($trimed)) {
                    $hasContent = true;
                    break;//stop loop
                }
            }

            if(!$hasContent)
                return true;
            //with content then add
            
            return parent::store( $params );
        }

        public function storeWithCop($params)
        {

            $userAddressModel = model('UserAddressesModel');

            $cop = $params['cop'] ?? '';

            unset($params['cop']);

            $insertId = parent::store($params);

            $userAddressModel->addCOP([
                'userId' => $params['userid'],
                'address' => $cop
            ]);


            $this->id = $insertId;
            
            return $insertId;
        }

        public function save_user_profiling($user_info, $userid)
        { 
           extract($user_info);

           $processBy = whoIs()['id'];
           $account_type = whoIs()['whoIs'];

           $returnStatus = $this->dbHelper->insert($this->table, [
                'userid' => $userid,
                'source_income'   => $source_income ,
                'income' => $income,
                'house_rental '  => $house_rental,
                'dependents' => $dependents,
                'rice_consumption '  => $rice_consumption,
                'process_by' => $processBy,
                'account_type' => $account_type
            ]);

           //set profiling id do not delete!!
           $this->id = $returnStatus;

           return $returnStatus;
        }

        public function get_user_profiling_info($userId)
        {
            $this->db->query(
                "SELECT * FROM $this->table
                 WHERE userid = '{$userId}' 
                 ORDER BY id DESC"
            );

            return $this->db->resultSet();
        }


        public function get_list($userid, $account_type)
        {
            $this->db->query(
                "SELECT * 
                 FROM `csr_timesheets` user_id "
            );

            return $this->db->resultSet();
        }

	
	}


