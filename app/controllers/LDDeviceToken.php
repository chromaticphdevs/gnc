<?php 	

	class LDDeviceToken extends Controller
	{

		public function __construct()
		{
			$this->devicetokenModel = $this->model('LDDevicetokenModel');
		}

		public function index()
		{
			$this->create_token();
		}
		/*admin access*/
		public function create_token()
		{

			if($this->request() === 'POST')
			{
				$result = $this->devicetokenModel->create($_POST['tokenCount']);

				if($result) {
					Flash::set("{$_POST['tokenCount']} device token created");
				}

				redirect('LDDeviceToken/create_token');
			}else
			{
				$data = [
					'title'      => 'Token Create',
					'tokenList'  => $this->devicetokenModel->get_list()
				];

				$this->view('lending/devicetoken/create' , $data);
			}
		}

		public function token_list()
		{

		}

		public function add_device()
		{

		}
	}