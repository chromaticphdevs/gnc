<?php   

    class UserRegisterAttempt extends Controller
    {   
        public function __construct()
        {
            $this->model = $this->model('UserRegisterAttemptModel');
        }

        public function index()
        {
            $data = [
                'attempts' => $this->model->all()
            ];
            
            return $this->view('register_attempts/index' , $data);
        }

        public function create()
        {
            
        }

        public function store()
        {

        }

        public function show($id)
        {

        }
        public function edit($id)
        {

        }

        public function update()
        {

        }

        public function delete()
        {

        }
    }