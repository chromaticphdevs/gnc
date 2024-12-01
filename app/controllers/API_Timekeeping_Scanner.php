<?php   

    class API_Timekeeping_Scanner extends Controller
    {

        public function index()
        {
            return $this->view('tk_tool/qrscanner');
        }
    }