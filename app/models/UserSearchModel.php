<?php   

    class UserSearchModel extends Base_model
    {   
        public $table_name = 'users';

        public function search($keyPair , $limit = null) 
        {
            $fields = array_keys($keyPair);
            $values = array_values($keyPair);

            $keys = '';
            foreach($fields as $key => $value) 
            {
                if($key > 0) {
                    $keys .= ' OR ';
                }

                $keys .= "$value LIKE '%{$values[$key]}%'";
            } 

            if(!is_null($limit))
                $limit = " LIMIT {$limit}";
            $this->db->query(
                "SELECT * FROM $this->table_name 
                    WHERE $keys $limit"  
            );

            return $this->db->resultSet();
        }
    }