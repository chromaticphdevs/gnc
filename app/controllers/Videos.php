<?php   

    class Videos extends Controller
    {
        
        public function __construct()
        {
           
        }

        public function index()
        {  
         
             return $this->view('video_tutorial/mechanics');
        }


    }