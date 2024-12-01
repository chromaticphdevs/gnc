<?php

    use Services\UserService;
    load(['UserService'],APPROOT.DS.'services');

    class AccountProfile extends Controller
    {
        public function __construct()
        {
            $this->userModel = $this->model('User_model');
            $this->accountModel = $this->model('AccountModel');
            $this->governmentidModel = $this->model('GovernmentIdModel');
            $this->usersUploadedId   = $this->model('UserIdVerificationModel');
            $this->userMeta = model('UsermetaModel');
            $this->userBankModel = model('UserBankModel');
            $this->fnCashAdvanceModel = model('FNCashAdvanceModel');
            $this->userService = new UserService;
            authRequired();
        }

        /**
         * admin only
         * the passed parameter is the user to be opened
         */
        public function openAccount($userid) {
            if(isEqual(whoIs('type'), USER_TYPES['ADMIN'])) {
                $res = $this->userModel->sessionUpdate(unseal($userid));

                if(!$res) {
                    Flash::set($this->userModel->getErrorString(), 'danger');
                    return request()->return();
                } else {
                    Flash::set('Session Updated');
                }

                return redirect('AccountProfile/index');
            }
        }

        /** SHOW PROFILE */
        public function index()
        {
            if(empty(whoIs())) {
                return redirect('users/login');
            }
            /** GRAB THE FOLLOWING
             * PERSONAL INFORMATION
             * INCOME
             * SPONSORS AND UPLINES
             * BINARY DETAILS ( LEFT POINT  RIGHT POINT AND MAX PAIR)
            */

            $userid = Session::get('USERSESSION')['id'];

            /*If profile view is users logged in account*/
            $isUserLogged = true;

            if(isset($_GET['userid'])){
                $userid = $_GET['userid'];
                $isUserLogged = false;
            }

            $user = $this->userModel->get_user($userid);
            $sponsor = $this->userModel->get_user($user->direct_sponsor);
            $upline = $this->userModel->get_user($user->upline);

            $identifications = $this->governmentidModel->primary();
            $userIds         = $this->usersUploadedId->get_user_uploaded_id($userid);

            $heir_list = $this->accountModel->get_heir_list($userid);
            $addresses = $this->accountModel->get_addresses($userid);
            $loanProcessor = $this->userModel->get_user($user->loan_processor_id);

            $loan = $this->fnCashAdvanceModel->fetchOne([
                'where' => [
                    'cd.userid' => $userid,
                    'cd.status' => [
                        'condition' => 'in',
                        'value' => ['pending','released','approved']
                    ]
                ]
            ]); 

            $directs = $this->userModel->getDirects($userid);
            
            $userCreditLine = $this->userModel->db->query(
                "SELECT * FROM user_credit_line 
                    WHERE user_id = '{$userid}' "
            );
            $userCreditLine = $this->userModel->db->single();
            $data = [
                'personal' => $user,
                'heir_list' => $heir_list,
                'addresses' => $addresses,
                'sponsor'  => $sponsor,
                'upline'   => $upline,
                'loanProcessor' => $loanProcessor,
                'identifications' => $identifications,
                'userIds'         => $userIds,

                'isUserLogged' => $isUserLogged,
                'userMeta' => $this->userMeta->getByUser($userid),
                'user' => $this->userModel->getSingle([
                    'where' => [
                        'user.id' => $userid
                    ]
                ]),
                'userService' => $this->userService,
                'userBank'  => $this->userBankModel->get([
                    'where' => [
                        'ub.user_id' => $userid,
                        'ub.organization_id' => $this->userBankModel::GOTYME_ID
                    ]
                ]),

                'loan' => $loan,
                'directs' => $directs,
                'userCreditLine' => $userCreditLine
            ];

            return $this->view('accountprofile/index' , $data);
        }

        public function shipping_address()
        {
            $userid = Session::get('USERSESSION')['id'];

            $user = $this->userModel->get_user($userid);
            $addresses = $this->accountModel->get_addresses($userid);
            $active_cop =  $this->accountModel->get_active_address($userid);

            $data  = [
                'user_info' => $user,
                'addresses' => $addresses,
                'active_cop' => $active_cop
            ];
   
            return $this->view('accountprofile/shipping_address' , $data);
        }   

        public function update_email()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];
                $email = $_POST['email'];
               
                $result = $this->accountModel->update_email($userid, $email);

                if($result) 
                {
                    echo json_encode([
                        'status' => 'ok'
                    ]);
                }else{
                    echo json_encode([
                        'status' => 'failed'
                    ]);
                }
            }
        }




        public function update_address()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];
                $old_address = $_POST['old_address'];
                $address = $_POST['house_st'].", ".$_POST['brgy'].", ".$_POST['city'].", ".$_POST['province'].", ".$_POST['region'];

                $result = $this->accountModel->update_address($address, $userid, $old_address);

                if($result)
                {
                    Flash::set('Address Updated');
                    return request()->return();
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    return request()->return();
                }


            }else
            {
                if(isset($_GET['user'])){

                    $data  = [
                        'old_address' => $_GET['address']
                    ];

                    $this->view('accountprofile/edit_address',$data);

                }else{
                    redirect('AccountProfile');
                }

            }
        }

        public function update_main_address()
        {
            $result = $this->accountModel->update_main_address($_GET['id'], $_GET['userid']);
   
            if($result)
            {
                Flash::set('Address Is Now A Main Address');
                return request()->return();
            }else
            {
                Flash::set('something went wrong' , 'danger');
                return request()->return();
            }
        }

        public function remove_address($id)
        {
            $result = $this->accountModel->remove_address($id);

            if($result)
            {
                Flash::set('Address has been Removed');
                return request()->return();
            }else
            {
                Flash::set('something went wrong' , 'danger');
                return request()->return();
            }
        }

         public function add_address()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];
                $address = $_POST['house_st'].", ".$_POST['brgy'].", ".$_POST['city'].", ".$_POST['province'].", ".$_POST['region'];

                $result = $this->accountModel->add_address($userid, $address);

                if($result)
                {
                    Flash::set('Address is Added');
                    redirect('AccountProfile/shipping_address');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    redirect('AccountProfile/shipping_address');
                }


            }else
            {
                if($_GET['user']){

                    $this->view('accountprofile/add_address');

                }else{
                    redirect('AccountProfile');
                }

            }
        }

         public function add_cop()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];
                $address = $_POST['cop_address'];

                $result = $this->accountModel->add_cop($userid, $address);

                if($result)
                {
                    Flash::set('COP Address Added');
                    redirect('AccountProfile/shipping_address');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    redirect('AccountProfile/shipping_address');
                }
            }
        }


        public function add_heir()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];

                $result = $this->accountModel->add_heir( $_POST['firstname'], $_POST['middlename'], $_POST['lastname'],  $userid);

                if($result)
                {
                    Flash::set('Heir Added');
                    redirect('AccountProfile');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    redirect('AccountProfile');
                }


            }else
            {
                if($_GET['user']){

                    $this->view('accountprofile/add_heir');

                }else{
                    redirect('AccountProfile');
                }

            }
        }

        public function edit_heir()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];

                $result = $this->accountModel->edit_heir( $_POST['firstname'], $_POST['middlename'], $_POST['lastname'],$_POST['id'],  $userid);

                if($result)
                {
                    Flash::set('Heir Updated');
                    redirect('AccountProfile');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    redirect('AccountProfile');
                }


            }else
            {
                if($_GET['id']){

                    $this->view('accountprofile/edit_heir');

                }else{
                    redirect('AccountProfile');
                }

            }
        }

        public function delete_heir($id)
        {

                $result = $this->accountModel->delete_heir($id);

                if($result)
                {
                    Flash::set('Heir Deleted');
                    redirect('AccountProfile');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    redirect('AccountProfile');
                }

        }


        public function edit_contact()
        {
            $userid  = Session::get('USERSESSION')['id'];
            $account = $this->userModel->get_user($userid);

            if($this->request() === 'POST')
            {
                $errors = [];

                $email  = $_POST['email'];
                $mobile = $_POST['mobile'];
                $address = $_POST['address'];

                $isModified = false;
                /** Check if email is changed */
                if($mobile != $account->mobile) {
                    $isModified = true;

                    if($this->accountModel->getMobile($mobile)){
                        $errors [] = " Mobile Number {$mobile} already exists";
                    }
                }
                /** Check if email is changed */
                if($email != $account->email) {
                    $isModified = true;

                    if($this->accountModel->getEmail($email)){
                        $errors [] = " Email {$email} already taken";
                    }
                }

                if($address != $account->address) {
                    $isModified = true;
                }

                if(!empty($errors))
                {
                    Flash::set(implode(',' , $errors) , 'danger');

                    redirect('AccountProfile/edit_contact');
                    return;
                }else{

                    if($isModified) {
                        /** Check if mobile is changed */
                        $result = $this->accountModel->update_contact($_POST);

                        if($result) {
                            Flash::set("Contact Updated");
                            redirect('AccountProfile/edit_contact');

                            return;
                        }   
                    }else{
                        Flash::set("No Change found" , 'warning');
                        redirect('AccountProfile/edit_contact');
                        return;
                    }

                }


            }

            $data  = [
                'title' => 'Edit Contact Information',
                'account'  => $account
            ];

            $this->view('accountprofile/edit_contact' , $data);
        }


        public function edit_password()
        {
            $userid = whoIs('id');

            if($this->request() == 'POST')
            {
                /** VALIDATE PASSWORD */

                $password = $_POST['password'];

                if(strlen(str_replace(' ', '' , $password)) < 4) {
                    Flash::set("Password must atleast contains 4 characters" , 'warning');
                    return redirect("AccountProfile/edit_password");

                }
                $result = $this->accountModel->update_password($userid , $password);

                if($result) {
                    Flash::set("Password Updated");
                    return redirect("AccountProfile/edit_password");
                }
            }

            $account = $this->userModel->get_user($userid);

            $data = [
                'account' => $account ,
            ];

            $this->view('accountprofile/edit_password' , $data);
        }

        public function edit_profile()
        {
            /** UPDATE PROFILE */
            $userid = Session::get('USERSESSION')['id'];


            if($this->request() === 'POST')
            {
                $file = new File();

                $file->setFile($_FILES['profile'])
				->setPrefix('IMAGE')
				->setDIR(PATH_UPLOAD.DS.'profile')
				->upload();

				if(!empty($file->getErrors())){
					Flash::set($file->getErrors(), 'danger');
					redirect('AccountProfile/edit_profile');
					return;
				}

               $result = $this->accountModel->update_profile($userid , $file->getFileUploadName());

               if($result) {
                   Flash::set("Profile Updated");
                   redirect('AccountProfile/edit_profile');
                   return;
               }
            }

            $account = $this->userModel->get_user($userid);

            $data = [
                'account' => $account ,
            ];

            $this->view('accountprofile/edit_profile' , $data);
        }

        public function verify_account()
        {

        }

        public function show()
        {

        }


        public function select_cop() 
        {
            $result = $this->accountModel->select_cop(unseal($_GET['id']),$_GET['type'],unseal($_GET['user']));

            if($result)
            {
                Flash::set('Address is your now current COP');
                return request()->return();
            }else
            {
                Flash::set('something went wrong' , 'danger');
                return request()->return();
            }
        }

        public function directs($userId) {
            $data = [
                'directs' => $this->userModel->getDirects($userId)
            ];
            return $this->view('accountprofile/directs', $data);
        }

    }
