<?php   

    class RegisterVerification extends Controller
    {   

        public function __construct()
        {
            $this->model = $this->model('RegisterVerificationModel');
            $this->user      = $this->model('User_model');
            $this->register = $this->model('RegistrationModel');
        }

        public function index()
        {

        }

        public function show($verificationid)
        {
            $verificationid = unseal($verificationid);
            $via            = request()->input('via');
            $verification = $this->model->get($verificationid);
            $user         = $this->register->get($verification->userid);

            $data = [
                'via' => strtoupper($via) ,
                'verificationid' => $verificationid,
                'verification' => $verification,
                'user'    => $user
            ];

            return $this->view('registration/verify' , $data);
        }


        public function update()
        {
            $id   = request()->input('id');//verification id
            $code = request()->input('code');

            $verification = $this->model->get($id);
            $userid = $verification->userid;
            /** MATCH CODE */

            if($code === $verification->code)
            {
               $this->model->update([
                   'is_used' => TRUE 
               ] , $id);

               $this->register->update([
                   'mobile_verify' => 'verified'
               ], $id);

               Flash::set("Verification Success!");

               /** LOGIN USER */

                if($this->user->sessionUpdate($userid))
                    return redirect("Users");
            
                return redirect("Users/login");
               
            }else{
                
                Flash::set("Code Unmatched" , 'danger');

                return validationFailed();
            }
        }
    }