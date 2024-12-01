<?php   

    class GovernmentIdModel extends Base_model
    {
        private $table_name = 'users_uploaded_id';

        public function store($values)
        {
            $data = [
                $this->table_name , 
                $values,
                " by id desc "
            ]; 

            return $this->dbHelper->insert(...$data);
        }

        public function update($values , $id)
        {
            $data = [
                $this->table_name ,
                $values,
                " id = '$id'"
            ];

            return $this->dbHelper->update(...$data);
        }

        public function all()
        {
            $all = array_merge($this->primary() , $this->secondary());
            sort($all);
            return $all;
        }

        public function get($id)
        {
            $data =[ 
                $this->table_name ,
                '*',
                " id = '$id" 
            ];
            
            return $this->dbHelper->single(...$data);
        }

        public function secondary()
        {
            $secondary = [
                "Professional Regulation Commission ID",
                "Senior Citizen ID",
                "OFW ID",
                "Company ID",
                "NBI Clearance",
                "Police Clearance"
            ];

            sort($secondary);

            return $secondary;
        }

        public function primary()
        {
            $primary = [
                "Philippine passport",
                "Drivers license",
                "SSS UMID Card",
                "Postal ID",
                "Voters ID",
                "PhilHealth ID",
                "TIN Card"
            ];
            sort($primary);

            return $primary;
        }
    }