<?php   

    class RegistrationModel extends Base_model 
    {

        private $table_name = 'users';

        public function store($values)
        {
            $data =[
                $this->table_name ,
                $values
            ];

            return $this->dbHelper->insert(...$data);
        }

        /** HELPERS */
        public function formatAddress($housenumber , $barangay , $city , $province = null)
        {   
            $housenumber = str_replace("#" , '' , $housenumber);
            
            return "#{$housenumber} {$barangay} {$city} {$province}";
        }
        

        public function get($id)
        {
            return $this->dbHelper->single(...[
                $this->table_name ,
                '*',
                " id = '$id'"
            ]);
        }

        public function update($values , $id)
        {
            return $this->dbHelper->update(...[
                $this->table_name ,
                $values,
                " id = '{$id}'"
            ]);
        }

        public function getUsername($username)
        {
            $data = [
                $this->table_name , 
                '*',
                " username = '$username'"
            ];

            return $this->dbHelper->single(...$data);
        }

        public function getEmail($email)
        {
            $data = [
                $this->table_name , 
                '*',
                " email = '$email'"
            ];

            return $this->dbHelper->single(...$data);
        }

        public function getMobile($mobile)
        {
            $data = [
                $this->table_name , 
                '*',
                " mobile = '$mobile'"
            ];

            return $this->dbHelper->single(...$data);
        }

        public function fullname($firstname , $lastname) 
        {
            $data = [
                $this->table_name ,
                '*' ,
                " firstname = '$firstname' and lastname = '$lastname'"
            ];

            return $this->dbHelper->single(...$data);
        }
    }