<?php   

    class AccountQRCODE
    {
        public function __construct($userId)
        {
            $this->userId = $userId;
            $this->db = Database::getInstance();
            
        }
        
        public function generate()
        {
            require_once LIBS.DS.'phpqrcode'.DS.'qrlib.php';

            $userModel = model('UserModel');
            $user = $userModel->get($this->userId);


            $qrCode = [
                now(),
                $user->username,
                $user->id
            ];

            $qrcodeJSON = json_encode($qrCode);

            $fileName = seal($qrcodeJSON).'.png';

            $path = PATH_ASSETS;
            $abspath = $path.DS.$fileName;
            $relativePath = GET_PATH_ASSETS.DS.$fileName;
            
            $code = get_token_random_char(15);
        
            QRcode::png( $code , $abspath);

            $this->db->query(
                "INSERT INTO user_qr (user_id , qrcode , path_name)
                VALUES('$this->userId' , '$code' , '$fileName')"
            );

            $this->db->execute();

            return $this->get();
        }


        public function get()
        {
            $this->db->query(
                "SELECT * FROM user_qr  
                    where user_id = '$this->userId'"
            );

            $result = $this->db->single();

            if(!$result)
                return $this->generate();
            return $result;
        }
    }