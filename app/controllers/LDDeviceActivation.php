<?php

	class LDDeviceActivation extends Controller
	{
		public function __construct()
		{
			$this->devicetokenModel = $this->model('LDDevicetokenModel');
		}

		public function activate_device()
		{
			$data = [
				'title' => 'Device Activation'
			];

			if($this->request() === 'POST')
			{
				$result = $this->devicetokenModel->activate_device($_POST['token']);

				if($result) {
					Flash::set("Device Activated");

					redirect('Finance');
				}
			}

			$this->view('lending/devicetoken/activate_device' , $data);
		}
	}
