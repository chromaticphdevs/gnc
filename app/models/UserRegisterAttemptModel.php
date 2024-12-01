<?php   

    class UserRegisterAttemptModel extends Base_model
    {
        private $table_name = 'user_register_attempts';

        public function store($values)
        {
            return $this->dbHelper->insert(...[
                $this->table_name , 
                $values
            ]);
        }

        public function fullname($fullname){

            return $this->dbHelper->resultSet(
                ...[
                    $this->table_name,
                    '*',
                    " fullname  = '{$fullname}'"
                ]
            );
        }

        public function all()
        {
            return $this->dbHelper->resultSet(...[
                $this->table_name , 
                '*',
                null,
                " id desc"
            ]);
        }
    }