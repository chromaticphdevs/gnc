<?php 	

	class PrintingExpense extends Controller
	{	

		public function __construct()
		{
			$this->PrintingExpenseModel = $this->model('PrintingExpenseModel');
		}

	
		public function index()
		{
				
			if($this->request() === 'POST')
			{		

				 $image = $this->upload_image_file($_FILES['image']);

				 $result = $this->PrintingExpenseModel->upload_expense_info($_POST,$image);

				 if($result)
				 {	
				 	 Flash::set("Data Successfully Saved");

					 if($_POST['total_running'] > 0 and $_POST['amount_total_running'] > 0)
					 {

						$data = [
			             	'pre_view' => $_POST
			       		];	

					 	$this->view('printing/pre_view',$data);
					 }else{
					 	 	return request()->return();
					 }

	              
				 }

				 
			}else
			{	
				$this->view('printing/index');

			}

		}

		public function show_all()
		{
						
			$data = [
             	'expenses' => $this->PrintingExpenseModel->get_all_expenses()
       		];	

			$this->view('printing/show_all',$data);

		}

		public function computation()
		{
						
			$data = [
             	'expenses' => $this->PrintingExpenseModel->get_all_expenses()
       		];	

			$this->view('printing/computation',$data);

		}

		public function get_last_job_order()
		{

			$meter_readings = $this->PrintingExpenseModel->get_last_job_order($_POST['machine_type']);

            if($meter_readings) {
		 		echo json_encode($meter_readings);
			}else{
				echo 'false';
			}
		}
	
 
		private function upload_image_file($image)
		{
		   $file = new File();

            $file->setFile($image)
			->setPrefix('IMAGE')
			->setDIR(PUBLIC_ROOT.DS.'assets/PrintingImage')
			->upload();

			if(!empty($file->getErrors())){

				Flash::set($file->getErrors(), 'danger');

				return request()->return();

				return;
			}

			return $file->getFileUploadName();
		}


	}