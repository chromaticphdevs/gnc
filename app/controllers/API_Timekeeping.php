<?php   

    class API_Timekeeping extends Controller
    {
        public function __construct()
        {
            $this->tktool = model('TimekeepingModel');

            $this->domain = 1;
        }

        public function index()
        {
            $user = Auth::get();

            $tkData = $this->tktool->getByUser($user['id']);

            $userData = [
                'id' => $tkData->id,
                'secret_key' => $tkData->secret_key,
                'firstname'  => $tkData->userData->firstname,
                'lastname'   => $tkData->userData->lastname,
                'domain_id'     => $this->domain
            ]; 

            $userEncoded = seal( json_encode($userData) );

            $results = $this->tktool->apiTimesheets($tkData->user_id , $this->domain);

            $data = compact([
                'userData',
                'userEncoded',
                'results',
                'tkData'
            ]);

            return $this->view('tk_tool/index' , $data);
        }

        public function register()
        {
            $post = request()->inputs();

            $userData = unseal($post['userData']);

            $returnData = $this->tktool->apiRegister($userData , $this->domain);

            Flash::set($returnData->data);

            return request()->return();
        }

        public function clockIn()
        {
            $post = request()->inputs();

            $secretKey = $post['secret_key'];

            $result = $this->tktool->apiClockIn($secretKey , $this->domain);

            Flash::set($result->data);
            return request()->return();
        }


        public function cloutOut()
        {
            $post = request()->inputs();

            $result = $this->tktool->apiClockOut($post['secret_key'] , $post['domain_id']);

            Flash::set($result->data);

            return request()->return();
        }
    }