<?php 	
	/*Previous Controller Market*/
	class Checkout extends Controller
	{	
		public function __construct()
		{
			$this->cart_id = Session::get('CARTSESSION')['id'];
		}
		public function doCheckOut()
		{
			if($this->request() === 'POST')
			{	
				$this->billingModel = $this->model('billingModel');

				$file = new File();

				$file->setFile($_FILES['payment_attachment'])
				->setPrefix('IMAGE')
				->setDIR(PUBLIC_ROOT.DS.'assets')
				->upload();


				if(!empty($file->getErrors()))
				{
					Flash::set($file->getErrors() , 'danger');

					$this->view('billing/index');
				}else{

					$userid = Session::get('USERSESSION')['id'];

					$image  = $file->getFileUploadName();

					$orderid    = $this->billingModel->billOut($_POST , $image, $this->cart_id , $userid);
				}
			}		
		}
	}