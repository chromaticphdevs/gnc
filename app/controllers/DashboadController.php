<?php 

    class DashboardController extends Controller
    {
        
        public function __construct()
        {
            parent::__construct();
            $this->auth = whoIs();
        }

        public function index()
        {
            $data = [
                'user' => $this->auth
            ];
            return $this->view('dashboard/index' , $data);
        }
    }