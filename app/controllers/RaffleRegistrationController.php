<?php   

    class RaffleRegistrationController extends Controller
    {

        public function __construct()
        {
            parent::__construct();

            $this->raffle_registration_model = model('RaffleRegistrationModel');
            $this->user_owned_qr = model('UserOwnedQRModel');
            $this->user_model = model('User_model');
            $this->binaryModel = model('BinaryTransactionModel');
        }

        public function index()
        {
            $request = request()->inputs();

            if( isset($request['btnSearch']) )
            {
                $users = $this->raffle_registration_model->getRegisteredUsers([
                    'where' =>  $request
                ]);
            }else{
                $users = $this->raffle_registration_model->dbget_assoc('full_name');
            }
            $data = [
                'title' => 'Registered Users',
                'users' => $users
            ];

            return $this->view('raffle_registration/index' , $data);
        }

        public function register()
        {
            $whoIs = whoIs();

            if($this->request() === 'POST') {
                $post = request()->inputs();

                if (isset($_POST['verify_email'])) {
                    $result = $this->raffle_registration_model->sendRegistrationEmail($post['email'],$post['owned_qr'], $post['networkPayload'] ?? null);
                    if(!$result) {
                        Flash::set($this->raffle_registration_model->getErrorString(),'danger');
                        return request()->return();
                    } else {
                        Flash::set("If you're email is valid, you will recieve an email with a link,
                        click that link and complete your registration, you can close this page now." , 'warning');
                    }
                }

                if (isset($_POST['register'])) {
                    $res = $this->raffle_registration_model->register([
                        'mobile_number' => $_POST['mobile_number'],
                        'full_name' => $_POST['full_name'],
                        'address' => $_POST['address'],
                        'code' => $_POST['code'],
                        'city' => $_POST['city'],
                        'barangay' => $_POST['barangay'],
                    ]);
    
                    if(!$res) {
                        Flash::set( $this->raffle_registration_model->getErrorString() , 'danger');
                        return request()->return();
                    }

                    Flash::set("Registered");

                    return $this->view('raffle_registration/success');
    
                }

                if (isset($_POST['collect'])) {
                    $res = $this->user_owned_qr->collect([
                        'direct_id' => $post['direct_id'],
                        'upline_id' => $post['upline_id'],
                        'downline_position' => $post['position'],
                        'qr_id' => $post['code_id'],
                        'user_id' => $post['user_id']
                    ]);
                    if ($res) {
                        Flash::set($this->user_owned_qr->getMessageString());
                        return redirect('UserOwnedQRController/index');
                    }
                    Flash::set($this->user_owned_qr->getErrorString() , 'danger');
                    return request()->return();
                }

                /**
                 * REGISTER USING SOME-ELSES 
                 * QR-CODE
                 */
                if(isset($_POST['owned_qr_register'])) {
                   $errors = [];
                   //check upline and direct sponsor
                   $upline = $this->user_model->get_user($post['upline']);
                   $direct = $this->user_model->get_user($post['direct_sponsor']);

                   if (!$upline) {
                       $error [] = "UPLINE NOT FOUND";
                   }
                   if (!$direct) {
                       $error [] = "DIRECT SPONSOR NOT FOUND";
                   }

                   $user_id =  $this->user_model->register($post);

                   if(!$user_id) {
                        Flash::set($this->user_model->getErrorString(), 'danger');
                        return request()->return();
                   }

                    if ($user_id) {
                       $this->user_owned_qr->use($post['qr_id'], $user_id);
                       Flash::set($this->user_model->getMessageString());
                        if (isset($_GET['networkPayload'])) {
                            return redirect('geneology/binary/'.$post['upline']);
                        } else {
                            return $this->view('raffle_registration/success');
                        }
                    } else {
                       Flash::set($this->user_model->getErrorString());
                       return request()->return();
                   }                   
                }
                
                /**
                 * Register using qr
                 * this action is for qr that
                 * is not owned by anyone
                 */
                if(isset($post['qr_register']) )
                {  
                    $errors = [];
                    /**
                     * SEARCH FOR UPLINE
                     * SEARCH FOR SPONSOR
                     */
                    $upline_username = trim($post['upline']);
                    $sponsor_username = trim($post['direct_sponsor']);

                    $upline = $this->user_model->get_by_username( $upline_username );
                    $direct = $this->user_model->get_by_username( $sponsor_username );
                    
                    if( !$upline ) 
                        $errors [] = "Upline username does not exists {$upline_username}";

                    if( !$direct ) 
                        $errors [] = "Direct Sponsor username does not exists {$sponsor_username}";

                    if( !empty($errors) ) 
                    {
                        Flash::set( implode(',' , $errors) , 'danger');
                        return request()->return();
                    }

                    $post['upline'] = $upline->id;
                    $post['direct_sponsor'] = $direct->id;

                    $user_id = $this->user_model->register($post);

                    if($user_id) 
                    {
                        Flash::set("Succesfully registered , you now logged in your account.");
                        return redirect('users/login');
                    }else{
                        Flash::set($this->user_model->getErrorString(), 'danger');
                        return request()->return();
                    }
                }

            }

            $data = [
                'title' => 'Registter',
            ];

            if(isset($_GET['owned_qr']))
            {
                //check if code is already owned by the user
                $owned_code = $this->user_owned_qr->get($_GET['owned_qr']);

                if( $owned_code->is_used ) {
                    Flash::set("Code already used");
                    return $this->view('raffle_registration/already_used');
                }

                $data['owned_code'] = $owned_code;
                $data['code'] = $owned_code->code;

                if(isset($_GET['networkPayload'])) {
                    $networkPaylaod = unseal($_GET['networkPayload']);
                    $user = $this->user_model->get_user($networkPaylaod['upline']);

                    $data['upline'] = [
                        'name' => $user->fullname,
                        'id' => $user->id
                    ];
                    $data['position'] = $networkPaylaod['position'];
                } else {
                    
                    $data['upline'] = [
                        'name' => $owned_code->upline_name,
                        'id' => $owned_code->id
                    ];

                    $data['position'] = $owned_code->downline_position;
                }

                return $this->view('raffle_registration/register_qr_owned' , $data);
            }

            $code = $_GET['code'] ?? '';

            if(empty($code))
                echo die("Invalid Request");

            $code_unsealed = unseal($code);
            
            $code_used = $this->raffle_registration_model->getCode( $code_unsealed );
            
            if( $code_used->is_used ) 
                return $this->view('raffle_registration/already_used');

            $data = [
                'title' => 'Register',
                'code'  => $code_used->code,
                'code_instance' => $code_used,
                'whoIs' => $whoIs
            ];

            if( isset($_GET['collect']) )
            {
                if( empty($whoIs) )
                {
                    Flash::set("You can only collect qr if you breakthrough member" , 'danger');
                    return redirect('users/login');
                }

                $data['user'] = $whoIs;
                return $this->view('raffle_registration/collect' , $data);
            }

            return $this->view('raffle_registration/register_qr' , $data);
        }

        public function referralRegistration() {

        }

        public function openQR() {
            return $this->view('raffle_registration/open_camera');
        }

        public function registerNetwork() {
            $q = request()->input('q');

            if(empty($q)) {
                Flash::set("Invalid Request");
                return redirect('Pages');
            }
            $request = unseal($q);
            
            $qr_codes = $this->user_owned_qr->getAll([
                'where' => [
                    'user_id' => $request['user_id'],
                    'uoq.is_used' => false
                ],
                'order' => 'uoq.id asc'
            ]);

            if(empty($qr_codes)) {
                Flash::set("Not enough qr-codes to add member to your selected network.");
                return request()->return();
            }
            Flash::set("Verify your member email.");
            $qr = $qr_codes[0];

            return redirect("RaffleRegistrationController/register?owned_qr={$qr->id}&networkPayload={$q}");
        }
    }