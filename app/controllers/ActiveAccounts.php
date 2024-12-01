<?php   

    class ActiveAccounts extends Controller
    {
        public function __construct()
        {
            $this->model = $this->model('ActiveAccountModel');
        }
        public function index()
        {
            $data = [
                'onlineusers' => $this->model->all()
            ];

            return $this->view('account/online' , $data);
        }
    }