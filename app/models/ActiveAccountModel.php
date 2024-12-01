<?php   

    class ActiveAccountModel extends Base_model
    {
        private $table_name = 'users';

        public function online($userid)
        {
            $data = [
                $this->table_name , 
                [
                    'is_online' => today()
                ],
                " id = '$userid'"
            ];

            return $this->dbHelper->update(...$data);
        }

        public function offline($userid)
        {
            $data = [
                $this->table_name , 
                [
                    'is_online' => '0'
                ],
                " id = '$userid'"
            ];

            return $this->dbHelper->update(...$data);
        }

        public function all()
        {
            $data = [
                $this->table_name , 
                '*',
                " is_online != '0' " ,
                " is_online desc"
            ];

            return $this->dbHelper->resultSet(...$data);
        }
    }