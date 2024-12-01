<?php   

    class Home extends Controller
    {
        public function index($red = [])
        {
            echo 'asdasdasd';
        }


        public function complete($sponsor , $upline)
        {
            echo " SPONSOR {$sponsor} UPLINE {$upline}"; 
        }
    }