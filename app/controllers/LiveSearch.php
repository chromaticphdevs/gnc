
<?php 	

	class LiveSearch extends Controller
	{	

		public function __construct()
		{

			$this->LiveSearchModal = $this->model("LiveSearchModal");
		}


		public function brgy()
		{

			if($this->request() === 'POST') 
			{
			
				$this->LiveSearchModal->brgy($_POST);

			}

		}

		public function city()
		{

			if($this->request() === 'POST') 
			{
				
				$this->LiveSearchModal->city($_POST);

			}
		}
		
		public function province()
		{

			if($this->request() === 'POST') 
			{
			
				$this->LiveSearchModal->province($_POST);

			}

		}
		public function region()
		{

			if($this->request() === 'POST') 
			{
			
				$this->LiveSearchModal->region($_POST);

			}

		}



	}




