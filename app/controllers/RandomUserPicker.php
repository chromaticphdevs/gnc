<?php   

    class RandomUserPicker extends Controller
    {
        
        public function __construct()
        {
            $this->db = Database::getInstance();
        }

        public function index()
        {

            $this->db->query(
                "SELECT id , username , firstname , lastname , id as systemid
                from users 
                where firstname NOT LIKE '%Breakthrough%' 
                and firstname NOT LIKE '%Edromero%'
                and firstname NOT LIKE 'kl%' 
                and firstname NOT LIKE 'duplicate%' 
                and firstname NOT LIKE '%System_ad%'
                and account_tag = 'main_account'
                ORDER BY RAND() LIMIT 200
                 "
            );

            $result = $this->db->resultSet();

            $counter = 1;

            foreach($result as $key => $row) {
                $row->id = $counter;
                $counter++;
            }
    
            $data = [
                'Title' => 'Random User Picker' , 
                'users' => $result ,
                'fetchedCount' => count($result)
            ];
            
            $this->view('tools/randomuserpicker' , $data);
        }

        public function export()
        {
            if($this->request() === 'POST')
            {
                $exportData = (array) unserialize(base64_decode($_POST['users']));


                $result = objectAsArray($exportData);

                $header = [
                    'id'        => 'Raffle ID',
                    'firstname' => 'Firstname',
                    'lastname'  => 'Lastname',
                    'username'  => 'Username'
                ];

                export($result , $header);

                redirect('RandomUserPicker/index');
            }
        }

        
        public function get_random_admin()
        {
             $this->db->query(
                "SELECT CONCAT( firstname ,' ', lastname , '  ( username: ', username,' )') as info
                from users 
                where firstname NOT LIKE '%Breakthrough%' 
                and firstname NOT LIKE '%Edromero%'
                and firstname NOT LIKE 'kl%' 
                and firstname NOT LIKE 'duplicate%' 
                and firstname NOT LIKE '%System_ad%'
                and account_tag = 'main_account'
                ORDER BY RAND() LIMIT 1
                 "
            );

            $result = $this->db->single();

            echo json_encode($result);

        }

          public function get_random_user()
        {
             $this->db->query(
                "SELECT CONCAT( firstname ,' ', lastname ) as info, id
                from users 
                where firstname NOT LIKE '%Breakthrough%' 
                and firstname NOT LIKE '%Edromero%'
                and firstname NOT LIKE 'kl%' 
                and firstname NOT LIKE 'duplicate%' 
                and firstname NOT LIKE '%System_ad%'
                and account_tag = 'main_account'
                ORDER BY RAND() LIMIT 1
                 "
            );

            $result = $this->db->single();

            echo json_encode($result);

        }

        public function pick_one()
        {
             
            $this->view('tools/random_user');
        }

         public function record_winner()
        {
            if($this->request() === 'POST')
            {
                $userid =  $_POST['user_id'];
                $this->db->query("INSERT INTO `winners_list`(`userid`) VALUES ('$userid')");
                $this->db->execute();


            }

        }

        public function winners_list()
        {

            $this->db->query(
                "SELECT userid , (SELECT username FROM users WHERE id = userid) as username , 
                 (SELECT firstname FROM users WHERE id = userid)  as firstname ,
                 (SELECT lastname FROM users WHERE id = userid) as lastname , 
                 userid as systemid
                 from winners_list"
            );

            $result = $this->db->resultSet();

            $data = [
                'users' => $result 
            ];
            
            $this->view('tools/winners_list' , $data);
        }
    }