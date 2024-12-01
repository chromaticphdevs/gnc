<?php

    class BinaryGeneology extends Controller
    {

        public function __construct()
        {
            $this->userGeneologyModel    = $this->model('UserGeneologyModel');
            $this->geneologyHelper = new UserGeneologyObj($this->userGeneologyModel);
        }
        public function index()
        {   
            $user = Session::get('USERSESSION');
            $userid = $user['id'];

            if(isset($_GET['userid']))
            {
                $userid = $_GET['userid'];
            }
            
            $base1  = $this->geneologyHelper->getBaseOne($this->userGeneologyModel->getDownlines($userid));
            $base2 = $this->geneologyHelper->getBaseTwo($base1);
            $base3 = $this->geneologyHelper->getBaseThree($base2);
            $base4 = $this->geneologyHelper->getBaseFour($base3);
            $base5 = $this->geneologyHelper->getBaseFive($base4);
            $base6 = $this->geneologyHelper->getBaseSix($base5);

            $data = [
                'title' => 'Geneology tenth level',
                'userid' => $userid,
                'root'  => $this->userGeneologyModel->getUserInfo($userid),
                'base1' => $base1,
                'base2' => $base2,
                'base3' => $base3,
                'base4' => $base4,
                'base5' => $base5,
                'base6' => $base6,
                'userInfo' => $user
            ];

            return $this->view('geneology/binary_new' , $data);
        }
    }
