<?php   

    class API_GSM_SMS extends Controller
    {

        public function __construct()
        {
            $this->gsm = $this->model('GsmArduinoModel');
        }

        public function index()
        {
            $data = request()->inputs();

            if(!isset($data['mobileNumber'] , $data['code']))
            {
                ee(api_response('mobileNumber and code must be set!' , false));
            }else
            {
                $result = $this->gsm->sendSMS($data);

                if($result) {
                    ee(api_response('sucess' , true));
                }else{
                    ee(api_response('failed' , false));
                }
            }
        }
    }