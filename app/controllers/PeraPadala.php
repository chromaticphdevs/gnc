<?php 
	
	class PeraPadala extends Controller
	{	

		public function index()
		{
			
			if($this->request() === 'POST')
			{
			}else{

	            $this->view('pera_padala/index');

			}
		} 

	}