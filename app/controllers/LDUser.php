<?php 	

	class LDUser extends Controller
	{
		public function __construct()
		{
			//load user model
			$this->UserModel = $this->model('LDUserModel');	
			$this->ActivationModel = $this->model('LDActivationModel');
		}

		public function create_account()
		{

			if($this->request() === 'POST')
			{	
				$this->UserModel->create_account($_POST);

			}else{
				$data = [

						'branchList' => $this->UserModel->branch_list()
					];

				$this->view('lending/user/create_account', $data);
			}
		}

		public function live_search()
		{
			if($this->request() === 'POST')
			{	

				$this->UserModel->live_list_admin($_POST);
			}

		}


		public function pre_register_login()
		{	
			if($this->request() == 'POST')
			{
				$this->UserModel->pre_register_login($_POST);

			}else
			{

		       $this->view('lending/forms/login');
	    	}
	        
		}
		public function pre_register_activate_now()
		{	
		   $user =  Session::get('USER_INFO');
	
		   Flash::set($user->firstname." ".	$user->lastname, 'positive');
    	   redirect('LDActivation/activate_code_pre_register');	
	        
		}
		public function pre_register_full()
		{	
			
	        $this->view('lending/forms/full_register');
		}
		public function pre_register()
		{	
			if($this->request() == 'POST'){


				$this->UserModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->UserModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->UserModel->pre_register($_POST);

				
			}else
			{
				$data = [
					'userList' => $this->UserModel->list(),
					'branchList' => $this->UserModel->branch_list()
				];
			
		        $this->view('lending/forms/register',$data);
	    	}
		}

		public function pre_register_geneology()
		{	
			if($this->request() == 'POST'){

				$this->UserModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->UserModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->UserModel->pre_register_geneology($_POST);

			}else
			{

				$data = [
					'userList' => $this->UserModel->list(),
					'branchList' => $this->UserModel->branch_list()
				];
			
		        $this->view('lending/forms/register_geneology',$data);
	    	}
		}

		public function pre_register_left()
		{	
			if($this->request() == 'POST'){


				$this->UserModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->UserModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->UserModel->pre_register($_POST);

				
			}else
			{
				$data = [
					'userList' => $this->UserModel->list(),
					'branchList' => $this->UserModel->branch_list()
				];
			
		        $this->view('lending/forms/register_left',$data);
	    	}
		}

		public function pre_register_right()
		{	
		    
		 
		    
			if($this->request() == 'POST'){


				$this->UserModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->UserModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->UserModel->pre_register($_POST);

				
			}else
			{
				$data = [
					'userList' => $this->UserModel->list(),
					'branchList' => $this->UserModel->branch_list()
				];
			
		        $this->view('lending/forms/register_right',$data);
	    	}
		}

		public function check_send_text_code()
		{	
			if($this->request() == 'POST'){


				$this->UserModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->UserModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->UserModel->check_send_text_code($_POST);

				
			}
		}
		public function check_send_email_code()
		{	
			if($this->request() == 'POST'){


				$this->UserModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->UserModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->UserModel->check_send_email_code($_POST);

				
			}
		}

		public function encoder()
		{	

			DBBIAuthorization::setAccess(['super admin','admin','encoder'] , 'user' , 'FireLoginDBBI');

			if(isset($_GET['userID'])){
			
				
 			 	$data = [
					'userList' => $this->UserModel->classlist(),
					'userInfo' => $this->UserModel->preview($_GET['userID'])
				];
			
		        $this->view('lending/user/encoder',$data);

			}else{
				
				$data = [
					'userList' => $this->UserModel->classlist()
				];
		        $this->view('lending/user/encoder',$data);

	   		 }
		}

		public function edit_address()
		{
			DBBIAuthorization::setAccess(['super admin','admin','encoder'] , 'user' , 'FireLoginDBBI');


		}

		public function face_recog()
		{	
			
	        $this->view('lending/user/face_recog');
		}

		public function register_face()
		{	
			if($this->request() == 'POST'){
				$this->UserModel->save_face_image($_POST['file_name'] , $_POST['file_path'] , $_POST['image']);
			}else{
	       		 $this->view('lending/user/register_face');
	 	    }
		}

		public function register()
		{	
	

			$data = [
				'userList' => $this->UserModel->list(),
				'branchList' => $this->UserModel->branch_list()
			];

	        $this->view('lending/user/register',$data);
		}

		public function login()
		{
			if(hasLoggedIn('user')) {
				Flash::set('You are currently Logged in ' , 'negative');
				redirect('LDUser/profile');				
			}

			if($this->request() == 'POST')
			{
				$deviceToken  = new LDDevicetokenModel();
				$deviceCookie = $deviceToken->getDeviceCookie();
				
				if(!$deviceCookie)
				{
					Flash::set("Device not recognized" , 'danger');

					redirect('LDUser/login');

					return;
				}else{
					$this->UserModel->__add_model( 'LDClassLogger', $this->model('LDClassLogger'));
					$this->UserModel->fireLogin($_POST);
			}				
			}else{
	  			$this->view('lending/user/login');
			}
		}


		public function cancel_login()
		{
			Session::remove('loginVerified');
			if(!Session::check('loginVerified')){
				Flash::set('Login cancelled');
				echo 'true';
			}else{
				echo 'false';
			}
			
		}

		public function push_login()
		{
			if($this->request() == 'POST'){

				if(Session::check('loginVerified')){
					$this->LDClassLogger = $this->model('LDClassLogger');
					//load LDClass Model;
					$this->LDClassLogger->__add_model('LDClassModel' , $this->model('LDClassModel'));
					
					$this->LDClassLogger->fireLogger($_POST['classid'] , $_POST['userid'] , $_POST['image']);
				}else{
					echo "asdasd";
				}
			}
		}


			//for cashier check attendance
			public function manual_login_cashier($userName)
		{
	
				$this->UserModel->__add_model( 'LDClassLogger', $this->model('LDClassLogger'));
				$this->UserModel->fireLogin_cashier($userName);
		}

		public function cancel_login_cashier()
		{
			Session::remove('cashier_check_attendance');
			if(!Session::check('cashier_check_attendance')){
				Flash::set('Login cancelled');
				echo 'true';
			}else{
				echo 'false';
			}
			
		}

		public function push_login_cashier_manual()
		{
			if($this->request() == 'POST'){
				if(Session::check('cashier_check_attendance')){
					$this->LDClassLogger = $this->model('LDClassLogger');
					//load LDClass Model;
					$this->LDClassLogger->__add_model('LDClassModel' , $this->model('LDClassModel'));
					
					$this->LDClassLogger->fireLogger_manual_cashier($_POST['classid'] , $_POST['userid'] , $_POST['image']);
				}else{
					echo "asdasd";
				}
			}
		}
		//for cashier check attendance end

		public function preview($userId)
		{
			DBBIAuthorization::setAccess(['super admin','admin','cashier'] , 'user' , 'FireLoginDBBI');
			//load model
			$this->CashModel = $this->model('LDCashModel');	
			$this->ProductModel = $this->model('LDProductModel');	

	        $this->attendenceModel = $this->model('LDAttendanceModel');
			$userInfo  = $this->UserModel->preview($userId);
			$className  = $userInfo->getClass();
			$attendenceLog = $this->attendenceModel->getAttendance($userId);
			$class_history = $this->UserModel->history($userId);
			$cashAdvanceInfo  = $this->CashModel->latestLoan($userId);
			$productAdvanceInfo  = $this->ProductModel->latestLoan($userId);
			$cashAdvancePaymentInfo  = $this->CashModel->payment_history($userId);
			$productAdvancePaymentInfo  = $this->ProductModel->payment_history($userId);

			$data =[
				'userInfo' =>  $userInfo,
				'className' =>  $className,
				'attendanceLog' => $attendenceLog,
				'class_history' => $class_history,
				'cashAdvanceInfo' => $cashAdvanceInfo,
				'productAdvanceInfo' => $productAdvanceInfo,
				'cashAdvancePaymentInfo' => $cashAdvancePaymentInfo,
				'productAdvancePaymentInfo' => $productAdvancePaymentInfo,
				'cashAdvance_history' => $this->CashModel->history($userId),
				'productAdvance_history' => $this->ProductModel->history($userId)
			];
	        $this->view('lending/user/preview',$data);
		}

		public function profile()
		{
			DBBIAuthorization::setAccess(['super admin','admin' , 'customer'] , 'user' , 'FireLoginDBBI');

			$user   = Session::get('user');

			$userId = $user['id'];
			$branchId=$user['branch_id'];
			//load model
			$this->CashModel = $this->model('LDCashModel');	
			$this->ProductModel = $this->model('LDProductModel');	

			$this->attendenceModel = $this->model('LDAttendanceModel');

			$userInfo  = $this->UserModel->preview($userId);
				
			$className  = $userInfo->getClass();

			$attendenceLog = $this->attendenceModel->getAttendance($userId);
			$cashAdvanceInfo  = $this->CashModel->latestLoan($userId);
			$productAdvanceInfo  = $this->ProductModel->latestLoan($userId);
			$cashAdvancePaymentInfo  = $this->CashModel->payment_history($userId);
			$productAdvancePaymentInfo  = $this->ProductModel->payment_history($userId);
			$cashAdvance_balance = $this->CashModel->total_cashAdvance($userId);
			$total_cashPayment = $this->CashModel->total_cashPayment($userId);
			$product_Advance_balance = $this->ProductModel->total_product_Advance($userId);
			$total_productPayment = $this->ProductModel->total_productPayment($userId);
			$total_referrals = $this->UserModel->total_referral($userId);

			$data =[
				'userInfo' =>  $userInfo,
				'className' =>  $className,
				'attendanceLog' => $attendenceLog,
				'cashAdvanceInfo' => $cashAdvanceInfo,
				'productAdvanceInfo' => $productAdvanceInfo,
				'cashAdvancePaymentInfo' => $cashAdvancePaymentInfo,
				'productAdvancePaymentInfo' => $productAdvancePaymentInfo,
				'cashPaymentHistory' => $this->CashModel->payment_history($userId),
				'productPaymentHistory' => $this->ProductModel->payment_history($userId),
				'cashAdvance_balance' => $cashAdvance_balance,
				'total_cashPayment' => $total_cashPayment,
				'product_Advance_balance' => $product_Advance_balance,
				'total_productPayment' => $total_productPayment,
				'cashAdvance_history' => $this->CashModel->history($userId),
				'productAdvance_history' => $this->ProductModel->history($userId),
				'userList' => $this->UserModel->classlist(),
				'total_referrals' => $total_referrals,
				'total_weeks' => $this->UserModel->total_weeks($userId),
				'geneology' => $this->UserModel->geneology_sample($userId)
			];


			// die(var_dump($data['userInfo']));

			// die(var_dump($user));

			if($user['type'] == 'admin' || $user['type'] == 'super admin' )
			{

				$this->productLoanModel = $this->model('LDProductLoanModel');
				$this->cashLoanModel = $this->model('LDCashLoanModel');

				$this->productPayment = $this->model('LDPaymentProductModel');
				$this->cashPayment = $this->model('LDCashLoanPaymentModel');

				$this->CashModel = $this->model('LDCashModel');
				$this->ProductModel = $this->model('LDProductModel');	
				
				$data['loanToday'] = [
					'product' =>  $this->productLoanModel->get_list_total_today(),
					'cash'    =>  $this->cashLoanModel->get_list_total_today() ,

					'cashLoanListToday' => $this->cashLoanModel->get_list_today(), 
					'cashLoanTotal'     => $this->cashPayment->get_total_today($branchId),
					'interestTotal'     => $this->cashPayment->get_total_today_interest($branchId),

					'productLoanListToday' => $this->productLoanModel->get_list_today(),
					'productLoanTotal'     => $this->productPayment->get_total_today($branchId),

					'cash_paymentToday' => $this->cashLoanModel->payment_list_today(),
					'product_paymentToday' => $this->productLoanModel->payment_list_today(),
					'cash_advance_list' => $this->CashModel->list(),
					'product_advance_list' => $this->ProductModel->list(),
					'collection_summary_by_branch'	=>	$this->UserModel->collection_summary()
				];
				//die(var_dump($data['loanToday']['collection_summary_by_branch']));
				
				$data['vaultSummary'] = [
					'branch_vault_balance' => $this->UserModel->branch_vault($branchId),
					'branch_vault_balance_all' => $this->UserModel->branch_vault_all()
				];


				$data['inventorySummary'] = [
					'branch_inventory_stock' => $this->UserModel->branch_inventory($branchId),
					'branch_inventory_stock_all' => $this->UserModel->branch_inventory_all()
				];

				$this->attendenceModel = $this->model('LDAttendanceModel');

				$data['attendanceSummary'] = [
					'firstimerTotal' => $this->attendenceModel->getFirstTimer(),
					'repeatTotal'    => $this->attendenceModel->getRepeat(),
					'attendance_today'    => $this->attendenceModel->get_list_today()
				];

				$data['activation'] = [
					'branch_activation_lvl' => $this->ActivationModel->activation_level_branch($branchId),
					'activation_count_branch' => $this->ActivationModel->activation_count_branch($branchId)
				];
			}
			if(!empty($className)) {

				$this->classModel = $this->model('LDClassModel');

				$classInfo = $this->classModel->view($className->groupid);
				$data['classInfo'] = $classInfo;
				$data['classSchedule'] = $classInfo->getMonthSchedule();
			}
			

	        $this->view('lending/user/profile',$data);
		}
		public function create()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');

	        $this->view('lending/user/create');

		}


		public function list()
		{

			DBBIAuthorization::setAccess(['super admin','admin'] , 'user');
			$data = [
				'userList' => $this->UserModel->list()
			];
		
	        $this->view('lending/user/list',$data);

		}


		public function add_user()
		{
		
	      if($this->request() == 'POST') {

	      		 $this->UserModel->__add_model('binary_model' , $this->model('Binary_model'));
				 $this->UserModel->register($_POST);

			}
		}


		public function face_module()
		{
			if(! Session::check('loginVerified')){
				unAuthorize();
			}

			$data = [
				'userData' => Session::get('loginVerified')
			];

			$this->view('lending/user/face_module' , $data);
		}

		public function face_module_back()
		{
			if(! Session::check('loginVerified')){
				unAuthorize();
			}

			$data = [
				'userData' => Session::get('loginVerified')
			];

			$this->view('lending/user/face_module_back' , $data);
		}
			
		/*
			sa register firstimer
			attendance logger and register
		*/
		public function face_module2()
		{
			if(! Session::check('loginVerified')){
				unAuthorize();
			}


			$data = [
				'userData' => Session::get('loginVerified') 
			];

			$this->view('lending/user/face_module2' , $data);
		}

		/*
			
		*/
		public function id_capture()
		{
			if(! Session::check('user')){
				unAuthorize();
			}

			$position = 'front';

			if(isset($_GET['position']))
			{
				$position = $_GET['position'];
			}

			$data = [
				'userData' => Session::get('user'),
				'position' => $position
			];

			$this->view('lending/user/id_capture' , $data);
		}

		public function save_id_image()
		{
			if($this->request() == 'POST'){

				if(Session::check('user')){
					
					$position = $_POST['position'];

					$this->UserModel->__add_model('LDCashModel' , $this->model('LDCashModel'));
					$this->UserModel->__add_model('LDProductModel' , $this->model('LDProductModel'));

					 echo json_encode($this->UserModel->save_id_image($_POST , $position));
				}else{
					echo "asdasd";
				}
			}
		}

		public function logout()
		{
			Flash::set('Logged out' , 'positive');

			Session::remove('user');

			redirect('LDUser/login');
		}

	}