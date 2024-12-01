<?php 

    class UserController extends Controller
    {
        private $userModel;

        public function __construct()
        {
            parent::__construct();
            $this->userModel = model('User_model');
            $this->preRegisterModel = model('PreRegisterModel');
        }

        /**
         * Create new user
         * method is used for members want to add their new user
         */
        public function create() {
            
        }

        /**
         * used to create users 
         * which are pre-registererd for referral
         */
        public function preRegister() {

            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();
                
                $userId = $this->preRegisterModel->createReferral([
                    'firstname' => $post['firstname'],
                    'lastname' => $post['lastname'],
                    'email' => $post['email'],
                    'phone' => $post['mobile'],
                    'address' => $post['address'],
                    'created_by' => whoIs('id')
                ]);

                if($userId) {
                    //send email to the recipient using the email provided.
                    $body = $this->preRegisterModel->preRegistrationConfirmationMessage($userId);
                    _mail($post['email'], 'Request to create your account', $body);
                    Flash::set("Account registration request has been sent to your refferral");
                    return redirect('UserDirectsponsor/index');
                } else {
                    Flash::set($this->preRegisterModel->getErrorString(), 'danger');
                    return request()->return();
                }

            }
            $data = [
                'whoIs' => whoIs(),
                'navigationHelper' => $this->navigationHelper
            ];
            
            return $this->view('user/pre_register', $data);
        }

        /**
         * confirm by the user
         */
        public function preRegisterConfirm($preRegistrationIdSealed) {
            $preRegisterId = unseal($preRegistrationIdSealed);
            $preRegisteredUser = $this->preRegisterModel->dbget([
                'id' => $preRegisterId
            ]);

            if($preRegisteredUser) {
                $userId = $this->preRegisterModel->moveToUser($preRegisterId);
                if($userId) {
                    $body = "
                        <h3> Welcome on board {$preRegisteredUser->firstname}</h3>
                        <p> 
                            Thank you for registering to our platform, here is your credentials.
                            <strong> username : {$preRegisteredUser->username} </strong>
                            <strong> username : {$preRegisteredUser->password}</strong>
                        </p>
                    ";

                    Flash::set("Credentials has been sent to {$preRegisteredUser->email}");
                    _mail($preRegisteredUser->email, 'Credentials', $body);
                    /**
                     * login here
                     */
                     $this->userModel->sessionUpdate($userId);
                    return redirect('/UserIdVerification/upload_id_html');
                } else {
                    Flash::set($this->preRegisterModel->getErrorString(), 'danger');
                    return redirect('/users/login');
                }
            }
        }

        /**
         * currently disabled
         */
        public function changeUpline() {

        }

        public function changeSponsor($userId) {
            if(whoIs('type') != 1) {
                Flash::set('Invalid Operation');
                return request()->return();
            }
            $req = request()->inputs();

            $user = $this->userModel->getSingle([
                'where' => [
                    'user.id' => $userId
                ]
            ]);

            $data = [
                'user' => $user,
                'id' => $user->id
            ];

            if(isSubmitted()) {
                $post = request()->posts();

                if(!empty($post['change_sponsor_search'])) {
                    $newSponsor = $this->userModel->getSingle([
                        'where' => [
                            'user.username' => $post['username']
                        ]
                    ]);
    
                    if(($user->id == $newSponsor->id) || ($user->direct_sponsor == $newSponsor->id)) {
                        Flash::set('Invalid Operation');
                        return request()->return();
                    }
    
                    $data['newSponsor'] = $newSponsor;
                }

                if(!empty($post['change_sponsor_apply'])) {
                    $isOkay = $this->userModel->dbupdate([
                        'direct_sponsor' => $post['new_sponsor']
                    ], $post['userid']);

                    if($isOkay) {
                        Flash::set("Direct Sponsor updated");
                        return redirect('AccountProfile/index?userid='.$post['userid']);
                    } else {
                        Flash::set('something went wrong', 'danger');
                        return request()->return();
                    }
                }
            }
            return $this->view('user_v2/change_sponsor', $data);
        }

        public function editEsig() {
            return $this->view('user_v2/edit_esig');
        }

        public function editVideo() {
            if(isSubmitted()) {
                $post = request()->posts();
                $upload = upload_file('file', BASE_DIR.DS.'public/assets/user_videos');
                
                if(isEqual($upload['status'], 'success')) {
                    $this->userModel->dbupdate([
                        'video_file' => $upload['result']['name']
                    ], $post['user_id']);

                    Flash::set("Video Uploaded");
                    return redirect('AccountProfile');
                } else {
                    Flash::set("Something went wrong", 'danger');
                    return request()->return();
                }
            }
            $data = [
                'user' => whoIs()
            ];
            return $this->view('user_v2/edit_video', $data);
        }

        public function removeVideo($id) {
            $this->userModel->dbupdate([
                'video_file' => ''
            ], $id);

            return redirect('AccountProfile/');
        }

        public function referralRegistration() {
            $req = request()->inputs();
            $data = [];

            if(isSubmitted()) {
                $post = request()->posts();
                if(!empty($post['verify_email'])) {
                    $email = trim($post['email']);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        Flash::set('Invalid Email', 'danger');
                        return request()->return();
                    } else {
                        //check if email already in used.
                        $emailExist = $this->userModel->getSingle([
                            'where' => [
                                'user.email' => $email
                            ]
                        ]);

                        if($emailExist && !isEqual($email, $this->userModel::BYPASS_EMAIL)) {
                            Flash::set("Email '{$email}' already exists.", 'danger');
                            return request()->return();
                        }
                    }
                    //check loan processor
                    $networkPayload = unseal($req['networkPayload']);

                    if(!empty($post['loan_processor'])) {
                        $loanProcessor = $this->userModel->getSingle([
                            'where' => [
                                'user.username' => $post['loan_processor']
                            ]
                        ]);

                        if($loanProcessor) {
                            $networkPayload['loan_processor_id'] = $loanProcessor->id;
                        } else {
                            Flash::set("Loan Processor Not found", 'danger');
                            return request()->return();
                        }
                    }

                    $networkPayload = seal($networkPayload);
                    $resp = $this->sendEmailVerification($post['email'], $networkPayload);
                    if(!$resp) {
                        return request()->return();
                    } else {
                        Flash::set("Check your email, confirm registration and discover Breakthrough-e");
                        return $this->registrationSuccessPage();
                        return redirect('users/login');
                    }
                }

                if(!empty($post['register_user'])) {
                    $response = $this->userModel->register($post);
                    if($response) {
                        $this->userModel->sessionUpdate($response);
                    }

                    echo json_encode([
                        'status' => $response,
                        'message' => $this->userModel->getErrors() ?? $this->userModel->getMessages(),
                        'data' => [
                            'userId' => $response
                        ]
                    ]);
                    return;
                }
            }

            if(!empty($req['isVerifiedEmail']) && !empty($req['networkPayload'])) {
                //check value
                $validatedEmailValue = unseal($req['isVerifiedEmail']);
                $networkPayloadValue = unseal($req['networkPayload']);

                $data = [
                    'networkPayload' => $networkPayloadValue,
                    'validatedEmailValue' => $validatedEmailValue
                ];

                $data['referral'] = $this->userModel->get_user($networkPayloadValue['user_id']);
                $data['upline'] = $this->userModel->get_user($networkPayloadValue['upline']);

                if(!empty($networkPayloadValue['loan_processor_id'])) {
                    $data['loanProcessor'] = $this->userModel->get_user($networkPayloadValue['loan_processor_id']);
                }
                
                //check if email is already in used
                if(!isEqual($validatedEmailValue['email'], $this->userModel::BYPASS_EMAIL)) {
                    $user = $this->userModel->getSingle([
                        'where' => [
                            'user.email' => $validatedEmailValue['email']
                        ]
                    ]);

                    if($user) {
                        Flash::set("Invalid Registration link, please renew");
                        return redirect('Users/login');
                    }
                }
                
            }

            return $this->view('user_v2/referral_registration', $data);
        }

        /**
         * returns text data
         */
        public function referralLink() {
            $req = request()->inputs();
            $q = $req['q'];

            return redirect("UserController/referralRegistration?networkPayload={$q}");
        }

        public function edit($id) {
            if(!isEqual(whoIs('type'), USER_TYPES['ADMIN'])) {
                Flash::set("unauthorized access");
                return redirect('AccountProfile');
            }
            $id = unseal($id);
            if(isSubmitted()) {
                $errors = [];
                $post = request()->posts();
                if(isset($post['btn_general'])) {
                    $this->userModel->dbupdate([
                        'firstname' => $post['firstname'],
                        'lastname' => $post['lastname'],
                    ], $id);

                    Flash::set("General Info updated");
                }

                if(isset($post['btn_secondary'])) {
                    /**
                     * check email
                     * mobile and username
                     */

                    $checkEmail = $this->userModel->getSingle([
                        'where' => [
                            'user.email' => str_escape($post['email']),
                            'user.id' => [
                                'condition' => 'not equal',
                                'value' => $id
                            ]
                        ]
                    ]);
                    
                    $checkMobile = $this->userModel->getSingle([
                        'where' => [
                            'user.mobile' => str_escape($post['mobile']),
                            'user.id' => [
                                'condition' => 'not equal',
                                'value' => $id
                            ]
                        ]
                    ]);
                    if($checkEmail) {
                        array_push($errors, "Email '{$post['email']}' is already in use");
                    }

                    if($checkMobile) {
                        array_push($errors, "Mobile '{$post['mobile']}' is already in use");
                    }

                    if(!empty($errors)) {
                        Flash::set(implode(',', $errors), 'danger');
                    } else {
                        $this->userModel->dbupdate([
                            'email' => $post['email'],
                            'mobile' => $post['mobile'],
                            'address' => $post['address'],
                        ], $id);

                        Flash::set("Secondary Info  Updated");
                    }
                }

                if(isset($post['btn_sponsor'])) {
                    //check if exists
                    $checkSponsor = $this->userModel->getSingle([
                        'where' => [
                            'user.username' => str_escape($post['direct_sponsor'])
                        ]
                    ]);

                    if($checkSponsor)  {
                        $this->userModel->dbupdate([
                            'direct_sponsor' => $checkSponsor->id
                        ], $id);
                    } else {
                        Flash::set(WordLib::get('directSponsor') . ' Not Found ' , 'danger');
                    }
                }

                if(isset($post['btn_connection'])) {
                    //check if exists
                    $checkSponsor = $this->userModel->getSingle([
                        'where' => [
                            'user.username' => str_escape($post['upline'])
                        ]
                    ]);

                    if($checkSponsor)  {
                        $this->userModel->dbupdate([
                            'upline' => $checkSponsor->id
                        ], $id);
                    }else {
                        Flash::set(WordLib::get('upline') . ' Not Found ' , 'danger');
                    }
                }
                if(isset($post['loan_processor'])) {
                    //check if exists
                    $loanProcessor = $this->userModel->getSingle([
                        'where' => [
                            'user.username' => str_escape($post['loan_processor'])
                        ]
                    ]);

                    if($loanProcessor)  {
                        $this->userModel->dbupdate([
                            'loan_processor_id' => $loanProcessor->id
                        ], $id);
                    }else {
                        Flash::set(WordLib::get('loanProcessor') . ' Not Found ' , 'danger');
                    }
                }

                if(isset($post['btn_change_password'])) {
                    $resp = $this->userModel->update_password($id, $post['password']);
                    if(!$resp) {
                        Flash::set($this->userModel->getErrorString(), 'danger');
                        return request()->return();
                    } else {
                        Flash::set("user password has been updated");
                        return redirect('AccountProfile/index?userid=' . $id);
                    }
                }

                if(isset($post['btn_change_username'])) {
                    $resp = $this->userModel->changeusername($id, $post['username']);
                    if(!$resp) {
                        Flash::set($this->userModel->getErrorString(), 'danger');
                        return request()->return();
                    } else {
                        Flash::set("account username has been updated");
                        return redirect('AccountProfile/index?userid=' . $id);
                    }
                }
                return redirect('UserController/edit/'.seal($id));
            }
            
            $user = $this->userModel->getSingle([
                'where' => [
                    'user.id' => $id
                ]
            ]);

            $loanProcessor = $this->userModel->getSingle([
                'where' => [
                    'user.id' => $user->loan_processor_id
                ]
            ]);

            $data = [
                'user' => $user,
                'loanProcessor' => $loanProcessor,
                'navigationHelper' => $this->navigationHelper
            ];

            return $this->view('user_v2/edit', $data);
        }

        private function sendEmailVerification($email, $networkPayload = null) {
            $userModel = model('User_model');
            $user = $userModel->get_list(" WHERE email ='{$email}' limit 1");
            if ($user) {
                $user = $user[0];
                if(!isEqual($user->email, $this->userModel::BYPASS_EMAIL)) {
                    Flash::set("Email already in use {$user->email}");
                    return false;  
                }
            }

            $href = URL.'/UserController/referralRegistration';

            $href .= "?isVerifiedEmail=".seal([
                'email' => $email,
                'date' => today()
            ]);

            if(!empty($networkPayload)) {
                $href .= "&networkPayload={$networkPayload}";
            }

            $link = "<a href='{$href}'>Continue Registration</a>";
            
            $body = "<p>
                This is to confirm that you're email is valid.
                click this {$link} to continue your registration.
            </p>";

            $emailChunk = explode('@', $email);
            $domainName = $emailChunk[1];

            if(isEqual(URL, 'http://dev.bk_mlm') || isEqual($domainName, $this->userModel::BYPASS_DOMAIN_NAME)) {
                echo $body;
                die();
            }

            _mail($email , "Email Verification From " . SITE_NAME , $body);
            return true;
        }

        private function registrationSuccessPage() {
            return $this->view('user_v2/registration_success');
        }
    }