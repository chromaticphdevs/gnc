<?php 	

	class Delivery extends Controller
	{

		public function __construct()
		{
			$this->DeliveryModel = $this->model('DeliveryModel');
		}
		public function add_delivery()
		{
			if($this->request() === 'POST')
			{
				// instanciate the file class
				$file = new File();
				$file->setFile($_FILES['image'])
				->setPrefix('IMAGE')
				->setDIR(PUBLIC_ROOT.DS.'assets')
				->upload();

				if(empty($file->getErrors()))
				{
					$this->DeliveryModel->add_delivery($_POST , $file->getFileUploadName());
				}else{
					Flash::set("File Error " , 'danger');
					redirect('/orders/preview/'.$_POST['orderid']);
				}
				
			}
		}
	}