<?php 

    class RaffleRegistrationModel extends Base_model
    {
        public $table = 'raffle_registrations';


        public function __construct()
        {
            parent::__construct();

            $this->universal_code_model = model('UniversalCodeModel');
        }
        
        
        public function register($registrationData)
        {
            extract($registrationData);
            $code_used = $this->getCode($code);
            if ($code_used->is_used) {
                $this->addError("Code is already used.");
                return false;
            }
            $entry_id = parent::store([
                'full_name' => trim($full_name),
                'mobile_number' => trim($mobile_number),
                'address' => trim($address),
                'code_used' => $code_used->code,
                'city'  => $city,
                'barangay' => $barangay
            ]);

            if (!$entry_id) {
                $this->addError("Unable to create entry id");
                return false;
            }

            $this->universal_code_model->use_code($code_used->id);
            return $entry_id;
        }

        public function getCode( $code )
        {
            $code_used = $this->universal_code_model->dbget_single("code = '{$code}'");
            return $code_used;
        }


        public function getRegisteredUsers( $param )
        {
            $where = null;

            if( isset($param['where']) ) 
            {
                $whereParam = $param['where'];

                if( !empty( $whereParam['city']) ) {
                    $where['city'] = [
                        'condition' => 'like',
                        'value'     => "%{$whereParam['city']}%",
                        'concatinator' => ' AND '
                    ];
                }
                    

                if( !empty( $whereParam['barangay'] ) ) {
                    $where['barangay'] = [
                        'condition' => 'like',
                        'value'     => "%{$whereParam['barangay']}%"
                    ];
                }
            }

            if( !is_null($where) )
                $where = $this->dbParamsToCondition( $where );

            $registeredUsers = $this->db_get_results( $where );

            return $registeredUsers;
        }

        public function sendRegistrationEmail($email, $qrCodeId, $networkPayload = null) {

            $userModel = model('User_model');
            $user = $userModel->get_list(" WHERE email ='{$email}' limit 1");
            if ($user) {
                $user = $user[0];
                if(!isEqual($user->email, ['Edromero1472@yahoo.com','gonzalesmarkangeloph@gmail.com'])) {
                  $this->addError("Email already used {$email} use another valid email.");
                    return false;  
                }
            }

            $href = URL.'/RaffleRegistrationController/register?owned_qr='.$qrCodeId;

            $href .= "&isVerifiedEmail=".seal([
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

            _mail($email , "Email Verification From " . SITE_NAME , $body);
            return $body;
        }
    }