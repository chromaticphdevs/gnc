<?php   
    class SampAjax extends Controller 
    {
        public function index()
        {
            return $this->view('sampajax/index');
        }

        public function store()
        {
            $request = request()->inputs();

            echo json_encode($request);
        }
        
    }