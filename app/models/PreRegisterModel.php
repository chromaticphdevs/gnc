<?php   

    class PreRegisterModel extends Base_model
    {
        public $table = 'pre_register_users';

        public function createReferral($values) {
            $firstname = trim($values['firstname']);
            $lastname = trim($values['lastname']);

            $userNameStr = substr($firstname ,0 , 1);
            $userNameStr .= substr($lastname ,0 , 1);
            $userNameStr .= strtolower(random_number(4));
            // $userNameStr .= substr(strtotime(date('Y-m-d H:i:s')), 0, 3);

            $values['password'] = random_number(4);
            $values['username'] = $userNameStr;

            
            $preRegistered = parent::dbget([
                'username' => $values['username'],
                'email'    => $values['email'],
                'phone'    => $values['phone']
            ]);

            if($preRegistered) {
                $this->addError("User is already pre-registered");
                return false;
            }

            if(!isset($this->userModel)) {
                $this->userModel = model('User_model');
            }

            $personExist = $this->userModel->dbget([
                'firstname' => $firstname,
                'lastname'  => $lastname
            ]);

            if($personExist) {
                $this->addError("this person already have an account with us");
                return false;
            }

            if($this->userModel->dbget([
                'username' => $userNameStr
            ])) {
                $this->addError("Username already exists.");
                return false;
            }

            if($this->userModel->dbget([
                'email' => $values['email']
            ])) {
                $this->addError("Email already exists.");
                return false;
            }
            
            if($this->userModel->dbget([
                'mobile' => $values['phone']
            ])) {
                $this->addError("Mobile already exists.");
                return false;
            } 
            
            return parent::store($values);
        }
        /**
         * pre-registered user will
         * be moved as user
         */
        public function moveToUser($userId) {
            $preRegisteredUser = parent::dbget([
                'id' => $userId
            ]);

            if(!isset($this->userModel)) {
                $this->userModel = model('User_model');
            }
            $userId = $this->userModel->register([
                'firstname' => $preRegisteredUser->firstname,
                'lastname' => $preRegisteredUser->lastname,
                'username' => $preRegisteredUser->username,
                'password' => $preRegisteredUser->password,
                'direct_sponsor' => $preRegisteredUser->created_by,
                'upline' => $preRegisteredUser->created_by,
                'L_R' => 'LEFT',
                'position' => 'LEFT',
                'new_upline' => $preRegisteredUser->created_by,
                'address' => $preRegisteredUser->address,
                'email' => $preRegisteredUser->email,
                'mobile' => $preRegisteredUser->phone,
                'mobile_verify' => 'verified',
                'account_tag' => 'main_account',
            ]);
            if(!$userId) {
                $this->addError($this->userModel->getErrorString());
                return false;
            }

            return $userId;
        }

        public function preRegistrationConfirmationMessage($userId) {
            $user = parent::dbget([
                'id' => $userId
            ]);

            if(!$user) {
                $this->addError("User not found.");
                return false;
            }
            $referrerModel = model('User_model');
            $referrer = $referrerModel->get_user($user->created_by);

            $url = URL.DS.'UserController/preRegisterConfirm/'.seal($userId);

            $message = <<<EOF
                <p>
                    Good day {$user->firstname} {$user->lastname}, 
                    <br/>We would like to notify you that {$referrer->firstname} {$referrer->lastname},
                    created you an account for our platform.
                </p>
                <p> 
                    If you are aware of this transaction please confirm the registration.
                    your credentials will be sent to you shortly. <br/>

                    <a href='{$url}' style='text-decoration:underline; 
                    cursor:pointer; padding:5px; margin-top:10px; display:block;'>Confirm registration. </a>
                </p>
                <p>
                    If you are not aware of and no consent of this transaction please ignore this
                 email, thank you.
                </p>
            EOF;

            return $message;
        }
    }