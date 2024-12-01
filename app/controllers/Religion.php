
<?php 	

	class Religion extends Controller
	{	

		public function __construct()
		{

			$this->ReligionModal = $this->model("ReligionModal");
		}



		public function live_search(){

			if($this->request() === 'POST') 
			{
			
				$this->ReligionModal->list($_POST);

			}else{

				//$this->view('/rfid_scanning/take_pic');
			}

		}



	}




