<?php

    class UserNumber extends Controller
    {
        public function __construct()
        {
            $this->userModel = $this->model('User_model');
            $this->UserNumberModel = $this->model('UserNumberModel');

            err_nosession();
        }


        public function index()
        {
            $userid = Session::get('USERSESSION')['id'];

            $user = $this->userModel->get_user($userid);
            $numbers = $this->UserNumberModel->get_numbers($userid);

            $data  = [
                        'user_info' => $user,
                        'numbers' => $numbers
                    ];

            return $this->view('user_numbers/index' , $data);
        }   

        public function send_code()
        {
            check_session();


            if($this->request() === 'POST')
            {
                $sent_code = Session::get('VERIFICATION');

                $entered_code = $_POST['code'];

                if(isEqual($sent_code['code'] ,  $entered_code))
                {
                    $result = $this->UserNumberModel->verify($sent_code['id']);
                    Flash::set("Number is Now Verified");
                    redirect('UserNumber/index');

                }else{
                    Flash::set("Verification Code is Incorrect" , 'danger');
                    return request()->return();
                }

            }else
            {

                $mobile = $_GET['number'];
                $id = unseal($_GET['id']);

                $code1=random_number();
                $code2=random_number();
                $code3=random_number();
                $OTP_code=substr($code1,0,2).''.substr($code2,0,2).''.substr($code3,0,2);

                $sendSmsData = [
                    'mobile_number' => $mobile,
                    'code'      => $OTP_code,
                    'category' => 'OTP'
                 ];

                 $sms = api_call('post','https://www.itextko.com/api/SmsRequestApi/create' , $sendSmsData);
                 $sms = json_decode($sms);

                if($sms)
                {
                     $sendSmsData = [
                        'id'   => $id,
                        'code' => $OTP_code
                     ];

                    Session::set('VERIFICATION' , $sendSmsData);

                    redirect('UserNumber/verification_view');
                }else
                {
                    Flash::set("Error PLease Try Again" , 'danger');
                    redirect('UserNumber/index');
                }
            }
        }   

        public function verification_view()
        {
                return $this->view('user_numbers/verification');
        }

        public function update_number()
        {
            if($this->request() === 'POST')
            {
                $userid = $_POST['userid'];
                $old_number = $_POST['old_number'];
                $number = $_POST['mobile'];

                $result = $this->UserNumberModel->update_number($number, $userid, $old_number);

                if($result)
                {
                    Flash::set('Number Updated');
                    redirect('UserNumber');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    return request()->return();
                }


            }else
            {
                if(isset($_GET['user'])){

                    $data  = [
                        'old_number' => $_GET['number']
                    ];

                    $this->view('user_numbers/update_number',$data);

                }else{
                    redirect('UserNumber');
                }

            }
        }

        public function update_main_number()
        {
            $result = $this->UserNumberModel->update_main_number(unseal($_GET['id']), unseal($_GET['userid']));
   
            if($result)
            {
                Flash::set('Number is now a Primary Number');
                return request()->return();
            }else
            {
                Flash::set('something went wrong' , 'danger');
                return request()->return();
            }
        }

        public function remove_number($id)
        {
            $result = $this->UserNumberModel->remove_number(unseal($id));

            if($result)
            {
                Flash::set('Number has been Removed');
                return request()->return();
            }else
            {
                Flash::set('something went wrong' , 'danger');
                return request()->return();
            }
        }

         public function add_number()
        {
            if($this->request() === 'POST')
            {
                $userid = unseal($_POST['userid']);
                $number = $_POST['number'];

                $check_number =  $this->UserNumberModel->check_number($number);

                if($check_number)
                {
                  
                    Flash::set('Mobile number Already Used','danger');
                    return request()->return();
                }

                $result = $this->UserNumberModel->add_number($userid, $number);

                if($result)
                {
                    Flash::set('Mobile number Added!');
                    redirect('UserNumber/index');
                }else
                {
                    Flash::set('something went wrong' , 'danger');
                    redirect('UserNumber/index');
                }


            }else
            {
                if($_GET['user']){

                    $this->view('user_numbers/add_number');

                }else{
                    redirect('UserNumber');
                }

            }
        }



    }
