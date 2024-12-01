<?php   

    class UserSearch extends Controller
    {
        public function __construct()
        {
            $this->model = $this->model('UserSearchModel');
        }
        public function username_and_name()
        {
            $userKey = request()->input('userKey');


            $result = $this->model->search([
                'username'  => $userKey,
                'firstname' => $userKey,
                'lastname'  => $userKey
            ], '10');

            $requestStatus = $result != false ? true : false;

            ee(api_response($result , $requestStatus));
        }
    }