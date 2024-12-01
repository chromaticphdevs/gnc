<?php   

    class FacebookStreamModel extends Base_model
    {

        private $table_name = 'facebooklive_streams';

        public function create_stream($stream) 
        {
            extract($stream);

            $userid = Session::get('USERSESSION')['id'];

            $data = [
                $this->table_name , 
                [
                    'userid' => $userid,
                    'title' => $title, 
                    'stream_code' => $this->generate_stream_code(),
                    'description' => $description ,
                    'facebook_link' => base64_encode($facebook_link)
                ]
            ];

            $this->dbHelper->insert(...$data);
        }

        public function get_all($key = null)
        {   
            $this->db->query(
                "SELECT stream.* , concat(user.firstname , ' ' , user.lastname) as fullname 
                FROM $this->table_name as stream 
                LEFT JOIN users as user on user.id = stream.userid
                
                ORDER BY created_at desc LIMIT 1"
            );

            return $this->db->resultSet(); //will return an array
        }

        public function get_last()
        {
            $data = [
                $this->table_name ,
                '*',
                null,
                'id desc'
            ];

            return $this->dbHelper->single(...$data);
        }

        public function get($streamid)
        {
            $data = [
                $this->table_name ,
                '*',
                " id = '$streamid'"
            ];

            return $this->dbHelper->single(...$data);
        }

        public function edit($stream) 
        {
            extract($stream);

            $data = [
                $this->table_name , 
                [
                    'title' => $title, 
                    'stream_code' => $this->generate_stream_code(),
                    'description' => $description ,
                    'facebook_link' => base64_encode($facebook_link)
                ],
                " id = '$streamid'"
            ];

            return $this->dbHelper->update(...$data);
        }
        private function generate_stream_code()
        {
            return base64_encode(uniqid(true , 1)).random_number(5);
        }
    }