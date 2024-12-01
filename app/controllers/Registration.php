<?php   

    class Registration extends Controller
    {

        public function __construct()
        {   
            /** NEW MODELS */
            $this->model = $this->model('RegistrationModel');
            $this->preRegisterModel = $this->model('PreRegisterModel');
            $this->userRegisterAttempt = $this->model('userRegisterAttemptModel');
            $this->verification  = $this->model('RegisterVerificationModel');

            $this->binaryModel = $this->model('Binary_model');
            $this->userModel = $this->model('LDUserModel');
        }

        public function create()
        {
            /** STORE ERRORS */
            $errors = [];

            /** CHECK URL */
            $sponsor   =  request()->input('sponsor');
            $position  =  request()->input('position');

            if(is_null($sponsor) || is_null($position))
            {
                /*** POST ERROR **/
                Flash::set("Invalid URL");
                die(" INVALID URL ");
            }

            $branchList = $this->userModel->branch_list();
            $newBranchList = []; /**RE-FORMAT BRANCHLIST TO FIT ON THE FORM::SELECT HLPER */

            foreach($branchList as $key => $row) {
                $newBranchList[$row->id] = $row->name;
            };

            $data = [
                'title' => 'Register',
                'sponsor' => $sponsor , 
                'position' => $position,
                'branchList' =>  $newBranchList
            ];

            return $this->view('registration/create'  , $data);
        }

        public function store()
        {

            if($this->request() != 'POST') {
                die("INVALID REQUEST METHOD");
            }
            /** STORE TO PRE REGISTERED USER */
            $inputs = request()->inputs();

            $inputs['sponsor'] = unseal($inputs['sponsor']);

            $password = password_hash('123456' , PASSWORD_DEFAULT);

            $address  = $this->model->formatAddress(
                ...[
                    $inputs['housenumber'],
                    $inputs['barangay'],
                    $inputs['city'],
                    $inputs['province'],
                ]
            );
            /** VALIDATE MOBILE */
            $mobile = request()->input('mobile');
            if(!validate_mobile($mobile)){
                $errors [] = " Invalid Phone Number";
            }else{
                /** CHECK IF MOBILE EXISTS */
                if($this->model->getMobile($mobile)){
                    $errors [] = " Mobile Number Already Exists ";
                }
            }

            /** VALIDATE EMAIL */
            $email = request()->input('email');
            if(!validate_email($email)){
                $errors [] = " Invalid Email";
            }else{
                /** CHECK IF EMAIL EXISTS */
                if($this->model->getEmail($email)){
                    $errors [] = " Email Already Exists ";
                }
            }

            /** VALIDATE USERNAME */
            $username = request()->input('username');
            if($this->model->getUsername($username)){
                $errors [] = " Username Already Exists ";
            }
            /** CHECKS */
            if(!empty($errors)) {
                Flash::set(implode(',' , $errors) , 'danger');
                return validationFailed();
            }

            $firstname = request()->input('firstname');
            $lastname  = request()->input('lastname');
            /** CHECK IF PERSON ALREADY HAS DATA ON OUR SYSTEM */
            $personExists = $this->model->fullname(
                ...[
                    $firstname,
                    $lastname
                ]
            );

            $fullname = $firstname . ' ' .$lastname;

            if($personExists){
                Flash::set("You already have an account with us" , 'warning');

                $registerInstance = $this->userRegisterAttempt->fullname($fullname);
                /** SAVE ONLYT 3 TIMESs */
                if(count($registerInstance) < 3) {
                    /** STORE TO ATTEMP REGISTER */
                    $this->userRegisterAttempt->store([
                        'fullname' => $fullname,
                        'email'    => $email,
                        'mobile'   => $mobile
                    ]);
                }

                return validationFailed();
            }

            $addToPregister = $this->store_to_pre_register($password , $address);

            $addToPregister = true;

            if(!$addToPregister)
            {
                Flash::set("Registration Failed!");

                return validationFailed();
            }

            /** INSERT TO USER */

            /** CONNECT TO UPLINE */
            $upline = $this->binaryModel->outDownline( $inputs['sponsor'], $inputs['position']);

            $addtoUsers  = [
                    'firstname'      => $inputs['firstname'] , 
                    'middlename'     => $inputs['middlename'] , 
                    'lastname'       => $inputs['lastname'],
                    'username'       => $inputs['username'],
                    'password'       => $password,
                    'direct_sponsor' => $inputs['sponsor'],
                    'upline'         => $upline,
                    'L_R'            => $inputs['position'],
                    'new_upline'     => $upline,
                    'user_type'      => '2',
                    'email'          => $inputs['email'],
                    'address'        => $address,
                    'mobile'         => $inputs['mobile'],
                    'branchId'       => $inputs['branch'],
                    'religion_id'    => $inputs['religion'],
                    'mobile_verify'  => 'verified',
                    'account_tag'    => 'main_account'
            ];
            

            $userid = $this->model->store($addtoUsers);

            if($userid) {

                $verificationCode = $this->verification->createCode();

                /** STORE VERIFICATION CODE */
                $codeid = $this->verification->store([
                    'userid' => $userid,
                    'code'   => $verificationCode
                ]);

                $messageLeft = itexmoCurl()->MessagesLeft;

                $sent = $this->verification->send(
                    ...[
                        $messageLeft , $verificationCode, [
                            'username' => $username , 
                            'email'    => $email,
                            'mobile'   => $mobile,
                            'fullname' => $fullname,
                            'userid'   => $userid
                        ]
                    ]
                );

                $codeid = seal($codeid);
                /** CHECK SENT VIA */
                if($sent == 'sms')
                    return redirect("RegisterVerification/show/{$codeid}?&via=sms");
                return redirect("RegisterVerification/show/{$codeid}?&via=email");
            }else{
                echo "HINDI";
            }
            

        }

        private function store_to_pre_register($password , $address)
        {
            $inputs = request()->inputs();
            $address = ''; 
            $password = '';

            /**
             * religion_id Should be religion only
             */
            $pregisterArray = [
                'firstname' => $inputs['firstname'],
                'middlename' => $inputs['middlename'],
                'lastname' => $inputs['lastname'],
                'phone' => $inputs['mobile'],
                'address' => $address,
                'email' => $inputs['email'],
                'username' => $inputs['username'],
                'password' => $password,
                'referral_id' => $inputs['sponsor'],
                'note'       => 'Registered Via Online',
                'religion_id' => $inputs['religion']
            ];

            return $this->preRegisterModel->store($pregisterArray);
        }

        
    }