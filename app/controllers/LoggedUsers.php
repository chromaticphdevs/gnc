<?php   
    class LoggedUsers extends Controller
    {
        public function __construct()
        {
            $this->timeLog = model('TimelogModel');
        }

        public function index()
        {

            $activeUsers = $this->timeLog->getActive();
            return $this->view('logged_users/index' , compact('activeUsers'));
        }

        public function address()
        {
            $activeUsers = $this->timeLog->getActive();
            return $this->view('logged_users/address' , compact('activeUsers'));
        }

        public function active_staff_api()
        {
            $activeUsers = $this->timeLog->getActive();
            ee(api_response($activeUsers, true));
        }

        public function all_staff_api()
        {
            $activeUsers = $this->timeLog->getAllUser();
            ee(api_response($activeUsers, true));
        }

    }