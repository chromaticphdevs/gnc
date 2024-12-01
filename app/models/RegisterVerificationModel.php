<?php   
    class RegisterVerificationModel extends Base_model
    {
        private $table_name = 'registration_codes';
        
        public function store($values)
        {
            return $this->dbHelper->insert(
                ...[
                    $this->table_name , 
                    $values
                ]
            );
        }

        public function get($id)
        {
            return $this->dbHelper->single(...[
                $this->table_name , 
                '*',
                " id = '{$id}'"
            ]);
        }

        public function update($values , $id)
        {
            return $this->dbHelper->update(...[
                $this->table_name,
                $values,
                " id = '$id'"
            ]);
        }

        public function createCode()
        {
            return random_number(4);
        }

        public function send($messageLeft , $verificationCode , $userDetails)
        {

            $sentBy = 'sms';

            if($messageLeft > 0) 
            {
                $this->sendSMS(...[
                    $userDetails['mobile'] , 
                    $userDetails['fullname'],
                    $verificationCode
                ]);
            }else{
                $this->sendEmail(
                    ...[
                        $userDetails['email'] , 
                        $userDetails['fullname'],
                        $verificationCode
                    ]
                );

                $sentBy = 'email';
            }

            return $sentBy;
        }

        private function sendSMS($mobile , $fullname , $verificationCode)
        {   
            $siteName = SITE_NAME;

            $message = <<<EOF
                Hi , {$fullname} Your Verification code is {$verificationCode}
                \n\n {$siteName} \n\n
            EOF;

            itexmo($mobile,$message , ITEXMO);
        }

        private function sendEmail($email , $fullname , $verificationCode)
        {   
            $message = "
                <h2>Registration Code</h2>
                <p>
                    <strong> Dear {$fullname} ,<strong> <br/>
                    We recieved a registration request in our site 'www.socialnetwork-e.com',<br>
                    Your Confirmation Code: 
                    <h2  style='color: red; text-transform: uppercase; text-align: center;  border: 5px solid black;'>$verificationCode</h2>
                    <br>
                    Please Enter this Confirmation Code in the form so that we can process your  Registration.
                </p>";
            
            $mailer = new Mailer();

            $mailer->setFrom('socialnetworkecommerce@gmail.com','Social Network');
            $mailer->setTo($email , $fullname);
            $mailer->setSubject('Registration Code');
            $mailer->setBody($message);
        }
    }

?>