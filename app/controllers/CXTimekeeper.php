<?php   

    class CXTimekeeper extends Controller
    {

        public function __construct()
        {

            /*
            *Check if cookie is set
            *Check if session is set
            */

            $this->endpoint = 'https://app.breakthrough-e.com';

            // die("TIMEKEEPING IS UNDER MAINTENANCE THIS WONT TAKE A WHILE.. THANK YOU");
            // $this->endpoint = 'http://dev.bktktool';

            $this->tkapp = model('TimekeepingAppModel');
        }

        public function cx_clockIn($userToken)
        {
            $endpoint = $this->endpoint;

            $Data = [
                'userToken' => $userToken
            ];


            $requestAccess = api_call('POST' , "{$endpoint}/api/Timekeeping/cx_clockIn/",$Data);

            $response = json_decode($requestAccess);

            dump($response);
            if($response->status)
            {
                Flash::set('OK' , 'danger');
                return request()->return();
            }else{
                Flash::set($response->data , 'danger');
                return request()->return();
            }
        }  

       
    }